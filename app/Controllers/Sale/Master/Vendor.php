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
    
    private $rules = [
        'kode' =>  ['rules' => 'required|alpha_numeric_punct|is_unique[inv_kategori_barang.kode,kode,{kode}]'],
        'kategori_vendor_id' =>  ['rules' => 'required|alpha_numeric_punct'],
        'vendor_nama' =>  ['rules' => 'required|alpha_numeric_punct'],
        'vendor_alamat' =>  ['rules' => 'required|alpha_numeric_punct'],
        'desa_id' =>  ['rules' => 'required|alpha_numeric_punct'],
    ];

    public function __construct() {
        $this->vendormodel = new vendorModel();
        $this->kategorivendor = new kategorivendorModel();
        $this->propinsiModel = new propinsiModel();
       
        helper('form');
    }

    public function index() {
       
        echo view('proc/master/vendor/index', [
            'title' => 'Vendor',
            'kategori'=>$this->kategorivendor->getKategori(),
            'propinsi'=>$this->propinsiModel->getProvinsi(),
            //'desa'=>$this->desaModel->getDesa()
        ]);
    }

    public function ajax() {
        if ($this->request->isAJAX()) {
            return DataTables::use ('pro_vendor')
            ->select('pro_vendor.*,pro_kategori_vendor.kategori_vendor_nama as kategori,wilayah_kecamatan.id as kec_id,wilayah_kabupaten.id as kab_id, wilayah_provinsi.id as prov_id')
            ->join('pro_kategori_vendor', 'pro_kategori_vendor.kategori_vendor_id = pro_vendor.kategori_vendor_id')
            ->join('wilayah_desa', 'wilayah_desa.id = pro_vendor.desa_id')
            ->join('wilayah_kecamatan', 'wilayah_kecamatan.id = wilayah_desa.kecamatan_id')
            ->join('wilayah_kabupaten', 'wilayah_kabupaten.id = wilayah_kecamatan.kabupaten_id')
            ->join('wilayah_provinsi', 'wilayah_provinsi.id = wilayah_kabupaten.provinsi_id')


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
                    
                    'kategori_vendor_id' => ucwords($this->request->getPost('kategori_vendor_id', FILTER_SANITIZE_NUMBER_INT)),
                    'kode' => ucwords($this->request->getPost('kode', FILTER_UNSAFE_RAW)),
                    'vendor_nama' => ucwords($this->request->getPost('vendor_nama', FILTER_UNSAFE_RAW)),
                    'vendor_alamat' => ucwords($this->request->getPost('vendor_alamat', FILTER_UNSAFE_RAW)),
                    'desa_id' => ucwords($this->request->getPost('desa_id', FILTER_SANITIZE_NUMBER_INT)),
                    'cp' => ucwords($this->request->getPost('cp', FILTER_UNSAFE_RAW)),
                    'wa' => ucwords($this->request->getPost('wa', FILTER_UNSAFE_RAW)),
                    'telp' => ucwords($this->request->getPost('telp', FILTER_UNSAFE_RAW)),
                    'email' => ucwords($this->request->getPost('email', FILTER_UNSAFE_RAW)),
                    'hp' => ucwords($this->request->getPost('hp', FILTER_UNSAFE_RAW)),
                    
                ];
                $this->vendormodel->save($data);  
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
                    'kategori_vendor_id' => ucwords($this->request->getPost('kategori_vendor_id', FILTER_SANITIZE_NUMBER_INT)),
                    'kode' => ucwords($this->request->getPost('kode', FILTER_UNSAFE_RAW)),
                    'vendor_nama' => ucwords($this->request->getPost('vendor_nama', FILTER_UNSAFE_RAW)),
                    'vendor_alamat' => ucwords($this->request->getPost('vendor_alamat', FILTER_UNSAFE_RAW)),
                    'desa_id' => ucwords($this->request->getPost('desa_id', FILTER_SANITIZE_NUMBER_INT)),
                    'cp' => ucwords($this->request->getPost('cp', FILTER_UNSAFE_RAW)),
                    'wa' => ucwords($this->request->getPost('wa', FILTER_UNSAFE_RAW)),
                    'telp' => ucwords($this->request->getPost('telp', FILTER_UNSAFE_RAW)),
                    'email' => ucwords($this->request->getPost('email', FILTER_UNSAFE_RAW)),
                    'hp' => ucwords($this->request->getPost('hp', FILTER_UNSAFE_RAW)),
                    'vendor_id' => $this->request->getPost('vendor_id', FILTER_SANITIZE_NUMBER_INT),
                ];
                $this->vendormodel->save($data);  
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
            if ($this->vendormodel->find($id)) {
                $this->vendormodel->delete($id, true); // hapus data
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
