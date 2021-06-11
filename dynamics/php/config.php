<?php
    define("DBUSER", "coyolessons");
    define("DBHOST", "localhost");
    define("PASSWORD", "c0yol3$$0nS?");
    define("DB", "coyolessons");

    function conectdb()
    {
        $c=mysqli_connect(DBHOST, DBUSER, PASSWORD, DB);
        if(!$c)
        {
            /*mysqli_connect_error();
            mysqli_connect_errno();*/
            echo"No se pudó acceder a la base de datos";
        }
        
        return $c;
    }
?>