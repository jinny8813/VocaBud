<?php
namespace App\Models;
use CodeIgniter\Model;

class DatesModel extends Model
{
    protected $table = 'dates';

    protected $allowedFields = ['date_id', 'date'];

}