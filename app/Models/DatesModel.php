<?php
namespace App\Models;
use CodeIgniter\Model;

class DatesModel extends Model
{
    protected $table = 'dates';

    protected $allowedFields = ['d_id', 'date'];

}