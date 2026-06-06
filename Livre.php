<?php
// classes/Livre.php — Classe gérant les livres (CRUD)

require_once 'connexion.php';

class Livre {
    private PDO $pdo;

    public function __construct() {
        $this->pdo = Connexion::getInstance()->getPDO();
    }

    // ─── CREATE ────────────────────────────────────────────────────────────────
    public function ajouter(string $titre, string $isbn, int $annee, int $quantite, int $auteur_id, int $categorie_id): bool {
        $sql = "INSERT INTO livres (titre, isbn, annee, quantite, auteur_id, categorie_id)
                VALUES (:titre, :isbn, :annee, :quantite, :auteur_id, :categorie_id)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':titre'        => $titre,
            ':isbn'         => $isbn,
            ':annee'        => $annee,
            ':quantite'     => $quantite,
            ':auteur_id'    => $auteur_id,
            ':categorie_id' => $categorie_id
        ]);
    }

    // ─── READ (tous) avec jointures ────────────────────────────────────────────
    public function listerTous(): array {
        $sql = "SELECT l.*, 
                       CONCAT(a.prenom, ' ', a.nom) AS auteur_nom,
                       c.libelle AS categorie_libelle
                FROM livres l
                LEFT JOIN auteurs    a ON l.auteur_id    = a.id
                LEFT JOIN categories c ON l.categorie_id = c.id
                ORDER BY l.titre";
        return $this->pdo->query($sql)->fetchAll();
    }

    // ─── READ (un seul) ────────────────────────────────────────────────────────
    public function trouverParId(int $id): array|false {
        $stmt = $this->pdo->prepare("SELECT * FROM livres WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    // ─── UPDATE ────────────────────────────────────────────────────────────────
    public function modifier(int $id, string $titre, string $isbn, int $annee, int $quantite, int $auteur_id, int $categorie_id): bool {
        $sql = "UPDATE livres 
                SET titre=:titre, isbn=:isbn, annee=:annee, quantite=:quantite,
                    auteur_id=:auteur_id, categorie_id=:categorie_id
                WHERE id=:id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':id'           => $id,
            ':titre'        => $titre,
            ':isbn'         => $isbn,
            ':annee'        => $annee,
            ':quantite'     => $quantite,
            ':auteur_id'    => $auteur_id,
            ':categorie_id' => $categorie_id
        ]);
    }

    // ─── DELETE ────────────────────────────────────────────────────────────────
    public function supprimer(int $id): bool {
        $stmt = $this->pdo->prepare("DELETE FROM livres WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
}
?>
