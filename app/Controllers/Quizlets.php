<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;
use CodeIgniter\Database\RawSql;
use App\Models\BooksModel;
use App\Models\CardsModel;
use App\Models\StateModel;
use App\Models\EventlogModel;

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
        $main_way   = $data['main_way'];
        $quiz_type   = $data['quiz_type'];
        $select_amount = $data['select_amount'];

        if($main_way === null || $quiz_type === null) {
            return $this->fail("測驗方式是必填欄位", 404);
        }

        $booksModel = new BooksModel();
        $subQueryBooks = $booksModel->select('b_id')->where('u_id', $u_id)->findAll();
        $b_ids = array_column($subQueryBooks, 'b_id');

        $cardsModel = new CardsModel;
        $subQueryCards = $cardsModel->select('c_id')->whereIn('b_id', $b_ids)->findAll();
        $c_ids = array_column($subQueryCards, 'c_id');
        
        $stateModel = new StateModel;
        $query['newcards'] = $stateModel->select('cards.c_id')
                                        ->join('cards', 'cards.c_id = state.c_id')
                                        ->where('state.u_id', $u_id)
                                        ->where('state.state', 0)
                                        ->whereIn('cards.c_id', $c_ids)
                                        ->where('cards.deleted_at', null)
                                        ->orderBy('title', 'RANDOM')
                                        ->limit($select_amount * 1/10)
                                        ->find();

        $sql = "(SELECT s_id, MAX(created_at) as maxdate, AVG(score) as avg_score FROM eventlog GROUP BY s_id) AS eventlog";

        $query['oldcards_date'] = $stateModel->select('cards.c_id')
                                        ->join(new RawSql($sql), 'eventlog.s_id = state.s_id')
                                        ->join('cards', 'cards.c_id = state.c_id')
                                        ->where('state.u_id', $u_id)
                                        ->whereNotIn('state.state', [0])
                                        ->whereIn('cards.c_id', $c_ids)
                                        ->where('cards.deleted_at', null)
                                        ->orderBy('eventlog.maxdate ASC, state.state ASC, eventlog.avg_score DESC')
                                        ->limit($select_amount * 2/10)
                                        ->find();

        $query['oldcards_state'] = $stateModel->select('cards.c_id')
                                        ->join(new RawSql($sql), 'eventlog.s_id = state.s_id')
                                        ->join('cards', 'cards.c_id = state.c_id')
                                        ->where('state.u_id', $u_id)
                                        ->whereNotIn('state.state', [0])
                                        ->whereIn('cards.c_id', $c_ids)
                                        ->where('cards.deleted_at', null)
                                        ->orderBy('state.state ASC, eventlog.avg_score DESC, eventlog.maxdate ASC')
                                        ->limit($select_amount * 6/10)
                                        ->find();

        $select_c_ids = array_merge(array_column($query['newcards'], 'c_id'),
                                    array_column($query['oldcards_date'], 'c_id'), 
                                    array_column($query['oldcards_state'], 'c_id'));

        $query['randoms'] = $stateModel->select('cards.c_id')
                            ->join('cards', 'cards.c_id = state.c_id')
                            ->where('state.u_id', $u_id)
                            ->whereNotIn('cards.c_id', $select_c_ids)
                            ->where('cards.deleted_at', null)
                            ->orderBy('title', 'RANDOM')
                            ->limit($select_amount - count($select_c_ids))
                            ->find();
        $all_c_ids = array_merge(array_column($query['newcards'], 'c_id'),
                    array_column($query['randoms'], 'c_id'));
       
        $quizData['cards'] = $cardsModel->select('*')
                                        ->join('state', 'cards.c_id = state.c_id')
                                        ->whereIn('cards.c_id', $all_c_ids)
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
        $data = $this->request->getPost();
        $userData = $this->session->userData;

        $u_id          = $userData['u_id'];
        $s_id   = $data['s_id'];
        $score   = $data['score'];

        if($s_id === null || $score === null) {
            return $this->fail("測驗記錄錯誤", 404);
        }

        $eventlogModel = new EventlogModel();
        $values = [
            'u_id'=>$u_id,
            's_id'=>$s_id,
            'score'=>$score,
        ];
        $eventlogModel->insert($values);

        $stateModel = new StateModel();
        $verifyStateData = $stateModel->where('s_id', $s_id)->first();

        if($verifyStateData['u_id'] !== $u_id) {
            return $this->fail("測驗對象錯誤", 404);
        }

        $update_state = $verifyStateData['state'];

        switch($score){
            case 1:
                $update_state = round($update_state/2);
                break;
            case 3:
                $update_state = round($update_state/1.5);
                break;
            case 5:
                $update_state = $update_state + 2;
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

        $updateValues = [
            'state' => $update_state,
            'grade' => $update_grade,
        ];
        $stateModel->update($verifyStateData['s_id'], $updateValues);

        return $this->respond([
            "status" => true,
            "msg"    => "測驗紀錄成功"
        ]);
    }
}
