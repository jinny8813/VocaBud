<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;
use App\Models\EventlogModel;

class MemberManage extends BaseController
{
    use ResponseTrait;

    public function index()
    {
        $userData = $this->session->userData;

        $u_id           = $userData['u_id'];

        if(date('l')=='Monday')
            $dateWeekFirst = date('Y-m-d', strtotime("monday 0 week"));
        else
            $dateWeekFirst = date('Y-m-d', strtotime("monday -1 week"));
        $dateWeekEnd   = date('Y-m-d', strtotime("sunday 0 week"));

        $eventlogModel = new EventlogModel();
        $logData['the_week_log_count'] = $eventlogModel->getRangeLogCount($u_id, $dateWeekFirst, $dateWeekEnd);

        $dateData = ['date' => date('Y-m-d')];
        $data = array_merge($userData, $logData, $dateData);

        return view('pages/user_home', $data);
    }
}
