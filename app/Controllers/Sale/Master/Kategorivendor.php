<?php

namespace App\Controllers\Proc\Master;

use App\Models\KategorivendorModel;
use Irsyadulibad\DataTables\DataTables;

class Kategorivendor extends BaseController {
    protected $kategorivendorModel;
   
    private $rules = [
        'kode' =>  ['rules' => 'required|alpha_numeric_punct|is_unique[inv_kategori_barang.kode,kode,{kode}]'],
        'kategori_vendor_nama' =>  ['rules' => 'required|alpha_numeric_punct'],
    ];

    public function __construct() {
        $this->kategorivendorModel = new kategorivendorModel();
        helper('form');
    }

    public function index() {
        echo view('proc/master/kategorivendor/index', ['title' => 'Kategori Vendor']);
    }

    public function ajax() {
        if ($this->request->isAJAX()) {
            return DataTables::use ('pro_kategori_vendor')
            ->select('kategori_vendor_id, kode, kategori_vendor_nama, keterangan')
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
                    'kategori_vendor_nama' => ucwords($this->request->getPost('kategori_vendor_nama', FILTER_UNSAFE_RAW)),
                    'keterangan' => ucwords($this->request->getPost('keterangan', FILTER_UNSAFE_RAW)),
                ];
                $this->kategorivendorModel->save($data);  
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
                    'kategori_vendor_nama' => ucwords($this->request->getPost('kategori_vendor_nama', FILTER_UNSAFE_RAW)),
                    'keterangan' => ucwords($this->request->getPost('keterangan', FILTER_UNSAFE_RAW)),
                    'kategori_vendor_id' => $this->request->getPost('kategori_vendor_id', FILTER_SANITIZE_NUMBER_INT),
                ];
                $this->kategorivendorModel->save($data);  
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
            if ($this->kategorivendorModel->find($id)) {
                $this->kategorivendorModel->delete($id, true); // hapus data
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
