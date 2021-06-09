<?php
define("HASH", "sha256");//Tipo de hasheo.
define("LLAVE","cm#oym!ola/esi#son");//Contraseña.
define("METHOD","aes-128-cbc");//Método.

//Función para validar la información ingresada.
function validStr($post, $connect){
    $str= strip_tags($post);//Elimina inyecciones html y php.
    $str= mysqli_real_escape_string($connect, $str);//Elimina inyecciones sql.
    return $str;
}

function cifrar($text){
  $key= openssl_digest(LLAVE, HASH);
  $iv_len= openssl_cipher_iv_length(METHOD);
  $iv= openssl_random_pseudo_bytes($iv_len);
  $textoCifrado= openssl_encrypt(
    $text,
    METHOD,
    $key,
    OPENSSL_RAW_DATA,
    $iv
  );
  $ciffWIv=base64_encode($iv.$textoCifrado);//Codificar en base 64 el texto.

  return $ciffWIv;//Regresar el texto codificado.
}

function descifrar($cifradoWIv){
  $cifradoWIv=base64_decode($cifradoWIv);//Decodificar en base 64 el texto.
  $iv_len= openssl_cipher_iv_length(METHOD);//Definir long.
  $iv= substr($cifradoWIv,0,$iv_len);//Sustraer de la cadena el $iv_len.
  $cifrado = substr($cifradoWIv,$iv_len);
  $key= openssl_digest(LLAVE,HASH);//Guardar la clave del hasheo con la LLAVE y el HASH.
  $desciff=openssl_decrypt(
    $cifrado,
    METHOD,
    $key, //La contraseña deshasheada.
    OPENSSL_RAW_DATA,
    $iv
  );

  return $desciff;//Regresar la cadena descifrada.
}

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
?>
