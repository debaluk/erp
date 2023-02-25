<?php

namespace App\Models;

use CodeIgniter\Model;

class OverheadModel extends Model
{
    protected $table      = 'proc_overhead';
    protected $primaryKey = 'overhead_id';
    protected $useSoftDeletes = true;
    protected $allowedFields = ['kode','overhead_nama','satuan_id','keterangan'];
    protected $useTimestamps = true;
    protected $createdField       = 'created_at';
    protected $updatedField       = 'updated_at';
    protected $deletedField       = 'deleted_at';

    public function getOverhead($id = null)
    {
        if (!(empty($id))) {
            return $this->builder($this->table)
            ->select('overhead_id,kode,overhead_nama')
            ->where('overhead_id', $id)->get(1)->getRow();
        }
        return $this->builder($this->table)
        ->select('overhead_id,kode,overhead_nama')
        ->get()->getResult();
    }

}
