<?php

require 'database.php';

class Editeur {
    private $pdo;

    public function __construct() {
        global $pdo;
        $this->pdo = $pdo;
    }

    public function ajouterEditeur($nom, $adresse) {
        $query = $this->pdo->prepare("INSERT INTO Editeurs (nom, adresse) VALUES (?, ?)");
        $query->execute([$nom, $adresse]);
        echo "L'éditeur '$nom' a été ajouté.\n\n";
    }

    public function modifierEditeur($id, $nom, $adresse) {
        $query = $this->pdo->prepare("UPDATE Editeurs SET nom = ?, adresse = ? WHERE id = ?");
        $query->execute([$nom, $adresse, $id]);
        echo "L'éditeur avec l'ID $id a été modifié.\n\n";
    }

    public function supprimerEditeur($id) {
        $query = $this->pdo->prepare("DELETE FROM Editeurs WHERE id = ?");
        $query->execute([$id]);
        echo "L'éditeur avec l'ID $id a été supprimé.\n\n";
    }

    public function recupererEditeur($id) {
        $query = $this->pdo->prepare("SELECT * FROM Editeurs WHERE id = ?");
        $query->execute([$id]);

        if ($query->rowCount() > 0) {
            $editeur = $query->fetch(PDO::FETCH_ASSOC);
            return "ID : " . $editeur['id'] . "\n" . " Nom : " . $editeur['nom'] . "\n" . " Adresse : " . $editeur['adresse'] . "\n\n";
        } else {
            return "Aucun éditeur trouvé avec l'ID $id.\n\n";
        }
    }
}

$editeurManager = new Editeur();

// Ajouter un éditeur
$editeurManager->ajouterEditeur('Maison d\'édition 1', 'Adresse 1');
$editeur = $editeurManager->recupererEditeur(1);
print_r($editeur);

$editeurManager->ajouterEditeur('Maison d\'édition 2', 'Adresse 2');
$editeur = $editeurManager->recupererEditeur(2);
print_r($editeur);

$editeurManager->ajouterEditeur('Maison d\'édition 3', 'Adresse 3');
$editeur = $editeurManager->recupererEditeur(3);
print_r($editeur);

// Modifier un éditeur
$editeurManager->modifierEditeur(1, 'Nouvelle Maison', 'Nouvelle Adresse');

// Supprimer un éditeur
$editeurManager->supprimerEditeur(2);

// Récupérer un éditeur
$editeur = $editeurManager->recupererEditeur(1);
print_r($editeur);

$editeur = $editeurManager->recupererEditeur(2);
print_r($editeur);

$editeur = $editeurManager->recupererEditeur(3);
print_r($editeur);

?>
