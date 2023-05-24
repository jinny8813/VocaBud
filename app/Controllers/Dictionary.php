<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;
use CodeIgniter\Exceptions\FrameworkException;
use Dotenv\Dotenv;

class Dictionary extends BaseController
{
    use ResponseTrait;

    public function index()
    {
        $request = \Config\Services::request();
        $data = $request->getPost();

        $dataArray['def'] = $this->getWordnikDefinition($data['word']);
        $data1['def'] = $this->wordInfo(json_decode($dataArray['def']));
        $dataText['eg'] = $this->getExampleSentences($data['word']);
        $data1['eg'] = $this->wordEg($dataText['eg']);

        $data1['pron'] = $this->getWordnikPronunciations($data['word']);
        $data1['trans'] = $this->getMicrosoftTranslation($data['word']);

        $data1['word'] = $data['word'];

        return $this->response->setStatusCode(200)->setJSON($data1);
    }

    public function wordEg($dataText)
    {
        $wordEgArr = [];
        $tmp = explode("\n", $dataText);

        for ($i=0;$i<count($tmp);$i++){
            if(empty(substr($tmp[$i], 3))==false){
                array_push($wordEgArr, substr($tmp[$i], 3));
            }
        }

        return $wordEgArr;
    }

    public function wordInfo($dataArray)
    {
        $wordInfoArr = [];
        for ($i=0;$i<count($dataArray[0]->shortdef);$i++){
            $part_of_speech = $dataArray[0]->fl;
            $definition = $dataArray[0]->shortdef[$i];
            array_push($wordInfoArr, [$part_of_speech, $definition]);     
        }
        return $wordInfoArr;
    }

    public function getWordnikPronunciations($word)
    {
        $dotenv = Dotenv::createImmutable(ROOTPATH);
        $dotenv->load();
        $apiKeyWordnik = $_ENV['API_KEY_Wordnik'];

        $uri = "https://api.wordnik.com/v4/word.json/" . $word . "/pronunciations?useCanonical=false&typeFormat=IPA&limit=1&api_key=" . $apiKeyWordnik;
        $response = json_decode(file_get_contents($uri));
        return $response[0]->raw;
    }

    public function getWordnikDefinition($word)
    {
        $dotenv = Dotenv::createImmutable(ROOTPATH);
        $dotenv->load();
        $apiKeyWebster = $_ENV['API_KEY_Dictionary'];

        $uri = "https://www.dictionaryapi.com/api/v3/references/collegiate/json/" . $word . "?key=" . $apiKeyWebster;
        return file_get_contents($uri);
    }

    public function getMicrosoftTranslation($word)
    {
        $endpoint = "https://api.cognitive.microsofttranslator.com/translate?api-version=3.0&from=en&to=zh-Hant";

        $dotenv = Dotenv::createImmutable(ROOTPATH);
        $dotenv->load();
        $apiKeyTranslation = $_ENV['API_KEY_Translation'];

        $content = array(
            array(
                'Text' => $word,
            ),
        );

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $endpoint);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($content));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Ocp-Apim-Subscription-Key: ' . $apiKeyTranslation,
            'Ocp-Apim-Subscription-Region: southeastasia',
            'Content-Type: application/json'
        ]);

        $response = curl_exec($ch);
        curl_close($ch);

        $transText = json_decode($response);
        return $transText[0]->translations[0]->text;
    }

    public function getExampleSentences($word)
    {
        $endpoint = "https://api.openai.com/v1/completions";

        $dotenv = Dotenv::createImmutable(ROOTPATH);
        $dotenv->load();
        $apiKeyChatGPT = $_ENV['API_KEY_ChatGPT'];

        $headers = array(
            'Content-Type: application/json',
            'Authorization: Bearer ' . $apiKeyChatGPT
        );

        $content = array(
            'model' => 'text-davinci-003',
            'prompt' => '3  example sentences about ' . $word,
            'max_tokens' => 128,
        );

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $endpoint);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($content));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($ch);
        curl_close($ch);

        $egText = json_decode($response);
        return $egText->choices[0]->text;
    }
}
