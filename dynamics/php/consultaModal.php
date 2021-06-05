<?php
    include('./configDB.php');
    $conexion=conectdb();
    $grado="";
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
    if(isset($_POST['dato1'])){
        $grado=$_POST['dato1'];
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
    if(isset($_POST['dato2'])){
        $horario="SELECT * FROM Hora"; 
        $respuesta1= mysqli_query($conexion, $horario);
        while($row = mysqli_fetch_array($respuesta1))
        {
            echo "<option value=".$row[0].">".$row[1]."</option>";
        }
    }
    if(isset($_POST['dato3'])){
        $grado=$_POST['dato1'];
        $dsemana=$_POST['dato2'];
        $num_cuenta=$_POST['dato3'];
        $nombre=$_POST['dato4'];
        $correo=$_POST['dato5'];
        $tel=$_POST['dato6'];
        $nacimiento=$_POST['dato7'];
        $materias= $_POST['dato8'];
        $hora=$_POST['dato9'];
        $contra=$_POST['dato10'];
        
        $base="INSERT INTO Usuario VALUES($num_cuenta,'$nombre','$correo', '$tel','$nacimiento', '$grado', 0, '$contra', 'B', 'E', 'user.png')"; 
        $respuesta2 = mysqli_query($conexion, $base);
        

        //SI NO FUNCIONA, DESCOMENTAR ESTO.
        /*if($respuesta2){
            echo $respuesta2;
        }
        else{
            //echo $respuesta2;
            echo "no HUBO exito";
        }*/



    }
    else{
        echo "nada";
    }



?>