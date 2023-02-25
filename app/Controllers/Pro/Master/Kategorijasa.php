<?php

namespace App\Controllers\Pro\Master;

use App\Models\KategorijasaModel;
use Irsyadulibad\DataTables\DataTables;

class Kategorijasa extends BaseController {
    protected $kategorijasaModel;
    private $rules = [
        'kode' =>  ['rules' => 'required|alpha_numeric_punct|is_unique[pro_kategori_jasa.kode,kode,{kode}]'],
        'nama_kategori_jasa' =>  ['rules' => 'required|alpha_numeric_punct'],
    ];

    public function __construct() {
        $this->kategori = new kategorijasaModel();
        helper('form');
    }

    public function index() {
        echo view('pro/master/kategorijasa/index', ['title' => 'Kategori Jasa']);
    }

    public function ajax() {
        if ($this->request->isAJAX()) {
            return DataTables::use ('pro_kategori_jasa')
            ->select('kategori_jasa_id, kode as kode, nama_kategori_jasa as nama,keterangan')
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
                    'nama_kategori_jasa' => ucwords($this->request->getPost('nama_kategori_jasa', FILTER_UNSAFE_RAW)),
                    'keterangan' => ucwords($this->request->getPost('keterangan', FILTER_UNSAFE_RAW)),
                ];
                $this->kategori->save($data); // simpan data
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
                    'nama_kategori_jasa' => ucwords($this->request->getPost('nama_kategori_jasa', FILTER_UNSAFE_RAW)),
                    'keterangan' => ucwords($this->request->getPost('keterangan', FILTER_UNSAFE_RAW)),
                    'kategori_jasa_id' => $this->request->getPost('kategori_jasa_id', FILTER_SANITIZE_NUMBER_INT),
                ];
                $this->kategori->save($data);  
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
            if ($this->kategori->find($id)) {
                $this->kategori->delete($id, true); // hapus data
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
