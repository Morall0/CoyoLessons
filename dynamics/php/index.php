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
            elseif(isset($_POST["search"])){
                $busq=$_POST["search"];
                $nombre_busq="SELECT num_cuenta, Nombre FROM usuario WHERE Nombre LIKE '%$busq%'";
                $conex_nombre=mysqli_query($conexion,$nombre_busq);
                $count= mysqli_num_rows($conex_nombre);
                if($count>0){
                    echo"<br<br><table border='1'>
                        <thead>
                            <tr>
                                <th>Materia</th>
                                <th>Tema</th>
                                <th>Modalidad</th>
                                <th>Medio</th>
                                <th>Horario</th>
                                <th>Cupo</th>
                                <th>Duración</th>
                                <th>Fecha</th>
                                <th>Asesor</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>";
                    while($array_nombre=mysqli_fetch_array($conex_nombre)){
                        $tabla= "SELECT id_materia, id_asesoria, Medio, Modalidad, Fecha, Tema,id_ahh,Nombre,num_cuentaAsesor,Duracion,Estado,num_cuentaAlumno FROM asesoria NATURAL JOIN materia NATURAL JOIN asesoriahasalumno WHERE num_cuentaAsesor=$array_nombre[0] GROUP BY  id_asesoria";
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
                                if($arrtabla[8]!=$usuario){
                                    //checa si el usuario ya está inscrito
                                    $cuantas="SELECT COUNT(num_cuentaAlumno) FROM asesoriahasalumno WHERE num_cuentaAlumno=$usuario AND id_asesoria=$arrtabla[1]";
                                    $res_cuantas=mysqli_query($conexion,$cuantas);
                                    $arr_cuantas=mysqli_fetch_array($res_cuantas);
                                    echo "<td>$arr_nombre[0]</td>";
                                    //si ya está inscrito manda el botón de desinscribirse
                                    if($arr_cuantas[0]>0 && $xcupo[0]>0){
                                        echo "<td><button type='button' class='desinscribirse' id='$arrtabla[1]'><i class='fas fa-user-check'></i></button></td>
                                        </tr>";
                                    }
                                    //Si no está inscrito manda el botón de inscribirse
                                    elseif($arr_cuantas[0]==0 && $xcupo[0]>0){
                                        echo "<td><button type='button' class='inscribirse' id='$arrtabla[1]'><i class='fas fa-marker'></i></button></td>
                                    </tr>";
                                    }
                                    //Si está lleno
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
                            else{
                                echo "no funciono la consulta de la tabla";
                            }
                        }
                    }
                    echo "</tbody></table>";
                }
                else{
                    echo "<h1>La búsqueda '$busq' no generó ningún resultado （︶︿︶）</h1>";
                }
            }
        }
        else{
            echo "NO HAY SESION";
        }
    }

?>
