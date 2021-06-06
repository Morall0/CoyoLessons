<?php
//define("PASSWORD", "textoahashear");
define("HASH", "sha256");   //Este HASH se hace con una longitud de 64.
define("METHOD", "chacha20"); 
$password = "Amazul125???";

function sal(){
    $sal='';
    $char_sal = "abcdefghijklmnopqrstuvwxyzABZDEFGHIJKLMNOPQRSTUVWXYZ0123456789!#$%&/()=?";
    $longS = strlen($char_sal);
    for($i=0; $i<10; $i++)
    {
        $sal .= $char_sal[rand(0, $longS - 1)];
    }
    return $sal;
}

function pimienta(){
    $pimienta='';
    $char_pim ="abcdefghijklmnopqrstuvwxyzABZDEFGHIJKLMNOPQRSTUVWXYZ";
    $longP = strlen($char_pim);
    for($j=0; $j<2; $j++)
    {
        $pimienta .= $char_pim[rand(0, $longP -1)];
    }
    return $pimienta;
}

//Varibales a las que se les asigna la sal y la pimienta.
$salt = sal();
$pepper = pimienta();

echo $password.'<br>';
$password = $password.$salt.$pepper;    //Concatenación de la sal y la pimienta.
echo $password.'<br>';

$key = openssl_digest($password, HASH);
$iv_len = openssl_cipher_iv_length(METHOD);
$iv = openssl_random_pseudo_bytes($iv_len);

$cifrado = openssl_encrypt(
    "Datos que queremos encriptar",
    METHOD,
    $key,
    OPENSSL_RAW_DATA,
    $iv
);

echo $key;



?>