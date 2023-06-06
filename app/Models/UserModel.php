<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $allowedFields = ['u_id','email', 'password_hash','nickname','create_at', 'uuidv4', 'lasting', 'delete_at', 'goal'];

}
