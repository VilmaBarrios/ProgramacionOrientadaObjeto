<?php

namespace App\models;

//require __DIR__ ."/../vendor/autoload.php";
use App\models\Evaluacion;

class Parcial extends Evaluacion{

  public function __construct($nombreEvaluacion , $ponderacion, public array $notas){
    parent::__construct($nombreEvaluacion , $ponderacion);
  }

   public function calcularNota(){
        return array_sum($this->notas)/count($this->notas);
    }

}


?>