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
            if(isset($_POST["comentario"])){
                $comentario=$_POST["comentario"];
                $calificacion=$_POST["calif"];
                $id_asesoria =$_POST["id_asesoria"];
                $cons_num_asesor="SELECT num_cuentaAsesor FROM asesoriahasalumno WHERE id_asesoria =  $id_asesoria";
                $res_asesor=mysqli_query($conexion, $cons_num_asesor);
                $info_asesor=mysqli_fetch_array($res_asesor);
                $cuenta_asesor=$info_asesor[0];
                $ins="INSERT INTO comentario (num_cuentaAsesor,num_cuentaAlumno,Calificaion, Comentario) VALUES($cuenta_asesor,$usuario,'$comentario',$calificacion)";
                $res_ins=mysqli_query($conexion, $ins);
                if($res_ins){
                    echo "Registro exitoso del comentario";
                }else{
                    echo "Fallo la insercion del comentario";
                }
            }
            //Consulta que obtiene las asesorias en las que ha estado el usuario.
            if(isset($_POST["asesoria"]))
            {   //CAMBIAR EL ESTADO A 'T'.
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
                            echo "<td><button type='button' class='misComentarios' id='$info_asesorias[0]'><i class='fas fa-chalkboard-teacher fa-2x'></i></td></tr>";
                        else
                            echo "<td><button type='button' class='comentar' id='$info_asesorias[0]'><i class='far fa-comment-alt fa-2x'></i></button></td></tr>";


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
