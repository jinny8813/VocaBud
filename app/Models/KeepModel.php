<?php

namespace App\Models;

use CodeIgniter\Model;

class KeepModel extends Model
{
    protected $table = 'keep';
    protected $primaryKey = 'k_id';
    protected $allowedFields = ['k_id','u_id','c_id','create_at', 'delete_at'];
}