<?php
    include('./configDB.php');
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
    if(isset($_POST['dato1'])){
        $dato1=$_POST['dato1'];
        if($dato1=='C'){
            materia(1400, 1412, $conexion);
        } 
        else if($dato1=='Q'){
            materia(1400, 1516, $conexion);
        }
        else if($dato1=='S'){
            materia(1400, 2226, $conexion);
        }        
    }
    if(isset($_POST['dato2'])){
        $horario="SELECT * FROM Hora"; 
        $respuesta= mysqli_query($conexion, $horario);
        while($row = mysqli_fetch_array($respuesta))
        {
            echo "<option value=".$row[0].">".$row[1]."</option>";
        }
    }
    else{
        echo "nada";
    }



?>