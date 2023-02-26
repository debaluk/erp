<?php

namespace App\Controllers\Aset\Master;

use App\Models\JenisasetModel;
use App\Models\KategoriasetModel;
use Irsyadulibad\DataTables\DataTables;

class Jenisaset extends BaseController {
    protected $kategoriasetModel;
    protected $jeniasetModel;
    private $rules = [
        'kode' =>  ['rules' => 'required|alpha_numeric_punct|is_unique[inv_jenis_barang.kode,kode,{kode}]'],
        'jenis_aset' =>  ['rules' => 'required|alpha_numeric_punct'],
        'kategori_aset_id' =>  ['rules' => 'required|integer'],
    ];

    public function __construct() {
        $this->kategori = new kategoriasetModel();
        $this->jenis = new jenisasetModel();
        helper('form');
    }

    public function index() {
        $data = [
            'title'    => 'Jenis Aset',
            'kategori' => $this->kategori->getKategori(),           
        ];
        echo view('aset/master/jenisaset/index', $data);
        
    }

    public function ajax() {
        if ($this->request->isAJAX()) {
            return DataTables::use ('aset_jenis_aset')
            ->select('aset_jenis_aset.*,aset_kategori_aset.kategori_aset as kategori')
            ->join('aset_kategori_aset', 'aset_kategori_aset.kategori_aset_id = aset_jenis_aset.kategori_aset_id')
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
                    'kategori_aset_id' => ucwords($this->request->getPost('kategori_aset_id', FILTER_SANITIZE_NUMBER_INT)),
                    'jenis_aset' => ucwords($this->request->getPost('jenis_aset', FILTER_UNSAFE_RAW)),
                    'keterangan' => ucwords($this->request->getPost('keterangan', FILTER_UNSAFE_RAW)),
                ];
                $this->jenis->save($data);  
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
                    'kategori_aset_id' => ucwords($this->request->getPost('kategori_aset_id', FILTER_SANITIZE_NUMBER_INT)),
                    'jenis_aset' => ucwords($this->request->getPost('jenis_aset', FILTER_UNSAFE_RAW)),
                    'keterangan' => ucwords($this->request->getPost('keterangan', FILTER_UNSAFE_RAW)),
                    'jenis_aset_id' => $this->request->getPost('jenis_aset_id', FILTER_SANITIZE_NUMBER_INT),
                ];
                $this->jenis->save($data); // simpan data
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
            if ($this->jenis->find($id)) {
                $this->jenis->delete($id, true); // hapus data
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
