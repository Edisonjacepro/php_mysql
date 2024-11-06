<?php
session_start();

require_once(__DIR__ . '/isConnect.php');
require_once(__DIR__ . '/config/mysql.php');
require_once(__DIR__ . '/databaseconnect.php');

/**
 * On ne traite pas les super globales provenant de l'utilisateur directement,
 * ces données doivent être testées et vérifiées.
 */
$getData = $_GET;

if (!isset($getData['id']) || !is_numeric($getData['id'])) {
    echo('Il faut un identifiant d\'entité pour la modifier.');
    return;
}

$retrieveentityStatement = $mysqlClient->prepare('SELECT * FROM entities WHERE entity_id = :id');
$retrieveentityStatement->execute([
    'id' => (int)$getData['id'],
]);
$entity = $retrieveentityStatement->fetch(PDO::FETCH_ASSOC);

// si l'entité n'est pas trouvée, renvoyer un message d'erreur
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edition d'entité</title>
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >
</head>
<body class="d-flex flex-column min-vh-100">
    <div class="container">

        <?php require_once(__DIR__ . '/header.php'); ?>
        <h1>Mettre à jour <?php echo($entity['title']); ?></h1>
        <form action="entities_post_update.php" method="POST">
            <div class="mb-3 visually-hidden">
                <label for="id" class="form-label">Identifiant de l'entité</label>
                <input type="hidden" class="form-control" id="id" name="id" value="<?php echo($getData['id']); ?>">
            </div>
            <div class="mb-3">
                <label for="title" class="form-label">Titre de l'entité</label>
                <input type="text" class="form-control" id="title" name="title" aria-describedby="title-help" value="<?php echo($entity['title']); ?>">
                <div id="title-help" class="form-text">Choisissez un titre percutant !</div>
            </div>
            <div class="mb-3">
                <label for="entity" class="form-label">Description de l'entité</label>
                <textarea class="form-control" placeholder="Seulement du contenu vous appartenant ou libre de droits." id="entity" name="entity"><?php echo $entity['entity']; ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Envoyer</button>
        </form>
        <br />
    </div>

    <?php require_once(__DIR__ . '/footer.php'); ?>
</body>
</html>
