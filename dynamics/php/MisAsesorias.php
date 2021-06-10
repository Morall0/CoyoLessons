<?php
    session_name("usuario");
    session_start();

    include('./config.php');


    if(isset($_POST['sesion'])){
        if(isset($_SESSION['usuario'])){
            $conexion=conectdb();
            $usuario = $_SESSION["usuario"];
            if(isset($_POST["formAsesoria"])){
                $materiaA=$_POST["materiaSelect"];
                $tema=$_POST["tema"];
                $modalidad=$_POST["modalidad"];
                $medio=$_POST["medio"];
                $horario=$_POST["horario"];
                $duracion=$_POST["duracion"];
                $fecha=$_POST["fecha"];
                $cupo=$_POST["cupo"];
                $i=0;

                $consul_ahh="SELECT id_ahh FROM alumnohashorario WHERE num_cuenta=$usuario AND id_horario=$horario";
                $res_id=mysqli_query($conexion, $consul_ahh);
                $id_ahh=mysqli_fetch_array($res_id);
                $insertAsesoria="INSERT INTO asesoria (Medio, Modalidad, Fecha, Duracion, Tema, id_materia, id_ahh,estado) VALUES ('$medio', '$modalidad', '$fecha', $duracion, '$tema', '$materiaA', ".$id_ahh[0].",'I')";
                $res=mysqli_query($conexion,$insertAsesoria);
                if($res){

                    $consul="SELECT MAX(id_asesoria) AS id FROM asesoria";
                    $rescon=mysqli_query($conexion, $consul);
                    $id_asesoria=mysqli_fetch_array($rescon);
                    while($i<$cupo){
                        $ins="INSERT INTO asesoriahasalumno (id_asesoria, num_cuentaAsesor) VALUES". "(".$id_asesoria[0].",".$usuario.")";
                        $res1=mysqli_query($conexion,$ins);
                        $i++;
                    }
                    if($res1){
                        echo "si se guardo";
                    }
                    else{
                        echo "no se pudo";
                    }
                }
                else{
                    echo"no se inserto la asesoria";;
                }
            }
            if(isset($_POST["tabla"]) || isset($_POST["todasAsesorias"])){
                echo "<br><br><table border='1'>
                <thead>
                <tr>
                <th>Materia</th>
                <th>Tema</th>
                <th>Modalidad</th>
                <th>Medio</th>
                <th>Horario</th>
                <th>Cupo</th>
                <th>Duración</th>
                <th>Fecha</th>";
                if(isset($_POST["todasAsesorias"])){
                    //Obtiene todas las asesorias
                    $tabla= "SELECT id_materia, id_asesoria, Medio, Modalidad, Fecha, Tema,id_ahh,Nombre,num_cuentaAsesor,Duracion,Estado,num_cuentaAlumno FROM asesoria NATURAL JOIN materia NATURAL JOIN asesoriahasalumno GROUP BY  id_asesoria";
                            echo"
                            <th>Asesor</th>
                            <th></th>
                            </tr>
                            </thead>
                            <tbody>";
                }
                elseif(isset($_POST["tabla"])){
                    //Obtiene solo las asesorías que da el usuario
                    $tabla= "SELECT id_materia, id_asesoria, Medio, Modalidad, Fecha, Tema,id_ahh,Nombre,num_cuentaAsesor,Duracion,Estado FROM asesoria NATURAL JOIN materia NATURAL JOIN asesoriahasalumno WHERE num_cuentaAsesor=$usuario GROUP BY  id_asesoria";

                    echo "<th>Estado</th>
                    <th>Eliminar</th>
                    </tr>
                    </thead>
                    <tbody>";
                }
                $restabla=mysqli_query($conexion,$tabla);
                while($arrtabla=mysqli_fetch_array($restabla)){
                    //dia y hora
                    $cons_hor="SELECT dia, hora FROM alumnohashorario NATURAL JOIN horario NATURAL JOIN hora WHERE id_ahh=".$arrtabla[6];
                    $res_hor=mysqli_query($conexion,$cons_hor);
                    $arr_hor=mysqli_fetch_array($res_hor);
                    //nombre del asesor
                    $cons_nombre="SELECT nombre FROM usuario WHERE num_cuenta=".$arrtabla[8];
                    $res_nombre=mysqli_query($conexion,$cons_nombre);
                    $arr_nombre=mysqli_fetch_array($res_nombre);
                    $cupo="SELECT COUNT(*) FROM asesoriahasalumno WHERE id_asesoria=$arrtabla[1] AND COALESCE(num_cuentaAlumno) IS NULL"; //COALESCE permite contemplar valores nulos en la cosulta
                    // $cupo="SELECT COUNT(id_asesoria) FROM asesoriahasalumno WHERE id_asesoria='$arrtabla[1]'";
                    $cupo_con=mysqli_query($conexion, $cupo);
                    $xcupo=mysqli_fetch_array($cupo_con);
                    if($arr_hor){

                        $arr_hor[0] = ($arr_hor[0] == 'L')? 'Lunes':$arr_hor[0];
                        $arr_hor[0] = ($arr_hor[0] == 'Ma')? 'Martes':$arr_hor[0];
                        $arr_hor[0] = ($arr_hor[0] == 'Mi')? 'Miércoles':$arr_hor[0];
                        $arr_hor[0] = ($arr_hor[0] == 'J')? 'Jueves':$arr_hor[0];
                        $arr_hor[0] = ($arr_hor[0] == 'V')? 'Viernes':$arr_hor[0];

                        $arrtabla[9] = ($arrtabla[9] == 1)? '50 min':$arrtabla[9];
                        $arrtabla[9] = ($arrtabla[9] == 2)? '100 min':$arrtabla[9];

                        $arrtabla[3] = ($arrtabla[3] == 'P')? 'Presencial':$arrtabla[3];
                        $arrtabla[3] = ($arrtabla[3] == 'L')? 'En línea':$arrtabla[3];

                            echo"<tr>
                            <td>$arrtabla[7]</td>
                            <td>$arrtabla[5]</td>
                            <td>$arrtabla[3]</td>
                            <td>$arrtabla[2]</td>
                            <td>".$arr_hor[0]." ".$arr_hor[1]."</td>
                            <td>$xcupo[0]</td>
                            <td>$arrtabla[9]</td>
                            <td>$arrtabla[4]</td>";
                            if(isset($_POST["tabla"])){
                                echo "<td><button type='button' class='estado' id='$arrtabla[1]'><i class='fas fa-play-circle'></i></button></td>
                                <td><button type='button' class='borrar' id='$arrtabla[1]'><i class='fas fa-trash-alt fa-2x'></i></button></td>
                                 </tr>";
                            }
                            else if(isset($_POST["todasAsesorias"])){
                                if($arrtabla[8]!=$usuario){
                                    //checa si el usuario ya está inscrito
                                    $cuantas="SELECT COUNT(num_cuentaAlumno) FROM asesoriahasalumno WHERE num_cuentaAlumno=$usuario AND id_asesoria=$arrtabla[1]";
                                    $res_cuantas=mysqli_query($conexion,$cuantas);
                                    $arr_cuantas=mysqli_fetch_array($res_cuantas);
                                    echo "<td>$arr_nombre[0]</td>";
                                    if($arr_cuantas[0]>0 && $xcupo[0]>0){
                                        echo "<td><button type='button' class='desinscribirse' id='$arrtabla[1]'><i class='fas fa-user-check'></i></button></td>
                                        </tr>";
                                    }
                                    elseif($arr_cuantas[0]==0 && $xcupo[0]>0){
                                        echo "<td><button type='button' class='inscribirse' id='$arrtabla[1]'><i class='fas fa-marker'></i></button></td>
                                        </tr>";
                                    }
                                    else{
                                        echo "<td><button type='button' class='lleno' id='$arrtabla[1]'><i class='fas fa-ban'></i></button></td>
                                        </tr>";
                                    }

                                }
                                else{
                                    echo "<td>$arr_nombre[0]</td>
                                    <td><i class='fas fa-chalkboard-teacher'></i></td>
                                    </tr>";
                                }

                            }
                    }
                    else{
                        echo "no funciono la consulta de la tabla";
                    }

                }
                echo "</tbody></table>";
            }

            if(isset($_POST["delete"])){
                $boton=$_POST["delete"];
                $consul_borrar="DELETE from asesoriahasalumno WHERE id_asesoria=$boton";
                $res_borrar=mysqli_query($conexion,$consul_borrar);
                if($res_borrar){
                    $borrar2="DELETE from asesoria WHERE id_asesoria=$boton";
                    $res_borrar2=mysqli_query($conexion,$borrar2);
                    if($res_borrar2){
                        echo "se borró la asesoría con éxito";
                    }
                    else{
                        echo "no se pudo borrar";
                    }
                }
                else{
                    echo "no se pudo borrar la asesoria";
                }
            }
        }
        else{
            echo "NO HAY SESION";
        }
    }
?>
