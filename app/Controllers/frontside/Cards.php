<?php

namespace App\Controllers\frontside;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use App\Models\CardsModel;
use App\Models\TagsModel;
use App\Models\StateModel;

class Cards extends BaseController
{
    use ResponseTrait;

    public function index()
    {
        $userData = $this->session->userData;
        $u_id = $userData['u_id'];

        $cardsModel = new CardsModel();
        $cardData['cards'] = $cardsModel ->join('state', 'cards.c_id = state.c_id')
                                    ->where('state.u_id', $u_id)
                                    ->orderBy('cards.c_id', 'DESC')
                                    ->findAll();
        return view('pages/frontside/cards_list', $cardData);
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
        $tags_group     = $data['tags_group'] ?? array();
        $tag_add        = trim($data['tag_add']);

        if($title === null || $content === null) {
            return $this->fail("需標題內容進行建立", 404);
        }

        if($title === " " || $content === " ") {
            return $this->fail("需標題內容進行建立", 404);
        }

        $tag_add_group = explode("_",$tag_add);

        $tagsModel = new TagsModel();
        for($i=0;$i<count($tag_add_group);$i++){
            $findTag = $tagsModel->where("u_id", $u_id)->where('tagname', $tag_add_group[$i])->first();
            $isfound = $findTag['t_id'] ?? null;
            if($isfound == null){
                $values = [
                    'u_id'    => $u_id,
                    'tagname' => $tag_add_group[$i],
                ];
                $tagsModel->insert($values);
                $thetag = $tagsModel->where("u_id", $u_id)->where("tagname", $tag_add_group[$i])->first();
                array_push($tags_group, $thetag['t_id']);
            }else{
                array_push($tags_group, $isfound);
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
