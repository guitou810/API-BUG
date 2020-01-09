<?php

require_once('Models/bugManager.php');

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

            $content = $this->render('Views/list', ['bugs' => $bugs]);

            return $this->sendHttpResponse($content, 200);
        }
    }

    public function update($id)
    {

        // 1. instancier

        $bugManager = new BugManager();

        $bug = $bugManager->find($id);

        // 2. mettre à jour l'instance

        if (isset($_POST["closed"]) && $_POST["closed"] == 1) {

            $bug->setClosed(new \DateTime());
        }

        // 3. persister les données

        $bugManager->update($bug);

        // 4. construire la réponse json

        $headers = apache_request_headers();

        if (isset($headers['XMLHttpRequest']) && $headers['XMLHttpRequest'] == true) {

            $response = [
                'success' => true,
                'id' => $bug->getId(),
            ];

            $json = json_encode($response);

            // 5. envoyer la réponse

            http_response_code(200);

            header('Content-Type: application/json');

            echo $json;
        } else {

            // TODO: Réponse html
        }
    }

    public function show($id)
    {

        $manager = new BugManager();

        $bug = $manager->find($id);

        $content = $this->render('Views/show', ['bug' => $bug]);

        return $this->sendHttpResponse($content, 200);
    }

    public function add()
    {

        if (isset($_POST['submit'])) {

            $bugManager = new BugManager();

            $bug = new Bug();

            $bug->setTitle($_POST["title"]);

            $bug->setDescription($_POST["description"]);

            $bugManager->add($bug);

            header('Location: /bug/list');
        } else {

            $content = $this->render('Views/add', []);

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
