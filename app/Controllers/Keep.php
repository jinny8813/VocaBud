<?php

namespace App\Controllers;
use App\Models\KeepModel;

class Keep extends BaseController
{
    public function index()
    {

    }

    public function toggleKeep()
    {
        date_default_timezone_set('Asia/Taipei');
        $date = date('Y-m-d H:i:s');

        $request = \Config\Services::request();
        $data = $request->getPost();

        $userData = session()->userData;

        $keepModel = new KeepModel();
        $data1 = $keepModel->where("u_id", $userData['u_id'])->where("c_id", $data['c_id'])->first();

        if($data['keeping'] === 'true'){
            if(is_null($data1) === true){
                $values = [
                    'u_id'=>$userData['u_id'],
                    'c_id'=>$data['c_id'],
                    'create_at'=>$date,
                ];
                $keepModel->insert($values);
            }
        }else{
            if(is_null($data1) === false){
                $keepModel->where('k_id', $data1['k_id'])->delete();
            }
        }
        

        return $this->response->setStatusCode(200)->setJSON($data1);
    }
}