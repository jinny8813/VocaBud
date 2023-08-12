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
        $userData = session()->userData;

        $dateSub7 = date('Y-m-d', strtotime($date. ' - 6 days'));
        $eventlogModel = new EventlogModel();
        $data1['weekly_log_count'] = $eventlogModel->getRangeLogCount($userData['u_id'],$dateSub7,$date);

        $eventlogModel = new EventlogModel();
        $data1['the_month_log_count'] = $eventlogModel->getRangeLogCount($userData['u_id'],date("Y-m-01", strtotime($date)),date("Y-m-t", strtotime($date)));

        return $data1;
    }
}
