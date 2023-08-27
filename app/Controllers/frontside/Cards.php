<?php

namespace App\Controllers\frontside;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use App\Models\CardsModel;
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
        return view('pages/frontside/cards_create');
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

        if($title === null || $content === null) {
            return $this->fail("需標題內容進行建立", 404);
        }

        if($title === " " || $content === " ") {
            return $this->fail("需標題內容進行建立", 404);
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

    public function perCard($uuidv4)
    {
        $bookData = $this->session->bookData;

        $cardsModel = new CardsModel();
        $cardData = $cardsModel->where("uuidv4", $uuidv4)->first();

        if($bookData === null) {
            return redirect()->to("/books");
        } elseif($cardData === null) {
            return redirect()->to("/perbook");
        }

        return view('pages/percard', $cardData);
    }

    public function renderUpdatePage($uuidv4)
    {
        $cardsModel = new CardsModel();
        $cardData = $cardsModel->where("uuidv4", $uuidv4)->first();

        return view('pages/percard_edit', $cardData);
    }

    public function update($uuidv4)
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

    public function delete($uuidv4)
    {
        $cardsModel = new CardsModel();
        $verifyCardData = $cardsModel->where("uuidv4", $uuidv4)->first();

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