<?php

namespace App\Models;

use CodeIgniter\Model;

class JenisupahModel extends Model
{
    protected $table      = 'inv_jenis_upah';
    protected $primaryKey = 'jenis_upah_id';
    protected $useSoftDeletes = true;
    protected $allowedFields = ['kode','jenis_upah','keterangan','kategori_upah_id'];
    protected $useTimestamps = true;
    protected $createdField       = 'created_at';
    protected $updatedField       = 'updated_at';
    protected $deletedField       = 'deleted_at';

    public function getJenisupah($id = null)
    {
        if (!(empty($id))) {
            return $this->builder($this->table)
            ->select('jenis_upah_id,kode,jenis_upah')
            ->where('jenis_upah_id', $id)->get(1)->getRow();
        }
        return $this->builder($this->table)
        ->select('jenis_upah_id,kode,jenis_upah')
        ->get()->getResult();
    }

}
