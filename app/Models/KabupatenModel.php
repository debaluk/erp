<?php

namespace App\Models;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\Model;

class KabupatenModel extends Model
{
    protected $table      = 'wilayah_kabupaten';
    protected $primaryKey = 'id';
    protected $useSoftDeletes = true;
    protected $allowedFields = ['provinsi_id,nama'];
    protected $useTimestamps = true;
    protected $createdField       = 'created_at';
    protected $updatedField       = 'updated_at';
    protected $deletedField       = 'deleted_at';

    public function getKabupaten($id = null)
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
