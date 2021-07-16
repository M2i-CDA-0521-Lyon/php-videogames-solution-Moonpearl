<?php

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
