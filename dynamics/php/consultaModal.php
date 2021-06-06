<?php
    include('./config.php');
    $conexion=conectdb();
    
    function materia($x, $y, $conexion){
        if($y==1516)
            $materia="SELECT * FROM MATERIA WHERE id_materia BETWEEN $x AND $y OR id_materia LIKE '%E%' OR id_materia BETWEEN 2000 AND 2226";
        else
            $materia="SELECT * FROM Materia WHERE id_materia BETWEEN $x AND $y OR id_materia LIKE '%E%'"; 
        $respuesta= mysqli_query($conexion, $materia);
        while($row = mysqli_fetch_array($respuesta))
        {
            echo "<option value=".$row[0].">".$row[1]."</option>";
        }
    }

    //MATERIA
    if(isset($_POST['anio'])){
        $grado=$_POST['anio'];
        if($grado=='C'){
            materia(1400, 1412, $conexion);
        } 
        else if($grado=='Q'){
            materia(1400, 1516, $conexion);
        }
        else if($grado=='S'){
            materia(1400, 2226, $conexion);
        }        
    }
        
    //Registro de usuario.
    else if(isset($_POST['num_cuenta'])){
        $num_cuenta=$_POST['num_cuenta'];
        $nombre=$_POST['nombre'];
        $correo=$_POST['correo'];
        $tel=$_POST['tel'];
        $nacimiento=$_POST['fechaNac'];
        $grado=$_POST['cursando'];
        $materias= $_POST['materias'];
        $dsemana=$_POST['dsemana'];
        $hora=$_POST['hora'];
        $contra=$_POST['contra'];
        
        $base="INSERT INTO Usuario VALUES($num_cuenta,'$nombre','$correo', '$tel','$nacimiento', '$grado', 0, '$contra', 'B', 'E', 'user.png')"; 
        $respuesta2 = mysqli_query($conexion, $base);

        //SI NO FUNCIONA, DESCOMENTAR ESTO.
        if($respuesta2){
            echo "REGISTRO EXITOSO";
        }
        else{
            //echo $respuesta2;
            echo "no HUBO exito";
        }
    }

    mysqli_close($conexion);



?>