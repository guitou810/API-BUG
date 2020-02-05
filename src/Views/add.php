<?php

// ini_set('display_errors', 1);

// if(isset($_POST['submit'])){

//     require_once('../Models/bugManager.php');

//     function valid_donnees($donnees){
//         $donnees = trim($donnees);
//         $donnees = stripslashes($donnees);
//         $donnees = htmlspecialchars($donnees);
//         return $donnees;
//     }

    
//     $bugManager = new BugManager();
//     $bug = new Bug();
//     $bug->setTitle(valid_donnees($_POST["title"]));
//     $bug->setDescription(valid_donnees($_POST["description"]));
//     $bugManager->add($bug);

//     header('Location: list.php'); 
// }

?>

<!DOCTYPE html>

<html>

<head>

</head>

<body>

    <h1>Consigner un bug</h1>

    <a href="/bug/list">Retour à la liste</a>

    <form method="post">
        <div class="form-group">
            <label for="titre">Titre</label>
            <input type="text" class="form-control" name="title" id="titre">
        </div>
        <div class="form-group">
            <label for="description">description</label>
            <textarea class="form-control" name="description" id="description"></textarea>
        </div>
        <div class="form-group">
            <label for="domain">Domaine</label>
            <input type="text" class="form-control" name="domain" id="domain">
        </div>
        <button type="submit" name="submit" class="btn btn-primary">Consigner</button>
    </form>

</body>

</html>