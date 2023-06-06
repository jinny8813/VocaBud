<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;
use App\Models\CardModel;
use App\Models\StateModel;

class PerCard extends BaseController
{
    use ResponseTrait;

    public function index($c_id)
    {
        $userData = session()->userData;

        $cardModel = new CardModel();
        $data['card'] = $cardModel->where("c_id", $c_id)->first();

        return view('pages/percard', $data);
    }
}
