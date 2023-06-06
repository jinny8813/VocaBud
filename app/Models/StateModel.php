<?php

namespace App\Models;

use CodeIgniter\Model;

class StateModel extends Model
{
    protected $table = 'state';
    protected $allowedFields = ['s_id','u_id','c_id','state','grade','create_at','update_at', 'delete_at'];
}
