<?php
include 'Twig/Autoloader.php';
include 'miembros.php';
Twig_Autoloader::register();

try {
 
   // define template directory location
  $loader = new Twig_Loader_Filesystem('templates');
  
  // initialize Twig environment
  $twig = new Twig_Environment($loader);
  
  // load template
  $template = $twig->loadTemplate('update.tmpl');
  
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "db_empl";
        
        $conn = mysqli_connect($servername, $username, $password, $dbname);
        //solucion a los acentos en phpMyadmin
        $conn->query("SET NAMES 'utf8'");

        // Check connection
        if (!$conn):
            die("Connection failed: " . mysqli_connect_error());
        endif;
        
        if ($_SERVER["REQUEST_METHOD"] == "POST" ):
            $sql="UPDATE empleados SET nombre = '" . $_POST['nombre'] . "', apellidos = '" . $_POST['apellidos'] . "', fechaNacimiento = '" . $_POST['fechaNacimiento'] . "' WHERE id=" . $_POST['id'];
            echo ($sql);
            echo "post" . $_POST['id'];
            if ($conn->query($sql) === TRUE):
                echo "Registro actualizado";
            else:
                echo "Error: " . $sql . "<br>" . $conn->error;
            endif;
        endif;
            //SELECT
            $sql="SELECT id, nombre, apellidos,fechaNacimiento FROM empleados WHERE id=" . $_GET['id'];
        
            $result = $conn->query($sql);

            if ($result->num_rows > 0):
                // output data of each row
                while($row = $result->fetch_assoc()):
                    $miembro = new miembros($row['id'],$row['nombre'],$row['apellidos'],$row['fechaNacimiento']);
                endwhile;
            
            else:
                echo "No hay datos para mostrar";
            endif;
         
            //MANDAS LAS VARIABLES A LA PLANTILLA
            echo $template->render(array (
                'miembro'=>$miembro,
                'nameErr'=>$nameErr,
                'apellidosErr'=>$apellidosErr,
                'fechaErr'=>$fechaErr,
            ));
        

        
        
  
  
  
} catch (Exception $e) {
  die ('ERROR: ' . $e->getMessage());
}