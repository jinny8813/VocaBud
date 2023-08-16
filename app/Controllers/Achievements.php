<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;

class Achievements extends BaseController
{
    use ResponseTrait;

    public function index()
    {
        return view('pages/achievement');
    }
}
