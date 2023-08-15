<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;
use CodeIgniter\Database\RawSql;

use App\Models\EventlogModel;
use App\Models\DatesModel;
use App\Models\BooksModel;
use App\Models\CardsModel;

class Statistics extends BaseController
{
    use ResponseTrait;

    public function index()
    {
        $date = date('Y-m-d');
        $data['data'] = $this->setDaily($date);

        return view('pages/statistics_main', $data);
    }

    public function changeDaily()
    {
        $data = $this->request->getPost();

        $date = $data['date'];
        if($date === null) {
            return $this->fail("請選擇日期", 404);
        }

        $changedData = $this->setDaily($date);

        return $this->respond([
            "status" => true,
            "msg"    => "書本建立成功",
            "data"   => $changedData
        ]);
    }
    
    public function setDaily($date)
    {
        $userData = $this->session->userData;

        $u_id = $userData['u_id'];

        $dateSub7       = date('Y-m-d', strtotime($date. ' - 6 days'));
        $dateMonthFirst = date("Y-m-01", strtotime($date));
        $dateMonthEnd   = date("Y-m-t", strtotime($date));

        $eventlogModel = new EventlogModel();
        $data['weekly_log_count'] = $eventlogModel->getRangeLogCount($u_id,$dateSub7,$date);
        $data['the_month_log_count'] = $eventlogModel->getRangeLogCount($u_id,$dateMonthFirst,$dateMonthEnd);

        $data['daily_log_score'] = $eventlogModel->select('eventlog.score')
                                                ->selectCount('*', 'count')
                                                ->where('eventlog.u_id',$u_id)
                                                ->where("CAST(eventlog.created_at AS DATE) = CAST('{$date}' AS DATE)")
                                                ->groupBy('eventlog.score')
                                                ->orderBy('eventlog.score')
                                                ->findAll();

        $sql = "dates.date = CAST(eventlog.created_at AS DATE)";
        $quizzedDays = $eventlogModel->select('dates.date')
                                    ->join('dates', new RawSql($sql), 'left')
                                    ->where('eventlog.u_id',$u_id)
                                    ->where("dates.date <= CAST('{$date}' AS DATE)")
                                    ->groupBy('dates.date')
                                    ->orderBy('dates.date','DESC')
                                    ->findAll();
        
        $dateCount = 0;
        $verifyDate = $date;
        while(true){
            if($dateCount>=count($quizzedDays)){
                break;
            }
            $toverifyDate = $quizzedDays[$dateCount]['date'];
            if($verifyDate == $toverifyDate){
                $verifyDate = date_format(date_sub(date_create($verifyDate), date_interval_create_from_date_string('1 days')), 'Y-m-d');
                $dateCount++;
            }else{
                break;
            }
        }

        $todayQCount = $eventlogModel->where('eventlog.u_id',$u_id)
                                    ->where("CAST(eventlog.created_at AS DATE) = CAST('{$date}' AS DATE)")
                                    ->countAllResults();
        $totalQCount = $eventlogModel->where('eventlog.u_id',$u_id)
                                    ->where("CAST(eventlog.created_at AS DATE) <= CAST('{$date}' AS DATE)")
                                    ->countAllResults();

        $booksModel = new BooksModel();
        $subQueryBooks = $booksModel->select('b_id')->where('u_id', $u_id)->findAll();
        $b_ids = implode(",",array_column($subQueryBooks, 'b_id'));

        $subquery = "(Select created_at, COUNT(c_id) AS count 
                    From cards 
                    Where deleted_at IS NULL 
                    AND b_id IN ({$b_ids}) 
                    Group By CAST(created_at AS DATE)) AS cards";    
        $sql = "dates.date = CAST(cards.created_at AS DATE)";
        $w1  = "dates.date >= CAST('{$dateSub7}' AS DATE)";
        $w2  = "dates.date <= CAST('{$date}' AS DATE)";
        
        $datesModel = new DatesModel();
        $data['weekly_cards_count'] = $datesModel->select('dates.date')
                                                ->select('cards.count', 'count')
                                                ->join(new RawSql($subquery), new RawSql($sql), 'left')
                                                ->where($w1)
                                                ->where($w2)
                                                ->groupBy('dates.date')
                                                ->orderBy('dates.date')
                                                ->findAll();

        $cardsModel = new CardsModel();
        $todayCCount = $cardsModel->whereIn('b_id',array_column($subQueryBooks, 'b_id'))
                                ->where("CAST(created_at AS DATE) = CAST('{$date}' AS DATE)")
                                ->where('deleted_at', null)
                                ->countAllResults();
        $totalCCount = $cardsModel->whereIn('b_id',array_column($subQueryBooks, 'b_id'))
                                ->where("CAST(created_at AS DATE) <= CAST('{$date}' AS DATE)")
                                ->where('deleted_at', null)
                                ->countAllResults();

        $data['single_data'] = [
            'accumulated_days' => count($quizzedDays),
            'consecutive_days' => $dateCount,
            'today_q_count'    => $todayQCount,
            'total_q_count'    => $totalQCount,
            'today_c_count'    => $todayCCount,
            'total_c_count'    => $totalCCount
        ];

        return $data;
    }
}
