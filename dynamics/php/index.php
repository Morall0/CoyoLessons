<?php
    session_name("usuario");
    session_start();

    include('./config.php');

    if(isset($_POST["sesion"])){
        if(isset($_SESSION["usuario"])){
            $conexion=conectdb();
            if(isset($_POST["inscribirse"])){
                //inscribir
                $usuario=$_SESSION["usuario"];
                $inscribir=$_POST["inscribirse"];
                $ins="INSERT INTO asesoriahasalumno (id_asesoria, num_cuentaAlumno) VALUES". "(".$inscribir.",".$usuario.")";
                $res1=mysqli_query($conexion,$ins);
            }


        }
        else{
            echo "NO HAY SESION";
        }
    }

?>
