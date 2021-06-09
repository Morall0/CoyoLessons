<?php
    session_name("usuario");
    session_start();

    include('./config.php');
    include('./cifr.php');
    $conexion=conectdb();   //Conexión con la base de datos.

    //Funcion que despliega el select de materias.
    function materia($x, $y, $conexion){
        if($y==1516)
            $materia="SELECT * FROM materia WHERE id_materia BETWEEN $x AND $y OR id_materia LIKE '%E%' OR id_materia BETWEEN 2000 AND 2226";
        else
            $materia="SELECT * FROM materia WHERE id_materia BETWEEN $x AND $y OR id_materia LIKE '%E%'";
        $respuesta= mysqli_query($conexion, $materia);
        while($row = mysqli_fetch_array($respuesta))
        {
            echo "<option value=".$row[0].">".$row[1]."</option>";
        }
    }

    //Peticion que permite saber si hay una sesion iniciada.
    if(isset($_POST["usuario"]))
    {
        if(isset($_SESSION["usuario"]) && $_SESSION["tipo"] == 'A')
        {
            //Peticion que manda la lista de usuarios.
            if(isset($_POST["usuarios"])){
                $cons="SELECT num_cuenta, Nombre, Correo, Grado, Strike FROM usuario";
                $resp= mysqli_query($conexion, $cons);
                while($row=mysqli_fetch_array($resp)){
                    echo"<tr>
                        <td>$row[1]</td>
                        <td>$row[0]</td>
                        <td>".descifrar($row[2])."</td>
                        <td>$row[3]</td>
                        <td>$row[4]</td>
                        <td><button type='button' class='borrar' id='$row[0]'><i class='fas fa-trash-alt fa-2x'></i></button></td>
                    </tr>";
                }
            }
            //Peticion que elimina un usuario seleccionado.
            else if(isset($_POST["delete"]))
            {
                $eliminar_horario = "DELETE FROM alumnohashorario WHERE num_cuenta = ".$_POST['delete']."";
                $resp = mysqli_query($conexion, $eliminar_horario);
                if($resp){
                    $eliminar_materia = "DELETE FROM usuariohasmateria WHERE num_cuenta =".$_POST['delete']."";
                    $resp1=mysqli_query($conexion, $eliminar_materia);
                    if($resp1){
                        $eliminar_usuario="DELETE FROM usuario WHERE num_cuenta = ".$_POST['delete']."";
                        $resp2 = mysqli_query($conexion, $eliminar_usuario);
                        if($resp2){
                            echo "SE ELIMINO CORRECTAMENTE";
                        }
                        else{
                            echo "NO SE ELIMINO";
                        }
                    }
                }
            }

            //Consulta para obtener las materias
            else if(isset($_POST['anio'])){
                $grado=$_POST['anio'];
                if($grado=='C')
                    materia(1400, 1412, $conexion);
                else if($grado=='Q')
                    materia(1400, 1516, $conexion);
                else if($grado=='S')
                    materia(1400, 2226, $conexion);
            }

            //Registro de usuario en el Modal.
            else if(isset($_POST['num_cuenta'])){
                $num_cuenta= validStr($_POST['num_cuenta'], $conexion);
                $nombre=validStr($_POST['nombre'], $conexion);
                $correo=validStr($_POST['correo'], $conexion);
                $tel=validStr($_POST['tel'], $conexion);
                $nacimiento=validStr($_POST['fechaNac'], $conexion);
                $grado=validStr($_POST['cursando'], $conexion);
                $materias=validStr($_POST['materias'], $conexion);
                $dsemana=validStr($_POST['dsemana'], $conexion);
                $hora=validStr($_POST['hora'], $conexion);
                $contra=validStr($_POST['contra'], $conexion);
                $tipo=validStr($_POST["tipo"], $conexion);

                //Variables de RegEx
                $regexNumcuenta = '/^((3(19|20|21))|(1(16|17|18)))\d{6}$/';
                $regexNombre = '/^([A-Za-zÑñáéíóúÁÉÍÓÚ]( )?){2,50}$/';
                $regexCorreo = '/^[\w\.\-]{4,28}@(((g|hot)mail|outlook|live|yahoo)\.com|(comunidad|alumno\.enp|enp)\.unam\.mx)|\.mx$/';
                $regexTel = '/^((55|56)(\d{8}))$/';
                $regexContra = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$#@$!=\(\)\/%*?&])([A-Za-z\d$#@$!=\(\)\/%*?&]|[^ ]){10,30}$/';

                //Verificacion de los datos con las regex.
                if(preg_match($regexNumcuenta, $num_cuenta) && preg_match($regexNombre, $nombre) && preg_match($regexCorreo, $correo) && preg_match($regexTel, $tel) && preg_match($regexContra, $contra))
                {
                    //Cifrado de datos sensibles.
                    $correo=cifrar($correo);    //Cifrado de correo.
                    $tel=cifrar($tel);  //Cifrado de telefono.

                    //Verifica que el numero de cuenta no esté registrado
                    $busca="SELECT num_cuenta FROM usuario WHERE num_cuenta='$num_cuenta'";
                    $res= mysqli_query($conexion, $busca);
                    $cont= mysqli_num_rows($res);
                    if($cont>0)//si hay registro
                    {
                        echo $cont;//manda 1
                    }
                    else{//si no hay registro introduce los datos a la  BD
                        //Hasheo de contraseña
                        $salt=sal();
                        $pepper=rand(0, 10);
                        $contra=password_hash($contra.$salt.$pepper, PASSWORD_BCRYPT);
                        $contra=$contra.$salt;

                        //Insersion en la tabla de USUARIO.
                        $base="INSERT INTO usuario VALUES($num_cuenta,'$nombre','$correo', '$tel','$nacimiento', '$grado', 0, '$contra', 'B', '$tipo', 'user.png')";
                        $respuesta2 = mysqli_query($conexion, $base);

                        if($respuesta2){//Si el registro fue exitoso, se hace la insersion de los horarios y de las materias.
                            //echo $cont; //manda el 0 de que no existía el registro PRUEBA

                            //Obteniendo el ID del horario.
                            $buscahorario= "SELECT id_horario FROM horario WHERE dia='$dsemana' AND id_hora=$hora";
                            $resHorario = mysqli_query($conexion, $buscahorario);
                            if($resHorario){//Si la consulta fue exitosa...
                                $id_horario = mysqli_fetch_array($resHorario);
                                //Insercion en la tabla de alumnohashorario.
                                $inserthorario="INSERT INTO alumnohashorario (num_cuenta, id_horario) VALUES ($num_cuenta, $id_horario[0])";
                                $respInHorario= mysqli_query($conexion, $inserthorario);

                            }
                            //Inserción en la tabla de usuariohasmateria.
                            $insertmateria="INSERT INTO usuariohasmateria (num_cuenta, id_materia) VALUES ($num_cuenta, '$materias')";
                            $respInMateria=mysqli_query($conexion, $insertmateria);
                            if($respInMateria && $respInHorario)
                            {
                                echo "Registro exitoso";
                                //header("location: ../../templates/MiPerfil.html");
                            }
                        }
                        else{
                            //echo $respuesta2;
                            echo "No hubo exito";
                        }
                    }
                    //echo "Funciono";
                }
                else{//No te deja hacer la consulta
                    echo "No se realizo la consulta por las regex"; //PRUEBA
                }
            }
            mysqli_close($conexion);    //Ciere de la conexion con la BD.
        }
        else {
            echo "NO HAY SESION O NO ES ADMIN";
        }
    }

?>
