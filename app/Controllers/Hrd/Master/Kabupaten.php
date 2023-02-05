<?php

namespace App\Controllers\Hrd\Master;

use App\Models\KabupatenModel;
use App\Models\PropinsiModel;
use Irsyadulibad\DataTables\DataTables;

class Kabupaten extends BaseController {
    protected $kabupatenModel;
    protected $propinsiModel;

    private $rules = [
        'nama' =>  ['rules' => 'required|string'],
        'provinsi_id' =>  ['rules' => 'required|integer'],
    ];

    public function __construct() {
        $this->kabupaten = new kabupatenModel();
        $this->provinsi = new propinsiModel();
        helper('form');
    }

    public function index() {
        $data = [
            'title'    => 'Kabupaten', 
            'provinsi' => $this->provinsi->getProvinsi(),         
        ];
        echo view('hrd/master/kabupaten/index', $data);
        
    }

    public function ajax() {
        if ($this->request->isAJAX()) {
            return DataTables::use ('wilayah_kabupaten')
            ->select('wilayah_kabupaten.*,wilayah_provinsi.nama as provinsi')
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
