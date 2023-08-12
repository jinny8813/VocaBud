<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;
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

        return $data;
    }
}
