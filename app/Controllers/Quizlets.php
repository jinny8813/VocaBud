<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;
use App\Models\BooksModel;
use App\Models\CardsModel;

class Quizlets extends BaseController
{
    use ResponseTrait;

    public function index()
    {
        return view('pages/quiz_list');
    }

    public function renderCreatePage()
    {
        $userData = $this->session->userData;

        $u_id = $userData['u_id'];

        $booksModel = new BooksModel();
        $data['books'] = $booksModel->where('u_id', $u_id)->findAll();

        return view('pages/quiz_create', $data);
    }

    public function createQuiz()
    {
        $data = $this->request->getPost();
        $userData = $this->session->userData;

        $u_id          = $userData['u_id'];
        $select_book   = $data['select_book'];
        $select_amount = $data['select_amount'];

        if($select_book === null || $select_amount === null) {
            return $this->fail("書本和測驗數目是必填欄位", 404);
        }

        $cardsModel = new CardsModel;
        $quizData['cards'] = $cardsModel->select('cards.*')
                                        ->select('state.*')
                                        ->join('state', 'cards.c_id = state.c_id')
                                        ->where('state.u_id', $u_id)
                                        ->where('cards.deleted_at', null)
                                        ->orderBy('title', 'RANDOM')
                                        ->findAll();


        $this->session->set("quizData", $quizData);
        return $this->respond([
            "status" => true,
            "msg"    => "測驗建立成功"
        ]);
    }

    public function renderQuizzingPage()
    {
        $quizData = $this->session->quizData;

        return view('pages/quiz_flashcard',$quizData);
    }

    public function store()
    {
        
    }
}
