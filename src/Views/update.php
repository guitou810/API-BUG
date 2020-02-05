<?php

    $bug = $parameters['bug'];

?>

<!DOCTYPE html>

<html>

<head>

</head>

<body>

    <h1>Mettre à jour un bug</h1>

    <a href="/bug/list">Retour à la liste</a>

    <form method="post">
        <div class="form-group">
            <label for="titre">Titre</label>
            <input type="text" class="form-control" name="title" id="titre" value="<?=$bug->getTitle();?>">
        </div>
        <div class="form-group">
            <label for="description">description</label>
            <textarea class="form-control" name="description" id="description"><?=$bug->getDescription();?></textarea>
        </div>
        <div class="form-group">
            <label for="domain">Domaine</label>
            <input type="text" class="form-control" name="domain" id="domain" value="<?=$bug->getDomain();?>">
        </div>
        <button type="submit" name="submit" class="btn btn-primary">Consigner</button>
    </form>

</body>

</html>