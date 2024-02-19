<?php
require 'database.php';

class Emprunteur {
    private $pdo;

    public function __construct() {
        global $pdo;
        $this->pdo = $pdo;
    }

    public function ajouterEmprunteur($nom, $prenom, $adresseEmail, $motDePasse) {
        $query = $this->pdo->prepare("INSERT INTO emprunteurs (nom, prenom, adresse_email, mot_de_passe) VALUES (?, ?, ?, ?)");
        $query->execute([$nom, $prenom, $adresseEmail, $motDePasse]);
        echo "L'emprunteur $nom $prenom a été ajouté.\n\n";
    }

    public function modifierEmprunteur($id, $nom, $prenom, $adresseEmail, $motDePasse) {
        $query = $this->pdo->prepare("UPDATE emprunteurs SET nom = ?, prenom = ?, adresse_email = ?, mot_de_passe = ? WHERE id = ?");
        $query->execute([$nom, $prenom, $adresseEmail, $motDePasse, $id]);
        echo "L'emprunteur avec l'ID $id a été modifié.\n\n";
    }

    public function supprimerEmprunteur($id) {
        $query = $this->pdo->prepare("DELETE FROM emprunteurs WHERE id = ?");
        $query->execute([$id]);
        echo "L'emprunteur avec l'ID $id a été supprimé.\n\n";
    }

    public function recupererEmprunteur($id) {
        $query = $this->pdo->prepare("SELECT * FROM emprunteurs WHERE id = ?");
        $query->execute([$id]);

        if ($query->rowCount() > 0) {
            $emprunteur = $query->fetch(PDO::FETCH_ASSOC);
            return "ID : " . $emprunteur['id'] . "\n" . " Nom : " . $emprunteur['nom'] . "\n" . " Prénom : " . $emprunteur['prenom'] . "\n" . " Adresse Email : " . $emprunteur['adresse_email'] . "\n\n";
        } else {
            return "Aucun emprunteur trouvé avec l'ID $id.\n\n";
        }
    }
}

$emprunteurManager = new Emprunteur($pdo);

// Ajouter un Emprunteur
$emprunteurManager->ajouterEmprunteur('Jiji', 'NIni', 'Jiji@email.com', 'motdepasse123');

$emprunteur = $emprunteurManager->recupererEmprunteur(1);
print_r($emprunteur);

$emprunteurManager->ajouterEmprunteur('Bob', 'Martin', 'bob@email.com', 'motdepasse2');
$emprunteur = $emprunteurManager->recupererEmprunteur(2);
print_r($emprunteur);

$emprunteurManager->ajouterEmprunteur('Jo', 'Blo', 'jo@email.com', 'motdepasse3');
$emprunteur = $emprunteurManager->recupererEmprunteur(3);
print_r($emprunteur);


// Modifier un emprunteur
$emprunteurManager->modifierEmprunteur(1, 'Alicia', 'Dupont', 'alicia@email.com', 'nouveaumotdepasse');

// Supprimer un emprunteur
$emprunteurManager->supprimerEmprunteur(2);


// Récupérer un emprunteur
$emprunteur = $emprunteurManager->recupererEmprunteur(1);
print_r($emprunteur);
$emprunteur = $emprunteurManager->recupererEmprunteur(2);
print_r($emprunteur);
$emprunteur = $emprunteurManager->recupererEmprunteur(3);
print_r($emprunteur);
?>
