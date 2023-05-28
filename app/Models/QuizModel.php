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
        $new_amount = $select_amount / 5;

        $db = \Config\Database::connect();
        $builder1 = $db->table('cards c');
        $query['newcard'] = $builder1->select("c.card_id")
                    ->where($whereBook)
                    ->whereIn('c.card_state', [0])
                    ->limit($new_amount)
                    ->get()
                    ->getResult();
        
        $old_amount_maxdate = $select_amount / 10 - count($query['newcard']);

        $temp1 = "
                select c.card_id
                FROM cards c
                join (SELECT card_id, MAX(create_at) as maxdate, AVG(choose) as avg_choose
                    FROM eventlog
                    GROUP BY card_id) e on c.card_id = e.card_id
                WHERE {$whereBook}
                GROUP BY c.card_id
                ORDER BY e.maxdate, c.card_state, e.avg_choose DESC
                LIMIT {$old_amount_maxdate}
            ";
        $query['oldcard_maxdate'] = $db->query($temp1)->getResult();

        $obj_card = array();
        foreach($query['oldcard_maxdate'] as $row){
            array_push($obj_card, $row->card_id);
        }
        $where_not_card_id=implode( ',', $obj_card);

        $old_amount_state = $select_amount - count($query['newcard']) - count($query['oldcard_maxdate']);

        $temp2 = "
                select c.card_id
                FROM cards c
                join (SELECT card_id, MAX(create_at) as maxdate, AVG(choose) as avg_choose
                    FROM eventlog
                    GROUP BY card_id) e on c.card_id = e.card_id
                WHERE {$whereBook}
                AND c.card_id NOT IN ({$where_not_card_id})
                GROUP BY c.card_id
                ORDER BY c.card_state, e.maxdate, e.avg_choose DESC
                LIMIT {$old_amount_state}
            ";
        $query['oldcard_state'] = $db->query($temp2)->getResult();

        foreach($query['newcard'] as $row){
            array_push($obj_card, $row->card_id);
        }
        foreach($query['oldcard_state'] as $row){
            array_push($obj_card, $row->card_id);
        }
        $str_card_id=implode( ',', $obj_card);

        $builder2 = $db->table('cards c');
        $data = $builder2
                    ->where("c.card_id IN ({$str_card_id})")
                    ->orderBy('title', 'RANDOM')
                    ->get()
                    ->getResult();

        return $data;
    }
}