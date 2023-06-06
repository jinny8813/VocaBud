<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;
use App\Models\EventlogModel;

class Statistics extends BaseController
{
    use ResponseTrait;

    public function index()
    {
        date_default_timezone_set('Asia/Taipei');
        $date = date('Y-m-d H:i:s');

        $data1 = $this->setDaily($date);

        return view('pages/statistics_main',  ['data' => $data1]);
    }

    public function changeDaily()
    {
        $request = \Config\Services::request();
        $data = $request->getPost();

        $data1 = $this->setDaily($data['date']);

        return $this->respond($data1);;
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
