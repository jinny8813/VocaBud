<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;
use CodeIgniter\Database\RawSql;

use App\Models\EventlogModel;

class Statistics extends BaseController
{
    use ResponseTrait;

    public function index()
    {
        $date = date('Y-m-d');
        $data['data'] = $this->setDaily($date);

        return view('pages/statistics_main', $data);
    }
    
    public function setDaily($date)
    {
        $userData = $this->session->userData;

        $u_id = $userData['u_id'];

        $dateSub7       = date('Y-m-d', strtotime($date. ' - 6 days'));
        $dateMonthFirst = date("Y-m-01", strtotime($date));
        $dateMonthEnd   = date("Y-m-t", strtotime($date));

        $eventlogModel = new EventlogModel();
        $data['weekly_log_count'] = $eventlogModel->getRangeLogCount($u_id,$dateSub7,$date);
        $data['the_month_log_count'] = $eventlogModel->getRangeLogCount($u_id,$dateMonthFirst,$dateMonthEnd);

        $sql = "dates.date = CAST(eventlog.created_at AS DATE)";
        $quizzedDays = $eventlogModel->select('dates.date')
                                    ->join('dates', new RawSql($sql), 'left')
                                    ->where('eventlog.u_id',$u_id)
                                    ->where("dates.date <= CAST('{$date}' AS DATE)")
                                    ->groupBy('dates.date')
                                    ->findAll();
        
        $index = 0;
        while(true){
            if(date_format(date_sub(date_create($quizzedDays[$index]['date']), date_interval_create_from_date_string('1 days')), 'Y-m-d') == $quizzedDays[$index+1]['date']){
                $index++;
            }else{
                break;
            }
        }

        $data['single_data'] = [
            'accumulated_days' => count($quizzedDays),
            'consecutive_days' => $index
        ];

        return $data;
    }
}
