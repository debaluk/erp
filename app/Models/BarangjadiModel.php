<?php

namespace App\Models;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\Model;

class BarangjadiModel extends Model
{
    protected $table      = 'pro_barang_jadi';
    protected $primaryKey = 'barang_id';
    protected $allowedFields = ['id_bentuk','id_bahan','id_diamond','id_permata','kode','barang_nama','satuan_id','diskripsi','gambar'];
    protected $useTimestamps = true;
    protected $createdField       = 'created_at';
    protected $updatedField       = 'updated_at';
    protected $deletedField       = 'deleted_at';

    public function detailItem($id = null)
    {
        $builder = $this->builder($this->table)->select('pro_barang_jadi.*')
            ->join('inv_jenis_barang', 'inv_jenis_barang.jenis_barang_id = jenis_barang_id')
            ->join('inv_kategori_barang', 'inv_kategori_barang.kategori_barang_id = kategori_barang_id')
            ->join('inv_satuan', 'inv_satuan.satuan_id = satuan_id');
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
