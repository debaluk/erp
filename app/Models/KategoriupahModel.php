<?php

namespace App\Models;

use CodeIgniter\Model;

class KategoriupahModel extends Model
{
    protected $table      = 'inv_kategori_upah';
    protected $primaryKey = 'kategori_upah_id';
    protected $useSoftDeletes = true;
    protected $allowedFields = ['kode','kategori_upah','keterangan'];
    protected $useTimestamps = true;
    protected $createdField       = 'created_at';
    protected $updatedField       = 'updated_at';
    protected $deletedField       = 'deleted_at';

    public function getKategori($id = null)
    {
        if (!(empty($id))) {
            return $this->builder($this->table)
            ->select('kategori_upah_id,kode,kategori_upah')
            ->where('kategori_upah_id', $id)->get(1)->getRow();
        }
        return $this->builder($this->table)
        ->select('kategori_upah_id,kode,kategori_upah')
        ->get()->getResult();
    }

}
