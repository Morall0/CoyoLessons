<?php
define("PASSWORD", "");
define("HASH", "sha256");
define("METHOD", "chacha20");

function sal(){
    $sal;
    $char_sal = "abcdefghijklmnopqrstuvwxyzABZDEFGHIJKLMNOPQRSTUVWXYZ0123456789!#$%&/()=?";
    $longS = strlen($caracteres);
    for($i=0; $i<10; $i++)
    {
        $sal .= $caracteres[rand(0, $longitud - 1)];
    }
    return = sal;
}

function pimienta(){
    $pimienta;
    $char_pim ="abcdefghijklmnopqrstuvwxyzABZDEFGHIJKLMNOPQRSTUVWXYZ";
    $longP = strlen($char_pim);
    for($j=0; $j<2; $j++)
    {
        $pimienta .= $char_pim[rand(0, $longP -1)];
    }
    return $pimienta;
}

$key = openssl_digest(PASSWORD, HASH);



?>