<?php
//define("PASSWORD", "textoahashear");
define("METHOD", "chacha20");   //Esto encripta.
$password = "contraSeña9?";    //Contraseña

function sal(){
    $sal='';
    $char_sal = "abcdefghijklmnopqrstuvwxyzABZDEFGHIJKLMNOPQRSTUVWXYZ0123456789!#$%&/()=?";
    $longS = strlen($char_sal);
    for($i=0; $i<5; $i++)
    {
        $sal .= $char_sal[rand(0, $longS - 1)];
    }
    return $sal;
}

//Varibales a las que se les asigna la sal y la pimienta.
$salt = sal();
$pepper = rand(0, 10);

echo $salt.'<br>';

$key = password_hash($password.$salt.$pepper, PASSWORD_BCRYPT);
$iv_len = openssl_cipher_iv_length(METHOD);
$iv = openssl_random_pseudo_bytes($iv_len);

$guardar_base = $key.$salt;

$cifrado = openssl_encrypt(
    "Datos que queremos encriptar",
    METHOD,
    $key,
    OPENSSL_RAW_DATA,
    $iv
);

echo $key.'<br>';

echo $guardar_base.'<br>';

$sal_bd = substr($guardar_base,-5, 5);

echo $sal_bd.'<br>';
$key_solita = substr($guardar_base, 0, -5);
echo $key_solita.'<br>';

$contador=0;
for($i=0; $i<10; $i++){
    if(password_verify($password.$sal_bd.$i, $key_solita)){
        $contador ++;
    }
}
if($contador == 1){
    echo "correcta";
}

//echo strlen($key);


?>