<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;
use App\Models\BookModel;
use App\Models\CardModel;

class Books extends BaseController
{
    use ResponseTrait;

    public function index()
    {
        $userData = session()->userData;

        $bookModel = new BookModel();
        $data['books'] = $bookModel->where("user_id", $userData['user_id'])->orderBy('book_id', 'DESC')->findAll();

        return view('pages/book_list', $data);
    }

    public function create()
    {
        return view('pages/book_create');
    }

    public function store()
    {
        date_default_timezone_set('Asia/Taipei');
        $date = date('Y-m-d H:i:s');

        $request = \Config\Services::request();
        $data = $request->getPost();

        $userData = session()->userData;

        $values = [
            'user_id'=>$userData['user_id'],
            'book_title'=>$data['title'],
            'book_description'=>$data['description'],
            'create_at'=>$date,
        ];
        $bookModel = new BookModel();
        $bookModel->insert($values);

        return $this->response->setStatusCode(200)->setJSON("OK");
    }

    public function show($book_id)
    {
        $bookModel = new BookModel();
        $bookData = $bookModel->where("book_id", $book_id)->first();
        session()->set("bookData", $bookData);

        $cardModel = new CardModel();
        $data['cards'] = $cardModel->where("book_id", $book_id)->orderBy('card_id', 'DESC')->findAll();

        return view('pages/book_per', $data + session()->bookData);
    }
}
