<?php

    $bug = $parameters['bug'];

?>

<!DOCTYPE html>

<html>

<head>

</head>

<body>

<h1>Détail d'un Bug</h1>

    <h2><?=$bug->getTitle();?></h2>

    <div><?=$bug->getDescription();?></div>

    <div><?=$bug->getClosed();?></div>

    <div><a href="/bug/list">Retout à la liste</a></div>

</body>

</html>