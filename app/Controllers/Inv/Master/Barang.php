<?php

namespace App\Controllers\Inv\Master;

use App\Models\BarangModel;
use App\Models\KategoribarangModel;
use App\Models\JenisbarangModel;
use App\Models\SatuanModel;
use Irsyadulibad\DataTables\DataTables;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Barang extends BaseController {
    protected $barangModel;
    protected $kategoribarangModel;
    protected $jenisbarangModel;
    protected $satuanModel;

    private $rules = [
        'kode' =>  ['rules' => 'required|alpha_numeric_punct|is_unique[inv_barang.kode,kode,{kode}]'],
        'jenis_barang_id' =>  ['rules' => 'required|integer'],
        'kategori_barang_id' =>  ['rules' => 'required|integer'],
        'barang_nama' =>  ['rules' => 'required|string'],
        'satuan_id' =>  ['rules' => 'required|integer'],
        'gambar'   => ['rules' => 'max_size[gambar,2048]|mime_in[gambar,image/png,image/jpg,image/jpeg]|ext_in[gambar,png,jpg,jpeg]|is_image[gambar]'],

    ];

    public function __construct() {
        $this->kategoribarang = new kategoribarangModel();
        $this->jenisbarang = new jenisbarangModel();
        $this->satuan = new satuanModel();
        $this->barang = new barangModel();
        helper('form');
    }

    public function index() {
        $data = [
            'title'    => 'Barang',
            'kategori' => $this->kategoribarang->getKategori(),  
            'satuan' => $this->satuan->getSatuan(),  
            'jenis' => $this->jenisbarang->getJenis(), 


        ];
        echo view('inv/master/barang/index', $data);
        
    }

    public function ajax() {
        if ($this->request->isAJAX()) {
            return DataTables::use ('inv_barang')
            ->select('inv_satuan.satuan_id as satuan_id,inv_kategori_barang.kategori_barang_id as kategori_id,inv_jenis_barang.jenis_barang_id as jenis_id, 
            inv_barang.gambar,inv_barang.barang_id,inv_barang.kode as kode,inv_barang.barang_nama as nama,inv_barang.diskripsi as diskripsi,inv_kategori_barang.kategori_barang as kategori,inv_satuan.satuan as satuan,inv_jenis_barang.jenis_barang as jenis')
            ->join('inv_kategori_barang', 'inv_kategori_barang.kategori_barang_id = inv_barang.kategori_barang_id')
            ->join('inv_jenis_barang', 'inv_jenis_barang.jenis_barang_id = inv_barang.jenis_barang_id')
            ->join('inv_satuan', 'inv_satuan.satuan_id = inv_barang.satuan_id')
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
                    'kategori_barang_id' => $this->request->getPost('kategori_barang_id', FILTER_SANITIZE_NUMBER_INT),
                    'jenis_barang_id' =>$this->request->getPost('jenis_barang_id', FILTER_SANITIZE_NUMBER_INT),
                    'barang_nama' => ucwords($this->request->getPost('barang_nama', FILTER_UNSAFE_RAW)),
                    'satuan_id' => $this->request->getPost('satuan_id', FILTER_SANITIZE_NUMBER_INT),
                    'diskripsi' => $this->request->getPost('diskripsi'),
                ];
                // jika gambar produk ditambahkan
                $upload = $this->_unggahGambarProduk();
                if (!empty($upload)) {
                    $data['gambar'] = $upload['gambar'];
                }
                $this->barang->save($data);  
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
                    'kategori_barang_id' => $this->request->getPost('kategori_barang_id', FILTER_SANITIZE_NUMBER_INT),
                    'jenis_barang_id' =>$this->request->getPost('jenis_barang_id', FILTER_SANITIZE_NUMBER_INT),
                    'barang_nama' => ucwords($this->request->getPost('barang_nama', FILTER_UNSAFE_RAW)),
                    'satuan_id' => $this->request->getPost('satuan_id', FILTER_SANITIZE_NUMBER_INT),
                    'diskripsi' => $this->request->getPost('diskripsi'),
                    'barang_id' => $this->request->getPost('barang_id', FILTER_SANITIZE_NUMBER_INT),
                ];
                 // jika gambar produk diubah
                 $gambarLama = $this->request->getPost('gambarLama', FILTER_SANITIZE_SPECIAL_CHARS);
                 $upload     = $this->_unggahGambarProduk($gambarLama);
                 if (!empty($upload)) {
                     $data['gambar'] = $upload['gambar'];
                 }
                $this->barang->save($data); // simpan data
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
            if ($this->barang->find($id)) {
                $this->barang->delete($id, true); // hapus data
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
            if (!empty($gambarLama) && $gambarLama != 'gambar.jpg' && file_exists(FCPATH . 'uploads/produk/' . $gambarLama)) {
                // hapus gambar lama
                unlink(FCPATH . 'uploads/produk/' . $gambarLama);
            }
            // pindahkan photo baru ke folder uploads/produk
            $file->move(FCPATH . 'uploads/produk', $namaRandom, true);

            return ['gambar' => $namaRandom]; // ambil nama photo untuk disimpan di
        }
    }
}
