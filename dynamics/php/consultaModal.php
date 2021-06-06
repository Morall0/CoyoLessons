<?php
    include('./config.php');
    include('./cifr.php');

    $conexion=conectdb();   //Conexión con la base de datos.
    
    //Función para validar la información ingresada.
    function validStr($post, $connect){
        $str= strip_tags($post);//Elimina inyecciones html y php.
        $str= mysqli_real_escape_string($connect, $str);//Elimina inyecciones sql.
        return $str;
    }

    //Funcion que despliega el select de materias.
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
        $num_cuenta= validStr($_POST['num_cuenta'], $conexion);
        $nombre=validStr($_POST['nombre'], $conexion);
        $correo=validStr($_POST['correo'], $conexion);
        $correo=cifrar($correo);    //Cifrado de correo.
        $tel=validStr($_POST['tel'], $conexion);
        $tel=cifrar($tel);  //Cifrado de telefono.
        $nacimiento=validStr($_POST['fechaNac'], $conexion);
        $grado=validStr($_POST['cursando'], $conexion);
        $materias=validStr($_POST['materias'], $conexion);
        $dsemana=validStr($_POST['dsemana'], $conexion);
        $hora=validStr($_POST['hora'], $conexion);
        $contra=validStr($_POST['contra'], $conexion);
        //Hasheo de contraseña
        $salt=sal();
        $pepper=rand(0, 10);
        $contra=password_hash($contra.$salt.$pepper, PASSWORD_BCRYPT);
        $contra=$contra.$salt;

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