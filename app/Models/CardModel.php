<?php

namespace App\Models;

use CodeIgniter\Model;

class CardModel extends Model
{
    protected $table = 'cards';
    protected $allowedFields = ['c_id','b_id','title','content','create_at',
                'pronunciation','e_sentence','c_sentence','part_of_speech','e_content','uuidv4', 'delete_at'];
}
