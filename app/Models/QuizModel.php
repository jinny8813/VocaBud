<?php
namespace App\Models;
use CodeIgniter\Model;

class QuizModel extends Model
{
    public function getSelfQuiz($date,$book_id,$select_old,$select_wrong,$select_state,$select_amount){
        $wherebook="c.book_id IN ({$book_id})";
        switch ($select_state){
            case "差":
                $state=[1,2];
                break;
            case "弱":
                $state=[3,4];
                break;
            case "中":
                $state=[5,6];
                break;
            case "可":
                $state=[7,8];
                break;
            case "佳":
                $state=[9,10];
                break;
            case "已測驗":
                $state=[1,2,3,4,5,6,7,8,9,10];
                break;
        }
        $wherec="DATEDIFF('{$date}',c.create_at)>={$select_old}";
        $wheree="DATEDIFF('{$date}',e.maxdate)>={$select_old}";
        $where30="DATEDIFF('{$date}',e.maxdate)<=30";

        $db = \Config\Database::connect();
        $builder = $db->table('cards c');
        if($select_state=="未測驗"){
            $query = $builder->select("c.*")
                    ->where($wherebook)
                    ->where($wherec)
                    ->whereIn('c.card_state', [0])
                    ->groupBy('c.card_id')
                    ->orderBy('title', 'RANDOM')
                    ->limit($select_amount)
                    ->get()->getResult();
        }else{
            if($select_wrong==0){
                $query = $builder->select("c.*")
                    ->join('(select card_id, max(create_at) as maxdate
                                from eventlog
                                group by card_id) e','c.card_id = e.card_id')
                    ->where($wherebook)
                    ->whereIn('c.card_state', $state)
                    ->where($wheree)
                    ->groupBy('c.card_id')
                    ->orderBy('title', 'RANDOM')
                    ->limit($select_amount)
                    ->get()->getResult();
            }else{
                $query = $builder->select("c.*")
                    ->join('(select card_id, max(create_at) as maxdate
                            from eventlog
                            group by card_id) e','c.card_id = e.card_id')
                    ->where($wheree)
                    ->where($wherebook)
                    ->whereIn('c.card_state', $state)
                    ->whereIn('e.choose', ["模糊","忘記"])
                    ->where($where30)
                    ->groupBy('c.card_id')
                    ->having('c_count>=' . $select_wrong)
                    ->orderBy('title', 'RANDOM')
                    ->limit($select_amount)
                    ->get()->getResult();
            }
        }
        
        $data=array();
        foreach($query as $row){
            array_push($data,(array)$row);
        }
        return $data;
    }

    public function getSystemQuiz($book_id, $select_amount)
    {
        $whereBook="c.book_id IN ({$book_id})";

        $db = \Config\Database::connect();
        $temp =  "
                    select c.card_id
                    FROM cards c
                    WHERE {$whereBook}
                    AND c.card_state IN (0)
                ";
        $temp_query['id_new_cards'] = $db->query($temp)->getResult();
        $id_new_cards = $this->toCardIdStr($temp_query['id_new_cards']);
        $temp =  "
                    select c.card_id
                    FROM cards c
                    join (SELECT card_id
                    FROM eventlog) e on c.card_id = e.card_id
                    WHERE {$whereBook}
                    GROUP BY c.card_id
                ";
        $temp_query['id_old_cards'] = $db->query($temp)->getResult();
        $id_old_cards = $this->toCardIdStr($temp_query['id_old_cards']);
        
        $select_cards_id = "";
        $amount_old_cards = 0;
        $finally_cards = $select_amount;
        if($select_amount >= count($temp_query['id_old_cards']) / 10){
            $amount_maxdate = $select_amount / 10;

            $temp = "
                    select c.card_id
                    FROM cards c
                    join (SELECT card_id, MAX(create_at) as maxdate, AVG(choose) as avg_choose
                    FROM eventlog
                    GROUP BY card_id) e on c.card_id = e.card_id
                    WHERE c.card_id IN ({$id_old_cards})
                    GROUP BY c.card_id
                    ORDER BY e.maxdate, c.card_state, e.avg_choose DESC
                    LIMIT {$amount_maxdate}
                ";
            $temp_query['old_maxdate'] = $db->query($temp)->getResult();
            $id_old_maxdate = $this->toCardIdStr($temp_query['old_maxdate']);

            $amount_state = $select_amount * 4 / 5;

            $temp = "
                    select c.card_id
                    FROM cards c
                    join (SELECT card_id, MAX(create_at) as maxdate, AVG(choose) as avg_choose
                    FROM eventlog
                    GROUP BY card_id) e on c.card_id = e.card_id
                    WHERE c.card_id IN ({$id_old_cards})
                    AND c.card_id NOT IN ({$id_old_maxdate})
                    GROUP BY c.card_id
                    ORDER BY c.card_state, e.maxdate, e.avg_choose DESC
                    LIMIT {$amount_state}
                ";
            $temp_query['old_state'] = $db->query($temp)->getResult();
            $id_old_state = $this->toCardIdStr($temp_query['old_state']);

            $select_cards_id = $select_cards_id . $id_old_maxdate . "," . $id_old_state;
            $amount_old_cards = $amount_old_cards + count($temp_query['old_maxdate']) + count($temp_query['old_state']);
        }

        $finally_cards = $finally_cards - $amount_old_cards;

        if(count($temp_query['id_new_cards']) < 1){
            $temp = "
                    select c.card_id
                    FROM cards c
                    join (SELECT card_id, MAX(create_at) as maxdate, AVG(choose) as avg_choose
                    FROM eventlog) e on c.card_id = e.card_id
                    WHERE c.card_id IN ({$id_old_cards})
                    AND c.card_id NOT IN ({$select_cards_id})
                    GROUP BY c.card_id
                    ORDER BY RAND()
                    LIMIT {$finally_cards}
                ";
            $temp_query['finally_cards'] = $db->query($temp)->getResult();
            $id_finally_cards = $this->toCardIdStr($temp_query['finally_cards']);
            
            if(empty($id_finally_cards) === false)
                $select_cards_id = $select_cards_id . "," . $id_finally_cards;
        }else{
            $temp =  "
                    select c.card_id
                    FROM cards c
                    WHERE c.card_id IN ({$id_new_cards})
                    ORDER BY RAND()
                    LIMIT {$finally_cards}
                ";
            $temp_query['finally_cards'] = $db->query($temp)->getResult();
            $id_finally_cards = $this->toCardIdStr($temp_query['finally_cards']);

            if($finally_cards == $select_amount)
                $select_cards_id = $select_cards_id . $id_finally_cards;
            else
                $select_cards_id = $select_cards_id . "," . $id_finally_cards;
        }

        $temp =  "
                    select *
                    FROM cards c
                    WHERE c.card_id IN ({$select_cards_id})
                    ORDER BY RAND()
                ";
        $data = $db->query($temp)->getResult();

        return $data;
    }

    public function toCardIdStr($sql_result)
    {
        $arr= array();
        foreach($sql_result as $row){
            array_push($arr, $row->card_id);
        }
        $str=implode( ',', $arr);
        return $str;
    }
}