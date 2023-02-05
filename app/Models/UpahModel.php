<?php

namespace App\Models;

use CodeIgniter\Model;

class UpahModel extends Model
{
    protected $table      = 'hrd_upah';
    protected $primaryKey = 'upah_id';
    protected $useSoftDeletes = true;
    protected $allowedFields = ['kategori_upah_id','jenis_upah_id','kode','upah_nama','satuan_id','keterangan'];
    protected $useTimestamps = true;
    protected $createdField       = 'created_at';
    protected $updatedField       = 'updated_at';
    protected $deletedField       = 'deleted_at';

    public function getUpah($id = null)
    {
        if (!(empty($id))) {
            return $this->builder($this->table)
            ->select('upah_id,kode,upah_nama')
            ->where('upah_id', $id)->get(1)->getRow();
        }
        return $this->builder($this->table)
        ->select('upah_id,kode,upah_nama')
        ->get()->getResult();
    }

}
