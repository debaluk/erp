<?php

namespace App\Models;

use CodeIgniter\Model;

class KaryawanModel extends Model
{
    protected $table      = 'hrd_pekerja';
    protected $primaryKey = 'id_pekerja';
    protected $useSoftDeletes = true;
    protected $allowedFields = ['nik','nama_pekerja','no_hp','no_wa','email','prov_id','kab_id','kec_id','desa_id','alamat'];
    protected $useTimestamps = true;
    protected $createdField       = 'created_at';
    protected $updatedField       = 'updated_at';
    protected $deletedField       = 'deleted_at';

    public function getKaryawan($id = null)
    {
        if (!(empty($id))) {
            return $this->builder($this->table)
            ->select('id_pekerja,nama_pekerja')
            ->where('id_pekerja', $id)->get(1)->getRow();
        }
        return $this->builder($this->table)
        ->select('id_pekerja,nama_pekerja')
        ->get()->getResult();
    }

}
