<?php

namespace App\Controllers\Proc\Master;

use App\Models\JenisupahModel;
use App\Models\KategoriupahModel;
use Irsyadulibad\DataTables\DataTables;

class Jenisupah extends BaseController {
    protected $kategoriupahModel;
    protected $jenisupahModel;
    private $rules = [
        'kode' =>  ['rules' => 'required|alpha_numeric_punct|is_unique[inv_jenis_barang.kode,kode,{kode}]'],
        'jenis_upah' =>  ['rules' => 'required|alpha_numeric_punct'],
        'kategori_upah_id' =>  ['rules' => 'required|integer'],
    ];

    public function __construct() {
        $this->kategoriupah = new kategoriupahModel();
        $this->jenisupahModel = new JenisupahModel();
        helper('form');
    }

    public function index() {
        $data = [
            'title'    => 'Jenis Upah',
            'kategori' => $this->kategoriupah->getKategori(),           
        ];
        echo view('proc/master/jenisupah/index', $data);
        
    }

    public function ajax() {
        if ($this->request->isAJAX()) {
            return DataTables::use ('inv_jenis_upah')
            ->select('inv_jenis_upah.*,inv_kategori_upah.kategori_upah as kategori')
            ->join('inv_kategori_upah', 'inv_kategori_upah.kategori_upah_id = inv_jenis_upah.kategori_upah_id')
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
                    'kategori_upah_id' => ucwords($this->request->getPost('kategori_upah_id', FILTER_SANITIZE_NUMBER_INT)),
                    'jenis_upah' => ucwords($this->request->getPost('jenis_upah', FILTER_UNSAFE_RAW)),
                    'keterangan' => ucwords($this->request->getPost('keterangan', FILTER_UNSAFE_RAW)),
                ];
                $this->jenisupahModel->save($data);  
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
                    'kategori_upah_id' => ucwords($this->request->getPost('kategori_upah_id', FILTER_SANITIZE_NUMBER_INT)),
                    'jenis_upah' => ucwords($this->request->getPost('jenis_upah', FILTER_UNSAFE_RAW)),
                    'keterangan' => ucwords($this->request->getPost('keterangan', FILTER_UNSAFE_RAW)),
                    'jenis_upah_id' => $this->request->getPost('jenis_upah_id', FILTER_SANITIZE_NUMBER_INT),
                ];
                $this->jenisupahModel->save($data); // simpan data
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
            if ($this->jenisupahModel->find($id)) {
                $this->jenisupahModel->delete($id, true); // hapus data
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
