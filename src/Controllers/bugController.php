<?php

namespace BugApp\Controllers;

use BugApp\Models\BugManager;
use BugApp\Models\Bug;
use GuzzleHttp\Client;

class bugController
{

    public function list_Bug()
    {

        $bugManager = new BugManager();

        $bugs = $bugManager->findAll();
    
        $json = json_encode($bugs);

        return $this->sendHttpResponse($json, 200);
    }

    public function list_Bug_Closed($bool){

        $bugManager = new BugManager();

        if ($bool != ""){

            $bugs = $bugManager->findByClosed($bool);

            $json = json_encode($bugs);
    
            return $this->sendHttpResponse($json, 200);
        }

        return $this->sendHttpResponse("erreur au niveau saisie closed", 200);
    }

    public function delete($id){

        $bugManager = new BugManager();

        $bugs = $bugManager->delete($id);
    
        $json = json_encode($bugs);

        return $this->sendHttpResponse($json, 200);

    }

    public function show($id)
    {
        $bugManager = new BugManager();

        $bugs = $bugManager->find($id);
        
        $json = json_encode($bugs);

        return $this->sendHttpResponse($json, 200);
     
        // TODO: Instancier le bugManager

        // TODO: Récupérer le Bug

        // TODO: Encoder le Bug

        // TODO: Retourner la réponse Json

    }

    public function update($id,$list)
    {

        $bugManager = new BugManager();

        $bug = $bugManager->find($id);
        
        foreach ($list as $key=>$value){
            echo $value;
            switch($key){
                case "title":
                    $bug->setTitle($value);
                break;
                case "description":
                    $bug->setDescription($value);
                break;
                case "url":
                    $bug->setUrl($value);
                break;
                case "domain":
                    $bug->setDomain($value);
                break;
                case "ip":
                    $bug->setIp($value);
                break;
            }

        }

        $bugs = $bugManager->update($bug);
        $json = json_encode($bug);
        return $this->sendHttpResponse($json,200);

        // TODO: Set Title

        // TODO: Set Description

        // TODO: Set Url

        // TODO: (optionnal) Set Domain + set Ip

        // TODO: Set Closed

        // TODO: persister les données

        // TODO: Encoder le Bug

        // TODO: Retourner la réponse Json

    }



    public function add($params)
    {
        
        $bugManager = new BugManager();

        $bug = new Bug();
        
        foreach ($params as $key=>$value){
            switch($key){
                case "title":
                    $bug->setTitle($value);
                break;
                case "description":
                    $bug->setDescription($value);
                break;
                case "url":
                    $bug->setUrl($value);
                break;
                case "domain":
                    $bug->setDomain($value);
                break;
                case "ip":
                    $bug->setIp($value);
                break;
            }

        }

        $bugs = $bugManager->add($bug);
        $json = json_encode($bug);
        return $this->sendHttpResponse($json,200);
        // TODO: Set Title

        // TODO: Set Description

        // TODO: Set Url

        // TODO: (optionnal) Set Domain + set Ip

        // TODO: Persister le Bug en BDD et récupérer l'id

        // Set Bug Id

        // TODO: Encoder le Bug

        // TODO: Retourner la réponse Json
    }


    public static function sendHttpResponse($content, $code = 200)
    {
        http_response_code($code);

        header('Content-Type: application/json');

        echo $content;
    }
}
