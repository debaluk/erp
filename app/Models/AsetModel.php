<?php

namespace App\Models;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\Model;

class AsetModel extends Model
{
    protected $table      = 'aset_aset';
    protected $primaryKey = 'aset_id';
    protected $allowedFields = ['kategori_aset_id','jenis_aset_id','kode','aset_nama','satuan_id','diskripsi','gambar'];
    protected $useTimestamps = true;
    protected $createdField       = 'created_at';
    protected $updatedField       = 'updated_at';
    protected $deletedField       = 'deleted_at';

   
}
