<!-- inclusion des variables et fonctions -->
<?php
session_start();
require_once(__DIR__ . '/config/mysql.php');
require_once(__DIR__ . '/databaseconnect.php');
require_once(__DIR__ . '/variables.php');
require_once(__DIR__ . '/functions.php');
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nom du site - Page d'accueil</title>
    <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
            rel="stylesheet"
    >
</head>
<body class="d-flex flex-column min-vh-100">
    <div class="container">
        <!-- inclusion de l'entête du site -->
        <?php require_once(__DIR__ . '/header.php'); ?>
        <h1>Nom du site</h1>

        <!-- Formulaire de connexion -->
        <?php require_once(__DIR__ . '/login.php'); ?>

        <?php foreach (getEntities($entities) as $entity) : ?>
            <article>
                <h3><a href="entities_read.php?id=<?php echo($entity['entity_id']); ?>"><?php echo($entity['title']); ?></a></h3>
                <div><?php echo $entity['entity']; ?></div>
                <i><?php echo displayAuthor($entity['author'], $users); ?></i>
                <?php if (isset($_SESSION['LOGGED_USER']) && $entity['author'] === $_SESSION['LOGGED_USER']['email']) : ?>
                    <ul class="list-group list-group-horizontal">
                        <li class="list-group-item"><a class="link-warning" href="entities_update.php?id=<?php echo($entity['entity_id']); ?>">Editer l'entité</a></li>
                        <li class="list-group-item"><a class="link-danger" href="entities_delete.php?id=<?php echo($entity['entity_id']); ?>">Supprimer l'entité</a></li>
                    </ul>
                <?php endif; ?>
            </article>
        <?php endforeach ?>
    </div>

    <!-- inclusion du bas de page du site -->
    <?php require_once(__DIR__ . '/footer.php'); ?>
</body>
</html>