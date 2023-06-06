<?php
namespace App\Models;
use CodeIgniter\Model;

class FlashcardModel extends Model
{
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
            $all_cards_id = $all_cards_id . $str_id_new_cards . "," . $str_id_old_cards;
        }else{
            if(count($query['id_old_cards']) <= $select_amount * 0.8){
                $select_amount_new_cards = $select_amount - count($query['id_old_cards']);
                $temp =  "
                            select c.c_id
                            FROM cards c
                            WHERE c.c_id IN ({$str_id_new_cards})
                            ORDER BY RAND()
                            LIMIT {$select_amount_new_cards}
                        ";
                $temp_query['finally_new_cards'] = $db->query($temp)->getResult();
                $str_id_finally_new_cards = $this->toCardIdStr($temp_query['finally_new_cards']);

                $all_cards_id = $all_cards_id . $str_id_finally_new_cards . "," . $str_id_old_cards;
            }else{
                $select_amount_old_cards_maxdate = $select_amount * 0.1;
                $temp = "
                            select s.c_id
                            FROM state s
                            join (SELECT s_id, MAX(create_at) as maxdate, AVG(score) as avg_score
                            FROM eventlog
                            GROUP BY s_id) e on s.s_id = e.s_id
                            WHERE s.c_id IN ({$str_id_old_cards})
                            ORDER BY e.maxdate, s.state, e.avg_score DESC
                            LIMIT {$select_amount_old_cards_maxdate}
                        ";
                $temp_query['maxdate_old_cards'] = $db->query($temp)->getResult();
                $str_id_maxdate_old_cards = $this->toCardIdStr($temp_query['maxdate_old_cards']);

                if(empty($str_id_finally_new_cards) === true){
                    $select_amount_old_cards_state = $select_amount - $select_amount_old_cards_maxdate;
                    $temp = "
                                select s.c_id
                                FROM state s
                                join (SELECT s_id, MAX(create_at) as maxdate, AVG(score) as avg_score
                                FROM eventlog
                                GROUP BY s_id) e on s.s_id = e.s_id
                                WHERE s.c_id IN ({$str_id_old_cards})
                                AND s.c_id NOT IN ({$str_id_maxdate_old_cards})
                                ORDER BY s.state, e.maxdate, e.avg_score DESC
                                LIMIT {$select_amount_old_cards_state}
                            ";
                    $temp_query['state_old_cards'] = $db->query($temp)->getResult();
                    $str_id_state_old_cards = $this->toCardIdStr($temp_query['state_old_cards']);

                    $all_cards_id = $all_cards_id . $str_id_maxdate_old_cards . "," . $str_id_state_old_cards;
                }
                else{
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

                    $select_amount_old_cards_state = $select_amount - $select_amount_new_cards - $select_amount_old_cards_maxdate;
                    $temp = "
                                select s.c_id
                                FROM state s
                                join (SELECT s_id, MAX(create_at) as maxdate, AVG(score) as avg_score
                                FROM eventlog
                                GROUP BY s_id) e on s.s_id = e.s_id
                                WHERE s.c_id IN ({$str_id_old_cards})
                                AND s.c_id NOT IN ({$str_id_maxdate_old_cards})
                                ORDER BY s.state, e.maxdate, e.avg_score DESC
                                LIMIT {$select_amount_old_cards_state}
                            ";
                    $temp_query['state_old_cards'] = $db->query($temp)->getResult();
                    $str_id_state_old_cards = $this->toCardIdStr($temp_query['state_old_cards']);

                    $all_cards_id = $all_cards_id . $str_id_finally_new_cards . "," . $str_id_maxdate_old_cards . "," . $str_id_state_old_cards;
                }
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
}