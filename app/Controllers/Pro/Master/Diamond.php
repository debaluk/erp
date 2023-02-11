<?php

namespace App\Controllers\Pro\Master;

use App\Models\DiamondModel;
use Irsyadulibad\DataTables\DataTables;

class Diamond extends BaseController {
    protected $diamondModel;
    private $rules = [
        'kode' =>  ['rules' => 'required|alpha_numeric_punct|is_unique[pro_diamond.kode,kode,{kode}]'],
        'nama_diamond' =>  ['rules' => 'required|alpha_numeric_punct'],
    ];

    public function __construct() {
        $this->diamond = new diamondModel();
        helper('form');
    }

    public function index() {
        echo view('pro/master/diamond/index', ['title' => 'Diamond']);
    }

    public function ajax() {
        if ($this->request->isAJAX()) {
            return DataTables::use ('pro_diamond')
            ->select('id_diamond, kode as kode, nama_diamond as nama')
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
                    'nama_diamond' => ucwords($this->request->getPost('nama_diamond', FILTER_UNSAFE_RAW)),
                ];
                $this->diamond->save($data); // simpan data
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
                    'nama_diamond' => ucwords($this->request->getPost('nama_diamond', FILTER_UNSAFE_RAW)),
                    'id_diamond' => $this->request->getPost('id_diamond', FILTER_SANITIZE_NUMBER_INT),
                ];
                $this->diamond->save($data);  
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
            if ($this->diamond->find($id)) {
                $this->diamond->delete($id, true); // hapus data
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
