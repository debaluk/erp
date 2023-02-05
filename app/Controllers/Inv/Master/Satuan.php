<?php

namespace App\Controllers\Inv\Master;

use App\Models\SatuanModel;
use Irsyadulibad\DataTables\DataTables;

class Satuan extends BaseController {
    protected $satuanModel;
    private $rules = [
        'simbol' =>  ['rules' => 'required|alpha_numeric_punct|is_unique[inv_satuan.simbol,simbol,{simbol}]'],
        'satuan' =>  ['rules' => 'required|alpha_numeric_punct'],
    ];

    public function __construct() {
        $this->satuanModel = new satuanModel();
        helper('form');
    }

    public function index() {
        echo view('inv/master/satuan/index', ['title' => 'Satuan']);
    }

    public function ajax() {
        if ($this->request->isAJAX()) {
            return DataTables::use ('inv_satuan')
            ->select('satuan_id, simbol, satuan, keterangan')
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
                    'simbol' => ucwords($this->request->getPost('simbol', FILTER_UNSAFE_RAW)),
                    'satuan' => ucwords($this->request->getPost('satuan', FILTER_UNSAFE_RAW)),
                    'keterangan' => ucwords($this->request->getPost('keterangan', FILTER_UNSAFE_RAW)),
                ];
                $this->satuanModel->save($data); // simpan data
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
                    'simbol' => ucwords($this->request->getPost('simbol', FILTER_UNSAFE_RAW)),
                    'satuan' => ucwords($this->request->getPost('satuan', FILTER_UNSAFE_RAW)),
                    'keterangan' => ucwords($this->request->getPost('keterangan', FILTER_UNSAFE_RAW)),
                    'satuan_id' => $this->request->getPost('satuan_id', FILTER_SANITIZE_NUMBER_INT),
                ];
                $this->satuanModel->save($data); // simpan data
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
            if ($this->satuanModel->find($id)) {
                $this->satuanModel->delete($id, true); // hapus data
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
