<?php

namespace App\Controllers\frontside;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use App\Models\UsersModel;

class MemberManage extends BaseController
{
    use ResponseTrait;

    public function index()
    {
        $userData = $this->session->userData;

        // $u_id           = $userData['u_id'];

        // if(date('l')=='Monday') {
        //     $dateWeekFirst = date('Y-m-d', strtotime("monday 0 week"));
        // } else {
        //     $dateWeekFirst = date('Y-m-d', strtotime("monday -1 week"));
        // }
        // $dateWeekEnd   = date('Y-m-d', strtotime("sunday 0 week"));

        // $eventlogModel = new EventlogModel();
        // $logData['the_week_log_count'] = $eventlogModel->getRangeLogCount($u_id, $dateWeekFirst, $dateWeekEnd);

        // $dateData = ['date' => date('Y-m-d')];
        // $data = array_merge($userData, $logData, $dateData);

        return view('pages/frontside/user_home', $userData);
    }

    public function personalinfo(){
        $userData = $this->session->userData;
        return view('pages/frontside/personalinfo', $userData);
    }

    public function personal($uuid){
        $userData = $this->session->userData;
        return view('pages/frontside/personalinfo', $userData);
    }

    public function renderUpdatePage($uuid){
        $userData = $this->session->userData;
        return view('pages/frontside/personalinfo_edit', $userData);
    }

    public function update($uuid)
    {
        $data = $this->request->getJSON(true);

        $usersModel = new UsersModel();
        $verifyUserData = $usersModel->where("uuid", $uuid)->first();

        if($verifyUserData === null) {
            return $this->fail("查無此帳號", 404);
        }

        $email      = $data['email'];
        $password   = $data['password'];
        $cpassword  = $data['cpassword'];
        $nickname   = $data['nickname'];
        $goal      = $data['goal'];
        $lasting   = $data['lasting'];
        $date       = date("Y-m-d H:i:s");

        if($email === null || $nickname === null) {
            return $this->fail("標題內容是必要欄位", 404);
        }

        if($email === " " || $nickname === " ") {
            return $this->fail("標題內容是必要欄位", 404);
        }

        if($goal === null || $goal === " " || $goal < 0 || $goal > 99999) {
            return $this->fail("目標必須是介於0~99999的數字", 404);
        }

        if($lasting === null || $lasting === " " || $lasting < 0 || $lasting > 999) {
            return $this->fail("計算期間必須是介於0~999的數字", 404);
        }

        if($password != $cpassword) {
            return $this->fail("密碼驗證錯誤", 403);
        }else{
            $updateValues = [
                'password_hash' =>  password_hash($password, PASSWORD_DEFAULT),
            ];
            $usersModel->update($verifyUserData['u_id'], $updateValues);
        }

        $updateValues = [
            'email'       =>  $email,
            'nickname'    =>  $nickname,
            'goal'        =>  0,
            'lasting'     =>  30,
            'updated_at'  => $date
        ];
        $usersModel->update($verifyUserData['u_id'], $updateValues);

        return $this->respond([
            "status" => true,
            "msg"    => "個人資料修改成功"
        ]);
    }
}
