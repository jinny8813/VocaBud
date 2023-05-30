<?php
namespace App\Models;
use CodeIgniter\Model;

use mysqli_sql_exception;

class EventlogModel extends Model
{
    protected $table = 'eventlog';
    protected $primarykey = 'log_id';

    protected $allowedFields = ['log_id','user_id','card_id','choose','create_at'];

    public function getRangeLogCount($user_id,$start,$end){
        $db = \Config\Database::connect();

        try{
            // localhost MariaDB
            $query = "
                    WITH RECURSIVE temp_table AS (
                        SELECT DATE_ADD('" . $start . "', INTERVAL 0 DAY) AS date
                        UNION ALL
                        SELECT DATE_ADD(date, INTERVAL 1 DAY)
                        FROM temp_table
                        WHERE date < '" . $end . "'
                    )
                    SELECT temp_table.date, COUNT(eventlog.log_id) AS count
                    FROM temp_table
                    LEFT JOIN eventlog ON temp_table.date = CAST(eventlog.create_at AS DATE) AND eventlog.user_id = " . $user_id . "
                    GROUP BY temp_table.date
                    ORDER BY temp_table.date;
                    ";

            $data = $db->query($query)->getResult();

        }catch(mysqli_sql_exception $e){
            // cpanel MySQL 5.7 version =="
            $query = "
                    SELECT d.date, COUNT(e.log_id) AS count
                    FROM dates d
                    LEFT JOIN eventlog e ON d.date = CAST(e.create_at AS DATE) AND e.user_id = " . $user_id . "
                    WHERE d.date between '" . $start . "' and '" . $end . "'
                    GROUP BY d.date
                    ORDER BY d.date;
                    ";
                    
            $data = $db->query($query)->getResult();
        }

        return $data;
    }
}
