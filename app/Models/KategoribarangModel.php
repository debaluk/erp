<?php

namespace App\Models;

use CodeIgniter\Model;

class KategoribarangModel extends Model
{
    protected $table      = 'inv_kategori_barang';
    protected $primaryKey = 'kategori_barang_id';
    protected $useSoftDeletes = true;
    protected $allowedFields = ['kode','kategori_barang','keterangan'];
    protected $useTimestamps = true;
    protected $createdField       = 'created_at';
    protected $updatedField       = 'updated_at';
    protected $deletedField       = 'deleted_at';

    public function getKategori($id = null)
    {
        if (!(empty($id))) {
            return $this->builder($this->table)
            ->select('kategori_barang_id, kategori_barang AS kategori')
            ->where('kategori_barang_id', $id)->get(1)->getRow();
        }
        return $this->builder($this->table)
        ->select('kategori_barang_id, kategori_barang AS kategori')
        ->get()->getResult();
    }

}
