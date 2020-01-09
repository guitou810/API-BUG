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

    <div class="filters">

        <input type="checkbox" name="unresolved">Afficher uniquement les bugs non-résolus

    </div>

    <ul id="bugList">

        <?php foreach ($bugs as $bug) { ?>

            <li class="bug" id="bug_<?= $bug->getId(); ?>">

                <a href="/bug/show/<?= $bug->getId(); ?>">
                    <?= $bug->getTitle(); ?>
                </a>

                <p><?= $bug->getCreatedAt(); ?></p>

                <p class='closed'>
                    <?php
                    if ($bug->getClosed() !== null) {
                        echo "résolu";
                    } else {
                        echo '<a class="trigger" href="#">Non-résolu</a>';
                    }
                    ?>
                </p>

            </li>

        <?php } ?>

    </ul>

    <script src="../Resources/ajax.js">

    </script>

</body>

</html>