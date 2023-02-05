<?php

namespace App\Models;

use CodeIgniter\Model;

class KategorivendorModel extends Model
{
    protected $table      = 'pro_kategori_vendor';
    protected $primaryKey = 'kategori_vendor_id';
    protected $useSoftDeletes = true;
    protected $allowedFields = ['kode','kategori_vendor_nama','keterangan'];
    protected $useTimestamps = true;
    protected $createdField       = 'created_at';
    protected $updatedField       = 'updated_at';
    protected $deletedField       = 'deleted_at';

    public function getKategori($id = null)
    {
        if (!(empty($id))) {
            return $this->builder($this->table)
            ->select('kategori_vendor_id,kode,kategori_vendor_nama')
            ->where('kategori_vendor_id', $id)->get(1)->getRow();
        }
        return $this->builder($this->table)
        ->select('kategori_vendor_id,kode,kategori_vendor_nama')
        ->get()->getResult();
    }

}
