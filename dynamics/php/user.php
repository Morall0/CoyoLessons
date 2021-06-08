<?php
    include('./config.php');
    include('./cifr.php');

    session_name("usuario");
    session_start();

    if(isset($_SESSION["usuario"])){
        //Consulta para obetener los datos básicos del usuario.
        $conexion = conectdb();
        $consulta = 'SELECT num_cuenta, Nombre, Correo, Teléfono, Grado, Imagen FROM usuario WHERE num_cuenta='.$_SESSION["usuario"];
        $respuesta = mysqli_query($conexion, $consulta);
        $row = mysqli_fetch_array($respuesta);

        //Descifrando el correo y el telefono.
        $row[2]=descifrar($row[2]);
        $row[3]=descifrar($row[3]);

        echo $row[0].','.$row[1].','.$row[2].','.$row[3].','.$row[4].','.$row[5];    //Envio de los datos del usuario.

        //Consulta para obtener las materias.

    }
    else{
        header("location: ../../templates/registro.html");
    }


?>
