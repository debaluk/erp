<?php

namespace App\Controllers\Pro\Master;

use App\Models\BahanModel;
use Irsyadulibad\DataTables\DataTables;

class Bahan extends BaseController {
    protected $bahanModel;
    private $rules = [
        'kode' =>  ['rules' => 'required|alpha_numeric_punct|is_unique[pro_bahan.kode,kode,{kode}]'],
        'nama_bahan' =>  ['rules' => 'required|alpha_numeric_punct'],
    ];

    public function __construct() {
        $this->bahan = new bahanModel();
        helper('form');
    }

    public function index() {
        echo view('pro/master/bahan/index', ['title' => 'Bahan']);
    }

    public function ajax() {
        if ($this->request->isAJAX()) {
            return DataTables::use ('pro_bahan')
            ->select('id_bahan, kode as kode, nama_bahan as nama')
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
                    'nama_bahan' => ucwords($this->request->getPost('nama_bahan', FILTER_UNSAFE_RAW)),
                ];
                $this->bahan->save($data); // simpan data
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
                    'nama_bahan' => ucwords($this->request->getPost('nama_bahan', FILTER_UNSAFE_RAW)),
                    'id_bahan' => $this->request->getPost('id_bahan', FILTER_SANITIZE_NUMBER_INT),
                ];
                $this->bahan->save($data);  
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
            if ($this->bahan->find($id)) {
                $this->bahan->delete($id, true); // hapus data
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
