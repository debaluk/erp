<?php

namespace App\Models;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\Model;

class BarangModel extends Model
{
    protected $table      = 'inv_barang';
    protected $primaryKey = 'barang_id';
    protected $allowedFields = ['kategori_barang_id','jenis_barang_id','kode','barang_nama','satuan_id','diskripsi','gambar'];
    protected $useTimestamps = true;
    protected $createdField       = 'created_at';
    protected $updatedField       = 'updated_at';
    protected $deletedField       = 'deleted_at';

    public function detailItem($id = null)
    {
        $builder = $this->builder($this->table)->select('tb_item.*')
            ->join('inv_jenis_barang', 'inv_jenis_barang.jenis_barang_id = jenis_barang_id')
            ->join('inv_kategori_barang', 'inv_kategori_barang.kategori_barang_id = kategori_barang_id')
            ->join('inv_satuan', 'inv_satuan.satuan_id = satuan_id');
        if (empty($id)) {
            return $builder->get()->getResult(); // tampilkan semua data
        } else {
            // tampilkan data sesuai id/barcode
            return $builder->where('inv_barang.kode', $id)->orWhere('inv_barang', $id)->get(1)->getRow();
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
