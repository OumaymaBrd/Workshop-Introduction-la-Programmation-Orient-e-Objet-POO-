<?php


class personne{
    public $nom;
    public $prenom;

    public function __construct($nom,$prenom){
        $this->nom=$nom;
        $this->prenom=$prenom;
    }
}


$p1=new personne("oumayma","Bramid");

var_dump($p1);


?>