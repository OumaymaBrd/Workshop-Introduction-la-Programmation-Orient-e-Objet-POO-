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
        return "Nom : $this->nom, Prénom : $this->prenom, Type : $this->type_utilisateur";
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
        return "Rendez-vous pris pour le $date";
    }

    public function afficher_historique_rendez_vous() {
        $output = "Historique des rendez-vous pour $this->prenom $this->nom:<br>";
        foreach ($this->historique_rendez_vous as $date) {
            $output .= "- $date<br>";
        }
        return $output;
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
            return "Patient {$patient->prenom} {$patient->nom} ajouté à la liste du Dr. {$this->nom}";
        } else {
            throw new Exception("L'objet fourni n'est pas un patient valide.");
        }
    }

    public function consulter_patient($nom_patient) {
        foreach ($this->patients as $patient) {
            if ($patient->nom === $nom_patient) {
                return "Le Dr. {$this->nom} ({$this->specialite}) consulte le patient {$patient->prenom} {$patient->nom}";
            }
        }
        return "Patient $nom_patient non trouvé dans la liste du Dr. {$this->nom}";
    }

    public function afficher_patients() {
        $output = "Liste des patients du Dr. {$this->nom} ({$this->specialite}):<br>";
        foreach ($this->patients as $patient) {
            $output .= "- {$patient->prenom} {$patient->nom}<br>";
        }
        return $output;
    }
}
//initialiser un tableau 
$output = [];

try {
    // Création de patients
    $patient1 = new PATIENT("El Fassi", "Amina");
    $patient2 = new PATIENT("Benani", "Youssef");

    // Prise de rendez-vous
    $output[] = $patient1->prend_rendez_vous("2023-06-15");
    $output[] = $patient1->prend_rendez_vous("2023-07-20");
    $output[] = $patient2->prend_rendez_vous("2023-06-18");

    // Affichage de l'historique des rendez-vous
    $output[] = $patient1->afficher_historique_rendez_vous();

    // Création d'un médecin
    $medecin = new Medicine("Alaoui", "Fatima", "Pédiatre");

    // Ajout de patients au médecin
    $output[] = $medecin->ajouter_patient($patient1);
    $output[] = $medecin->ajouter_patient($patient2);

    // Consultation de patients
    $output[] = $medecin->consulter_patient("El Fassi");
    $output[] = $medecin->consulter_patient("Benani");
    $output[] = $medecin->consulter_patient("Tazi"); // Patient non existant

    // Affichage de la liste des patients du médecin
    $output[] = $medecin->afficher_patients();

    // Modification des informations d'un utilisateur
    $patient1->changerNom("Chraibi");
    $output[] = $patient1->afficher_nom_Complet();

} catch (Exception $e) {
    $output[] = "Erreur : " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Système de Gestion Médicale Marocain</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Système de Gestion Médicale Marocain</h1>
    <div class="output-container">
        <?php foreach ($output as $item): ?>
            <div class="output-item">
                <?php echo $item; ?>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>