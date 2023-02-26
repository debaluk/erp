<?php

namespace App\Controllers\Aset\Master;

use App\Models\AsetModel;
use App\Models\KategoriasetModel;
use App\Models\JenisasetModel;
use App\Models\SatuanModel;
use Irsyadulibad\DataTables\DataTables;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Aset extends BaseController {
    protected $asetModel;
    protected $kategoriasetModel;
    protected $jenisasetModel;
    protected $satuanModel;

    private $rules = [
        'kode' =>  ['rules' => 'required|alpha_numeric_punct|is_unique[aset_aset.kode,kode,{kode}]'],
        'jenis_aset_id' =>  ['rules' => 'required|integer'],
        'kategori_aset_id' =>  ['rules' => 'required|integer'],
        'aset_nama' =>  ['rules' => 'required|string'],
        'satuan_id' =>  ['rules' => 'required|integer'],
        'gambar'   => ['rules' => 'max_size[gambar,2048]|mime_in[gambar,image/png,image/jpg,image/jpeg]|ext_in[gambar,png,jpg,jpeg]|is_image[gambar]'],

    ];

    public function __construct() {
        $this->kategori = new kategoriasetModel();
        $this->jenis = new jenisasetModel();
        $this->satuan = new satuanModel();
        $this->aset = new asetModel();
        helper('form');
    }

    public function index() {
        $data = [
            'title'    => 'Aset',
            'kategori' => $this->kategori->getKategori(),  
            'satuan' => $this->satuan->getSatuan(),  
            'jenis' => $this->jenis->getJenis(), 


        ];
        echo view('aset/master/aset/index', $data);
        
    }

    public function ajax() {
        if ($this->request->isAJAX()) {
            return DataTables::use ('aset_aset')
            ->select('inv_satuan.satuan_id as satuan_id,aset_kategori_aset.kategori_aset_id as kategori_id,aset_jenis_aset.jenis_aset_id as jenis_id, 
            aset_aset.gambar,aset_aset.aset_id,aset_aset.kode as kode,aset_aset.aset_nama as nama,aset_aset.diskripsi as diskripsi,aset_kategori_aset.kategori_aset as kategori,inv_satuan.satuan as satuan,aset_jenis_aset.jenis_aset as jenis')
            ->join('aset_kategori_aset', 'aset_kategori_aset.kategori_aset_id = aset_aset.kategori_aset_id')
            ->join('aset_jenis_aset', 'aset_jenis_aset.jenis_aset_id = aset_aset.jenis_aset_id')
            ->join('inv_satuan', 'inv_satuan.satuan_id = aset_aset.satuan_id')
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
                    'kategori_aset_id' => $this->request->getPost('kategori_aset_id', FILTER_SANITIZE_NUMBER_INT),
                    'jenis_aset_id' =>$this->request->getPost('jenis_aset_id', FILTER_SANITIZE_NUMBER_INT),
                    'aset_nama' => ucwords($this->request->getPost('aset_nama', FILTER_UNSAFE_RAW)),
                    'satuan_id' => $this->request->getPost('satuan_id', FILTER_SANITIZE_NUMBER_INT),
                    'diskripsi' => $this->request->getPost('diskripsi'),
                ];
               
                $upload = $this->_unggahGambarProduk();
                if (!empty($upload)) {
                    $data['gambar'] = $upload['gambar'];
                }
                $this->aset->save($data);  
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
                    'kategori_aset_id' => $this->request->getPost('kategori_aset_id', FILTER_SANITIZE_NUMBER_INT),
                    'jenis_aset_id' =>$this->request->getPost('jenis_aset_id', FILTER_SANITIZE_NUMBER_INT),
                    'aset_nama' => ucwords($this->request->getPost('aset_nama', FILTER_UNSAFE_RAW)),
                    'satuan_id' => $this->request->getPost('satuan_id', FILTER_SANITIZE_NUMBER_INT),
                    'diskripsi' => $this->request->getPost('diskripsi'),
                    'aset_id' => $this->request->getPost('aset_id', FILTER_SANITIZE_NUMBER_INT),
                ];
                
                $gambarLama = $this->request->getPost('gambarLama', FILTER_SANITIZE_SPECIAL_CHARS);
                $upload     = $this->_unggahGambarProduk($gambarLama);
                if (!empty($upload)) {
                     $data['gambar'] = $upload['gambar'];
                }
                $this->aset->save($data);
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
            if ($this->aset->find($id)) {
                $this->aset->delete($id, true);
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
        $file       = $this->request->getFile('gambar');
        $namaRandom = $file->getRandomName();
        if ($file->isValid() && !$file->hasMoved()) {
            if (!empty($gambarLama) && $gambarLama != 'gambar.jpg' && file_exists(FCPATH . 'uploads/aset/' . $gambarLama)) {
                unlink(FCPATH . 'uploads/aset/' . $gambarLama);
            }
            $file->move(FCPATH . 'uploads/aset', $namaRandom, true);
            return ['gambar' => $namaRandom]; 
        }
    }
}
