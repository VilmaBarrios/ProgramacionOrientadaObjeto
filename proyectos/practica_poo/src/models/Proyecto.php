<?php

namespace App\models;
require __DIR__ ."/../vendor/autoload.php";
use App\models\Evaluacion;

class Proyecto extends Evaluacion
{
  // Recibe el array en el constructor
  public function __construct($nombreEvaluacion, $ponderacion, public array $notaPoryecto){
    parent::__construct($nombreEvaluacion, $ponderacion);
  }

  public function calcularNota(){
    return ($this->notaPoryecto['notaDefensa'] + $this->notaPoryecto['notaProyecto']) / 2;
    
  }
}


?>