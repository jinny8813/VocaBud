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
        $update_state=-1;
        if($state[0]['card_state']==0){
            $update_state=5;
            switch($data['answer']){
                case "忘記":
                    $update_state=$update_state-4;
                    break;
                case "模糊":
                    $update_state=$update_state-2;
                    break;
                case "熟悉":
                    $update_state=$update_state+3;
                    break;
                }
        }else{
            $update_state=$state[0]['card_state'];
            switch($data['answer']){
                case "忘記":
                    $update_state=$update_state-2;
                    break;
                case "模糊":
                    $update_state=$update_state-1;
                    break;
                case "熟悉":
                    $update_state=$update_state+1;
                    break;
            }
            if($update_state>=10){
                $update_state=10;
            }else if($update_state<=1){
                $update_state=1;
            }
        }
        $cardModel->where('card_id', $data['card_id'])
                ->set('card_state', $update_state)
                ->set('last_quiztime', $date)
                ->update();
    }
}
