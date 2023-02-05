<?php

namespace App\Models;

use CodeIgniter\Model;

class JenisbarangModel extends Model
{
    protected $table      = 'inv_jenis_barang';
    protected $primaryKey = 'jenis_barang_id';
    protected $allowedFields = ['kode','kategori_barang_id','jenis_barang','keterangan'];
    protected $useTimestamps = true;
    protected $createdField       = 'created_at';
    protected $updatedField       = 'updated_at';
    protected $deletedField       = 'deleted_at';

    public function getJenis($id = null)
    {
        if (!(empty($id))) {
            return $this->builder($this->table)
            ->select('jenis_barang_id, jenis_barang as jenis')
            ->where('kategori_barang_id', $id)->get(1)->getRow();
        }
        return $this->builder($this->table)
        ->select('jenis_barang_id, kode AS kode,jenis_barang as jenis')
        ->get()->getResult();
    }

}
