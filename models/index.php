<?php 


class USER {
    public $nom;
    public $prenom;
    public $type_utilisateur;


    //definir un constructeur

    public function __construct($nom, $prenom, $type_utilisateur) {
        $this->nom = $nom;
        $this->prenom = $prenom;


        $types_disponibles = ['medecine', 'patient'];
        if (in_array($type_utilisateur, $types_disponibles)) {
            $this->type_utilisateur = $type_utilisateur;
        } else {
            throw new Exception("Type utilisateur invalide : $type_utilisateur");
        }
    }

    public function afficherDetails() {
        echo "Nom : $this->nom, Prénom : $this->prenom, Type : $this->type_utilisateur";
    }
}


try {
    $user = new USER("Oumayma", "Bramid", "patient");
    $user->afficherDetails();
} catch (Exception $e) {
    echo "Erreur : " . $e->getMessage();
}





?>