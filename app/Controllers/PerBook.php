<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;
use App\Models\BookModel;
use App\Models\CardModel;
use Dotenv\Dotenv;

class PerBook extends BaseController
{
    use ResponseTrait;

    public function index($book_id)
    {
        $bookModel = new BookModel();
        $bookData = $bookModel->where("book_id", $book_id)->first();
        session()->set("bookData", $bookData);

        $cardModel = new CardModel();
        $data['cards'] = $cardModel->where("book_id", $book_id)->orderBy('card_id', 'DESC')->findAll();

        return view('pages/perbook_list', $data + session()->bookData);
    }

    public function create()
    {
        return view('pages/perbook_create', session()->bookData);
    }

    public function store()
    {
        date_default_timezone_set('Asia/Taipei');
        $date = date('Y-m-d H:i:s');

        $request = \Config\Services::request();
        $data = $request->getPost();

        $bookData = session()->bookData;

        $values = [
            'book_id'=>$bookData['book_id'],
            'card_title'=>$data['title'],
            'card_content'=>$data['content'],
            'card_pronunciation'=>$data['pronunciation'],
            'part_of_speech'=>$data['part_of_speech'],
            'card_e_sentence'=>$data['e_sentence'],
            'card_c_sentence'=>$data['c_sentence'],
            'create_at'=>$date,
            'card_state'=>0,
        ];
        $cardModel = new CardModel();
        $cardModel->insert($values);

        return $this->response->setStatusCode(200)->setJSON("OK");
    }
}
