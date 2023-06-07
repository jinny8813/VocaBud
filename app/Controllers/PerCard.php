<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;
use App\Models\CardModel;
use App\Models\KeepModel;

class PerCard extends BaseController
{
    use ResponseTrait;

    public function index($c_id)
    {
        $userData = session()->userData;

        $cardModel = new CardModel();
        $data['card'] = $cardModel->where("c_id", $c_id)->first();

        $keepModel = new KeepModel();
        $temp = $keepModel->where("u_id", $userData['u_id'])->where("c_id", $c_id)->first();

        if(is_null($temp) === true){
            $data['keep'] = "white";
        }else{
            $data['keep'] = "yellow";
        }

        return view('pages/percard', $data);
    }
}
