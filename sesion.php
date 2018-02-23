<?php

    $user = $_POST["user"]??"";
    $pass = $_POST["pass"]??"";
    $cierra = $_POST["cierra"]??false;
    $error;

    if ($cierra == false) {

        //ahora hay que comprobar si es un usuario valido
        require_once("conexion.php");

        $sql = "SELECT * FROM `usuarios` WHERE nick = '$user' AND api = '$pass'";
        
        $res = $lnk->query($sql);

        if (($res->num_rows)==0) {
            $error = "Lo siento, El usuario o la contraseña usados no son válidos";
        } else {
            session_start();
            $_SESSION["usuario"];
        }

        echo $error;

        $lnk->close() ;

    } else {
        session_destroy();
        session_write_close();
    }