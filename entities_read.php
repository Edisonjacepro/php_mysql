<?php
session_start();

require_once(__DIR__ . '/config/mysql.php');
require_once(__DIR__ . '/databaseconnect.php');

/**
 * On ne traite pas les super globales provenant de l'utilisateur directement,
 * ces données doivent être testées et vérifiées.
 */
$getData = $_GET;

if (!isset($getData['id']) || !is_numeric($getData['id'])) {
    echo('L\'entité n\'existe pas');
    return;
}

// On récupère l'entité
$retrieveentityWithCommentsStatement = $mysqlClient->prepare('SELECT e.*, c.comment_id, c.comment, c.user_id,  DATE_FORMAT(c.created_at, "%d/%m/%Y") as comment_date, u.full_name FROM entities e 
LEFT JOIN comments c on c.entity_id = e.entity_id
LEFT JOIN users u ON u.user_id = c.user_id
WHERE e.entity_id = :id 
ORDER BY comment_date DESC');
$retrieveentityWithCommentsStatement->execute([
    'id' => (int)$getData['id'],
]);
$entityWithComments = $retrieveentityWithCommentsStatement->fetchAll(PDO::FETCH_ASSOC);

if ($entityWithComments === []) {
    echo('L\'entité n\'existe pas');
    return;
}
$retrieveAverageRatingStatement = $mysqlClient->prepare('SELECT ROUND(AVG(c.review),1) as rating FROM entities e LEFT JOIN comments c on e.entity_id = c.entity_id WHERE e.entity_id = :id');
$retrieveAverageRatingStatement->execute([
    'id' => (int)$getData['id'],
]);
$averageRating = $retrieveAverageRatingStatement->fetch();
;

$entity = [
    'entity_id' => $entityWithComments[0]['entity_id'],
    'title' => $entityWithComments[0]['title'],
    'entity' => $entityWithComments[0]['entity'],
    'author' => $entityWithComments[0]['author'],
    'comments' => [],
    'rating' => $averageRating['rating'],
];

foreach ($entityWithComments as $comment) {
    if (!is_null($comment['comment_id'])) {
        $entity['comments'][] = [
            'comment_id' => $comment['comment_id'],
            'comment' => $comment['comment'],
            'user_id' => (int) $comment['user_id'],
            'full_name' => $comment['full_name'],
            'created_at' => $comment['comment_date'],
        ];
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nom du site - <?php echo($entity['title']); ?></title>
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >
</head>
<body class="d-flex flex-column min-vh-100">
    <div class="container">

        <?php require_once(__DIR__ . '/header.php'); ?>
        <h1><?php echo($entity['title']); ?></h1>
        <div class="row">
            <article class="col">
                <?php echo($entity['entity']); ?>
            </article>
            <aside class="col">
                <p><i>Contribuée par <?php echo($entity['author']); ?></i></p>
                <?php if ($entity['rating'] !== null) : ?>
                    <p><b>Evaluée par la communauté à <?php echo($entity['rating']); ?> / 5</b></p>
                <?php else : ?>
                    <p><b>Aucune évaluation</b></p>
                <?php endif; ?>
            </aside>
        </div>
        <hr />
        <h2>Commentaires</h2>
        <?php if ($entity['comments'] !== []) : ?>
        <div class="row">
            <?php foreach ($entity['comments'] as $comment) : ?>
                <div class="comment">
                    <p><?php echo($comment['created_at']); ?></p>
                    <p><?php echo($comment['comment']); ?></p>
                    <i>(<?php echo $comment['full_name']; ?>)</i>
                </div>
            <?php endforeach; ?>
        </div>
        <?php else : ?>
        <div class="row">
            <p>Aucun commentaire</p>
        </div>
        <?php endif; ?>
        <hr />
        <?php if (isset($_SESSION['LOGGED_USER'])) : ?>
            <?php require_once(__DIR__ . '/comments_create.php'); ?>
        <?php endif; ?>
    </div>
    <?php require_once(__DIR__ . '/footer.php'); ?>
</body>
</html>
