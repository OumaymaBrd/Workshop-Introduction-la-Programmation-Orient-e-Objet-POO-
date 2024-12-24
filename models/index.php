<?php

// class Mere
class USER{
    public $nom;
    public $prenom;
    public $type_utilisateur=['medicine','patient'];
    
}


// class Fils : herite class User 


class PATIENT extends USER{

   private $date_rendeZ_vous;
}




// class Fils : herite USER 

class MEDICINE extends USER{

    private $specialiste;

}









?>