<?php

namespace App\Models;

use CodeIgniter\Model;

class VendorModel extends Model
{
    protected $table      = 'pro_vendor';
    protected $primaryKey = 'vendor_id';
    protected $useSoftDeletes = true;
    protected $allowedFields = ['kategori_vendor_id','kode','vendor_nama','vendor_alamat','desa_id','cp','hp','hp','wa','telp'];
    protected $useTimestamps = true;
    protected $createdField       = 'created_at';
    protected $updatedField       = 'updated_at';
    protected $deletedField       = 'deleted_at';

    public function getVendor($id = null)
    {
        if (!(empty($id))) {
            return $this->builder($this->table)
            ->select('vendor_id,kode,vendor_nama')
            ->where('vendor_id', $id)->get(1)->getRow();
        }
        return $this->builder($this->table)
        ->select('vendor_id,kode,vendor_nama')
        ->get()->getResult();
    }

}
