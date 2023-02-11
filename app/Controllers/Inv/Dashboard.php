<?php

namespace App\Controllers\Inv;


use App\Models\UserModel;
use App\Models\BarangModel;

class Dashboard extends BaseController
{
    protected $produk;
    protected $pengguna;

    public function __construct()
    {
       
        
        $this->pengguna = new UserModel();
        $this->produk = new BarangModel();
    }
    public function index()
    {
        $data = [
            'title'     => 'Dashboard',
            'produk'    => $this->produk->countAllResults(),
            'pengguna'  => $this->pengguna->countAllResults()
        ];
        echo view('inv/dashboard', $data);
    }

}
