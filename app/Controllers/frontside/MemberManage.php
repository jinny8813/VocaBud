<?php

namespace App\Controllers\frontside;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use App\Models\UsersModel;

class MemberManage extends BaseController
{
    use ResponseTrait;

    public function index()
    {
        $userData = $this->session->userData;

        // $u_id           = $userData['u_id'];

        // if(date('l')=='Monday') {
        //     $dateWeekFirst = date('Y-m-d', strtotime("monday 0 week"));
        // } else {
        //     $dateWeekFirst = date('Y-m-d', strtotime("monday -1 week"));
        // }
        // $dateWeekEnd   = date('Y-m-d', strtotime("sunday 0 week"));

        // $eventlogModel = new EventlogModel();
        // $logData['the_week_log_count'] = $eventlogModel->getRangeLogCount($u_id, $dateWeekFirst, $dateWeekEnd);

        // $dateData = ['date' => date('Y-m-d')];
        // $data = array_merge($userData, $logData, $dateData);

        return view('pages/frontside/user_home', $userData);
    }

    public function personalinfo(){
        $userData = $this->session->userData;
        return view('pages/frontside/personalinfo', $userData);
    }

    public function personal($uuid){
        $userData = $this->session->userData;
        return view('pages/frontside/personalinfo', $userData);
    }

    public function renderUpdatePage($uuid){
        $userData = $this->session->userData;
        return view('pages/frontside/personalinfo_edit', $userData);
    }

    public function update($uuid)
    {
        $data = $this->request->getJSON(true);

        $cardsModel = new CardsModel();
        $verifyCardData = $cardsModel->where("uuidv4", $uuidv4)->first();

        if($verifyCardData === null) {
            return $this->fail("查無此字卡", 404);
        }

        $title          = $data['title'];
        $content        = $data['content'];
        $e_content      = $data['e_content'];
        $pronunciation  = $data['pronunciation'];
        $part_of_speech = $data['part_of_speech'];
        $e_sentence     = $data['e_sentence'];
        $c_sentence     = $data['c_sentence'];
        $date           = date("Y-m-d H:i:s");

        if($title === null || $content === null) {
            return $this->fail("標題內容是必要欄位", 404);
        }

        if($title === " " || $content === " ") {
            return $this->fail("標題內容是必要欄位", 404);
        }

        $updateValues = [
            'title'          => $title,
            'content'        => $content,
            'e_content'      => $e_content,
            'pronunciation'  => $pronunciation,
            'part_of_speech' => $part_of_speech,
            'e_sentence'     => $e_sentence,
            'c_sentence'     => $c_sentence,
            'updated_at'     => $date
        ];
        $cardsModel->update($verifyCardData['c_id'], $updateValues);

        return $this->respond([
            "status" => true,
            "msg"    => "字卡修改成功"
        ]);
    }
}
