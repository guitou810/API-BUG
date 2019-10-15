<?php

    $bugs = $parameters['bugs'];

?>

<!DOCTYPE html>

<html>

<head>

</head>

<body>

<h1>Liste des Bugs</h1>

    <a href="/bug/add">Consigner un nouveau bug</a>

    <ul>

        <?php foreach($bugs as $bug){ ?>

            <li>

                <div>

                    <a href="/bug/show/<?=$bug->getId();?>" >
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



