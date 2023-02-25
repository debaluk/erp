<?php

namespace App\Controllers\Proc\Master;

use App\Models\JenisupahModel;
use App\Models\KategoriupahModel;
use App\Models\SatuanModel;
use App\Models\UpahModel;
use Irsyadulibad\DataTables\DataTables;

class Upah extends BaseController {
    protected $kategoriupahModel;
    protected $jenisupahModel;
    protected $satuanModel;
    protected $upahModel;
    private $rules = [        
        'kategori_upah_id' =>  ['rules' => 'required|alpha_numeric_punct'],
        'jenis_upah_id' =>  ['rules' => 'required|alpha_numeric_punct'],
        'kode' =>  ['rules' => 'required|alpha_numeric_punct|is_unique[hrd_upah.kode,kode,{kode}]'],
        'upah_nama' =>  ['rules' => 'required'],
        'satuan_id' =>  ['rules' => 'required|alpha_numeric_punct'],
    ];

    public function __construct() {
        $this->kategoriupah = new kategoriupahModel();
        $this->jenisupah = new JenisupahModel();
        $this->satuan = new satuanModel();
        $this->upah = new upahModel();
        helper('form');
    }

    public function index() {
        $data = [
            'title'    => 'Upah',
            'kategori' => $this->kategoriupah->getKategori(),   
            'jenis' => $this->jenisupah->getJenisupah(),      
            'satuan' => $this->satuan->getSatuan(),                  
        ];
        echo view('proc/master/upah/index', $data);
        
    }

    public function ajax() {
        if ($this->request->isAJAX()) {
            return DataTables::use ('hrd_upah')
            ->select('hrd_upah.*,inv_kategori_upah.kategori_upah as kategori,inv_jenis_upah.jenis_upah as jenis,inv_satuan.satuan as satuan')
            ->join('inv_kategori_upah', 'inv_kategori_upah.kategori_upah_id = hrd_upah.kategori_upah_id')
            ->join('inv_jenis_upah', 'inv_jenis_upah.jenis_upah_id = hrd_upah.jenis_upah_id')
            ->join('inv_satuan', 'inv_satuan.satuan_id = hrd_upah.satuan_id')
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
                    'kategori_upah_id' => ucwords($this->request->getPost('kategori_upah_id', FILTER_SANITIZE_NUMBER_INT)),
                    'jenis_upah_id' => ucwords($this->request->getPost('jenis_upah_id',FILTER_SANITIZE_NUMBER_INT)),
                    'kode' => ucwords($this->request->getPost('kode', FILTER_UNSAFE_RAW)),
                    'upah_nama' => ucwords($this->request->getPost('upah_nama', FILTER_UNSAFE_RAW)),
                    'satuan_id' => ucwords($this->request->getPost('satuan_id', FILTER_SANITIZE_NUMBER_INT)),
                    'keterangan' => ucwords($this->request->getPost('keterangan', FILTER_UNSAFE_RAW)),
                ];
                $this->upah->save($data);  
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
                    'kategori_upah_id' => ucwords($this->request->getPost('kategori_upah_id', FILTER_SANITIZE_NUMBER_INT)),
                    'jenis_upah_id' => ucwords($this->request->getPost('jenis_upah_id',FILTER_SANITIZE_NUMBER_INT)),
                    'kode' => ucwords($this->request->getPost('kode', FILTER_UNSAFE_RAW)),
                    'upah_nama' => ucwords($this->request->getPost('upah_nama', FILTER_UNSAFE_RAW)),
                    'satuan_id' => ucwords($this->request->getPost('satuan_id', FILTER_SANITIZE_NUMBER_INT)),
                    'keterangan' => ucwords($this->request->getPost('keterangan', FILTER_UNSAFE_RAW)),
                    'upah_id' => $this->request->getPost('upah_id', FILTER_SANITIZE_NUMBER_INT),
                ];
                $this->upah->save($data); // simpan data
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
            if ($this->upah->find($id)) {
                $this->upah->delete($id, true); // hapus data
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
