<?php

// Récupération des variables à l'aide du client MySQL
$usersStatement = $mysqlClient->prepare('SELECT * FROM users');
$usersStatement->execute();
$users = $usersStatement->fetchAll();

$entitiesStatement = $mysqlClient->prepare('SELECT * FROM entities WHERE is_enabled is TRUE');
$entitiesStatement->execute();
$entities = $entitiesStatement->fetchAll();