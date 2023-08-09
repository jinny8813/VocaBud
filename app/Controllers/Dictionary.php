<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;
use Dotenv\Dotenv;

class Dictionary extends BaseController
{
    use ResponseTrait;

    public function index()
    {
        $data = $this->request->getPost();
        $word = $data['word'];

        $returnData['def'] = $this->getWordnikDefinition($word);
        $returnData['eg'] = $this->getExampleSentences($word);
        $returnData['pron'] = $this->getWordnikPronunciations($word);
        $returnData['trans'] = $this->getMicrosoftTranslation($word);

        $returnData['word'] = $word;

        return $this->response->setStatusCode(200)->setJSON($returnData);
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

        $dataArray = json_decode(file_get_contents($uri));

        $wordInfoArr = [];

        for ($i=0;$i<count($dataArray[0]->shortdef);$i++){
            $part_of_speech = $dataArray[0]->fl;
            $definition = $dataArray[0]->shortdef[$i];
            array_push($wordInfoArr, [$part_of_speech, $definition]);     
        }

        return $wordInfoArr;
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
        $dataText = explode("\n", $egText->choices[0]->text);

        $wordEgArr = [];

        for ($i=0;$i<count($dataText);$i++){
            if(empty(substr($dataText[$i], 3))==false){
                array_push($wordEgArr, substr($dataText[$i], 3));
            }
        }

        return $wordEgArr;
    }
}
