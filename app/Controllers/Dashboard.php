<?php

namespace App\Controllers;


use App\Models\UserModel;

class Dashboard extends BaseController
{
    protected $pengguna;

    public function __construct()
    {
       
        $this->pengguna = new UserModel();
       
    }
    public function index()
    {
        $data = [
            'title'     => 'Dashboard Module',
            'aksesmodul' => $this->pengguna->getRoleakses(session('id')),
           
        ];
        echo view('dashboard', $data);
    }

}
