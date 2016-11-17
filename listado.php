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
  $template = $twig->loadTemplate('listado.tmpl');

        $apellidosErr="";
        $nameErr="";
        $fechaErr="";
        $miembro=array();

        function test_input($data) {
              $data = trim($data);
              $data = stripslashes($data);
              $data = htmlspecialchars($data);
              return $data;
        }

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
        
        //INSERTAR
        if ($_SERVER["REQUEST_METHOD"] == "POST" ):
            
            //validacion nombre
            if (empty($_POST["nombre"])):
                $nameErr = "Nombre obligatorio";
                
            
            else:
                $name = test_input($_POST["nombre"]);
                // check if name only contains letters and whitespace
                if (!preg_match("/^[a-zA-Z ]*$/",$name)):
                  $nameErr = "Solo esta permitido letras y espacions en blanco"; 
                endif;
                
            endif;
           
            //validacion apellidos
            if (empty($_POST["apellidos"])):
                $apellidosErr = "Apellidos obligatorios";
               
                
             
            else:
                $apellidos = test_input($_POST["apellidos"]);
                // check if name only contains letters and whitespace
                if (!preg_match("/^[a-zA-Z ]*$/",$apellidos)):
                  $apellidosErr = "Solo esta permitido letras y espacios en blanco"; 
                endif;
                
            endif;

            //validacion de fecha
            echo ($_POST['fechaNacimiento'] . "fecha");
            if (empty($_POST['fechaNacimiento'])):
                $fechaErr = "la fecha es obligatoria";
            
            else:
                $fecha=$_POST['fechaNacimiento'];
                $fecha=explode("-", $fecha);
                if (sizeof($fecha) !=3):
                    $fechaErr="Fecha incorrecta";

                
                elseif ($fecha[0]> date(Y)):
                    $fechaErr="Todavia no has nacido";
                

                elseif (checkdate($fecha[1],$fecha[2],$fecha[0])==false):
                    $fechaErr="Fecha incorrecta";
                endif;
            endif;

            if ($apellidosErr=="" && $nameErr=="" && $fechaErr==""):
                $sql="INSERT INTO empleados (nombre, apellidos,fechaNacimiento) 
                    VALUES ('".$name."','". $apellidos."','". $_POST['fechaNacimiento']. "')";
                    if ($conn->query($sql) === TRUE):
                        echo "Nuevo registro insertado";
                    else:
                        echo "Error: " . $sql . "<br>" . $conn->error;
                    endif;
            endif;
        endif;
        
        //DELETE
        if ($_SERVER["REQUEST_METHOD"]=="GET" && $_GET["id"]!=""):
            $sql="DELETE FROM empleados WHERE id=" . $_GET["id"];
            if ($conn->query($sql) === TRUE):
                echo "Empleado eliminado";
            else:
                echo "Error: " . $sql . "<br>" . $conn->error;
            endif;
        endif;

        //SELECT
        $sql="SELECT id, nombre, apellidos,fechaNacimiento FROM empleados order by id DESC";
        
        $result = $conn->query($sql);

        if ($result->num_rows > 0):
            // output data of each row
            while($row = $result->fetch_assoc()):
                $objMiembro = new miembros($row['id'],$row['nombre'],$row['apellidos'],$row['fechaNacimiento']);
                array_push($miembro, $objMiembro);
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
?>