<?php
namespace App\Models;
use CodeIgniter\Model;

use mysqli_sql_exception;

class EventlogModel extends Model
{
    protected $table = 'eventlog';
    protected $primarykey = 'e_id';

    protected $allowedFields = ['e_id','u_id','s_id','create_at', 'score', 'delete_at'];

    public function getRangeLogCount($u_id,$start,$end){
        $db = \Config\Database::connect();

        $query = "
                    SELECT d.date, COUNT(e.e_id) AS count
                    FROM dates d
                    LEFT JOIN eventlog e ON d.date = CAST(e.create_at AS DATE) AND e.u_id = " . $u_id . "
                    WHERE d.date between '" . $start . "' and '" . $end . "'
                    GROUP BY d.date
                    ORDER BY d.date;
                    ";
                    
        $data = $db->query($query)->getResult();

        return $data;
    }
}
