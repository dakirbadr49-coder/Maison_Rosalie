<?php
// path: model/abstract/AbstractMapping.php
// typage strict
declare(strict_types=1);

namespace model\abstract;
// class qui ne peut pas etre instanciée
abstract class AbstractMapping
{
    public function __construct(array $datas)
    {
       // $this represent un enfant 
       $this->hydrate($datas);
    }
// création d'une méthode hyadration
// génération du nom des setters via les clef du tableau
protected function hydrate(array $datas):void{

// tant qu'on a des données dans le tableau
foreach($datas as $setter=>$value){
    // création du nom de setter
    $setterName = "set".str_replace("_","",ucwords($setter, '_'));
    // echo "$setterName <br>";
    // vérification de l'existance  du setter dans la classe enfant
    if(method_exists($this,$setterName)){
        // appel du setter existant avec la valeur passée en paramètre
       $this->$setterName($value);
    }
   
}
}


    // méthode qui DOIT etre implémenté dans ses enfants
    //peut etre remplacée par les interfaces
    // abstract public function maMethod():string   
}
