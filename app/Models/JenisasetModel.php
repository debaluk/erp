<?php

namespace App\Models;

use CodeIgniter\Model;

class JenisasetModel extends Model
{
    protected $table      = 'aset_jenis_aset';
    protected $primaryKey = 'jenis_aset_id';
    protected $useSoftDeletes = true;
    protected $allowedFields = ['kode','jenis_aset','keterangan','kategori_aset_id'];
    protected $useTimestamps = true;
    protected $createdField       = 'created_at';
    protected $updatedField       = 'updated_at';
    protected $deletedField       = 'deleted_at';

    public function getJenis($id = null)
    {
        if (!(empty($id))) {
            return $this->builder($this->table)
            ->select('jenis_aset_id,kode,jenis_aset')
            ->where('jenis_upah_id', $id)->get(1)->getRow();
        }
        return $this->builder($this->table)
        ->select('jenis_aset_id,kode,jenis_aset')
        ->get()->getResult();
    }

}
