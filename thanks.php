<?php
include 'Persona.php';
// include and register Twig auto-loader
include 'Twig/Autoloader.php';
Twig_Autoloader::register();

try {
  // specify where to look for templates
  $loader = new Twig_Loader_Filesystem('templates');
  
  // initialize Twig environment
  $twig = new Twig_Environment($loader);
  
  // load template
  $template = $twig->loadTemplate('thanks.tmpl');
   $a = $_REQUEST['a'];
   $b = $_REQUEST['b'];
  // set template variables
  // render template
  $persona = new Persona('Paco', 'pgarcia', 'ch0r1zO');
  
  echo $template->render(array(
    'name' => 'Clark Kent',
    'username' => 'ckent',
    'password' => 'krypt0n1te', 
    'suma' => $a+$b,
    'persona' => $persona
  ));
  
} catch (Exception $e) {
  die ('ERROR: ' . $e->getMessage());
}
?>