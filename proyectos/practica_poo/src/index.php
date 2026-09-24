<?php
require __DIR__ ."/../vendor/autoload.php";

use App\models\Parcial;
use App\models\Laboratorio;
use App\models\Proyecto;


$parcial = new Parcial("Parcial 1", 0.25, [6,7,9]);
echo $parcial->calcularNota() . "\n";
echo "<br>";
$laboratorio = new Laboratorio("Laboratorio 1", 0.15, 7);
echo $laboratorio->calcularNota() . "\n";
echo "<br>";
$proyecto = new Proyecto("Proyecto 1", 0.60, [
    'nombrePoyecto' => 'Sistema PHP',
    'notaDefensa' => 8,
    'notaProyecto' => 10
]);
echo $proyecto->calcularNota();
echo '<br>';
echo $laboratorio->aporteNota();
echo '<br>';
echo $parcial->aporteNota();
echo '<br>';
echo $proyecto->aporteNota();
echo '<br>';
$laboratorio->MostrarFecha(); 
echo '<br>';
//echo Alumno::mostarMensaje("Vilma");
?>