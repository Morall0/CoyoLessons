<?php
    session_name("usuario");
    session_start();

    include('./config.php');

    if(isset($_POST["sesion"])){
        if(isset($_SESSION["usuario"])){
            $conexion=conectdb();
            $usuario=$_SESSION["usuario"];
            if(isset($_POST["inscribirse"])){
                //inscribir
                $inscribir=$_POST["inscribirse"];
                $cons_ahu="SELECT MIN(id_uha) FROM asesoriahasalumno WHERE id_asesoria=$inscribir AND num_cuentaAlumno IS NULL";
                $resp_ahu=mysqli_query($conexion, $cons_ahu);
                $ahu_array = mysqli_fetch_array($resp_ahu);
                $ins="UPDATE asesoriahasalumno SET num_cuentaAlumno=$usuario WHERE id_uha=$ahu_array[0]";
                $res1=mysqli_query($conexion,$ins);
                if($res1)
                    echo "si entro";
                else{
                    echo $ins;
                }
            }
            if(isset($_POST["desinscribirse"])){
                $desinscribirse=$_POST["desinscribirse"];
                $cons_desins="UPDATE asesoriahasalumno SET num_cuentaAlumno= NULL WHERE id_asesoria=$desinscribirse AND num_cuentaAlumno=$usuario";
                $resp_desins=mysqli_query($conexion, $cons_desins);
                if($resp_desins)
                    echo "si entro";
                else{
                    echo $cons_desins;
                }

            }

        }
        else{
            echo "NO HAY SESION";
        }
    }

?>
