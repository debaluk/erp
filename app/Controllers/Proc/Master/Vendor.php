<?php

namespace App\Controllers\Proc\Master;

use App\Models\VendorModel;
use App\Models\KategorivendorModel;
use App\Models\PropinsiModel;
use App\Models\KabupatenModel;
use App\Models\KecamatanModel;
use App\Models\DesaModel;
use Irsyadulibad\DataTables\DataTables;

class Vendor extends BaseController {
    protected $vendorModel;
    protected $kategorivendorModel;
    protected $ropinsiModel;
    protected $kabupatenModel;
    protected $kecamatanModel;
    protected $desaModel;
    private $rules = [
        'kode' =>  ['rules' => 'required|alpha_numeric_punct|is_unique[inv_kategori_barang.kode,kode,{kode}]'],
        'kategori_vendor_nama' =>  ['rules' => 'required|alpha_numeric_punct'],
    ];

    public function __construct() {
        $this->vendorModel = new vendorModel();
        $this->kategorivendor = new kategorivendorModel();
        $this->propinsiModel = new propinsiModel();
        $this->desaModel = new desaModel();
        helper('form');
    }

    public function index() {
       
        echo view('proc/master/vendor/index', [
            'title' => 'Vendor',
            'kategori'=>$this->kategorivendor->getKategori(),
            'propinsi'=>$this->propinsiModel->getProvinsi(),
            'desa'=>$this->desaModel->getDesa()
        ]);
    }

    public function ajax() {
        if ($this->request->isAJAX()) {
            return DataTables::use ('pro_vendor')
            ->select('pro_vendor.*,pro_kategori_vendor.kategori_vendor_nama as kategori')
            ->join('pro_kategori_vendor', 'pro_kategori_vendor.kategori_vendor_id = pro_vendor.kategori_vendor_id')
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
