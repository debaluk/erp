<?php

namespace App\Models;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\Model;

class PropinsiModel extends Model
{
    protected $table      = 'wilayah_provinsi';
    protected $primaryKey = 'id';
    protected $useSoftDeletes = true;
    protected $allowedFields = ['nama'];
    protected $useTimestamps = true;
    protected $createdField       = 'created_at';
    protected $updatedField       = 'updated_at';
    protected $deletedField       = 'deleted_at';

    public function getProvinsi($id = null)
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

   
}
