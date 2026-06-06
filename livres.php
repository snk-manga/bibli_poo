<?php
// livres.php — Page CRUD des livres

require_once 'Livre.php';
require_once 'Auteur.php';
require_once 'Categorie.php';

$livre    = new Livre();
$auteur   = new Auteur();
$categorie = new Categorie();
$message  = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'ajouter') {
        $livre->ajouter(
            trim($_POST['titre']),
            trim($_POST['isbn']),
            (int)$_POST['annee'],
            (int)$_POST['quantite'],
            (int)$_POST['auteur_id'],
            (int)$_POST['categorie_id']
        );
        $message = "Livre ajouté avec succès.";

    } elseif ($action === 'modifier') {
        $livre->modifier(
            (int)$_POST['id'],
            trim($_POST['titre']),
            trim($_POST['isbn']),
            (int)$_POST['annee'],
            (int)$_POST['quantite'],
            (int)$_POST['auteur_id'],
            (int)$_POST['categorie_id']
        );
        $message = "Livre modifié.";

    } elseif ($action === 'supprimer') {
        $livre->supprimer((int)$_POST['id']);
        $message = "Livre supprimé.";
    }
}

$editData   = null;
if (isset($_GET['edit'])) {
    $editData = $livre->trouverParId((int)$_GET['edit']);
}

$liste      = $livre->listerTous();
$auteurs    = $auteur->listerTous();
$categories = $categorie->listerTous();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Livres</title>
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
    <h1>📚 Gestion des Livres</h1>

    <?php if ($message): ?>
        <div class="alert"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <div class="card">
        <h2><?= $editData ? 'Modifier un livre' : 'Ajouter un livre' ?></h2>
        <form method="POST">
            <input type="hidden" name="action" value="<?= $editData ? 'modifier' : 'ajouter' ?>">
            <?php if ($editData): ?>
                <input type="hidden" name="id" value="<?= $editData['id'] ?>">
            <?php endif; ?>

            <label>Titre :</label>
            <input type="text" name="titre" required value="<?= htmlspecialchars($editData['titre'] ?? '') ?>">

            <label>ISBN :</label>
            <input type="text" name="isbn" required value="<?= htmlspecialchars($editData['isbn'] ?? '') ?>">

            <label>Année :</label>
            <input type="number" name="annee" required value="<?= htmlspecialchars($editData['annee'] ?? date('Y')) ?>">

            <label>Quantité :</label>
            <input type="number" name="quantite" required min="0" value="<?= htmlspecialchars($editData['quantite'] ?? '1') ?>">

            <label>Auteur :</label>
            <select name="auteur_id" required>
                <option value="">-- Choisir un auteur --</option>
                <?php foreach ($auteurs as $a): ?>
                    <option value="<?= $a['id'] ?>" <?= (isset($editData['auteur_id']) && $editData['auteur_id'] == $a['id']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($a['prenom'] . ' ' . $a['nom']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label>Catégorie :</label>
            <select name="categorie_id" required>
                <option value="">-- Choisir une catégorie --</option>
                <?php foreach ($categories as $c): ?>
                    <option value="<?= $c['id'] ?>" <?= (isset($editData['categorie_id']) && $editData['categorie_id'] == $c['id']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($c['libelle']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <button type="submit"><?= $editData ? '💾 Enregistrer' : '➕ Ajouter' ?></button>
            <?php if ($editData): ?>
                <a href="livres.php" class="btn-annuler">✖ Annuler</a>
            <?php endif; ?>
        </form>
    </div>

    <div class="card">
        <h2>Liste des livres</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th><th>Titre</th><th>ISBN</th><th>Année</th>
                    <th>Quantité</th><th>Auteur</th><th>Catégorie</th><th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($liste as $l): ?>
                <tr>
                    <td><?= $l['id'] ?></td>
                    <td><?= htmlspecialchars($l['titre']) ?></td>
                    <td><?= htmlspecialchars($l['isbn']) ?></td>
                    <td><?= $l['annee'] ?></td>
                    <td><?= $l['quantite'] ?></td>
                    <td><?= htmlspecialchars($l['auteur_nom'] ?? '-') ?></td>
                    <td><?= htmlspecialchars($l['categorie_libelle'] ?? '-') ?></td>
                    <td>
                        <a href="livres.php?edit=<?= $l['id'] ?>" class="btn-edit">✏️</a>
                        <form method="POST" style="display:inline;" onsubmit="return confirm('Supprimer ce livre ?')">
                            <input type="hidden" name="action" value="supprimer">
                            <input type="hidden" name="id" value="<?= $l['id'] ?>">
                            <button type="submit" class="btn-delete">🗑️</button>
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
