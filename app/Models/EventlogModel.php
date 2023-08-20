<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\Database\RawSql;

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

    public function getRangeLogCount($u_id, $start, $end)
    {
        $sql = "dates.date = CAST(eventlog.created_at AS DATE) AND eventlog.u_id = {$u_id}";
        $w1  = "dates.date >= CAST('{$start}' AS DATE)";
        $w2  = "dates.date <= CAST('{$end}' AS DATE)";

        $data = $this->select('dates.date')
                    ->selectCount('eventlog.e_id', 'count')
                    ->join('dates', new RawSql($sql), 'right')
                    ->where($w1)
                    ->where($w2)
                    ->groupBy('dates.date')
                    ->orderBy('dates.date')
                    ->findAll();

        return $data;
    }
}
