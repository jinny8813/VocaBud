<?php

namespace App\Models;

use CodeIgniter\Model;

class ManifestModel extends Model
{
    protected $table = 'manifest';
    protected $allowedFields = ['m_id','b_id','u_id','type','create_at', 'delete_at'];
}
