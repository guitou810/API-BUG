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

    <div>Description : <?=$bug->getDescription();?></div>

    <div>Domaine : <?=$bug->getDomain();?></div>

    <div>IP : <?=$bug->getIp();?></div>

    <div>
    
        <?php if($bug->getClosed() != null){

            echo $bug->getClosed()->format("Y-m-d H:i:s");
        }
        ?>
        
    </div>

    <div><a href="/bug/list">Retour à la liste</a></div>

</body>

</html>