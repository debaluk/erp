<?php

namespace App\Controllers\Hrd\Master;

use App\Models\PropinsiModel;
use Irsyadulibad\DataTables\DataTables;

class Propinsi extends BaseController {
    protected $propinsiModel;
   
    private $rules = [
        'nama' =>  ['rules' => 'required|string'],
    ];

    public function __construct() {
        $this->propinsi = new PropinsiModel();
        helper('form');
    }

    public function index() {
        $data = [
            'title'    => 'Propinsi',          
        ];
        echo view('hrd/master/propinsi/index', $data);
        
    }

    public function ajax() {
        if ($this->request->isAJAX()) {
            return DataTables::use ('wilayah_provinsi')
            ->select('id,nama')
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
                    'nama' => ucwords($this->request->getPost('nama', FILTER_UNSAFE_RAW)),
                   
                ];
                $this->propinsi->save($data);  
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
                    'nama' => ucwords($this->request->getPost('nama', FILTER_UNSAFE_RAW)),
                    'id' => $this->request->getPost('id', FILTER_SANITIZE_NUMBER_INT),
                ];
                $this->propinsi->save($data); // simpan data
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
            if ($this->propinsi->find($id)) {
                $this->propinsi->delete($id, true); // hapus data
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
