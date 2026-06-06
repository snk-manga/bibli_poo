<?php
// connexion.php — Connexion à la base de données avec PDO

class Connexion {
    // Attributs privés (on ne les expose pas directement)
    private static $instance = null; // instance unique (Singleton)
    private $pdo;

    // Paramètres de connexion
    private $host     = 'localhost';
    private $dbname   = 'bibliotheque';
    private $username = 'root';
    private $password = 'root';
    private $charset  = 'utf8';

    // Le constructeur est privé : on ne peut pas faire "new Connexion()" depuis l'extérieur
    private function __construct() {
        $dsn = "mysql:host={$this->host};dbname={$this->dbname};charset={$this->charset}";

        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Lance des exceptions en cas d'erreur
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Résultats sous forme de tableau associatif
            PDO::ATTR_EMULATE_PREPARES   => false,                  // Désactive l'émulation des requêtes préparées
        ];

        try {
            $this->pdo = new PDO($dsn, $this->username, $this->password, $options);
        } catch (PDOException $e) {
            die("Erreur de connexion : " . $e->getMessage());
        }
    }

    // Méthode statique pour récupérer l'instance unique
    public static function getInstance(): self {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    // Retourne l'objet PDO
    public function getPDO(): PDO {
        return $this->pdo;
    }
}
?>
