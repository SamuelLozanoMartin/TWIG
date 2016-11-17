<?php
// Start the session
session_start();
// include and register Twig auto-loader
include 'Twig/Autoloader.php';
Twig_Autoloader::register();
$maxIntentos = 300;
$num = rand (0,3);
$numPremio = 1;

try {
  // define template directory location
  $loader = new Twig_Loader_Filesystem('templates');
  
  // initialize Twig environment
  $twig = new Twig_Environment($loader);
  
  // load template
  $template = $twig->loadTemplate('numbers.tmpl');

  
  // generate random number and
  // check whether odd or even
  
  if(!isset($_SESSION["numbers"])){
    $arrNumbers = array(); 
  }
  else{
    $arrNumbers = $_SESSION["numbers"];
  }
  array_push($arrNumbers,$num);
  $_SESSION["numbers"]  = $arrNumbers;
  
  $div = ($num % 2);
  $activado = ($maxIntentos > $arrNumbers.length) && ($num != $numPremio);
  echo $activado;

  // set template variables
  // render template
  echo $template->render(array (
    'num' => $num,
    'div' => $div,
    'numbers' => array_reverse($_SESSION["numbers"]),
    'activado' => $activado,
    'numPremio' => $numPremio
  ));
  
} catch (Exception $e) {
  die ('ERROR: ' . $e->getMessage());
}
?>