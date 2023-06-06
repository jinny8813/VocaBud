<?php

namespace App\Models;

use CodeIgniter\Model;

class BookModel extends Model
{
    protected $table = 'books';
    protected $allowedFields = [ 'b_id', 'uuidv4', 'u_id', 'title', 'description', 'manifest', 'create_at', 'delete_at'];
}
