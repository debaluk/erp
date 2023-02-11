<?php

namespace App\Controllers\Transaksi;

use App\Models\GudangModel;
use Irsyadulibad\DataTables\DataTables;

class Penerimaanbarang extends BaseController {
    protected $gudangModel;
    private $rules = [
        'gudang_kode' =>  ['rules' => 'required|alpha_numeric_punct|is_unique[inv_gudang.gudang_kode,gudang_kode,{gudang_kode}]'],
        'gudang_nama' =>  ['rules' => 'required|alpha_numeric_punct'],
    ];

    public function __construct() {
        $this->gudangModel = new gudangModel();
        helper('form');
    }

    public function index() {
        echo view('master/gudang/index', ['title' => 'Gudang']);
    }

    public function ajax() {
        if ($this->request->isAJAX()) {
            return DataTables::use ('inv_gudang')
            ->select('gudang_id, gudang_kode as kode, gudang_nama as namagudang, keterangan')
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
                    'gudang_kode' => ucwords($this->request->getPost('gudang_kode', FILTER_UNSAFE_RAW)),
                    'gudang_nama' => ucwords($this->request->getPost('gudang_nama', FILTER_UNSAFE_RAW)),
                    'keterangan' => ucwords($this->request->getPost('keterangan', FILTER_UNSAFE_RAW)),
                ];
                $this->gudangModel->save($data); // simpan data
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
                    'gudang_kode' => ucwords($this->request->getPost('gudang_kode', FILTER_UNSAFE_RAW)),
                    'gudang_nama' => ucwords($this->request->getPost('gudang_nama', FILTER_UNSAFE_RAW)),
                    'keterangan' => ucwords($this->request->getPost('keterangan', FILTER_UNSAFE_RAW)),
                    'gudang_id' => $this->request->getPost('gudang_id', FILTER_SANITIZE_NUMBER_INT),
                ];
                $this->gudangModel->save($data); // simpan data
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
            if ($this->gudangModel->find($id)) {
                $this->gudangModel->delete($id, true); // hapus data
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
