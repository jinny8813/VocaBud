<?php

namespace App\Controllers;

class Books extends BaseController
{
    public function index()
    {
        return view('pages/book_list');
    }
}