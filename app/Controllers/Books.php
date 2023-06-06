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
        $data['books'] = $bookModel->where("u_id", $userData['u_id'])->orderBy('b_id', 'DESC')->findAll();

        return view('pages/books_list', $data);
    }

    public function create()
    {
        return view('pages/books_create');
    }

    public function store()
    {
        date_default_timezone_set('Asia/Taipei');
        $date = date('Y-m-d H:i:s');

        $request = \Config\Services::request();
        $data = $request->getPost();

        $userData = session()->userData;

        $values = [
            'u_id'=>$userData['u_id'],
            'title'=>$data['title'],
            'description'=>$data['description'],
            'create_at'=>$date,
        ];
        $bookModel = new BookModel();
        $bookModel->insert($values);

        return $this->response->setStatusCode(200)->setJSON("OK");
    }
}
