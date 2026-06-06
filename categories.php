<?php
// categories.php — Page CRUD des catégories

require_once 'Categorie.php';

$categorie = new Categorie();
$message   = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'ajouter') {
        $categorie->ajouter(trim($_POST['libelle']));
        $message = "Catégorie ajoutée.";

    } elseif ($action === 'modifier') {
        $categorie->modifier((int)$_POST['id'], trim($_POST['libelle']));
        $message = "Catégorie modifiée.";

    } elseif ($action === 'supprimer') {
        $categorie->supprimer((int)$_POST['id']);
        $message = "Catégorie supprimée.";
    }
}

$editData = null;
if (isset($_GET['edit'])) {
    $editData = $categorie->trouverParId((int)$_GET['edit']);
}

$liste = $categorie->listerTous();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Catégories</title>
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
    <h1>🏷️ Gestion des Catégories</h1>

    <?php if ($message): ?>
        <div class="alert"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <div class="card">
        <h2><?= $editData ? 'Modifier une catégorie' : 'Ajouter une catégorie' ?></h2>
        <form method="POST">
            <input type="hidden" name="action" value="<?= $editData ? 'modifier' : 'ajouter' ?>">
            <?php if ($editData): ?>
                <input type="hidden" name="id" value="<?= $editData['id'] ?>">
            <?php endif; ?>

            <label>Libellé :</label>
            <input type="text" name="libelle" required value="<?= htmlspecialchars($editData['libelle'] ?? '') ?>">

            <button type="submit"><?= $editData ? '💾 Enregistrer' : '➕ Ajouter' ?></button>
            <?php if ($editData): ?>
                <a href="categories.php" class="btn-annuler">✖ Annuler</a>
            <?php endif; ?>
        </form>
    </div>

    <div class="card">
        <h2>Liste des catégories</h2>
        <table>
            <thead>
                <tr><th>ID</th><th>Libellé</th><th>Actions</th></tr>
            </thead>
            <tbody>
                <?php foreach ($liste as $c): ?>
                <tr>
                    <td><?= $c['id'] ?></td>
                    <td><?= htmlspecialchars($c['libelle']) ?></td>
                    <td>
                        <a href="categories.php?edit=<?= $c['id'] ?>" class="btn-edit">✏️ Modifier</a>
                        <form method="POST" style="display:inline;" onsubmit="return confirm('Supprimer ?')">
                            <input type="hidden" name="action" value="supprimer">
                            <input type="hidden" name="id" value="<?= $c['id'] ?>">
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
