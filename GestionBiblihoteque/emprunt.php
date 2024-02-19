<?php
require 'database.php';

class Emprunt {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function ajouterEmprunt($idEmprunteur, $idLivre, $dateEmprunt, $dateRetour) {
        // Vérification de l'existence de l'emprunteur
        $emprunteurExists = $this->checkIfEmprunteurExists($idEmprunteur);
        
        // Vérification de l'existence du livre
        $livreExists = $this->checkIfLivreExists($idLivre);
        
        if (!$emprunteurExists || !$livreExists) {
            echo "L'emprunteur ou le livre spécifié n'existe pas. L'emprunt n'a pas été ajouté.\n\n";
        } else {
            // Les ID d'emprunteur et de livre existent, on peut ajouter l'emprunt
            $query = $this->pdo->prepare("INSERT INTO Emprunts (id_emprunteur, id_livre, date_d_emprunt, date_de_retour) VALUES (?, ?, ?, ?)");
            $query->execute([$idEmprunteur, $idLivre, $dateEmprunt, $dateRetour]);
            echo "L'emprunt a été ajouté avec succès.\n\n";
        }
    }
    
    public function modifierEmprunt($id, $idEmprunteur, $idLivre, $dateEmprunt, $dateRetour) {
        // Vérification de l'existence de l'emprunteur
        $emprunteurExists = $this->checkIfEmprunteurExists($idEmprunteur);
        
        // Vérification de l'existence du livre
        $livreExists = $this->checkIfLivreExists($idLivre);
        
        if (!$emprunteurExists || !$livreExists) {
            echo "L'emprunteur ou le livre spécifié n'existe pas. L'emprunt n'a pas été modifié.\n\n";
        } else {
            // Les ID d'emprunteur et de livre existent, on peut modifier l'emprunt
            $query = $this->pdo->prepare("UPDATE Emprunts SET id_emprunteur = ?, id_livre = ?, date_d_emprunt = ?, date_de_retour = ? WHERE id = ?");
            $query->execute([$idEmprunteur, $idLivre, $dateEmprunt, $dateRetour, $id]);
            echo "L'emprunt avec l'ID $id a été modifié.\n\n";
        }
    }

    public function supprimerEmprunt($id) {
        $query = $this->pdo->prepare("DELETE FROM Emprunts WHERE id = ?");
        $query->execute([$id]);
        echo "L'emprunt avec l'ID $id a été supprimé.\n\n";
    }

    public function recupererEmprunt($id) {
        $query = $this->pdo->prepare("SELECT * FROM Emprunts WHERE id = ?");
        $query->execute([$id]);

        if ($query->rowCount() > 0) {
            $emprunt = $query->fetch(PDO::FETCH_ASSOC);
            return "ID : " . $emprunt['id'] . "\n" . "ID Emprunteur : " . $emprunt['id_emprunteur'] . "\n" . "ID Livre : " . $emprunt['id_livre'] . "\n" . "Date d'emprunt : " . $emprunt['date_d_emprunt'] . "\n" . "Date de retour : " . $emprunt['date_de_retour'] . "\n\n";
        } else {
            return "Aucun emprunt trouvé avec l'ID $id.\n\n";
        }
    }

    // Méthode pour vérifier l'existence d'un auteur
    private function checkIfEmprunteurExists($idEmprunteur) {
        $query = $this->pdo->prepare("SELECT id FROM Emprunteurs WHERE id = ?");
        $query->execute([$idEmprunteur]);
        return $query->rowCount() > 0;
    }
    
    // Méthode pour vérifier l'existence d'un éditeur
    private function checkIfLivreExists($idLivre) {
        $query = $this->pdo->prepare("SELECT id FROM Livres WHERE id = ?");
        $query->execute([$idLivre]);
        return $query->rowCount() > 0;
    }
}

$empruntManager = new Emprunt($pdo);

// Exemples d'utilisation
$empruntManager->ajouterEmprunt(1, 1, '2023-11-01', '2023-11-15');
$emprunt = $empruntManager->recupererEmprunt(1);
print_r($emprunt);

$empruntManager->ajouterEmprunt(2, 2, '2023-10-01', '2023-10-15');
$emprunt = $empruntManager->recupererEmprunt(2);
print_r($emprunt);

$empruntManager->ajouterEmprunt(3, 1, '2023-09-01', '2023-09-15');
$emprunt = $empruntManager->recupererEmprunt(3);
print_r($emprunt);

//modifier emprunt
$empruntManager->modifierEmprunt(1, 2, 2, '2023-11-10', '2023-11-25');
$emprunt = $empruntManager->recupererEmprunt(1);
print_r($emprunt);

//supprimer emprunt
$empruntManager->supprimerEmprunt(2);

$emprunt = $empruntManager->recupererEmprunt(1);
print_r($emprunt);

$emprunt = $empruntManager->recupererEmprunt(2);
print_r($emprunt);

$emprunt = $empruntManager->recupererEmprunt(3);
print_r($emprunt);

?>