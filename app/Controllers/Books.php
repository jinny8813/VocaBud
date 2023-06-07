<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;
use App\Models\BookModel;
use App\Models\KeepModel;

class Books extends BaseController
{
    use ResponseTrait;

    public function index()
    {
        $userData = session()->userData;

        $db = \Config\Database::connect();
        $temp =  "
                    SELECT count(c.c_id) count, AVG(s.state) avg
                    FROM keep k
                    LEFT JOIN cards c ON k.c_id = c.c_id
                    LEFT JOIN state s ON c.c_id = s.c_id
                    WHERE k.u_id = {$userData['u_id']}
                ";
        $data['keep'] = $db->query($temp)->getResultArray();

        $temp =  "
                    SELECT b.*,count(c.c_id) count, AVG(s.state) avg
                    FROM books b
                    LEFT JOIN cards c ON b.b_id = c.b_id
                    LEFT JOIN state s ON c.c_id = s.c_id
                    WHERE b.u_id = {$userData['u_id']}
                    GROUP BY c.b_id
                    ORDER BY b.b_id DESC;
                ";
        $data['books'] = $db->query($temp)->getResultArray();

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
