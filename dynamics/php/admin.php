<?php
    session_name("usuario");
    session_start();

    include('./config.php');
    include('./cifr.php');
    $conexion=conectdb();   //Conexión con la base de datos.


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
?>
