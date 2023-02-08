<?php

namespace App\Models;

use CodeIgniter\Model;

class BentukModel extends Model
{
    protected $table      = 'pro_bentuk';
    protected $primaryKey = 'id_bentuk';
    protected $useSoftDeletes = true;
    protected $allowedFields = ['kode','nama_bentuk'];
    protected $useTimestamps = true;
    protected $createdField       = 'created_at';
    protected $updatedField       = 'updated_at';
    protected $deletedField       = 'deleted_at';

    public function getBentuk($id = null)
    {
        if (!(empty($id))) {
            return $this->builder($this->table)
            ->select('id_bentuk,kode,nama_bentuk')
            ->where('id_bentuk', $id)->get(1)->getRow();
        }
        return $this->builder($this->table)
        ->select('id_bentuk,kode,nama_bentuk')
        ->get()->getResult();
    }

}
