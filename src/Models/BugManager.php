<?php

namespace BugApp\Models;

use BugApp\Models\Bug;
use BugApp\Manager;

class BugManager extends Manager
{

    public function add(Bug $bug){

        $dbh = $this->connectDb();  

            $sql = "INSERT INTO bug (title, description, closed, domain, ip, url, createdAt) VALUES (:title, :description, :closed, :domain, :ip, :url, :createdAt)";
            $sth = $dbh->prepare($sql);
            $sth->execute([
                "title" => $bug->getTitle(),
                "description" => $bug->getDescription(),
                "closed" => null,
                "domain" => $bug->getDomain(),
                "url" => $bug->getUrl(),
                "ip" => $bug->getIp(),
                "createdAt" => $bug->getCreatedAt()->format("Y-m-d H:i:s")
            ]); 
                        
            // TODO: Décommenter ces lignes pour récupérer l'id ;-)

            // $id = $dbh->lastInsertId();

            // return $id;

    }



    public function delete($id){

        $dbh = $this->connectDb();  

            $bug = BugManager::find($id);
            $sql = "DELETE From bug WHERE id = :id";
            $sth = $dbh->prepare($sql);
            $sth->bindParam(':id', $id, \PDO::PARAM_INT);
            $sth->execute();

            
            return $bug;

    }

    public function update(Bug $bug){

        $dbh = $this->connectDb();  

            if($bug->getClosed() != null){
                $bugGetClosed = $bug->getClosed()->format("Y-m-d H:i:s");
            }else{
                $bugGetClosed = null;
            }

            $sql = "UPDATE bug SET title = :title, description = :description, closed = :closed, domain = :domain, ip = :ip, url = :url WHERE id =:id";
            $sth = $dbh->prepare($sql);
            $sth->execute([
                "id" => $bug->getId(),
                "title" => $bug->getTitle(),
                "description" => $bug->getDescription(),
                "closed" => $bugGetClosed,
                "domain" => $bug->getDomain(),
                "ip" => $bug->getIp(),
                "url" => $bug->getUrl(),
            ]);        

    }

    public function find($id)
    {

        $dbh = $this->connectDb();

        $sth = $dbh->prepare('SELECT * FROM bug WHERE id = :id');
        $sth->bindParam(':id', $id, \PDO::PARAM_INT);
        $sth->execute();
        $result = $sth->fetch(\PDO::FETCH_ASSOC);
        if(isset($result["id"])){

        $bug = new Bug();
        $bug->setId($result["id"]);
        $bug->setTitle($result["title"]);
        $bug->setDescription($result["description"]);
        $bug->setCreatedAt($result["createdAt"]);
        $bug->setClosed($result["closed"]);
        $bug->setDomain($result["domain"]);
        $bug->setUrl($result["url"]);
        $bug->setIp($result["ip"]);      

        return $bug;
        }else{
            $rel = "PAS DE BUG AVEC CET ID DANS LA TABLE";
            $notf = json_encode($rel);
            return $notf;
        }
        
    }


    public function findAll()
    {

        $dbh = $this->connectDb();

        $results = $dbh->query('SELECT * FROM `bug` ORDER BY `id`', \PDO::FETCH_ASSOC);

        $bugs = [];

        // Parcours des résultats
        foreach ($results as $result) {
            $bug = new Bug();
            $bug->setId($result["id"]);
            $bug->setTitle($result["title"]);
            $bug->setDescription($result["description"]);
            $bug->setCreatedAt($result["createdAt"]);
            $bug->setClosed($result["closed"]);
            $bug->setDomain($result["domain"]);
            $bug->setUrl($result["url"]);
            $bug->setIp($result["ip"]);
            
            $bugs[] = $bug;
        }

        return $bugs;
    }

    public function findByClosed($bool){

        $dbh = $this->connectDb();

        if($bool == "false"){
            $results = $dbh->query('SELECT * FROM `bug` WHERE closed IS NULL ORDER BY `id`', \PDO::FETCH_ASSOC);

        }else{

            $results = $dbh->query('SELECT * FROM `bug` WHERE closed IS NOT NULL ORDER BY `id`', \PDO::FETCH_ASSOC);

        }

        $bugs = [];

        // Parcours des résultats
        foreach ($results as $result) {
            $bug = new Bug();
            $bug->setId($result["id"]);
            $bug->setTitle($result["title"]);
            $bug->setDescription($result["description"]);
            $bug->setCreatedAt($result["createdAt"]);
            $bug->setClosed($result["closed"]);
            $bug->setDomain($result["domain"]);
            $bug->setUrl($result["url"]);
            $bug->setIp($result["ip"]);
            
            $bugs[] = $bug;
        }

        return $bugs;


    }

}
