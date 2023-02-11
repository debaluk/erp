<?php

namespace App\Models;

use CodeIgniter\Model;

class PermataModel extends Model
{
    protected $table      = 'pro_permata';
    protected $primaryKey = 'id_permata';
    protected $useSoftDeletes = true;
    protected $allowedFields = ['kode','nama_permata'];
    protected $useTimestamps = true;
    protected $createdField       = 'created_at';
    protected $updatedField       = 'updated_at';
    protected $deletedField       = 'deleted_at';

    public function getPermata($id = null)
    {
        if (!(empty($id))) {
            return $this->builder($this->table)
            ->select('id_permata,kode,nama_permata')
            ->where('id_permata', $id)->get(1)->getRow();
        }
        return $this->builder($this->table)
        ->select('id_permata,kode,nama_permata')
        ->get()->getResult();
    }

}
