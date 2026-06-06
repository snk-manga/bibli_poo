<?php
// classes/Categorie.php — Classe gérant les catégories (CRUD)

require_once 'connexion.php';

class Categorie {
    private PDO $pdo;

    public function __construct() {
        $this->pdo = Connexion::getInstance()->getPDO();
    }

    // ─── CREATE ────────────────────────────────────────────────────────────────
    public function ajouter(string $libelle): bool {
        $stmt = $this->pdo->prepare("INSERT INTO categories (libelle) VALUES (:libelle)");
        return $stmt->execute([':libelle' => $libelle]);
    }

    // ─── READ (tous) ───────────────────────────────────────────────────────────
    public function listerTous(): array {
        $stmt = $this->pdo->query("SELECT * FROM categories ORDER BY libelle");
        return $stmt->fetchAll();
    }

    // ─── READ (un seul) ────────────────────────────────────────────────────────
    public function trouverParId(int $id): array|false {
        $stmt = $this->pdo->prepare("SELECT * FROM categories WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    // ─── UPDATE ────────────────────────────────────────────────────────────────
    public function modifier(int $id, string $libelle): bool {
        $stmt = $this->pdo->prepare("UPDATE categories SET libelle=:libelle WHERE id=:id");
        return $stmt->execute([':id' => $id, ':libelle' => $libelle]);
    }

    // ─── DELETE ────────────────────────────────────────────────────────────────
    public function supprimer(int $id): bool {
        $stmt = $this->pdo->prepare("DELETE FROM categories WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
}
?>
