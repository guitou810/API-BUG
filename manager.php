<?php

class Manager 
{

    public function connectDb(){

        require_once('params.php');

        try{
    
            $dbh = new PDO(DSN, LOGIN, MOT_DE_PASSE);
            // $dbh = new PDO('mysql:host=localhost;dbname=bugmanager;charset=utf8', 'alex', 'alex');
            
            } catch (Exception $e)
            {
            die('Erreur : ' . $e->getMessage());
            }

            return $dbh;
    }  
    

}