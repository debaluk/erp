<?php

namespace App\Models;

use CodeIgniter\Model;

class SupplierModel extends Model
{
    protected $table = "pro_vendor";
    protected $primaryKey   = 'vendor_id';
    protected $allowedFields = ['kategori_vendor_id', 'kode', 'vendor_nama'];
    protected $useTimestamps = true;

    public function detailSupplier($id = null)
    {
        $builder = $this->builder($this->table)->select('*');
        if (empty($id)) {
            return $builder->get()->getResult();
        }
        return $builder->where('vendor_id', $id)->get(1)->getRow();
    }
}
