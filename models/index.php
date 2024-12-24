<?php

class USER {
    public $nom;
    public $prenom;
    public $type_utilisateur;

    public function __construct($nom, $prenom, $type_utilisateur) {
        $this->nom = $nom;
        $this->prenom = $prenom;

        $types_disponibles = ['medecin', 'patient'];
        if (in_array($type_utilisateur, $types_disponibles)) {
            $this->type_utilisateur = $type_utilisateur;
        } else {
            throw new Exception("Type utilisateur invalide : $type_utilisateur");
        }
    }

    public function afficher_nom_Complet() {
        echo "Nom : $this->nom, Prénom : $this->prenom, Type : $this->type_utilisateur\n";
    }

    public function changerNom($nouveauNom) {
        $this->nom = $nouveauNom;
    }

    public function changerPrenom($nouveauPrenom) {
        $this->prenom = $nouveauPrenom;
    }
}

class PATIENT extends USER {
    private $date_rendez_vous;
    private $historique_rendez_vous = [];

    public function __construct($nom, $prenom, $date_rendez_vous = null) {
        parent::__construct($nom, $prenom, 'patient');
        $this->date_rendez_vous = $date_rendez_vous;
    }

    public function prend_rendez_vous($date) {
        $this->date_rendez_vous = $date;
        $this->historique_rendez_vous[] = $date;
        echo "Rendez-vous pris pour le $date\n";
    }

    public function afficher_historique_rendez_vous() {
        echo "Historique des rendez-vous pour $this->prenom $this->nom:\n";
        foreach ($this->historique_rendez_vous as $date) {
            echo "- $date\n";
        }
    }
}

class Medicine extends USER {
    private $patients = [];
    private $specialite;

    public function __construct($nom, $prenom, $specialite) {
        parent::__construct($nom, $prenom, 'medecin');
        $this->specialite = $specialite;
    }

    public function ajouter_patient($patient) {
        if ($patient instanceof PATIENT) {
            $this->patients[] = $patient;
            echo "Patient {$patient->prenom} {$patient->nom} ajouté à la liste du Dr. {$this->nom}\n";
        } else {
            throw new Exception("L'objet fourni n'est pas un patient valide.");
        }
    }

    public function consulter_patient($nom_patient) {
        foreach ($this->patients as $patient) {
            if ($patient->nom === $nom_patient) {
                echo "Le Dr. {$this->nom} ({$this->specialite}) consulte le patient {$patient->prenom} {$patient->nom}\n";
                return;
            }
        }
        echo "Patient $nom_patient non trouvé dans la liste du Dr. {$this->nom}\n";
    }

    public function afficher_patients() {
        echo "Liste des patients du Dr. {$this->nom} ({$this->specialite}):\n";
        foreach ($this->patients as $patient) {
            echo "- {$patient->prenom} {$patient->nom}\n";
        }
    }
}

// Exemple 

try {
    // Création de patients
    $patient1 = new PATIENT("Dupont", "Jean");
    $patient2 = new PATIENT("Martin", "Sophie");

    // Prise de rendez-vous
    $patient1->prend_rendez_vous("2023-06-15");
    $patient1->prend_rendez_vous("2023-07-20");
    $patient2->prend_rendez_vous("2023-06-18");

    // Affichage de l'historique des rendez-vous
    $patient1->afficher_historique_rendez_vous();

    // Création d'un médecin
    $medecin = new Medicine("Smith", "John", "Cardiologue");

    // Ajout de patients au médecin
    $medecin->ajouter_patient($patient1);
    $medecin->ajouter_patient($patient2);

    // Consultation de patients
    $medecin->consulter_patient("Dupont");
    $medecin->consulter_patient("Martin");
    $medecin->consulter_patient("Doe"); // Patient non existant

    // Affichage de la liste des patients du médecin
    $medecin->afficher_patients();

    // Modification des informations d'un utilisateur
    $patient1->changerNom("Durand");
    $patient1->afficher_nom_Complet();

} catch (Exception $e) {
    echo "Erreur : " . $e->getMessage() . "\n";
}

?>