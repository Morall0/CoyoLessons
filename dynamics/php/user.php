<?php
    include('./config.php');
    include('./cifr.php');

    session_name("usuario");
    session_start();

    function materia($x, $y, $conexion){
        if($y==1516)
            $materia="SELECT * FROM materia WHERE id_materia BETWEEN $x AND $y OR id_materia LIKE '%E%' OR id_materia BETWEEN 2000 AND 2226";
        else
            $materia="SELECT * FROM materia WHERE id_materia BETWEEN $x AND $y OR id_materia LIKE '%E%'";
        $respuesta= mysqli_query($conexion, $materia);
        while($asign = mysqli_fetch_array($respuesta))
        {
            echo "<option value=".$asign[0].">".$asign[3]."</option>";
        }
    }

    if(isset($_POST["sesion"])){
        if(isset($_SESSION["usuario"])){
            $conexion = conectdb();
            //Consulta para obetener los datos básicos del usuario.
            if(isset($_POST['datos']))
            {
                $consulta = 'SELECT num_cuenta, Nombre, Correo, Teléfono, Grado, Imagen FROM usuario WHERE num_cuenta='.$_SESSION["usuario"];
                $respuesta = mysqli_query($conexion, $consulta);
                $row = mysqli_fetch_array($respuesta);
        
                //Descifrando el correo y el telefono.
                $row[2]=descifrar($row[2]);
                $row[3]=descifrar($row[3]);
        
                echo $row[0].','.$row[1].','.$row[2].','.$row[3].','.$row[4].','.$row[5];    //Envio de los datos del usuario.
                
            }
    
            if(isset($_POST["asignaturas"]) || isset($_POST["eliminar"]))
            {
                //Consulta para obtener las materias.
                $materiasd_usuario='SELECT id_materia, abreviacion FROM usuariohasmateria NATURAL JOIN materia WHERE num_cuenta='.$_SESSION["usuario"];
                $res_materias = mysqli_query($conexion, $materiasd_usuario);
                while($row_asignaturas = mysqli_fetch_array($res_materias))
                {
                    if(isset($_POST["asignatura"]))
                        echo "<p>".$row_asignaturas[1]."</p>";
                    //Select para eliminar materias
                    if(isset($_POST["eliminar"]))
                        echo "<option value=".$row_asignaturas[0].">".$row_asignaturas[1]."</option>";
                }
            }
    
            if(isset($_POST["materias_select"])){
                //Agregar más materias
                $consultando = 'SELECT Grado FROM usuario WHERE num_cuenta='.$_SESSION["usuario"];
                $resp_grado = mysqli_query($conexion, $consultando);
                $grado = mysqli_fetch_array($resp_grado);
                if($grado[0]=='C'){
                    materia(1400, 1412, $conexion);
                }
                else if($grado[0]=='Q'){
                    materia(1400, 1516, $conexion);
                }
                else if($grado[0]=='S'){
                    materia(1400, 2226, $conexion);
                }
            }
    
            //Horario
            if(isset($_POST['horarios']))
            {
                $horario_in= 'SELECT num_cuenta, dia, hora FROM alumnohashorario NATURAL JOIN horario NATURAL JOIN hora WHERE num_cuenta='.$_SESSION['usuario'];
                $res_horario= mysqli_query($conexion, $horario_in);
                while($row1 = mysqli_fetch_array($res_horario))
                {
                    $row1[1] = ($row1[1] == 'L')? 'Lunes':$row1[1];
                    $row1[1] = ($row1[1] == 'Ma')? 'Martes':$row1[1];
                    $row1[1] = ($row1[1] == 'Mi')? 'Miércoles':$row1[1];
                    $row1[1] = ($row1[1] == 'J')? 'Jueves':$row1[1];
                    $row1[1] = ($row1[1] == 'V')? 'Viernes':$row1[1];
                    
                    echo '<div id="horariosIn"><span>'.$row1[1].'  </span><span>'.$row1[2].'</span></div>';
                }
                
            }
            if(isset($_POST["cerrar"])){
                session_unset();
                session_destroy();
            }
        }
        else{ 
            echo "NO HAY SESION";
        }
    }


?>
