<?php

function displayAuthor(string $authorEmail, array $users): string
{
    foreach ($users as $user) {
        if ($authorEmail === $user['email']) {
            return $user['full_name'] . '(' . $user['age'] . ' ans)';
        }
    }

    return 'Auteur inconnu';
}

function isValidEntity(array $entity): bool
{
    if (array_key_exists('is_enabled', $entity)) {
        $isEnabled = $entity['is_enabled'];
    } else {
        $isEnabled = false;
    }

    return $isEnabled;
}

function getEntities(array $entities): array
{
    $valid_entities = [];

    foreach ($entities as $entity) {
        if (isValidEntity($entity)) {
            $valid_entities[] = $entity;
        }
    }

    return $valid_entities;
}

function redirectToUrl(string $url): never
{
    header("Location: {$url}");
    exit();
}