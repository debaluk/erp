<?php

namespace App\Models;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\Model;

class BarangjadiModel extends Model
{
    protected $table      = 'pro_barang_jadi';
    protected $primaryKey = 'barang_id';
    protected $allowedFields = ['id_gender','id_bentuk','id_bahan','id_diamond','id_permata','kode','barang_nama','satuan_id','diskripsi','gambar'];
    protected $useTimestamps = true;
    protected $createdField       = 'created_at';
    protected $updatedField       = 'updated_at';
    protected $deletedField       = 'deleted_at';

    public function detailItem($id = null)
    {
        $builder = $this->builder($this->table)->select('pro_barang_jadi.*')
            ->join('pro_bentuk', 'pro_bentuk.id_bentuk = pro_barang_jadi.id_bentuk')
            ->join('pro_bahan', 'pro_bahan.id_bahan = pro_barang_jadi.id_bahan')
            ->join('pro_diamond', 'pro_diamond.id_diamond = pro_barang_jadi.id_diamond')
            ->join('pro_permata', 'pro_permata.id_permata= pro_barang_jadi.id_permata')
            ->join('inv_satuan', 'inv_satuan.satuan_id = pro_barang_jadi.satuan_id');
        if (empty($id)) {
            return $builder->get()->getResult(); // tampilkan semua data
        } else {
           
            return $builder->where('pro_barang_jadi.barang_id', $id)->orWhere('pro_barang_jadi', $id)->get(1)->getRow();
        }
    }

    public function cariProduk($keyword)
    {
        $builder = $this->builder($this->table);
        $query = $builder->select('*');
        if (empty($keyword)) {
            $data = $query->get(10)->getResult();
        } else {
            $data = $query->like('kode', $keyword)->orLike('barang_nama', $keyword)->get()->getResult();
        }
        return $data;
    }

}
