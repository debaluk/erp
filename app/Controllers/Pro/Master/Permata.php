<?php

namespace App\Controllers\Pro\Master;

use App\Models\PermataModel;
use Irsyadulibad\DataTables\DataTables;

class Permata extends BaseController {
    protected $permataModel;
    private $rules = [
        'kode' =>  ['rules' => 'required|alpha_numeric_punct|is_unique[pro_permata.kode,kode,{kode}]'],
        'nama_permata' =>  ['rules' => 'required|alpha_numeric_punct'],
    ];

    public function __construct() {
        $this->permata = new permataModel();
        helper('form');
    }

    public function index() {
        echo view('pro/master/permata/index', ['title' => 'Permata']);
    }

    public function ajax() {
        if ($this->request->isAJAX()) {
            return DataTables::use ('pro_permata')
            ->select('id_permata, kode as kode, nama_permata as nama')
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
                    'nama_permata' => ucwords($this->request->getPost('nama_permata', FILTER_UNSAFE_RAW)),
                ];
                $this->permata->save($data);  
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
                    'nama_permata' => ucwords($this->request->getPost('nama_permata', FILTER_UNSAFE_RAW)),
                    'id_permata' => $this->request->getPost('id_permata', FILTER_SANITIZE_NUMBER_INT),
                ];
                $this->permata->save($data);  
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
            if ($this->permata->find($id)) {
                $this->permata->delete($id, true);
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
