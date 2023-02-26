<?php

namespace App\Controllers\Hrd\Transaksi;

use App\Models\KaryawanModel;
use App\Models\PropinsiModel;
use App\Models\KabupatenModel;
use App\Models\KecamatanModel;
use App\Models\DesaModel;
use Irsyadulibad\DataTables\DataTables;

class Karyawan extends BaseController {
    protected $karyawanModel;
   
    private $rules = [
        'nik' =>  ['rules' => 'required|alpha_numeric_punct|is_unique[hrd_pekerja.nik,nik,{nik}]'],
        'nama_pekerja' =>  ['rules' => 'required|alpha_numeric_punct'],
        'no_hp' =>  ['rules' => 'required|alpha_numeric_punct'],
        'no_wa' =>  ['rules' => 'required|alpha_numeric_punct'],
        'email' =>  ['rules' => 'required'],
        'alamat' =>  ['rules' => 'required|alpha_numeric_punct'],
        'prov_id' => ['rules' => 'required|integer'],
        'kab_id' =>  ['rules' => 'required|integer'],
        'kec_id' =>  ['rules' => 'required|integer'],
        'desa_id' => ['rules' => 'required|integer'],
       
    ];

    public function __construct() {
        $this->karyawan = new karyawanModel();
        $this->propinsiModel = new propinsiModel();
        
        helper('form');
    }

    public function index() {
        $data = [
            'title'    => 'Pekerja',
            'propinsi'=>$this->propinsiModel->getProvinsi(),
        ];
        echo view('hrd/transaksi/karyawan/index', $data);
        
    }

    public function ajax() {
        if ($this->request->isAJAX()) {
            return DataTables::use ('hrd_pekerja')
            ->select('hrd_pekerja.*')
            ->make();
        }
    }

    public function tambah() {
        if ($this->request->isAJAX()) {
            if (!$this->validate($this->rules)) {
                $respon = [
                    'validasi' => false,
                    'error'    => $this->validator->getErrors(),
                ];
            } else {
                $data = [
                    'nik' => ucwords($this->request->getPost('nik', FILTER_UNSAFE_RAW)),
                    'nama_pekerja' => ucwords($this->request->getPost('nama_pekerja', FILTER_UNSAFE_RAW)),
                    'no_wa' => ucwords($this->request->getPost('no_wa', FILTER_UNSAFE_RAW)),
                    'no_hp' => ucwords($this->request->getPost('no_hp', FILTER_UNSAFE_RAW)),
                    'email' => ucwords($this->request->getPost('email', FILTER_UNSAFE_RAW)),
                    'alamat' => ucwords($this->request->getPost('alamat', FILTER_UNSAFE_RAW)),
                    'prov_id' => $this->request->getPost('prov_id', FILTER_SANITIZE_NUMBER_INT),
                    'kab_id' => $this->request->getPost('kab_id', FILTER_SANITIZE_NUMBER_INT),
                    'kec_id' => $this->request->getPost('kec_id', FILTER_SANITIZE_NUMBER_INT),
                    'desa_id' => $this->request->getPost('desa_id', FILTER_SANITIZE_NUMBER_INT),
                ];
                $this->karyawan->save($data);  
                $respon = [
                    'validasi' => true,
                    'sukses'   => true,
                    'pesan'    => 'Data berhasil ditambahkan',
                    'isi'=> $data,
                ];
            }

            return $this->response->setJSON($respon);
        }
    }
    public function ubah() {
        if ($this->request->isAJAX()) {
            if (!$this->validate($this->rules)) {
                $respon = [
                    'validasi' => false,
                    'error'    => $this->validator->getErrors(),
                ];
            } else {
                $data = [
                    'nik' => ucwords($this->request->getPost('nik', FILTER_UNSAFE_RAW)),
                    'nama_pekerja' => ucwords($this->request->getPost('nama_pekerja', FILTER_UNSAFE_RAW)),
                    'no_wa' => ucwords($this->request->getPost('no_wa', FILTER_UNSAFE_RAW)),
                    'no_hp' => ucwords($this->request->getPost('no_hp', FILTER_UNSAFE_RAW)),
                    'email' => ucwords($this->request->getPost('email', FILTER_UNSAFE_RAW)),
                    'alamat' => ucwords($this->request->getPost('alamat', FILTER_UNSAFE_RAW)),
                    'prov_id' => $this->request->getPost('prov_id', FILTER_SANITIZE_NUMBER_INT),
                    'kab_id' => $this->request->getPost('kab_id', FILTER_SANITIZE_NUMBER_INT),
                    'kec_id' => $this->request->getPost('kec_id', FILTER_SANITIZE_NUMBER_INT),
                    'desa_id' => $this->request->getPost('desa_id', FILTER_SANITIZE_NUMBER_INT),
                    'id_pekerja' => $this->request->getPost('id_pekerja', FILTER_SANITIZE_NUMBER_INT),
                ];
                $this->karyawan->save($data); // simpan data
                $respon = [
                    'validasi' => true,
                    'sukses'   => true,
                    'pesan'    => 'Data berhasil diubah',
                    'isi'=> $data,
                ];
            } 

            return $this->response->setJSON($respon);
        }
    }

    public function hapus() {
        if ($this->request->isAJAX()) {           
            $id = $this->request->getGet('id', FILTER_SANITIZE_NUMBER_INT);
            if ($this->karyawan->find($id)) {
                $this->karyawan->delete($id, true); 
                $respon = [
                    'status' => true,
                    'pesan'  => 'Data berhasil dihapus',
                ];
            } else {
                $respon = [
                    'status' => false,
                    'pesan'  => 'Gagal menghapus data',
                ];
            }
           
            return $this->response->setJSON($respon);
        }
    }
}
