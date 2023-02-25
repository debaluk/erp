<?php

namespace App\Controllers\Pro\Master;

use App\Models\KategorijasaModel;
use App\Models\SatuanModel;
use App\Models\JasaModel;
use Irsyadulibad\DataTables\DataTables;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Jasa extends BaseController {
    protected $kategorijasaModel;
    protected $satuanModel;
    protected $jasaModel;
    private $rules = [
        'kode' =>  ['rules' => 'required|alpha_numeric_punct|is_unique[pro_jasa.kode,kode,{kode}]'],
        'nama_jasa' =>  ['rules' => 'required|string'],
        'satuan_id' =>  ['rules' => 'required|integer'],
        'kategori_jasa_id' =>  ['rules' => 'required|integer'],
        'gambar'   => ['rules' => 'max_size[gambar,2048]|mime_in[gambar,image/png,image/jpg,image/jpeg]|ext_in[gambar,png,jpg,jpeg]|is_image[gambar]'],

    ];

    public function __construct() {
        $this->kategori = new kategorijasaModel();
        $this->satuan = new satuanModel();
        $this->jasa = new jasaModel();
        helper('form');
    }

    public function index() {
        $data = [
            'title'    => 'Jasa',
            'satuan' => $this->satuan->getSatuan(),  
            'kategori' => $this->kategori->getKategoriJasa(),  
        ];
        echo view('pro/master/jasa/index', $data);
        
    }

    public function ajax() {
        if ($this->request->isAJAX()) {
            return DataTables::use ('pro_jasa')
            ->select('pro_jasa.*,inv_satuan.satuan as satuan,pro_kategori_jasa.nama_kategori_jasa as kategori')
            ->join('pro_kategori_jasa', 'pro_kategori_jasa.kategori_jasa_id= pro_jasa.kategori_jasa_id')
            ->join('inv_satuan', 'inv_satuan.satuan_id = pro_jasa.satuan_id')
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
                    'kode' => strtoupper($this->request->getPost('kode', FILTER_SANITIZE_SPECIAL_CHARS)),
                    'kategori_jasa_id' => $this->request->getPost('kategori_jasa_id', FILTER_SANITIZE_NUMBER_INT),
                    'satuan_id' => $this->request->getPost('satuan_id', FILTER_SANITIZE_NUMBER_INT),
                    'nama_jasa' => ucwords($this->request->getPost('nama_jasa', FILTER_UNSAFE_RAW)),
                    'keterangan' => $this->request->getPost('keterangan'),
                ];
                // jika gambar produk ditambahkan
                $upload = $this->_unggahGambarProduk();
                if (!empty($upload)) {
                    $data['gambar'] = $upload['gambar'];
                }
                $this->jasa->save($data);  
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
                    'kode' => strtoupper($this->request->getPost('kode', FILTER_SANITIZE_SPECIAL_CHARS)),
                    'kategori_jasa_id' => $this->request->getPost('kategori_jasa_id', FILTER_SANITIZE_NUMBER_INT),
                    'satuan_id' => $this->request->getPost('satuan_id', FILTER_SANITIZE_NUMBER_INT),
                    'nama_jasa' => ucwords($this->request->getPost('nama_jasa', FILTER_UNSAFE_RAW)),
                    'keterangan' => $this->request->getPost('keterangan'),
                    'jasa_id' => $this->request->getPost('jasa_id', FILTER_SANITIZE_NUMBER_INT),
                   
                ];
                 // jika gambar produk diubah
                 $gambarLama = $this->request->getPost('gambarLama', FILTER_SANITIZE_SPECIAL_CHARS);
                 $upload     = $this->_unggahGambarProduk($gambarLama);
                 if (!empty($upload)) {
                     $data['gambar'] = $upload['gambar'];
                 }
                $this->jasa->save($data); // simpan data
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
            if ($this->jasa->find($id)) {
                $this->jasa->delete($id, true); // hapus data
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

   private function _unggahGambarProduk($gambarLama = null) {
        $file       = $this->request->getFile('gambar'); // ambil data file
        $namaRandom = $file->getRandomName();
        if ($file->isValid() && !$file->hasMoved()) {
            if (!empty($gambarLama) && $gambarLama != 'gambar.jpg' && file_exists(FCPATH . 'uploads/jasa/' . $gambarLama)) {
                // hapus gambar lama
                unlink(FCPATH . 'uploads/jasa/' . $gambarLama);
            }
            // pindahkan photo baru ke folder uploads/produk
            $file->move(FCPATH . 'uploads/jasa', $namaRandom, true);

            return ['gambar' => $namaRandom]; // ambil nama photo untuk disimpan di
        }
    }
}
