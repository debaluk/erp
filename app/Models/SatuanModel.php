<?php

namespace App\Models;

use CodeIgniter\Model;

class SatuanModel extends Model
{
    protected $table      = 'inv_satuan';
    protected $primaryKey = 'satuan_id';
    protected $useSoftDeletes = true;
    protected $allowedFields = ['simbol','satuan','keterangan'];
    protected $useTimestamps = true;
    protected $createdField       = 'created_at';
    protected $updatedField       = 'updated_at';
    protected $deletedField       = 'deleted_at';

    public function getSatuan($id = null)
    {
        if (!(empty($id))) {
            return $this->builder($this->table)
            ->select('satuan_id, satuan as satuan, keterangan as keterangan')
            ->where('satuan_id', $id)->get(1)->getRow();
        }
        return $this->builder($this->table)
        ->select('satuan_id, satuan as satuan, keterangan as keterangan')
        ->get()->getResult();
    }
}
