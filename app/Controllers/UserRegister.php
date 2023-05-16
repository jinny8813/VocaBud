<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;
use App\Models\UserModel;
use App\Controllers\Collection;

class UserRegister extends BaseController
{
    use ResponseTrait;

    public function index()
    {
        if(session()->get('userData')) {
            return redirect()->to("/home");
        } else {
            date_default_timezone_set('Asia/Taipei');
            $date = date('Y-m-d H:i:s');

            $request = \Config\Services::request();
            $data = $request->getPost();

            if($data['password'] != $data['cpassword']) {
                return $this->response->setStatusCode(400)->setJSON("密碼驗證錯誤");
            }

            $userModel = new UserModel();
            $temp = $userModel->where('email', $data['email'])->first();

            if($temp != null) {
                return $this->response->setStatusCode(400)->setJSON("帳號已被註冊");
            }

            $values = [
                'email'=>$data['email'],
                'password'=>$data['password'],
                'nickname'=>$data['nickname'],
                'create_at'=>$date,
            ];
            $userModel->insert($values);

            $user = $userModel->select("user_id")->where('email', $data['email'])->first();
            $collection = new Collection();
            $collection->create($user['user_id']);

            return $this->response->setStatusCode(200)->setJSON("OK");
        }
    }
}
