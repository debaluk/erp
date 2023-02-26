<?php

namespace App\Controllers\Aset;


use App\Models\UserModel;
class Dashboard extends BaseController
{
    protected $produk;
    protected $pengguna;

    public function __construct()
    {
       
    }
    public function index()
    {
        $data = [
            'title'     => 'Dashboard',
           
        ];
        echo view('aset/dashboard', $data);
    }

}
