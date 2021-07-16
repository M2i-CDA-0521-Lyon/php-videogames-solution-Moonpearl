<?php

try {
    // Si la méthode HTTP utilisée dans cette requête n'est pas POST, c'est donc que l'utilisateur a tenté d'accéder à ce script manuellement
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('This script must be accessed via a POST HTTP request.', 0);
    }

    // S'il manque un seul des champ présents dans le formulaire, c'est donc que l'utilisateur a contourné le formulaire
    if (!isset($_POST['title']) ||
        !isset($_POST['link']) ||
        !isset($_POST['release_date']) ||
        !isset($_POST['developer']) ||
        !isset($_POST['platform'])
    ) {
        throw new Exception('Form field missing in request.', 1);
    }

    // Teste si l'un des champs est vide
    if (empty($_POST['title']) ||
        empty($_POST['link']) ||
        empty($_POST['release_date']) ||
        empty($_POST['developer']) ||
        empty($_POST['platform'])
    ) {
        throw new Exception('Form should not have empty fields.', 2);
    }

    // Configure une connexion au serveur de base de données
    $databaseHandler = new PDO('mysql:host=localhost;dbname=videogames', 'root', 'root');
    // Crée un modèle de requête "à trous" dans lequel on pourra injecter des variables
    $statement = $databaseHandler->prepare('INSERT INTO `game`
        (`title`, `link`, `release_date`, `developer_id`, `platform_id`)
    VALUES (:title, :link, :release_date, :developer_id, :platform_id)');
    // Exécute la requête préparée en remplaçant chaque champ variable par le contenu reçu du champ correspondant dans le formulaire
    $statement->execute([
        ':title' => $_POST['title'],
        ':link' => $_POST['link'],
        ':release_date' => $_POST['release_date'],
        ':developer_id' => $_POST['developer'],
        ':platform_id' => $_POST['platform'],
    ]);

    // Redirige sur la liste des jeux
    header('Location: /');
}
catch (Exception $exception) {
    // Redirige sur la liste des jeux
    header('Location: /?error=' . $exception->getCode());
}
