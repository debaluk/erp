<?php

namespace App\Controllers\Hrd\Master;

use App\Models\PropinsiModel;
use App\Models\KabupatenModel;
use App\Models\KecamatanModel;

use Irsyadulibad\DataTables\DataTables;

class Kecamatan extends BaseController {
    protected $propinsiModel;
    protected $kabupatenModel;
    protected $kecamatanModel;

    private $rules = [
        'nama' =>  ['rules' => 'required|string'],
        'kabupaten_id' =>  ['rules' => 'required|integer'],
    ];

    public function __construct() {
        $this->kabupaten = new kabupatenModel();
        $this->provinsi = new propinsiModel();
        $this->kecamatan = new kecamatanModel();
        helper('form');
    }

    public function index() {
        $data = [
            'title'    => 'Kecamatan', 
            'provinsi' => $this->provinsi->getProvinsi(), 
            'kabupaten' => $this->kabupaten->getKabupaten(),     

        ];
        echo view('hrd/master/kecamatan/index', $data);
        
    }

    public function ajax() {
        if ($this->request->isAJAX()) {
            return DataTables::use ('wilayah_kecamatan')
            ->select('wilayah_kecamatan.*,wilayah_provinsi.nama as provinsi,wilayah_provinsi.id as provinsi_id,wilayah_kabupaten.nama as kabupaten')
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
                    'nama' => ucwords($this->request->getPost('nama', FILTER_UNSAFE_RAW)),
                    'provinsi_id' => ucwords($this->request->getPost('provinsi_id', FILTER_SANITIZE_NUMBER_INT)),
                   
                ];
                $this->kabupaten->save($data);  
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
                    'nama' => ucwords($this->request->getPost('nama', FILTER_UNSAFE_RAW)),
                    'provinsi_id' => ucwords($this->request->getPost('provinsi_id', FILTER_SANITIZE_NUMBER_INT)),
                    'id' => $this->request->getPost('id', FILTER_SANITIZE_NUMBER_INT),
                ];
                $this->kabupaten->save($data); // simpan data
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
            if ($this->kabupaten->find($id)) {
                $this->kabupaten->delete($id, true); // hapus data
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
