<?php
// auteurs.php — Page CRUD des auteurs

require_once 'Auteur.php';

$auteur = new Auteur();
$message = '';

// ─── Traitement des actions POST ──────────────────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'ajouter') {
        $auteur->ajouter(
            trim($_POST['nom']),
            trim($_POST['prenom']),
            trim($_POST['nationalite'])
        );
        $message = "Auteur ajouté avec succès.";

    } elseif ($action === 'modifier') {
        $auteur->modifier(
            (int)$_POST['id'],
            trim($_POST['nom']),
            trim($_POST['prenom']),
            trim($_POST['nationalite'])
        );
        $message = "Auteur modifié avec succès.";

    } elseif ($action === 'supprimer') {
        $auteur->supprimer((int)$_POST['id']);
        $message = "Auteur supprimé.";
    }
}

// Récupérer l'auteur à modifier si demandé via GET
$editData = null;
if (isset($_GET['edit'])) {
    $editData = $auteur->trouverParId((int)$_GET['edit']);
}

// Liste de tous les auteurs
$liste = $auteur->listerTous();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Auteurs</title>
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
    <h1>👤 Gestion des Auteurs</h1>

    <?php if ($message): ?>
        <div class="alert"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <!-- Formulaire Ajouter / Modifier -->
    <div class="card">
        <h2><?= $editData ? 'Modifier un auteur' : 'Ajouter un auteur' ?></h2>
        <form method="POST">
            <input type="hidden" name="action" value="<?= $editData ? 'modifier' : 'ajouter' ?>">
            <?php if ($editData): ?>
                <input type="hidden" name="id" value="<?= $editData['id'] ?>">
            <?php endif; ?>

            <label>Nom :</label>
            <input type="text" name="nom" required value="<?= htmlspecialchars($editData['nom'] ?? '') ?>">

            <label>Prénom :</label>
            <input type="text" name="prenom" required value="<?= htmlspecialchars($editData['prenom'] ?? '') ?>">

            <label>Nationalité :</label>
            <input type="text" name="nationalite" required value="<?= htmlspecialchars($editData['nationalite'] ?? '') ?>">

            <button type="submit"><?= $editData ? '💾 Enregistrer' : '➕ Ajouter' ?></button>
            <?php if ($editData): ?>
                <a href="auteurs.php" class="btn-annuler">✖ Annuler</a>
            <?php endif; ?>
        </form>
    </div>

    <!-- Tableau liste -->
    <div class="card">
        <h2>Liste des auteurs</h2>
        <table>
            <thead>
                <tr><th>ID</th><th>Nom</th><th>Prénom</th><th>Nationalité</th><th>Actions</th></tr>
            </thead>
            <tbody>
                <?php foreach ($liste as $a): ?>
                <tr>
                    <td><?= $a['id'] ?></td>
                    <td><?= htmlspecialchars($a['nom']) ?></td>
                    <td><?= htmlspecialchars($a['prenom']) ?></td>
                    <td><?= htmlspecialchars($a['nationalite']) ?></td>
                    <td>
                        <a href="auteurs.php?edit=<?= $a['id'] ?>" class="btn-edit">✏️ Modifier</a>
                        <form method="POST" style="display:inline;" onsubmit="return confirm('Supprimer cet auteur ?')">
                            <input type="hidden" name="action" value="supprimer">
                            <input type="hidden" name="id" value="<?= $a['id'] ?>">
                            <button type="submit" class="btn-delete">🗑️ Supprimer</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
