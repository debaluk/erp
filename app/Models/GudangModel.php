<?php

namespace App\Models;

use CodeIgniter\Model;

class GudangModel extends Model
{
    protected $table      = 'inv_gudang';
    protected $primaryKey = 'gudang_id';
    protected $useSoftDeletes = true;
    protected $allowedFields = ['gudang_kode','gudang_nama','keterangan'];
    protected $useTimestamps = true;
    protected $createdField       = 'created_at';
    protected $updatedField       = 'updated_at';
    protected $deletedField       = 'deleted_at';

    public function getSatuan($id = null)
    {
        if (!(empty($id))) {
            return $this->builder($this->table)
            ->select('gudang_id,gudang_kode as kode,nama_gudang as nama, keterangan')
            ->where('gudang_id', $id)->get(1)->getRow();
        }
        return $this->builder($this->table)
        ->select('gudang_id,gudang_kode as kode,nama_gudang as nama, keterangan')
        ->get()->getResult();
    }
}
