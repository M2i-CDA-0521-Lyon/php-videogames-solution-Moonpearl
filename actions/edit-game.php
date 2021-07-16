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

    // Récupère l'ID passé dans les données de formulaire le cas échéant
    $id = null;
    if (isset($_POST['id'])) {
        $id = $_POST['id'];
    }

    // Configure une connexion au serveur de base de données
    $databaseHandler = new PDO('mysql:host=localhost;dbname=videogames', 'root', 'root');
    // Crée un modèle de requête "à trous" dans lequel on pourra injecter des variables
    // Si aucun ID n'a été envoyé dans les données de formulaire, c'est donc qu'on souhaite créer un nouveau jeu
    if (is_null($id)) {
        $statement = $databaseHandler->prepare('INSERT INTO `game`
            (`title`, `link`, `release_date`, `developer_id`, `platform_id`)
        VALUES (:title, :link, :release_date, :developer_id, :platform_id)');
    // Sinon, c'est qu'on souhaite modifier un jeu déjà existant
    } else {
        $statement = $databaseHandler->prepare('UPDATE `game`
        SET `title` = :title, `link` = :link, `release_date` = :release_date, `developer_id` = :developer_id, `platform_id` = :platform_id
        WHERE `id` = :id');
    }

    // Compile toutes les données de formulaire dans un tableau associatif
    $parameters = [
        ':title' => $_POST['title'],
        ':link' => $_POST['link'],
        ':release_date' => $_POST['release_date'],
        ':developer_id' => $_POST['developer'],
        ':platform_id' => $_POST['platform'],
    ];
    
    // Dans le cas d'une modification d'un jeu déja existant, ajoute l'ID à ce tableau
    if (!is_null($id)) {
        $parameters['id'] = $id;
    }

    // Exécute la requête en remplaçant chaque champ variable par la valeur associée dans le tableau
    $statement->execute($parameters);

    // Redirige sur la liste des jeux
    header('Location: /');
}
catch (Exception $exception) {
    // Redirige sur la liste des jeux
    header('Location: /?error=' . $exception->getCode());
}
