<?php

namespace App\Controllers\Proc\Master;


use App\Models\SatuanModel;
use App\Models\OverheadModel;
use Irsyadulibad\DataTables\DataTables;

class Overhead extends BaseController {

    protected $satuanModel;
    protected $overheadModel;
    private $rules = [        
        'kode' =>  ['rules' => 'required|alpha_numeric_punct|is_unique[proc_overhead.kode,kode,{kode}]'],
        'overhead_nama' =>  ['rules' => 'required'],
        'satuan_id' =>  ['rules' => 'required|alpha_numeric_punct'],
    ];

    public function __construct() {
        $this->satuan = new satuanModel();
        $this->overhead = new overheadModel();
        helper('form');
    }

    public function index() {
        $data = [
            'title'    => 'Overhead',
            'satuan' => $this->satuan->getSatuan(),                  
        ];
        echo view('proc/master/overhead/index', $data);
        
    }

    public function ajax() {
        if ($this->request->isAJAX()) {
            return DataTables::use ('proc_overhead')
            ->select('proc_overhead.*,inv_satuan.satuan as satuan')
            ->join('inv_satuan', 'inv_satuan.satuan_id = proc_overhead.satuan_id')
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
                    'overhead_nama' => ucwords($this->request->getPost('overhead_nama', FILTER_UNSAFE_RAW)),
                    'satuan_id' => ucwords($this->request->getPost('satuan_id', FILTER_SANITIZE_NUMBER_INT)),
                    'keterangan' => ucwords($this->request->getPost('keterangan', FILTER_UNSAFE_RAW)),
                ];
                $this->overhead->save($data);  
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
                    'overhead_nama' => ucwords($this->request->getPost('overhead_nama', FILTER_UNSAFE_RAW)),
                    'satuan_id' => ucwords($this->request->getPost('satuan_id', FILTER_SANITIZE_NUMBER_INT)),
                    'keterangan' => ucwords($this->request->getPost('keterangan', FILTER_UNSAFE_RAW)),
                    'overhead_id' => $this->request->getPost('overhead_id', FILTER_SANITIZE_NUMBER_INT),
                ];
                $this->overhead->save($data); // simpan data
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
            if ($this->overhead->find($id)) {
                $this->overhead->delete($id, true); // hapus data
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
