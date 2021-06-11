<?php
    include('./config.php');
    include('./cifr.php');

    session_name("usuario");
    session_start();

    function materia($x, $y, $conexion){
        $usuario=$_SESSION['usuario'];
        if($y==1516)
            $materia= "SELECT * FROM materia  WHERE id_materia BETWEEN $x AND $y AND id_materia NOT IN (SELECT id_materia FROM usuariohasmateria WHERE num_cuenta=$usuario)
                        OR id_materia LIKE '%E%' AND id_materia NOT IN (SELECT id_materia FROM usuariohasmateria WHERE num_cuenta=$usuario)
                        OR id_materia BETWEEN 2101 AND 2226 AND id_materia NOT IN (SELECT id_materia FROM usuariohasmateria WHERE num_cuenta=$usuario)";
        else
            $materia= "SELECT * FROM materia WHERE id_materia BETWEEN $x AND $y AND id_materia NOT IN (SELECT id_materia FROM usuariohasmateria WHERE num_cuenta=$usuario)
                        OR id_materia LIKE '%E%' AND id_materia NOT IN (SELECT id_materia FROM usuariohasmateria WHERE num_cuenta=$usuario)";
        $respuesta= mysqli_query($conexion, $materia);
        echo $materia;

        while($asign = mysqli_fetch_array($respuesta))
        {
            echo "<option value=".$asign[0].">".$asign[3]."</option>";
        }
    }

    if(isset($_POST["sesion"])){


        if(isset($_SESSION["usuario"])){
            if(isset($_POST["eltipo"])){
                if($_SESSION["tipo"]=='A'){
                    echo "SI ES ADMIN";
                }
                else{
                    echo "NO ES ADMIN";
                }
            }
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

            elseif(isset($_POST["foto"]) && $_POST["foto"] != ""){
                $foto = $_POST["foto"];
                $updt_foto="UPDATE usuario SET Imagen = '$foto' WHERE num_cuenta =".$_SESSION["usuario"];
                $resp = mysqli_query($conexion, $updt_foto);
                if($resp){
                    echo "SE CAMBIO CORRECTAMENTE LA IMAGEN";
                }else{
                    echo "NO SE PUDO CAMBIAR LA IMAGEN";
                }
            }

            elseif(isset($_POST["asignaturas"]) || isset($_POST["eliminar"]))
            {
                //Consulta para obtener las materias.
                $materiasd_usuario='SELECT id_materia, abreviacion, nombre FROM usuariohasmateria NATURAL JOIN materia WHERE num_cuenta='.$_SESSION["usuario"];
                $res_materias = mysqli_query($conexion, $materiasd_usuario);
                $contar= mysqli_num_rows($res_materias);
                while($row_asignaturas = mysqli_fetch_array($res_materias))
                {
                    if(isset($_POST["asignaturas"]))
                        echo "<li>".$row_asignaturas[2]."</li>";
                    //Select para eliminar materias
                    if(isset($_POST["eliminar"])){
                        if(isset($_POST['materiaAsesoria'])){
                            echo "<option value=".$row_asignaturas[0].">".$row_asignaturas[2]."</option>";
                        }
                        if($contar>1 && !isset($_POST['materiaAsesoria']))
                           echo "<option value=".$row_asignaturas[0].">".$row_asignaturas[1]."</option>";
                        else{
                            echo "UNA MATERIA";
                        }
                    }
                }
            }

            elseif(isset($_POST["materias_select"])){
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

            //Horario //AQUI VA
            elseif(isset($_POST['horarios']) || isset($_POST["eliminarHorarios"]))
            {
                $horario_in= 'SELECT id_horario, num_cuenta, dia, hora FROM alumnohashorario NATURAL JOIN horario NATURAL JOIN hora WHERE num_cuenta='.$_SESSION['usuario'];
                $res_horario= mysqli_query($conexion, $horario_in);
                $contHorario = mysqli_num_rows($res_horario);
                while($row1 = mysqli_fetch_array($res_horario))
                {
                    $row1[2] = ($row1[2] == 'L')? 'Lunes':$row1[2];
                    $row1[2] = ($row1[2] == 'Ma')? 'Martes':$row1[2];
                    $row1[2] = ($row1[2] == 'Mi')? 'Miércoles':$row1[2];
                    $row1[2] = ($row1[2] == 'J')? 'Jueves':$row1[2];
                    $row1[2] = ($row1[2] == 'V')? 'Viernes':$row1[2];
                    if(isset($_POST['horarios'])){
                        echo '<li>'.$row1[2]."----".$row1[3].'</li>';
                    }
                    if(isset($_POST['eliminarHorarios'])){
                        if($contHorario>1 || isset($_POST['horarioAsesoria']))
                            echo "<option value=".$row1[0].">".$row1[2]." ".$row1[3]."</option>";
                        else
                            echo "UN HORARIO";
                    }
                }

            }

            //Agregar o eliminar materias
            elseif(isset($_POST['agregarm']) || isset($_POST['eliminarm'])){
                //Concicional que permite agregar.
                if($_POST['agregarm'] != "")
                {

                    $consul_agregarm = "INSERT INTO usuariohasmateria (num_cuenta, id_materia) VALUES (".$_SESSION['usuario'].",'".$_POST['agregarm']."')";
                    $respuestaagr = mysqli_query($conexion, $consul_agregarm);
                    if($respuestagr){
                        echo "SE AGREGO CORRECTAMENTE";
                    }else {
                        echo "NO SE PUDO AGREGAR";
                    }
                }
                //Condicional que permite eliminar.
                if($_POST['eliminarm'] != ""){
                    $consul_eliminarm="DELETE FROM usuariohasmateria WHERE num_cuenta=".$_SESSION['usuario']." AND id_materia="."'".$_POST['eliminarm']."'";
                    $respuestaelim = mysqli_query($conexion, $consul_eliminarm);
                    if($respuestaelim){
                        echo "SE ELIMINO CORRECTAMENTE";
                    }else {
                        echo "NO SE PUDO ELIMINAR";
                    }
                }
            }

            elseif(isset($_POST["editHora"]) || isset($_POST["editDia"]) || isset($_POST["eliminaHor"])){
                //Condicional que permite agregar
                if($_POST["editHora"] != "" && $_POST["editDia"] != "")
                {
                    $buscar="SELECT id_horario FROM horario WHERE dia='".$_POST['editDia']."' AND id_hora=".$_POST['editHora']."";//si no funciona es por las comillas
                    $res_buscar=mysqli_query($conexion, $buscar);
                    $id_horadia = mysqli_fetch_array($res_buscar);
                    $insertar_id= "INSERT INTO alumnohashorario (num_cuenta, id_horario) VALUES "."(".$_SESSION['usuario'].",".$id_horadia[0].")";
                    $res_insertar = mysqli_query($conexion, $insertar_id);
                    // $res_insertar=true;
                    if($res_insertar)
                    {
                        //echo "fFnciona";
                        echo "AGREGO EL HORARIO CORRECTAMENTE";
                    }else{
                        echo "HUBO UN ERROR HORA";
                    }
                }
                if($_POST["eliminaHor"] != "")
                {
                    $consul_elimina="DELETE FROM alumnohashorario WHERE num_cuenta=".$_SESSION['usuario']." AND id_horario=".$_POST["eliminaHor"];
                    $res_buscar=mysqli_query($conexion, $consul_elimina);
                    if($res_buscar){
                        echo "SE ELIMINÓ EL HORARIO";
                    }
                    else{
                        echo "HUBO UN ERROR HORARIO";
                    }

                }
            }

            //Peticion que permite cerrar la sesion.
            elseif(isset($_POST["cerrar"])){
                session_unset();
                session_destroy();
            }
        }
        else{
            echo "NO HAY SESION";
        }
    }


?>
