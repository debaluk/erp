<?php

namespace App\Controllers\Pro\Master;

use App\Models\BentukModel;
use Irsyadulibad\DataTables\DataTables;

class Bentuk extends BaseController {
    protected $bentukModel;
    private $rules = [
        'kode' =>  ['rules' => 'required|alpha_numeric_punct|is_unique[pro_bentuk.kode,kode,{kode}]'],
        'nama_bentuk' =>  ['rules' => 'required|alpha_numeric_punct'],
    ];

    public function __construct() {
        $this->bentuk = new bentukModel();
        helper('form');
    }

    public function index() {
        echo view('pro/master/bentuk/index', ['title' => 'Bentuk']);
    }

    public function ajax() {
        if ($this->request->isAJAX()) {
            return DataTables::use ('pro_bentuk')
            ->select('id_bentuk, kode as kode, nama_bentuk as nama')
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
                    'kode' => ucwords($this->request->getPost('kode', FILTER_UNSAFE_RAW)),
                    'nama_bentuk' => ucwords($this->request->getPost('nama_bentuk', FILTER_UNSAFE_RAW)),
                ];
                $this->bentuk->save($data); // simpan data
                $respon = [
                    'validasi' => true,
                    'sukses'   => true,
                    'pesan'    => 'Data berhasil ditambahkan',
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
                    'kode' => ucwords($this->request->getPost('kode', FILTER_UNSAFE_RAW)),
                    'nama_bentuk' => ucwords($this->request->getPost('nama_bentuk', FILTER_UNSAFE_RAW)),
                    'id_bentuk' => $this->request->getPost('id_bentuk', FILTER_SANITIZE_NUMBER_INT),
                ];
                $this->bentuk->save($data);  
                $respon = [
                    'validasi' => true,
                    'sukses'   => true,
                    'pesan'    => 'Data berhasil diubah',
                ];
            } 

            return $this->response->setJSON($respon);
        }
    }

    public function hapus() {
        if ($this->request->isAJAX()) {           
            $id = $this->request->getGet('id', FILTER_SANITIZE_NUMBER_INT);
            if ($this->bentuk->find($id)) {
                $this->bentuk->delete($id, true); // hapus data
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
