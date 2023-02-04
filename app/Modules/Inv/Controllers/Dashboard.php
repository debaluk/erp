<?php namespace App\Modules\Inv\Controllers;

use CodeIgniter\Controller;
use App\Modules\Inv\Models\DashboardModel;

class Dashboard extends Controller
{
    public function index()
    {
        $data = ['title' => 'Dashboard Page', 'view' => 'land/data', 'data' => 'Hello World from Inv Module -> Dashboard!'];
        return view('app/Modules/Inv/Views/dashboard', $data);
    }
}
