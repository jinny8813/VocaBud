<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;
use App\Models\CardModel;
use Dotenv\Dotenv;

class Cards extends BaseController
{
    use ResponseTrait;

    public function index()
    {

    }

    public function create()
    {
        $dotenv = Dotenv::createImmutable(ROOTPATH);
        $dotenv->load();
        $apiKey = $_ENV['API_KEY_Dictionary'];
        
        return view('pages/card_create');
    }
}
