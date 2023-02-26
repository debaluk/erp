<?php

namespace App\Models;

use CodeIgniter\Model;

class KategoriasetModel extends Model
{
    protected $table      = 'aset_kategori_aset';
    protected $primaryKey = 'kategori_aset_id';
    protected $useSoftDeletes = true;
    protected $allowedFields = ['kode','kategori_aset','keterangan'];
    protected $useTimestamps = true;
    protected $createdField       = 'created_at';
    protected $updatedField       = 'updated_at';
    protected $deletedField       = 'deleted_at';

    public function getKategori($id = null)
    {
        if (!(empty($id))) {
            return $this->builder($this->table)
            ->select('kategori_aset_id, kategori_aset AS kategori')
            ->where('kategori_aset_id', $id)->get(1)->getRow();
        }
        return $this->builder($this->table)
        ->select('kategori_aset_id, kategori_aset AS kategori')
        ->get()->getResult();
    }

}
