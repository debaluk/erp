<?php

namespace App\Controllers;

use App\Models\UserModel;
use \Mailjet\Resources;

class Auth extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        helper('form');
    }

    public function index()
    {
        if (is_login()) {
            return redirect()->to('dashboard');
        }
        echo view('auth/login', ['title' => 'User Login']);
    }

    public function proses()
    {
        // jika methodnya post lanjut proses 
        if ($this->request->getMethod() == 'post') {
            $rules = $this->validate([
                'username' => 'required|alpha_numeric',
                'password' => 'required'
            ]);
            if (!($rules)) {
                $respon = [
                    'validasi' => false,
                    'error'  => $this->validator->getErrors()
                ];
            } else {
                $user = $this->userModel->getUser($this->request->getPost('username', FILTER_UNSAFE_RAW));
                // jika username tidak terdaftar 
                if (empty($user)) {
                    $respon = [
                        'validasi' => true,
                        'error' => ['username' => 'Username tidak terdaftar!']
                    ];
                } else {
                    // jika password tidak sama
                    if (!verifikasi_password($this->request->getPost('password'), $user->password)) {
                        $respon = [
                            'validasi' => true,
                            'error' => ['password' => 'Password tidak sesuai!']
                        ];
                    } else {
                        // login sukses set session user
                        $data = [
                            'login' => true,
                            'id'    => $user->id,
                        ];
                        $this->session->set($data); // set session
                        $respon = [
                            'validasi' => true,
                            'sukses' => true,
                            'aksi' => 'login',
                            'pesan' => 'Login berhasil!'
                        ];
                    }
                }
            }
            return $this->response->setJSON($respon);
        }
    }

    public function gantiPassword()
    {
        if ($this->request->getMethod() == 'post') {
            $rules = $this->validate([
                'password' => 'required|min_length[6]|matches[konfirmasi_password]',
                'konfirmasi_password' => 'matches[password]'
            ]);
            if (!$rules) {
                // jika validasi form gagal
                $respon = [
                    'validasi' => false,
                    'error' => $this->validator->getErrors()
                ];
            } else {
                $user = $this->userModel->getToken($this->request->getPost('kode'));
                if (empty($user)) {
                    $respon = [
                        'validasi' => true,
                        'error' => ['token' => 'Token tidak valid, silahkan request link reset password kembali!']
                    ];
                } else {
                    // update password
                    $password = buat_password($this->request->getPost('konfirmasi_password'));
                    try {
                        $this->userModel->update($user->id, ['password' => $password, 'token' => null]);
                        $this->_kirimEmail($user->email, 'ganti'); // kirik email
                        $respon = [
                            'validasi' => true,
                            'sukses' => true,
                            'aksi' => 'ubah',
                            'pesan' => 'Password berhasil diubah, silahkan login :)'
                        ];
                    } catch (\Exception $e) {
                        $respon = [
                            'validasi' => true,
                            'sukses' => false,
                            'pesan' => 'Gagal mengirim email!'
                        ];
                    }
                }
            }
            return $this->response->setJSON($respon);
        }
    }

    /**
     * Kirim email untuk verifikasi akun
     * @param string $email email tujuan
     * @param string $token token verifikasi
     */
    public function verifikasiAkun(string $email, string $token)
    {
        return $this->_kirimEmail($email, 'verifikasi', $token);
    }

    /**
     * Verifikasi akun baru
     */
    public function verifikasi()
    {
        $token = $this->request->getGet('token', FILTER_SANITIZE_STRING);
        $user = $this->userModel->getToken($token);
        if (empty($user)) {
            echo 'Token tidak valid :(';
        } else {
            $this->userModel->update($user->id, ['status' => 1, 'token' => '']);
            echo 'Selamat akun kamu sudah aktif silahkan login :)';
            echo '<br/><br/> <a href="' . base_url() . '">LOGIN</a>';
        }
    }

    /**
     * @return bool true jika kirim email berhasil, false jika gagal
     */
    private function _kirimEmail($tujuan, $tipe = 'reset', $token = null): bool
    {
        $user = $this->userModel->getUser($tujuan); // ambil data user sesuai email ($tujuan)
        if (empty($user)) {
            return false;
        }

        $public = getenv('MJ_APIKEY_PUBLIC');
        $privat = getenv('MJ_APIKEY_PRIVATE');
        $email = getenv('MJ_FROM_EMAIL');
        $name = getenv('MJ_NAME_EMAIL');

        $mj = new \Mailjet\Client($public, $privat, true, ['version' => 'v3.1']);

        if ($tipe == 'reset') {
            $subjek = 'Lupa Password';
            $pesan = 'Anda telah melakukan permintaan untuk mereset password. Untuk melanjutkan silahkan<br/><br/> <a href="' . base_url("auth/reset?token={$token}") . '">KLIK DISINI</a><br/><br/>';
            $pesan .= 'Tapi jika Anda tidak pernah meminta proses ini, maka kami berharap Anda mengabaikan email ini.';
        } elseif ($tipe == 'ganti') {
            $subjek = 'Ubah Password';
            $pesan = 'Password berhasil di ubah, silahkan login kembali :)';
        } elseif ($tipe == 'notif') {
            $subjek = 'Konfirmasi Perubahan Email';
            $pesan = 'Anda telah melakukan permintaan untuk mengubah email. Untuk melanjutkan silahkan<br/><br/> <a href="' . base_url("auth/konfirmasi?token={$token}") . '">KLIK DISINI</a><br/>';
            $pesan .= 'Tapi jika Anda tidak pernah meminta proses ini, maka kami berharap Anda mengabaikan email ini.';
        } elseif ($tipe == 'verifikasi') {
            $subjek = 'Verifikasi Akun';
            $pesan = 'Silahkan konfirmasi email Anda<br/><br/> <a href="' . base_url("auth/verifikasi?token={$token}") . '">KLIK DISINI</a><br/>';
        }

        $body = [
            'Messages' => [
                [
                    'From' => ['Email' => $email, 'Name' => $name],
                    'To' => [
                        ['Email' => $user->email, 'Name' => $user->nama]
                    ],
                    'Subject' => $subjek,
                    'HTMLPart' => $pesan
                ]
            ]
        ];

        $response = $mj->post(Resources::$Email, ['body' => $body]);
        return  $response->success();
    }

    public function logout()
    {
        session()->remove(['login', 'id']); // hapus session login dan id
        return redirect()->to(base_url());
    }
}
