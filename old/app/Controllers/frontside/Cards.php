<?php

namespace App\Controllers\frontside;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use App\Models\CardsModel;
use App\Models\TagsModel;
use App\Models\StateModel;
use App\Models\KeepinglogModel;

class Cards extends BaseController
{
    use ResponseTrait;

    public function index()
    {
        $userData = $this->session->userData;
        $u_id = $userData['u_id'];

        $cardsModel = new CardsModel();
        $cardData['cards'] = $cardsModel->join('state', 'cards.c_id = state.c_id')
                                    ->where('state.u_id', $u_id)
                                    ->orderBy('cards.c_id', 'DESC')
                                    ->findAll();

        $tagsModel = new TagsModel();     
        $TagData['tags'] = $tagsModel->select('tags.*')
                                    ->selectCount('keepinglog.t_id', 'count')
                                    ->join('keepinglog', 'keepinglog.t_id = tags.t_id', 'left')
                                    ->where('tags.u_id', $u_id)
                                    ->groupBy('tags.t_id')
                                    ->orderBy('tags.t_id', 'DESC')
                                    ->findAll();

        $temp = $cardsModel->select('cards.c_id')
                        ->join('keepinglog', 'keepinglog.c_id = cards.c_id')
                        ->join('tags', 'keepinglog.t_id = tags.t_id')
                        ->join('state', 'cards.c_id = state.c_id')
                        ->where('tags.u_id', $u_id)
                        ->where('state.u_id', $u_id)
                        ->groupBy('cards.c_id')
                        ->findAll();
        $cards_had_tags_str = array_values(array_column($temp, 'c_id'));
        $cardData['notagcards'] = $cardsModel->join('state', 'cards.c_id = state.c_id')
                                    ->whereNotIn('cards.c_id', $cards_had_tags_str)
                                    ->orderBy('cards.c_id', 'DESC')
                                    ->findAll();

        $data = array_merge($cardData, $TagData);

        return view('pages/frontside/cards_list', $data);
    }

    public function renderCreatePage()
    {
        $userData = $this->session->userData;
        $u_id = $userData['u_id'];

        $tagsModel = new TagsModel();
        $tagsData['tags'] = $tagsModel->where('u_id', $u_id)->findAll();

        return view('pages/frontside/cards_create', $tagsData);
    }

    public function create()
    {
        $data = $this->request->getPost();
        $userData = $this->session->userData;

        $u_id           = $userData['u_id'];
        $title          = $data['title'];
        $content        = $data['content'];
        $e_content      = $data['e_content'];
        $pronunciation  = $data['pronunciation'];
        $part_of_speech = $data['part_of_speech'];
        $e_sentence     = $data['e_sentence'];
        $c_sentence     = $data['c_sentence'];
        $uuid           = $this->getUuid();
        $select_tags     = $data['select_tags'];
        $tag_add        = $data['tag_add'];

        if($title === null || $content === null) {
            return $this->fail("需標題內容進行建立", 404);
        }

        if($title === " " || $content === " ") {
            return $this->fail("需標題內容進行建立", 404);
        }

        $tagsModel = new TagsModel();
        $select_tags = explode(",",$select_tags);
        $tag_add = explode("_",$tag_add);
        for($i=0;$i<count($tag_add);$i++){
            $temp = trim($tag_add[$i]);
            if($temp != ""){
                $findTag = $tagsModel->where("u_id", $u_id)->where('tagname', $temp)->first();
                $isfound = $findTag['t_id'] ?? null;
                if($isfound === null){
                    $values = [
                        'u_id'    => $u_id,
                        'tagname' => $temp,
                    ];
                    $tagsModel->insert($values);
                    $thetag = $tagsModel->where("u_id", $u_id)->where("tagname", $temp)->first();
                    array_push($select_tags, $thetag['t_id']);
                }else{
                    array_push($select_tags, $isfound);
                }
            }
        }
            
        $values = [
            'u_id'           => $u_id,
            'title'          => $title,
            'content'        => $content,
            'e_content'      => $e_content,
            'pronunciation'  => $pronunciation,
            'part_of_speech' => $part_of_speech,
            'e_sentence'     => $e_sentence,
            'c_sentence'     => $c_sentence,
            'visibility'     =>"self",
            'uuid'           => $uuid,
        ];
        $cardsModel = new CardsModel();
        $cardsModel->insert($values);

        $thecard = $cardsModel->where("uuid", $uuid)->first();
        $c_id = $thecard['c_id'];

        $stateModel = new StateModel();
        $values = [
            'u_id'  => $u_id,
            'c_id'  => $c_id,
            'state' => 0,
            'grade' => "New",
        ];
        $stateModel->insert($values);

        $keepinglogModel = new KeepinglogModel();
        for($i=0;$i<count($select_tags);$i++){
            if($select_tags[$i] != ""){
                $values = [
                    't_id'  => $select_tags[$i],
                    'c_id'  => $c_id,
                ];
                $keepinglogModel->insert($values);
            }
        }

        return $this->respond([
            "status" => true,
            "msg"    => "字卡建立成功"
        ]);
    }

    public function perCard($uuid)
    {
        $userData = $this->session->userData;

        $cardsModel = new CardsModel();
        $cardData = $cardsModel->where("uuid", $uuid)->first();

        if($cardData === null || $cardData['u_id'] != $userData['u_id']) {
            return redirect()->to("/cards");
        }

        return view('pages/frontside/percard', $cardData);
    }

    public function renderUpdatePage($uuid)
    {
        $userData = $this->session->userData;

        $cardsModel = new CardsModel();
        $cardData = $cardsModel->where("uuid", $uuid)->first();

        if($cardData === null || $cardData['u_id'] != $userData['u_id']) {
            return redirect()->to("/cards");
        }

        return view('pages/frontside/percard_edit', $cardData);
    }

    public function update($uuid)
    {
        $data = $this->request->getJSON(true);

        $cardsModel = new CardsModel();
        $verifyCardData = $cardsModel->where("uuid", $uuid)->first();

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
        ];
        $cardsModel->update($verifyCardData['c_id'], $updateValues);

        return $this->respond([
            "status" => true,
            "msg"    => "字卡修改成功"
        ]);
    }

    public function delete($uuid)
    {
        $cardsModel = new CardsModel();
        $verifyCardData = $cardsModel->where("uuid", $uuid)->first();

        if($verifyCardData === null) {
            return $this->fail("查無此字卡", 404);
        }

        $cardsModel->delete($verifyCardData['c_id']);

        return $this->respond([
            "status" => true,
            "msg"    => "字卡刪除成功"
        ]);
    }
}
