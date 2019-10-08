<?php

ini_set('display_errors', 1);

require_once('bugManager.php');

$id = $_GET['id'];

$manager = new BugManager();

$bug = $manager->find($id);

?>

<!DOCTYPE html>

<html>

<head>

</head>

<body>

<h1>Détail d'un Bug</h1>

    <h2><?=$bug->getTitre();?></h2>

    <div><?=$bug->getDescription();?></div>

    <div><a href="list.php">Retout à la liste</a></div>

</body>

</html>