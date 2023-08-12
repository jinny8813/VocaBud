<?php

namespace App\Models;

use CodeIgniter\Model;

class EventlogModel extends Model
{
    protected $table = 'eventlog';
    protected $primarykey = 'e_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'e_id', 'u_id', 's_id', 'score', 'created_at', 'updated_at', 'deleted_at'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function getRangeLogCount($u_id,$start,$end){
        $db = \Config\Database::connect();

        $query = "
                    SELECT d.date, COUNT(e.e_id) AS count
                    FROM dates d
                    LEFT JOIN eventlog e ON d.date = CAST(e.created_at AS DATE) AND e.u_id = " . $u_id . "
                    WHERE d.date between '" . $start . "' and '" . $end . "'
                    GROUP BY d.date
                    ORDER BY d.date;
                    ";
                    
        $data = $db->query($query)->getResult();

        return $data;
    }
}
