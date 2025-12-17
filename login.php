<?php
//Se connecter
include "config.php";

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8",
        $username,
        $password,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    );
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

session_start();

$nom = $_POST['nom_utilisateur'] ?? '';
$mdp = $_POST['mot_de_passe'] ?? '';

if ($nom === '' || $mdp === '') {
    die("Veuillez remplir tous les champs");
}

$stmt = $pdo->prepare("SELECT * FROM scores WHERE nom_utilisateur = :nom");
$stmt->execute(['nom' => $nom]);
$user = $stmt->fetch();

if ($user) {
    if ($mdp === $user['mot_de_passe']) {
        $_SESSION['user_id'] = $user['id_scores'];
        $_SESSION['username'] = $user['nom_utilisateur'];

        header("Location: index(1).php");
        exit;
    } else {
        die("Nom ou mot de passe incorrect");
    }
} else {
    $stmt = $pdo->prepare("
        INSERT INTO scores (nom_utilisateur, mot_de_passe, nombre_partie, victoire_joueur)
        VALUES (:nom, :mdp, 0, 0)
    ");
    $stmt->execute([
        'nom' => $nom,
        'mdp' => $mdp
    ]);

    $_SESSION['user_id'] = $pdo->lastInsertId();
    $_SESSION['username'] = $nom; 

    header("Location: index(1).php");
    exit;
}
