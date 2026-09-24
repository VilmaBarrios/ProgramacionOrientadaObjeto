<?php

namespace App\models;
require __DIR__ ."/../vendor/autoload.php";

use App\models\Evaluacion;
use App\utils\MostrarFecha;


class Laboratorio extends Evaluacion{

use MostrarFecha;
  public function __construct($nombreEvaluacion , $ponderacion, public $notalab){
    parent::__construct($nombreEvaluacion , $ponderacion);
  }

   public function calcularNota(){
        return $this->notalab;
    }
}


?>