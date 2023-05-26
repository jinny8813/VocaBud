<?php
namespace App\Models;
use CodeIgniter\Model;

class EventlogModel extends Model
{
    protected $table = 'eventlog';
    protected $primarykey = 'log_id';

    protected $allowedFields = ['log_id','user_id','card_id','choose','create_at'];
}
