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

        <?php foreach ($bugs as $bug) { ?>

            <li class="bug" id="bug_<?= $bug->getId(); ?>">

                <div>

                    <a href="/bug/show/<?= $bug->getId(); ?>">
                        <?= $bug->getTitle(); ?>
                    </a>

                    <p><?= $bug->getCreatedAt(); ?></p>

                    <p>
                        <?php
                            if ($bug->getClosed() == 1) {
                                echo "résolu";
                            } else {
                                echo '<a class="trigger" href="#">Non-résolu</a>';
                            }
                            ?>
                    </p>

                </div>

            </li>

        <?php } ?>

    </ul>

    <script>
        (function() {
            var httpRequest;

            let els = document.getElementsByClassName(".trigger");

            Array.from(els).forEach((el) => {
                el.addEventListener('click', makeRequest)
            });

            function makeRequest() {
                httpRequest = new XMLHttpRequest();

                if (!httpRequest) {
                    alert('Abandon :( Impossible de créer une instance de XMLHTTP');
                    return false;
                }
                httpRequest.onreadystatechange = updateBugState;

                // params
                let id = 1
                var params = "id=".id

                httpRequest.open('POST', 'bug/update');

                httpRequest.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

                httpRequest.send(params);
            }

            function alertContents() {
                if (httpRequest.readyState === XMLHttpRequest.DONE) {
                    if (httpRequest.status === 200) {

                        document.getElementById("reponse").innerHTML = httpRequest.responseText

                    } else {
                        alert('Il y a eu un problème avec la requête.');
                    }
                }
            }
        })();
    </script>

</body>

</html>