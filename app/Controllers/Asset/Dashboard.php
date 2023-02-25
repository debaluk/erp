<?php

namespace App\Controllers\Asset;


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
        echo view('asset/dashboard', $data);
    }

}
