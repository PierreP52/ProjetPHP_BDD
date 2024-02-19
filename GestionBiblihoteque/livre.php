<?php
require 'database.php';

class Livre {
    private $pdo;

    public function __construct() {
        global $pdo;
        $this->pdo = $pdo;
    }

    public function ajouterLivre($titre, $datePublication, $idAuteur, $idEditeur) {
        // Vérification de l'existence de l'auteur
        $auteurExists = $this->checkIfAuteurExists($idAuteur);
    
        // Vérification de l'existence de l'éditeur
        $editeurExists = $this->checkIfEditeurExists($idEditeur);
    
        if (!$auteurExists || !$editeurExists) {
            echo "L'auteur ou l'éditeur spécifié n'existe pas. Le livre n'a pas été ajouté.\n\n";
        } else {
            // Les ID d'auteur et d'éditeur existent, on peut ajouter le livre
            $query = $this->pdo->prepare("INSERT INTO Livres (titre, date_de_publication, id_auteur, id_editeur) VALUES (?, ?, ?, ?)");
            $query->execute([$titre, $datePublication, $idAuteur, $idEditeur]);
            echo "Le livre '$titre' a été ajouté.\n\n";
        }
    }
    
    // Méthode pour vérifier l'existence d'un auteur
    private function checkIfAuteurExists($idAuteur) {
        $query = $this->pdo->prepare("SELECT id FROM Auteurs WHERE id = ?");
        $query->execute([$idAuteur]);
        return $query->rowCount() > 0;
    }
    
    // Méthode pour vérifier l'existence d'un éditeur
    private function checkIfEditeurExists($idEditeur) {
        $query = $this->pdo->prepare("SELECT id FROM Editeurs WHERE id = ?");
        $query->execute([$idEditeur]);
        return $query->rowCount() > 0;
    }

    public function modifierLivre($id, $titre, $datePublication, $idAuteur, $idEditeur) {
        $query = $this->pdo->prepare("UPDATE Livres SET titre = ?, date_de_publication = ?, id_auteur = ?, id_editeur = ? WHERE id = ?");
        $query->execute([$titre, $datePublication, $idAuteur, $idEditeur, $id]);
        echo "Le livre avec l'ID $id a été modifié.\n\n";
    }

    public function supprimerLivre($id) {
        $query = $this->pdo->prepare("DELETE FROM Livres WHERE id = ?");
        $query->execute([$id]);
        echo "Le livre avec l'ID $id a été supprimé.\n\n";
    }

    public function recupererLivre($id) {
        $query = $this->pdo->prepare("SELECT * FROM Livres WHERE id = ?");
        $query->execute([$id]);

        if ($query->rowCount() > 0) {
            // L'ID existe, on peut récupérer le livre
            $livre = $query->fetch(PDO::FETCH_ASSOC);
            return "ID : " . $livre['id'] . "\n" . " Titre : " . $livre['titre'] . "\n" . " Date de publication : " . $livre['date_de_publication'] . "\n" . " ID Auteur : " . $livre['id_auteur'] . "\n" . " ID Editeur : " . $livre['id_editeur'] . "\n\n";
        } else {
            // L'ID n'existe pas, message d'erreur
            return "Aucun livre trouvé avec l'ID $id.\n\n";
        }
    }
}

$livreManager = new Livre();

// Utilisation des méthodes pour gérer les livres (ajouter, modifier, supprimer, récupérer)
$livreManager = new Livre();

// Ajouter un livre
$livreManager->ajouterLivre('Le Seigneur des Anneaux', '1954-07-29', 1, 1);
$livre = $livreManager->recupererLivre(1);
print_r($livre);

$livreManager->ajouterLivre('Harry Potter à l`école des sorciers', '1997-06-26', 2, 2);
$livre = $livreManager->recupererLivre(2);
print_r($livre);

$livreManager->ajouterLivre('Le Petit Prince', '1943-04-06', 3, 3);
$livre = $livreManager->recupererLivre(2);
print_r($livre);

// Modifier un livre
$livreManager->modifierLivre(1, 'Le Hobbit', '1937-09-21', 1, 1);

// Supprimer un livre
$livreManager->supprimerLivre(2);

// Récupérer un livre
$livre = $livreManager->recupererLivre(1);
print_r($livre);

$livre = $livreManager->recupererLivre(2);
print_r($livre);
?>