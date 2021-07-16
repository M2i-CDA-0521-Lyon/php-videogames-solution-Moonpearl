<?php

try {
    // Si la méthode HTTP utilisée dans cette requête n'est pas POST, c'est donc que l'utilisateur a tenté d'accéder à ce script manuellement
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('This script must be accessed via a POST HTTP request.', 0);
    }

    // S'il manque un seul des champ présents dans le formulaire, c'est donc que l'utilisateur a contourné le formulaire
    if (!isset($_POST['id'])) {
        throw new Exception('Form field missing in request.', 1);
    }

    // Configure une connexion au serveur de base de données
    $databaseHandler = new PDO('mysql:host=localhost;dbname=videogames', 'root', 'root');
    // Crée un modèle de requête "à trous" dans lequel on pourra injecter des variables
    $statement = $databaseHandler->prepare('DELETE FROM `game` WHERE `id` = :id');
    // Exécute la requête préparée en remplaçant chaque champ variable par le contenu reçu du champ correspondant dans le formulaire
    $statement->execute([
        ':id' => $_POST['id']
    ]);

    // Redirige sur la liste des jeux
    header('Location: /');
}
catch (Exception $exception) {
    // Redirige sur la liste des jeux
    header('Location: /?error=' . $exception->getCode());
}
