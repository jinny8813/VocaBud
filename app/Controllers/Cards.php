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
        return view('pages/card_create');
    }

    public function search()
    {
        $request = \Config\Services::request();
        $data = $request->getPost();

        $dotenv = Dotenv::createImmutable(ROOTPATH);
        $dotenv->load();
        $apiKeyDictionary = $_ENV['API_KEY_Dictionary'];

        $data1 = $this->grab_json_definition_dictionary($data['word'], "collegiate", $apiKeyDictionary);

        $data1Array = json_decode($data1);

        return $this->response->setStatusCode(200)->setJSON($this->wordInfo($data1Array));
    }

    function grab_json_definition_dictionary ($word, $ref, $key) 
    {
        $uri = "https://dictionaryapi.com/api/v3/references/" . urlencode($ref) . "/json/" . urlencode($word) . "?key=" . urlencode($key);
        return file_get_contents($uri);
    }

    function grab_json_definition_translation ($word, $ref, $key) 
    {
        $uri = "https://api.cognitive.microsofttranslator.com/translate?api-version=3.0&from=en&to=zh-Hant&" . urlencode($ref) . "/json/" . urlencode($word) . "?key=" . urlencode($key);
        return file_get_contents($uri);
    }

    function wordInfo($dataArray)
    {
        $wordInfoArr = [];
        for ($i=0;$i<count($dataArray);$i++){
            $part_of_speech = $dataArray[$i]->fl;
            foreach ($dataArray[$i]->shortdef as $shortdef) {
                array_push($wordInfoArr, [$part_of_speech, $shortdef]);
            }
        }
        return $wordInfoArr;
    }
}
