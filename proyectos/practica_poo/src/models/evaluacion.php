<?php

namespace App\models;
//require __DIR__ ."/../vendor/autoload.php";

use App\contracts\EvaluacionAbs;
use App\contracts\EvaluacionI;


class Evaluacion extends EvaluacionAbs implements EvaluacionI{
    public function __construct(public $nombreEvaluacion , public $ponderacion)
    {   
    }
    public function calcularNota(){
        return "no implementado;";
    }
  public function aporteNota(){
        return $this->calcularNota() * $this->ponderacion;
    }
}


class Alumno {
  public static $nombreAlumno;
  public function __construct( public $carnet)
  {

  }

  public static function mostarMensaje($nombre){
   self ::$nombreAlumno=$nombre;
   return self::$nombreAlumno;
   
  }
}

/*$parcial = new Parcial("Parcial 1", 0.25, [6,7,9]);
echo $parcial->calcularNota() . "\n";
echo "<br>";
echo "<br>";
$proyecto = new Proyecto("Proyecto 1", 0.60, [
    'nombrePoyecto' => 'Sistema PHP',
    'notaDefensa' => 8,
    'notaProyecto' => 10
]);
echo $proyecto->calcularNota();
echo '<br>';
echo $parcial->aporteNota();
echo '<br>';
echo $proyecto->aporteNota();
echo '<br>';
echo Alumno::mostarMensaje("Vilma");*/
?>
