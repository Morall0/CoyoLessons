<?php
    session_name("usuario");
    session_start();

    include('./config.php');
    $conexion=conectdb();  

    if(isset($_POST['sesion'])){
        if(isset($_SESSION['usuario'])){
            $usuario = $_SESSION["usuario"];
            if(isset($_POST["formAsesoria"])){
                $materiaA=$_POST["materiaSelect"];
                $tema=$_POST["tema"];
                $modalidad=$_POST["modalidad"];
                $medio=$_POST["medio"];
                $horario=$_POST["horario"];
                $duracion=$_POST["duracion"];
                $fecha=$_POST["fecha"];
                
                $consul_ahh="SELECT id_ahh FROM alumnohashorario WHERE num_cuenta=$usuario AND id_horario=$horario";
                $res_id=mysqli_query($conexion, $consul_ahh);
                $id_ahh=mysqli_fetch_array($res_id);
                $insertAsesoria="INSERT INTO asesoria (Medio, Modalidad, Fecha, Duracion, Tema, id_materia, id_ahh) VALUES ('$medio', '$modalidad', '$fecha', $duracion, '$tema', '$materiaA', ".$id_ahh[0].")";
                $res=mysqli_query($conexion,$insertAsesoria);
                if($res){
                    echo $insertAsesoria;
                }
                else{
                    echo"no".$insertAsesoria;;
                }
            }
        }
        else{
            echo "NO HAY SESION";
        }
    }
?>