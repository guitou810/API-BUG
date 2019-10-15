<?php

require_once('Models/bugManager.php');

class bugController
{

    public function list(){

        $bugManager = new BugManager();
        
        $bugs = $bugManager->findAll();
        
        $content = $this->render('Views/list', ['bugs' => $bugs]);   
        
        return $this->sendHttpResponse($content, 200);

    }

    public function show($id){

        $manager = new BugManager();

        $bug = $manager->find($id);

        $content = $this->render('Views/show', ['bug' => $bug]);   
        
        return $this->sendHttpResponse($content, 200);

    }

    public function add(){

        if(isset($_POST['submit'])){
        
            $bugManager = new BugManager();

            $bug = new Bug();

            $bug->setTitle($_POST["title"]);

            $bug->setDescription($_POST["description"]);

            $bugManager->add($bug);

            header('Location: /bug/list'); 
        
        }else{

            $content = $this->render('Views/add', []);   
        
            return $this->sendHttpResponse($content, 200);
        }


    }

    public function render($templatePath, $parameters){

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