<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;
use App\Models\BookModel;
use App\Models\QuizModel;

class Quizlets extends BaseController
{
    use ResponseTrait;

    public function index()
    {
        return view('pages/quizmolds_list');
    }

    public function create()
    {
        $userData = session()->userData;

        $bookModel=new BookModel();
        $data['books'] = $bookModel->where('user_id', $userData['user_id'])->findAll();
        return view('pages/quizmolds_create', $data);
    }

    public function store()
    {
        
    }

    public function generateQuiz()
    {
        date_default_timezone_set('Asia/Taipei');
        $date = date('Y-m-d');

        $request = \Config\Services::request();
        $data = $request->getPost();

        $quizModel=new QuizModel();
        if($data['main_way'] == "self"){
            $data1['cards'] = $quizModel->getSelfQuiz($date,$data['select_book'],$data['select_old'],$data['select_wrong'],$data['select_state'],$data['select_amount']);
        }else{
            $data1['cards'] = $quizModel->getSystemQuiz($data['select_book'], $data['select_amount']);
        }

        if (count($data1['cards'])==0){
            $this->response->setStatusCode(200)->setJSON("OK");
        }else{
            session()->set("quizData", $data1);
            $this->response->setStatusCode(200)->setJSON("OK");
        }
    }

    public function runQuiz()
    {
        $data1 = session()->quizData;
        return view('pages/quiz_flashcard',$data1);
    }
}
