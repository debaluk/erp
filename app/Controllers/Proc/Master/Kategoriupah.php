<?php

namespace App\Controllers\Proc\Master;

use App\Models\KategoriupahModel;
use Irsyadulibad\DataTables\DataTables;

class Kategoriupah extends BaseController {
    protected $kategoriupahModel;
   
    private $rules = [
        'kode' =>  ['rules' => 'required|alpha_numeric_punct|is_unique[inv_kategori_barang.kode,kode,{kode}]'],
        'kategori_upah' =>  ['rules' => 'required|alpha_numeric_punct'],
    ];

    public function __construct() {
        $this->kategoriupahModel = new kategoriupahModel();
        helper('form');
    }

    public function index() {
        echo view('proc/master/kategoriupah/index', ['title' => 'Kategori Upah']);
    }

    public function ajax() {
        if ($this->request->isAJAX()) {
            return DataTables::use ('inv_kategori_upah')
            ->select('kategori_upah_id, kode, kategori_upah, keterangan')
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
                    'kategori_upah' => ucwords($this->request->getPost('kategori_upah', FILTER_UNSAFE_RAW)),
                    'keterangan' => ucwords($this->request->getPost('keterangan', FILTER_UNSAFE_RAW)),
                ];
                $this->kategoriupahModel->save($data);  
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
                    'kategori_upah' => ucwords($this->request->getPost('kategori_upah', FILTER_UNSAFE_RAW)),
                    'keterangan' => ucwords($this->request->getPost('keterangan', FILTER_UNSAFE_RAW)),
                    'kategori_upah_id' => $this->request->getPost('kategori_upah_id', FILTER_SANITIZE_NUMBER_INT),
                ];
                $this->kategoriupahModel->save($data);  
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
            if ($this->kategoriupahModel->find($id)) {
                $this->kategoriupahModel->delete($id, true); // hapus data
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
