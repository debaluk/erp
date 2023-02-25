<?php

namespace App\Models;

use CodeIgniter\Model;

class KategorijasaModel extends Model
{
    protected $table      = 'pro_kategori_jasa';
    protected $primaryKey = 'kategori_jasa_id';
    protected $useSoftDeletes = true;
    protected $allowedFields = ['kode','nama_kategori_jasa','keterangan'];
    protected $useTimestamps = true;
    protected $createdField       = 'created_at';
    protected $updatedField       = 'updated_at';
    protected $deletedField       = 'deleted_at';

    public function getKategoriJasa($id = null)
    {
        if (!(empty($id))) {
            return $this->builder($this->table)
            ->select('kategori_jasa_id,kode,nama_kategori_jasa')
            ->where('kategori_jasa_id', $id)->get(1)->getRow();
        }
        return $this->builder($this->table)
        ->select('kategori_jasa_id,kode,nama_kategori_jasa')
        ->get()->getResult();
    }

}
