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

        $headers = apache_request_headers();

        if (isset($headers['XMLHttpRequest']) && $headers['XMLHttpRequest'] == 'true') {

            if (isset($_GET['closed']) && $_GET['closed'] == 'false') {

                $bugs = $bugManager->findByClosed(false);
            } else {

                $bugs = $bugManager->findAll();
            }

            $response = [
                'success' => true,
                'bugs' => $bugs,
            ];

            $json = json_encode($response);

            //var_dump($json);

            // 5. envoyer la réponse

            http_response_code(200);

            header('Content-Type: application/json');

            echo $json;
        } else {

            $bugs = $bugManager->findAll();

            $content = $this->render('src/Views/list', ['bugs' => $bugs]);

            return $this->sendHttpResponse($content, 200);
        }
    }

    public function update($id)
    {

        // 1. instancier

        $bugManager = new BugManager();

        $bug = $bugManager->find($id);

        // 2. Detecter les requetes XHR

        $headers = apache_request_headers();

        if (isset($headers['XMLHttpRequest']) && $headers['XMLHttpRequest'] == true) {

            // 3. mettre à jour l'instance

            if (isset($_POST["closed"]) && $_POST["closed"] == 1) {

                $bug->setClosed(new \DateTime());
            }

            // 4. persister les données

            $bugManager->update($bug);

            // 5. Réponse JSON

            $response = [
                'success' => true,
                'id' => $bug->getId(),
            ];

            $json = json_encode($response);

            // 6. envoyer la réponse

            http_response_code(200);

            header('Content-Type: application/json');

            echo $json;
        } else {

            if (!empty($_POST)) {

                // 3. mettre à jour l'instance

                if (isset($_POST["title"])) {
                    $bug->setTitle($_POST["title"]);
                }

                if (isset($_POST["description"])) {
                    $bug->setDescription($_POST["description"]);
                }

                if (isset($_POST["domain"])) {
                    $bug->setDomain($_POST["domain"]);
                }

                if (isset($_POST["closed"]) && $_POST["closed"] == 1) {
                    $bug->setClosed(new \DateTime());
                }

                // 4. persister les données

                $bugManager->update($bug);

                $content = $this->render('src/Views/show', ['bug' => $bug]);

            }else{

                $content = $this->render('src/Views/update', ['bug' => $bug]);
            }

            // 5. Réponse HTML

            return $this->sendHttpResponse($content, 200);
        }
    }

    public function show($id)
    {

        $manager = new BugManager();

        $bug = $manager->find($id);

        $content = $this->render('src/Views/show', ['bug' => $bug]);

        return $this->sendHttpResponse($content, 200);
    }

    public function add()
    {

        if (isset($_POST['submit'])) {

            $bugManager = new BugManager();

            $bug = new Bug();
            $bug->setTitle($_POST["title"]);
            $bug->setDescription($_POST["description"]);
            $bug->setDomain($_POST["domain"]);

            // Recherche de l'IP

            $client = new Client([
                'base_uri' => 'http://ip-api.com',
            ]);

            $response = $client->request('GET', '/json/google.com', ['debug' => true]);

            // echo $response->getStatusCode();
            // echo $response->getHeader('content-type')[0];
            $body = $response->getBody();
            $remainingBytes = $body->getContents();
            $values = json_decode($remainingBytes);

            $ip = $values->query;

            $bug->setIp($ip);

            $bugManager->add($bug);

            header('Location: /bug/list');
        } else {

            $content = $this->render('src/Views/add', []);

            return $this->sendHttpResponse($content, 200);
        }
    }

    public function render($templatePath, $parameters)
    {

        $templatePath = $templatePath . '.php';

        ob_start();

        $parameters;

        require($templatePath);

        return ob_get_clean();
    }

    public static function sendHttpResponse($content, $code = 200)
    {
        http_response_code($code);

        header('Content-Type: text/html');

        echo $content;
    }
}
