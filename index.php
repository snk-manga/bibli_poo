<?php
// index.php — Page d'accueil
require_once 'Livre.php';
require_once 'Auteur.php';
require_once 'Categorie.php';

$livre    = new Livre();
$auteur   = new Auteur();
$categorie = new Categorie();

$nbLivres     = count($livre->listerTous());
$nbAuteurs    = count($auteur->listerTous());
$nbCategories = count($categorie->listerTous());
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Bibliothèque - Accueil</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<nav>
    <a href="index.php">🏠 Accueil</a>
    <a href="auteurs.php">👤 Auteurs</a>
    <a href="categories.php">🏷️ Catégories</a>
    <a href="livres.php">📚 Livres</a>
</nav>

<div class="container">
    <h1>📖 Gestion de Bibliothèque</h1>
    <p>Bienvenue dans l'application de gestion de bibliothèque.</p>

    <div class="stats">
        <div class="stat-card">
            <h3><?= $nbLivres ?></h3>
            <p>Livres</p>
        </div>
        <div class="stat-card">
            <h3><?= $nbAuteurs ?></h3>
            <p>Auteurs</p>
        </div>
        <div class="stat-card">
            <h3><?= $nbCategories ?></h3>
            <p>Catégories</p>
        </div>
    </div>

    <div class="links-grid">
        <a href="auteurs.php" class="link-card">👤 Gérer les Auteurs</a>
        <a href="categories.php" class="link-card">🏷️ Gérer les Catégories</a>
        <a href="livres.php" class="link-card">📚 Gérer les Livres</a>
    </div>
</div>
</body>
</html>
