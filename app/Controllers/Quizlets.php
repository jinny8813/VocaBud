<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;
use App\Models\BooksModel;
use App\Models\CardsModel;
use App\Models\StateModel;

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
        $quizData['cards'] = $stateModel->join('cards', 'cards.c_id = state.c_id')
                                        ->where('state.u_id', $u_id)
                                        ->whereIn('cards.c_id', $c_ids)
                                        ->where('cards.deleted_at', null)
                                        ->orderBy('title', 'RANDOM')
                                        ->findAll();

        $this->session->set("quizData", $quizData);
        return $this->respond([
            "status" => true,
            "msg"    => "測驗建立成功"
        ]);
    }

    public function getSystemQuiz($u_id, $b_id, $select_amount)
    {
        $whereBook="b_id IN ({$b_id})";

        $db = \Config\Database::connect();
        $temp =  "
                    select c.c_id
                    FROM state s
                    join (SELECT c_id
                    FROM cards WHERE {$whereBook}) c on s.c_id = c.c_id
                    WHERE s.state IN (0)
                ";
        $query['id_new_cards'] = $db->query($temp)->getResult();
        $str_id_new_cards = $this->toCardIdStr($query['id_new_cards']);

        $temp =  "
                    select c.c_id
                    FROM state s
                    join (SELECT c_id
                    FROM cards WHERE {$whereBook}) c on s.c_id = c.c_id
                    WHERE s.state NOT IN (0)
                ";
        $query['id_old_cards'] = $db->query($temp)->getResult();
        $str_id_old_cards = $this->toCardIdStr($query['id_old_cards']);

        $all_cards_id = "";
        if(count($query['id_new_cards']) + count($query['id_old_cards']) <= $select_amount){
            if(empty($str_id_old_cards) == true){
                $all_cards_id = $all_cards_id . $str_id_new_cards;
            }else if(empty($str_id_new_cards) == true){
                $all_cards_id = $all_cards_id . $str_id_old_cards;
            }else{
                $all_cards_id = $all_cards_id . $str_id_new_cards . "," . $str_id_old_cards;
            }
        }else{
            if(empty($str_id_old_cards) == true){
                $temp =  "
                            select c.c_id
                            FROM cards c
                            WHERE c.c_id IN ({$str_id_new_cards})
                            ORDER BY RAND()
                            LIMIT {$select_amount}
                        ";
                $temp_query['finally_new_cards'] = $db->query($temp)->getResult();
                $str_id_finally_new_cards = $this->toCardIdStr($temp_query['finally_new_cards']);

                $all_cards_id = $all_cards_id . $str_id_finally_new_cards;
            }else if(empty($str_id_new_cards) == true){
                $select_amount_old_cards_maxdate = $select_amount * 0.1;
                $select_amount_old_cards_state = $select_amount - $select_amount_old_cards_maxdate;
                $temp = "
                            (
                            select s.c_id
                            FROM state s
                            join (SELECT s_id, MAX(create_at) as maxdate, AVG(score) as avg_score
                            FROM eventlog
                            GROUP BY s_id) e on s.s_id = e.s_id
                            WHERE s.c_id IN ({$str_id_old_cards})
                            ORDER BY e.maxdate, s.state, e.avg_score DESC
                            LIMIT {$select_amount_old_cards_maxdate}
                            )
                            UNION
                            (
                            select s.c_id
                            FROM state s
                            join (SELECT s_id, MAX(create_at) as maxdate, AVG(score) as avg_score
                            FROM eventlog
                            GROUP BY s_id) e on s.s_id = e.s_id
                            WHERE s.c_id IN ({$str_id_old_cards})
                            ORDER BY s.state, e.maxdate, e.avg_score DESC
                            LIMIT {$select_amount_old_cards_state}
                            )
                        ";
                $temp_query['finally_old_cards'] = $db->query($temp)->getResult();
                $str_id_finally_old_cards = $this->toCardIdStr($temp_query['finally_old_cards']);

                $all_cards_id = $all_cards_id . $str_id_finally_old_cards;
            }else{
                $select_amount_new_cards = $select_amount * 0.2;
                $temp =  "
                            select c.c_id
                            FROM cards c
                            WHERE c.c_id IN ({$str_id_new_cards})
                            ORDER BY RAND()
                            LIMIT {$select_amount_new_cards}
                        ";
                $temp_query['finally_new_cards'] = $db->query($temp)->getResult();
                $str_id_finally_new_cards = $this->toCardIdStr($temp_query['finally_new_cards']);

                $select_amount_old_cards_maxdate = $select_amount * 0.1;
                $select_amount_old_cards_state = $select_amount - $select_amount_old_cards_maxdate - $select_amount_new_cards;
                $temp = "
                            (
                            select s.c_id
                            FROM state s
                            join (SELECT s_id, MAX(create_at) as maxdate, AVG(score) as avg_score
                            FROM eventlog
                            GROUP BY s_id) e on s.s_id = e.s_id
                            WHERE s.c_id IN ({$str_id_old_cards})
                            ORDER BY e.maxdate, s.state, e.avg_score DESC
                            LIMIT {$select_amount_old_cards_maxdate}
                            )
                            UNION
                            (
                            select s.c_id
                            FROM state s
                            join (SELECT s_id, MAX(create_at) as maxdate, AVG(score) as avg_score
                            FROM eventlog
                            GROUP BY s_id) e on s.s_id = e.s_id
                            WHERE s.c_id IN ({$str_id_old_cards})
                            ORDER BY s.state, e.maxdate, e.avg_score DESC
                            LIMIT {$select_amount_old_cards_state}
                            )
                        ";
                $temp_query['finally_old_cards'] = $db->query($temp)->getResult();
                $str_id_finally_old_cards = $this->toCardIdStr($temp_query['finally_old_cards']);

                $all_cards_id = $all_cards_id . $str_id_finally_new_cards . "," . $str_id_finally_old_cards;
            }
        }

        $temp =  "
                    select *
                    FROM cards c
                    join (SELECT *
                    FROM state
                    WHERE u_id = {$u_id}) s on s.c_id = c.c_id
                    WHERE c.c_id IN ({$all_cards_id})
                    ORDER BY RAND()
                ";
        $data = $db->query($temp)->getResult();

        return $data;
    }

    public function toCardIdStr($sql_result)
    {
        $arr= array();
        foreach($sql_result as $row){
            array_push($arr, $row->c_id);
        }
        $str=implode( ',', $arr);
        return $str;
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
