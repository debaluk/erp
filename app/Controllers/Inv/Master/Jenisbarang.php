<?php

namespace App\Controllers\Inv\Master;

use App\Models\JenisbarangModel;
use App\Models\KategoribarangModel;
use Irsyadulibad\DataTables\DataTables;

class Jenisbarang extends BaseController {
    protected $kategoribarangModel;
    protected $jenisbarangModel;
    private $rules = [
        'kode' =>  ['rules' => 'required|alpha_numeric_punct|is_unique[inv_jenis_barang.kode,kode,{kode}]'],
        'jenis_barang' =>  ['rules' => 'required|alpha_numeric_punct'],
        'kategori_barang_id' =>  ['rules' => 'required|integer'],
    ];

    public function __construct() {
        $this->kategoribarang = new kategoribarangModel();
        $this->jenisbarangModel = new jenisbarangModel();
        helper('form');
    }

    public function index() {
        $data = [
            'title'    => 'Jenis Barang',
            'kategori' => $this->kategoribarang->getKategori(),            
        ];
        echo view('inv/master/jenisbarang/index', $data);
        
    }

    public function ajax() {
        if ($this->request->isAJAX()) {
            return DataTables::use ('inv_jenis_barang')
            ->select('inv_jenis_barang.jenis_barang_id,inv_jenis_barang.kategori_barang_id as kategoriid,inv_jenis_barang.kode as kode, inv_jenis_barang.jenis_barang as jenisbarang, inv_jenis_barang.keterangan as keterangan, inv_kategori_barang.kategori_barang as kategoribarang')
            ->join('inv_kategori_barang', 'inv_kategori_barang.kategori_barang_id = inv_jenis_barang.kategori_barang_id')
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
                    'kategori_barang_id' => ucwords($this->request->getPost('kategori_barang_id', FILTER_SANITIZE_NUMBER_INT)),
                    'jenis_barang' => ucwords($this->request->getPost('jenis_barang', FILTER_UNSAFE_RAW)),
                    'keterangan' => ucwords($this->request->getPost('keterangan', FILTER_UNSAFE_RAW)),
                ];
                $this->jenisbarangModel->save($data);  
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
                    'kategori_barang_id' => ucwords($this->request->getPost('kategori_barang_id', FILTER_SANITIZE_NUMBER_INT)),
                    'jenis_barang' => ucwords($this->request->getPost('jenis_barang', FILTER_UNSAFE_RAW)),
                    'keterangan' => ucwords($this->request->getPost('keterangan', FILTER_UNSAFE_RAW)),
                    'jenis_barang_id' => $this->request->getPost('jenis_barang_id', FILTER_SANITIZE_NUMBER_INT),
                ];
                $this->jenisbarangModel->save($data); // simpan data
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
            if ($this->jenisbarangModel->find($id)) {
                $this->jenisbarangModel->delete($id, true); // hapus data
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
