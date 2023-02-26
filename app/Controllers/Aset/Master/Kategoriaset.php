<?php

namespace App\Controllers\Aset\Master;

use App\Models\KategoriasetModel;
use Irsyadulibad\DataTables\DataTables;

class Kategoriaset extends BaseController {
    protected $kategoriasetModel;
   
    private $rules = [
        'kode' =>  ['rules' => 'required|alpha_numeric_punct|is_unique[aset_kategori_aset.kode,kode,{kode}]'],
        'kategori_aset' =>  ['rules' => 'required|alpha_numeric_punct'],
    ];

    public function __construct() {
        $this->kategori = new kategoriasetModel();
        helper('form');
    }

    public function index() {
        echo view('aset/master/kategoriaset/index', ['title' => 'Kategori Aset']);
    }

    public function ajax() {
        if ($this->request->isAJAX()) {
            return DataTables::use ('aset_kategori_aset')
            ->select('kategori_aset_id, kode, kategori_aset, keterangan')
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
                    'kategori_aset' => ucwords($this->request->getPost('kategori_aset', FILTER_UNSAFE_RAW)),
                    'keterangan' => ucwords($this->request->getPost('keterangan', FILTER_UNSAFE_RAW)),
                ];
                $this->kategori->save($data);  
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
                    'kategori_aset' => ucwords($this->request->getPost('kategori_aset', FILTER_UNSAFE_RAW)),
                    'keterangan' => ucwords($this->request->getPost('keterangan', FILTER_UNSAFE_RAW)),
                    'kategori_aset_id' => $this->request->getPost('kategori_aset_id', FILTER_SANITIZE_NUMBER_INT),
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
