<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;
use App\Models\BookModel;

class Books extends BaseController
{
    use ResponseTrait;

    public function index()
    {
        $userData = session()->userData;

        $bookModel = new BookModel();
        $data['books'] = $bookModel->where("user_id", $userData['user_id'])->findAll();

        return view('pages/book_list', $data);
    }
}
