<?php

namespace App\Models;

use CodeIgniter\Model;

class BahanModel extends Model
{
    protected $table      = 'pro_bahan';
    protected $primaryKey = 'id_bahan';
    protected $useSoftDeletes = true;
    protected $allowedFields = ['kode','nama_bahan'];
    protected $useTimestamps = true;
    protected $createdField       = 'created_at';
    protected $updatedField       = 'updated_at';
    protected $deletedField       = 'deleted_at';

    public function getBahan($id = null)
    {
        if (!(empty($id))) {
            return $this->builder($this->table)
            ->select('id_bahan,kode,nama_bahan')
            ->where('id_bahan', $id)->get(1)->getRow();
        }
        return $this->builder($this->table)
        ->select('id_bahan,kode,nama_bahan')
        ->get()->getResult();
    }

}
