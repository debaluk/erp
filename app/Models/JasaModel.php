<?php

namespace App\Models;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\Model;

class JasaModel extends Model
{
    protected $table      = 'pro_jasa';
    protected $primaryKey = 'jasa_id';
    protected $allowedFields = ['kategori_jasa_id','kode','nama_jasa','satuan_id','keterangan','gambar'];
    protected $useTimestamps = true;
    protected $createdField       = 'created_at';
    protected $updatedField       = 'updated_at';
    protected $deletedField       = 'deleted_at';

   
    public function getJasa($id = null)
    {
        if (!(empty($id))) {
            return $this->builder($this->table)
            ->select('jasa_id,kode,nama_jasa')
            ->where('jasa_id', $id)->get(1)->getRow();
        }
        return $this->builder($this->table)
        ->select('jasa_id,kode,nama_jasa')
        ->get()->getResult();
    }

}
