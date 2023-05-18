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
        $bookData = session()->bookData;
        return view('pages/card_create', $bookData);
    }

    public function store()
    {
        date_default_timezone_set('Asia/Taipei');
        $date = date('Y-m-d H:i:s');

        $request = \Config\Services::request();
        $data = $request->getPost();

        $bookData = session()->bookData;

        $values = [
            'book_id'=>$bookData['book_id'],
            'card_title'=>$data['title'],
            'card_content'=>$data['content'],
            'card_pronunciation'=>$data['pronunciation'],
            'part_of_speech'=>$data['part_of_speech'],
            'card_e_sentence'=>$data['e_sentence'],
            'card_c_sentence'=>$data['c_sentence'],
            'create_at'=>$date,
            'card_state'=>0,
            'card_star'=>0,
        ];
        $cardModel = new CardModel();
        $cardModel->insert($values);

        return $this->response->setStatusCode(200)->setJSON("OK");
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

    public function grab_json_definition_dictionary($word, $ref, $key)
    {
        $uri = "https://dictionaryapi.com/api/v3/references/" . urlencode($ref) . "/json/" . urlencode($word) . "?key=" . urlencode($key);
        return file_get_contents($uri);
    }

    public function grab_json_definition_translation($text)
    {
        $endpoint = "https://api.cognitive.microsofttranslator.com/translate?api-version=3.0&from=en&to=zh-Hant";

        $dotenv = Dotenv::createImmutable(ROOTPATH);
        $dotenv->load();
        $apiKeyTranslation = $_ENV['API_KEY_Translation'];

        $requestBody = array(
            array(
                'Text' => $text,
            ),
        );
        $content = json_encode($requestBody);

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $endpoint);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $content);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Ocp-Apim-Subscription-Key: ' . $apiKeyTranslation,
            'Ocp-Apim-Subscription-Region: southeastasia',
            'Content-Type: application/json'
        ]);

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            $error = curl_error($ch);
            curl_close($ch);
            return $error;
        } else {
            $tranText = json_decode($response);
            return $tranText[0]->translations[0]->text;
        }
    }

    public function wordInfo($dataArray)
    {
        $wordInfoArr = [];
        for ($i=0;$i<count($dataArray);$i++) {
            $title = $dataArray[$i]->meta->id;
            $part_of_speech = $dataArray[$i]->fl;
            $pronunciation = $dataArray[$i]->hwi->hw;
            foreach ($dataArray[$i]->shortdef as $shortdef) {
                $translation = $this->grab_json_definition_translation($shortdef);
                array_push($wordInfoArr, [$title, $part_of_speech, $pronunciation, $shortdef, $translation]);
            }
        }
        return $wordInfoArr;
    }
}
