<?php

include_once('bug.php');
include_once('manager.php');

class BugManager extends Manager
{

    public function add(Bug $bug){

        $dbh = $this->connectDb();  

            $sql = "INSERT INTO bug (title, description, createdAt, closed) VALUES (:title, :description, :createdAt, :closed)";
            $sth = $dbh->prepare($sql);
            $sth->execute([
                "title" => $bug->getTitle(),
                "description" => $bug->getDescription(),
                "createdAt" => date("Y-m-d H:i:s"),
                "closed" => 0,
            ]);        

    }

    public function persist(Bug $bug){

        $dbh = $this->connectDb();  

            $sql = "UPDATE bug SET closed =:closed WHERE id =:id";
            $sth = $dbh->prepare($sql);
            $sth->execute([
                "id" => $bug->getId(),
                "closed" => $bug->getClosed(),
            ]);        

    }

    public function find($id)
    {

        $dbh = $this->connectDb();

        $sth = $dbh->prepare('SELECT * FROM bug WHERE id = :id');
        $sth->bindParam(':id', $id, PDO::PARAM_INT);
        $sth->execute();
        $result = $sth->fetch(PDO::FETCH_ASSOC);

        $bug = new Bug();
        $bug->setId($result["id"]);
        $bug->setTitle($result["title"]);
        $bug->setDescription($result["description"]);
        $bug->setCreatedAt($result["createdAt"]);
        $bug->setClosed($result["closed"]);

        return $bug;
    }


    public function findAll()
    {

        $dbh = $this->connectDb();

        $results = $dbh->query('SELECT * FROM `bug` ORDER BY `id`', PDO::FETCH_ASSOC);

        $bugs = [];

        // Parcours des résultats
        foreach ($results as $result) {
            $bug = new Bug();
            $bug->setId($result["id"]);
            $bug->setTitle($result["title"]);
            $bug->setDescription($result["description"]);
            $bug->setCreatedAt($result["createdAt"]);
            $bug->setClosed($result["closed"]);
            
            $bugs[] = $bug;
        }

        return $bugs;
    }


    public function load(){

        $handle = @fopen("result.txt", "r");
        if ($handle) {
            while (($buffer = fgets($handle, 4096)) !== false) { // TODO: 1 Finaliser la récupération des données issues d'un txt
                list($id, $description) = explode(";", $buffer);
                $bug = new Bug($id, $description);
                $this->addBug($bug);
        }
        if (!feof($handle)) {
            echo "Erreur: fgets() a échoué\n";
        }
        fclose($handle);
        }

    }

}
