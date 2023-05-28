<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;
use App\Models\EventlogModel;
use App\Models\CardModel;

class Flashcard extends BaseController
{
    use ResponseTrait;

    public function index()
    {
        $data1 = session()->quizData;
        return view('pages/quiz_flashcard',$data1);
    }

    public function store()
    {
        date_default_timezone_set('Asia/Taipei');
        $date = date('Y-m-d');

        $userData = session()->userData;

        $request = \Config\Services::request();
        $data = $request->getPost();

        $eventlogModel = new EventlogModel();
        $values = [
            'user_id'=>$userData['user_id'],
            'card_id'=>$data['card_id'],
            'choose'=>$data['answer'],
            'create_at'=>$date,
        ];
        $eventlogModel->insert($values);

        $cardModel = new CardModel();
        $state = $cardModel->where('card_id', $data['card_id'])->findAll();
        $update_state = $state[0]['card_state'];

        switch($data['answer']){
            case 3:
                $update_state = round($update_state/4);
                break;
            case 2:
                $update_state = round($update_state/2);
                break;
            case 1:
                $update_state = $update_state + 1;
                break;
        }

        if($update_state >= 100){
            $update_state = 100;
        }else if($update_state <= 1){
                $update_state = 1;
        }

        $cardModel->where('card_id', $data['card_id'])
                ->set('card_state', $update_state)
                ->set('last_quiztime', $date)
                ->update();
    }
}
