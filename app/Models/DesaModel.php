<?php

namespace App\Models;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\Model;

class DesaModel extends Model
{
    protected $table      = 'wilayah_desa';
    protected $primaryKey = 'id';
    protected $useSoftDeletes = true;
    protected $allowedFields = ['kecamatan_id,nama'];
    protected $useTimestamps = true;
    protected $createdField       = 'created_at';
    protected $updatedField       = 'updated_at';
    protected $deletedField       = 'deleted_at';

    public function getDesa($id = null)
    {
        if (!(empty($id))) {
            return $this->builder($this->table)
            ->select('id, nama AS nama')
            ->where('id', $id)->get(1)->getRow();
        }
        return $this->builder($this->table)
        ->select('id, nama AS nama')
        ->get()->getResult();
    }

    public function getDesaIdKec($idkec)
    {
        return $this->builder($this->table)
        ->select('id as iddesa, nama AS nama')
        ->where('kecamatan_id', $idkec)->get()->getResult();
       
    }
}
