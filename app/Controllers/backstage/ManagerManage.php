<?php

namespace App\Controllers\backstage;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use App\Models\UsersModel;

class ManagerManage extends BaseController
{
    use ResponseTrait;

    public function index()
    {
        $userData = $this->session->userData;
        return view('pages/backstage/manager_home', $userData);
    }

    public function managerinfo(){
        $userData = $this->session->userData;
        return view('pages/backstage/managerinfo', $userData);
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
        }else if($password == $cpassword && $password != null && $password !== " " ){
            $updateValues = [
                'password_hash' =>  password_hash($password, PASSWORD_DEFAULT),
            ];
            $usersModel->update($verifyUserData['u_id'], $updateValues);
        }

        $updateValues = [
            'email'       =>  $email,
            'nickname'    =>  $nickname,
            'goal'        =>  $goal,
            'lasting'     =>  $lasting,
        ];
        $usersModel->update($verifyUserData['u_id'], $updateValues);

        $userData  = $usersModel->where("u_id", $verifyUserData['u_id'])->first();
        $this->session->set("userData", [
            'uuid'      => $userData['uuid'],
            'email'     => $userData['email'],
            'nickname'  => $userData['nickname'],
            'goal'      => $userData['goal'],
            'lasting'   => $userData['lasting'],
            'coins'     => $userData['coins'],
        ]);

        return $this->respond([
            "status" => true,
            "msg"    => "個人資料修改成功"
        ]);
    }

    public function delete($uuid)
    {
        $usersModel = new UsersModel();
        $verifyUserData = $usersModel->where("uuid", $uuid)->first();

        if($verifyUserData === null) {
            return $this->fail("查無此帳號", 404);
        }

        $usersModel->delete($verifyUserData['u_id']);

        return $this->respond([
            "status" => true,
            "msg"    => "帳號刪除成功"
        ]);
    }
}
