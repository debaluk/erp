<?php

namespace App\Models;

use CodeIgniter\Model;

class DiamondModel extends Model
{
    protected $table      = 'pro_diamond';
    protected $primaryKey = 'id_diamond';
    protected $useSoftDeletes = true;
    protected $allowedFields = ['kode','nama_diamond'];
    protected $useTimestamps = true;
    protected $createdField       = 'created_at';
    protected $updatedField       = 'updated_at';
    protected $deletedField       = 'deleted_at';

    public function getDiamond($id = null)
    {
        if (!(empty($id))) {
            return $this->builder($this->table)
            ->select('id_diamond,kode,nama_diamond')
            ->where('id_diamond', $id)->get(1)->getRow();
        }
        return $this->builder($this->table)
        ->select('id_diamond,kode,nama_diamond')
        ->get()->getResult();
    }

}
