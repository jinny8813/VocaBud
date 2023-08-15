<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;
use App\Models\BooksModel;
use App\Models\CardsModel;

class Books extends BaseController
{
    use ResponseTrait;

    public function index()
    {
        $userData = $this->session->userData;

        $u_id = $userData['u_id'];

        $booksModel = new BooksModel();
        $data['books'] = $booksModel ->select('books.*')
                                    ->selectCount('cards.c_id', 'count')
                                    ->selectAvg('state.state', 'avg')
                                    ->join('cards', 'books.b_id = cards.b_id', 'left')
                                    ->join('state', 'cards.c_id = state.c_id', 'left')
                                    ->where('books.u_id', $u_id)
                                    ->where('cards.deleted_at', null)
                                    ->groupBy('books.b_id')
                                    ->orderBy('books.b_id', 'DESC')
                                    ->findAll();

        return view('pages/book_list', $data);
    }

    public function renderCreatePage()
    {
        return view('pages/book_create');
    }

    public function create()
    {
        $data = $this->request->getPost();
        $userData = $this->session->userData;

        $u_id        = $userData['u_id'];
        $title       = $data['title'];
        $description = $data['description'];
        $date        = date("Y-m-d H:i:s");

        if($title === null || $description === null) {
            return $this->fail("標題內容是必要欄位", 404);
        }

        if($title === " " || $description === " ") {
            return $this->fail("標題內容是必要欄位", 404);
        }

        $values = [
            'u_id'        => $u_id,
            'title'       => $title,
            'description' => $description,
            'uuidv4'      => $this->getUuid(),
            'created_at'  => $date
        ];
        $booksModel = new BooksModel();
        $booksModel->insert($values);

        return $this->respond([
            "status" => true,
            "msg"    => "書本建立成功"
        ]);
    }

    public function perBook($uuidv4)
    {
        $userData = $this->session->userData;

        $booksModel = new BooksModel();
        $bookData = $booksModel->where("uuidv4", $uuidv4)->first();

        if($bookData === null) {
            return redirect()->to("/books");
        } else {
            $this->session->set("bookData", $bookData);
        }

        $u_id = $userData['u_id'];
        $b_id = $bookData['b_id'];

        $cardsModel = new CardsModel();
        $cardData['cards'] = $cardsModel ->join('state', 'cards.c_id = state.c_id')
                                    ->where('cards.b_id', $b_id)
                                    ->where('state.u_id', $u_id)
                                    ->orderBy('cards.c_id', 'DESC')
                                    ->findAll();

        $data = array_merge($bookData, $cardData);

        return view('pages/perbook_list', $data);
    }

    public function renderUpdatePage($uuidv4)
    {
        $bookData = $this->session->bookData;

        return view('pages/perbook_edit', $bookData);
    }

    public function update($uuidv4)
    {
        $data = $this->request->getJSON(true);

        $booksModel = new BooksModel();
        $verifyBookData = $booksModel->where("uuidv4", $uuidv4)->first();

        if($verifyBookData === null) {
            return $this->fail("查無此書本", 404);
        }

        $title       = $data['title'];
        $description = $data['description'];
        $date        = date("Y-m-d H:i:s");

        if($title === null || $description === null) {
            return $this->fail("標題內容是必要欄位", 404);
        }

        if($title === " " || $description === " ") {
            return $this->fail("標題內容是必要欄位", 404);
        }

        $updateValues = [
            'title'       => $title,
            'description' => $description,
            'updated_at'  => $date
        ];
        $booksModel->update($verifyBookData['b_id'], $updateValues);

        return $this->respond([
            "status" => true,
            "msg"    => "書本修改成功"
        ]);
    }

    public function delete($uuidv4)
    {
        $booksModel = new BooksModel();
        $verifyBookData = $booksModel->where("uuidv4", $uuidv4)->first();

        if($verifyBookData === null) {
            return $this->fail("查無此書本", 404);
        }

        $booksModel->delete($verifyBookData['b_id']);

        $cardsModel = new CardsModel();
        $cardsModel->where('b_id', $verifyBookData['b_id'])->delete();

        return $this->respond([
            "status" => true,
            "msg"    => "書本刪除成功"
        ]);
    }
}
