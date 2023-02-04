<?php namespace App\Modules\Inv\Models;

use CodeIgniter\Model;

class DashboardModel extends Model
{
    protected $table      = "";
    protected $primaryKey = "";

    protected $returnType     = array();
    protected $useSoftDeletes = true;

    protected $allowedFields = [];

    protected $useTimestamps = false;
    protected $createdField  = "created_at";
    protected $updatedField  = "updated_a";
    protected $deletedField  ="deleted_at";

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}