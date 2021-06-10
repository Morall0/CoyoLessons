<?php
    include('./config.php');
    include('./cifr.php');

    session_name("usuario");
    session_start();

    //Condicional que permite comprobar si la sesion esta iniciada.
    if(isset($_POST["sesion"])){
        if(isset($_SESSION["usuario"]))
        {
            $conexion = conectdb(); //CONEXION CON LA BASE DE DATOS.
            $usuario = $_SESSION["usuario"];    //Número de cuenta.

            //Consulta que obtiene las asesorias en las que ha estado el usuario.
            if(isset($_POST["asesoria"]))
            {
                $consulta_asesorias= "SELECT id_asesoria, Medio, Modalidad, Fecha, Tema, id_ahh, Nombre, num_cuentaAsesor, num_cuentaAlumno 
                FROM asesoria NATURAL JOIN materia NATURAL JOIN asesoriahasalumno WHERE num_cuentaAsesor=$usuario AND 
                Estado = 'T' OR num_cuentaAlumno=$usuario AND Estado = 'T' GROUP BY  id_asesoria";

                $res_asesorias=mysqli_query($conexion, $consulta_asesorias);
                while($info_asesorias=mysqli_fetch_array($res_asesorias)){
                    //dia y hora
                    $cons_hor="SELECT dia, hora FROM alumnohashorario NATURAL JOIN horario NATURAL JOIN hora WHERE id_ahh=".$info_asesorias[5];
                    $res_hor=mysqli_query($conexion,$cons_hor);
                    $arr_hor=mysqli_fetch_array($res_hor);
                    //nombre del asesor
                    $cons_nombre="SELECT nombre FROM usuario WHERE num_cuenta=".$info_asesorias[7];
                    $res_nombre=mysqli_query($conexion,$cons_nombre);
                    $arr_nombre=mysqli_fetch_array($res_nombre);
                    // //Cupo.
                    // $cupo="SELECT COUNT(id_asesoria) FROM asesoriahasalumno WHERE id_asesoria='$info_asesorias[1]'";
                    // $cupo_con=mysqli_query($conexion, $cupo);
                    // $xcupo=mysqli_fetch_array($cupo_con);
                    //echo $arr_hor."hora";
                    if($arr_hor){

                        $arr_hor[0] = ($arr_hor[0] == 'L')? 'Lunes':$arr_hor[0];
                        $arr_hor[0] = ($arr_hor[0] == 'Ma')? 'Martes':$arr_hor[0];
                        $arr_hor[0] = ($arr_hor[0] == 'Mi')? 'Miércoles':$arr_hor[0];
                        $arr_hor[0] = ($arr_hor[0] == 'J')? 'Jueves':$arr_hor[0];
                        $arr_hor[0] = ($arr_hor[0] == 'V')? 'Viernes':$arr_hor[0];

                        $info_asesorias[2] = ($info_asesorias[2] == 'P')? 'Presencial':$info_asesorias[2];
                        $info_asesorias[2] = ($info_asesorias[2] == 'L')? 'En línea':$info_asesorias[2];

                        echo"<tr>
                            <td>$arr_nombre[0]</td>
                            <td>$info_asesorias[6]</td>
                            <td>$info_asesorias[4]</td>
                            <td>$info_asesorias[2]</td>
                            <td>$info_asesorias[1]</td>
                            <td>".$arr_hor[0]." ".$arr_hor[1]."</td>
                            <td>$info_asesorias[3]</td>;
                            <td><button type='button' class='reportar' id='$info_asesorias[0]'><i class='fas fa-exclamation-circle fa-2x'></button></td>";

                        //Condicional que permite poner el boton de comentar solo cuando no fuimos asesores.
                        if($info_asesorias[7] == $usuario)  //Cuando eres ascesor
                            echo "<td><button type='button' class='misComentarios' id='$info_asesorias[0]'><i class='fas fa-chalkboard-teacher'></i></td></tr>";
                        else 
                            echo "<td><button type='button' class='comentar' id='$info_asesorias[0]'><i class='far fa-comment-alt fa-2x'></i></button></td></tr>";

                            //echo "Hola";
                    }
                    else{
                        echo "no funciono la consulta de la tabla";
                    }
                }
            }
        }
        else {
            echo "NO HAY SESION";
        }
    }
?>