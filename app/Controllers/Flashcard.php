<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;
use App\Models\EventlogModel;
use App\Models\StateModel;

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
        $date = date('Y-m-d H:i:s');

        $userData = session()->userData;

        $request = \Config\Services::request();
        $data = $request->getPost();

        $eventlogModel = new EventlogModel();
        $values = [
            'u_id'=>$userData['u_id'],
            's_id'=>$data['s_id'],
            'score'=>$data['score'],
            'create_at'=>$date,
        ];
        $eventlogModel->insert($values);

        $stateModel = new StateModel();
        $state = $stateModel->where('s_id', $data['s_id'])->first();
        $update_state = $state['state'];

        switch($data['score']){
            case 1:
                $update_state = round($update_state/4);
                break;
            case 3:
                $update_state = round($update_state/2);
                break;
            case 5:
                $update_state = $update_state + 1;
                break;
        }

        if($update_state >= 100){
            $update_state = 100;
        }else if($update_state <= 1){
                $update_state = 1;
        }

        $update_grade = "";
        if ($update_state >= 1 && $update_state <= 3) {
            $update_grade = "F";
        } else if ($update_state >= 4 && $update_state <= 10) {
            $update_grade = "D";
        } else if ($update_state >= 11 && $update_state <= 25) {
            $update_grade = "C";
        } else if ($update_state >= 26 && $update_state <= 50) {
            $update_grade = "B";
        } else if ($update_state >= 51 && $update_state <= 100) {
            $update_grade = "A";
        }

        $stateModel->where('s_id', $data['s_id'])
                ->set('state', $update_state)
                ->set('grade', $update_grade)
                ->update();
    }
}
