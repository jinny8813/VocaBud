<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;
use App\Models\BookModel;

class Collection extends BaseController
{
    use ResponseTrait;

    public function index()
    {
        return view('pages/book_list');
    }

    public function create($user_id)
    {
        date_default_timezone_set('Asia/Taipei');
        $date = date('Y-m-d H:i:s');

        $values = [
                'user_id'=>$user_id,
                'book_title'=>"我的收藏",
                'book_description'=>"收集近期重要的字卡",
                'create_at'=>$date,
            ];
        $bookModel = new BookModel();
        $bookModel->insert($values);
    }
}
