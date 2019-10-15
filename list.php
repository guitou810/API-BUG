<?php

ini_set('display_errors', 1);

require_once('bugManager.php');

$bugManager = new BugManager();

$bugs = $bugManager->findAll();

// 2. Afficher les données dans une liste

?>

<!DOCTYPE html>

<html>

<head>

</head>

<body>

<h1>Liste des Bugs</h1>

    <a href="add.php">Consigner un nouveau bug</a>

    <ul>

        <?php foreach($bugs as $bug){ ?>

            <li>
                <div>
                    <a href="show.php?id=<?=$bug->getId();?>" >
                        <?=$bug->getTitle();?>
                    </a>
                    <p><?=$bug->getCreatedAt();?></p>
                    <p><?=$bug->getClosed();?></p>

                </div>
            </li>

        <?php } ?>

    </ul>

</body>

</html>



