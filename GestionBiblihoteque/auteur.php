<?php
require 'database.php';

class Auteur {
    private $pdo;

    public function __construct() {
        global $pdo;
        $this->pdo = $pdo;
    }

    public function ajouterAuteur($nom, $prenom, $dateNaissance) {
        $query = $this->pdo->prepare("INSERT INTO auteurs (nom, prenom, date_de_naissance) VALUES (?, ?, ?)");
        $query->execute([$nom, $prenom, $dateNaissance]);
        echo "L'auteur $nom $prenom a été ajouté.\n\n";
        
    }

    public function modifierAuteur($id, $nom, $prenom, $dateNaissance) {
        $query = $this->pdo->prepare("UPDATE auteurs SET nom = ?, prenom = ?, date_de_naissance = ? WHERE id = ?");
        $query->execute([$nom, $prenom, $dateNaissance, $id]);
        echo "L`auteur $id a été modiffié.\n\n";
       
    }

    public function supprimerAuteur($id) {
        $query = $this->pdo->prepare("DELETE FROM auteurs WHERE id = ?");
        $query->execute([$id]);
        echo "L`auteur $id a été supprimé.\n\n";
       
    }

    public function recupererAuteur($id) {
        $query = $this->pdo->prepare("SELECT * FROM auteurs WHERE id = ?");
        $query->execute([$id]);
    
        if ($query->rowCount() > 0) {
            // L'ID existe, on peut récupérer l'auteur
            $auteur = $query->fetch(PDO::FETCH_ASSOC);
            return "ID : " . $auteur['id'] . "\n" . " Nom : " . $auteur['nom'] . "\n" . " Prénom : " . $auteur['prenom'] . "\n" . " Date de naissance : " . $auteur['date_de_naissance'] . "\n\n";
        } else {
            // L'ID n'existe pas,message d'erreur
            return "Aucun auteur trouvé avec cet id $id.\n\n";
        }
    }
}

// Usage:
// $pdo = new PDO('mysql:host=localhost;dbname=bdd_bibli', 'root', 'AECgodin.21012023');
$auteurManager = new Auteur($pdo);

// Ajouter un auteur
$auteurManager->ajouterAuteur('Jean', 'Calude', '1990-08-22');

$auteur = $auteurManager->recupererAuteur(1);
print_r($auteur);

$auteurManager->ajouterAuteur('Pierre', 'Richard', '1984-09-22');

$auteur = $auteurManager->recupererAuteur(2);
print_r($auteur);

$auteurManager->ajouterAuteur('Nono', 'Lerobo', '1944-03-21');

$auteur = $auteurManager->recupererAuteur(3);
print_r($auteur);

// Modifier un auteur
$auteurManager->modifierAuteur(1, 'Bernadette', 'Coucou', '1980-10-14');

// Supprimer un auteur
$auteurManager->supprimerAuteur(2);

// Récupérer un auteur
$auteur = $auteurManager->recupererAuteur(1);
print_r($auteur);
$auteur = $auteurManager->recupererAuteur(2);
print_r($auteur);
$auteur = $auteurManager->recupererAuteur(3);
print_r($auteur);
?>