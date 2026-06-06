<?php
// classes/Auteur.php — Classe gérant les auteurs (CRUD)

require_once 'connexion.php';

class Auteur {
    private PDO $pdo;

    public function __construct() {
        // On récupère la connexion PDO via le Singleton
        $this->pdo = Connexion::getInstance()->getPDO();
    }

    // ─── CREATE ────────────────────────────────────────────────────────────────
    public function ajouter(string $nom, string $prenom, string $nationalite): bool {
        $sql  = "INSERT INTO auteurs (nom, prenom, nationalite) VALUES (:nom, :prenom, :nationalite)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':nom'         => $nom,
            ':prenom'      => $prenom,
            ':nationalite' => $nationalite
        ]);
    }

    // ─── READ (tous) ───────────────────────────────────────────────────────────
    public function listerTous(): array {
        $stmt = $this->pdo->query("SELECT * FROM auteurs ORDER BY nom");
        return $stmt->fetchAll();
    }

    // ─── READ (un seul) ────────────────────────────────────────────────────────
    public function trouverParId(int $id): array|false {
        $stmt = $this->pdo->prepare("SELECT * FROM auteurs WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    // ─── UPDATE ────────────────────────────────────────────────────────────────
    public function modifier(int $id, string $nom, string $prenom, string $nationalite): bool {
        $sql  = "UPDATE auteurs SET nom=:nom, prenom=:prenom, nationalite=:nationalite WHERE id=:id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':id'          => $id,
            ':nom'         => $nom,
            ':prenom'      => $prenom,
            ':nationalite' => $nationalite
        ]);
    }

    // ─── DELETE ────────────────────────────────────────────────────────────────
    public function supprimer(int $id): bool {
        $stmt = $this->pdo->prepare("DELETE FROM auteurs WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
}
?>
