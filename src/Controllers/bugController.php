<?php

namespace BugApp\Controllers;

use BugApp\Models\BugManager;
use BugApp\Models\Bug;
use GuzzleHttp\Client;

class bugController
{

    public function list()
    {

        $bugManager = new BugManager();

        if (isset($_GET['closed']) && $_GET['closed'] == 'false') {

            $bugs = $bugManager->findByClosed(false);
        } else {

            $bugs = $bugManager->findAll();
        }

        $json = json_encode($bugs);

        return $this->sendHttpResponse($json, 200);
    }

    public function update($id)
    {

        $bugManager = new BugManager();

        $bug = $bugManager->find($id);

        // Récupérer les données en PATCH

        parse_str(file_get_contents('php://input'), $_PATCH);

        // var_dump($_PATCH);die;

        if (isset($_PATCH["title"])) {
            $bug->setTitle($_PATCH["title"]);
        }

        if (isset($_PATCH["description"])) {
            $bug->setDescription($_PATCH["description"]);
        }

        if (isset($_PATCH["url"])) {
            $url_array = parse_url($_PATCH["url"]);

            // var_dump($url_array);die;

            if (isset($url_array['host'])) {

                // Traitement du domaine 

                $bug->setDomain($url_array['host']);

                // Recherche de l'IP

                $client = new Client([
                    'base_uri' => 'http://ip-api.com',
                ]);

                $response = $client->request('GET', '/json/' . $url_array['host'], ['debug' => true]);

                // echo $response->getStatusCode();
                // echo $response->getHeader('content-type')[0];
                $body = $response->getBody();
                $remainingBytes = $body->getContents();
                $values = json_decode($remainingBytes);

                $ip = $values->query;

                $bug->setIp($ip);
            }

            if (isset($url_array['path'])) {

                $bug->setUrl($url_array['path']);
            }
        }

        
        if (isset($_PATCH["closed"]) && $_PATCH["closed"] == '1') {

            $bug->setClosed(null);
        }

        // 4. persister les données

        $bugManager->update($bug);

        $content = json_encode($bug);

        return $this->sendHttpResponse($content, 200);

    }

    public function show($id)
    {

        $manager = new BugManager();

        $bug = $manager->find($id);

        $json = json_encode($bug);

        return $this->sendHttpResponse($json, 200);
    }

    public function add()
    {
        
        $bugManager = new BugManager();

        $bug = new Bug();
        $bug->setTitle($_POST["title"]);
        $bug->setDescription($_POST["description"]);

        // Découpage de l'url

        $url_array = parse_url($_POST["url"]);

        if (isset($url_array['host'])) {

            // Traitement du domaine 

            $bug->setDomain($url_array['host']);

            // Recherche de l'IP

            $client = new Client([
                'base_uri' => 'http://ip-api.com',
            ]);

            $response = $client->request('GET', '/json/' . $url_array['host'], ['debug' => true]);

            // echo $response->getStatusCode();
            // echo $response->getHeader('content-type')[0];
            $body = $response->getBody();
            $remainingBytes = $body->getContents();
            $values = json_decode($remainingBytes);

            $ip = $values->query;

            $bug->setIp($ip);
        }

        if (isset($url_array['path'])) {
            $bug->setUrl('path');
        }

        $id = $bugManager->add($bug);

        // Set Bug Id

        $bug->setId($id);

        $json = json_encode($bug);

        return $this->sendHttpResponse($json, 201);
    }


    public static function sendHttpResponse($content, $code = 200)
    {
        http_response_code($code);

        header('Content-Type: application/json');

        echo $content;
    }
}
