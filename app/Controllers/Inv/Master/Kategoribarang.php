<?php

namespace App\Controllers\Inv\Master;

use App\Models\KategoribarangModel;
use Irsyadulibad\DataTables\DataTables;

class Kategoribarang extends BaseController {
    protected $kategoribarangModel;
    private $rules = [
        'kode' =>  ['rules' => 'required|alpha_numeric_punct|is_unique[inv_kategori_barang.kode,kode,{kode}]'],
        'kategori_barang' =>  ['rules' => 'required|alpha_numeric_punct'],
    ];

    public function __construct() {
        $this->kategoribarangModel = new kategoribarangModel();
        helper('form');
    }

    public function index() {
        echo view('inv/master/kategoribarang/index', ['title' => 'Kategori Barang']);
    }

    public function ajax() {
        if ($this->request->isAJAX()) {
            return DataTables::use ('inv_kategori_barang')
            ->select('kategori_barang_id, kode, kategori_barang, keterangan')
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
                    'kategori_barang' => ucwords($this->request->getPost('kategori_barang', FILTER_UNSAFE_RAW)),
                    'keterangan' => ucwords($this->request->getPost('keterangan', FILTER_UNSAFE_RAW)),
                ];
                $this->kategoribarangModel->save($data);  
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
                    'kategori_barang' => ucwords($this->request->getPost('kategori_barang', FILTER_UNSAFE_RAW)),
                    'keterangan' => ucwords($this->request->getPost('keterangan', FILTER_UNSAFE_RAW)),
                    'kategori_barang_id' => $this->request->getPost('kategori_barang_id', FILTER_SANITIZE_NUMBER_INT),
                ];
                $this->kategoribarangModel->save($data); // simpan data
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
            if ($this->kategoribarangModel->find($id)) {
                $this->kategoribarangModel->delete($id, true); // hapus data
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
