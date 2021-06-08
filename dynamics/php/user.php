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
        while($row = mysqli_fetch_array($respuesta))
        {
            echo "<option value=".$row[0].">".$row[3]."</option>";
        }
    }

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

        if(isset($_POST["asignaturas"]) || isset($_POST["eliminar"]))
        {
            //Consulta para obtener las materias.
            $materiasd_usuario='SELECT id_materia, abreviacion FROM usuariohasmateria NATURAL JOIN materia WHERE num_cuenta='.$_SESSION["usuario"];
            $res_materias = mysqli_query($conexion, $materiasd_usuario);
            while($row = mysqli_fetch_array($res_materias))
            {
                if(isset($_POST["asignatura"]))
                    echo "<p>".$row[1]."</p>";
                if(isset($_POST["eliminar"]))
                    echo "<option value=".$row[0].">".$row[1]."</option>";
            }
        }
        if(isset($_POST["materias_select"])){
            //Agregar más materias
            if($row[4]=='C'){
                materia(1400, 1412, $conexion);
            }
            else if($row[4]=='Q'){
                materia(1400, 1516, $conexion);
            }
            else if($row[4]=='S'){
                materia(1400, 2226, $conexion);
            }
        }
    }
    else{
        header("location: ../../templates/registro.html");
    }


?>
