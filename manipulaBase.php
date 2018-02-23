<?php

    include_once("conexion.php");

    //en ésta página tendremos el borrado, el editado y el añadido a la base de datos
    //sabremos cuál método utilizaremos gracias a la variable cop

    $iden = $_POST["iden"];
    $cop = $_POST["cop"]??"";
    $titulo = $_POST["titulo"]??"";
    $genero = $_POST["genero"]??"";
    $nota = $_POST["nota"]??"";
    $lanzamiento = $_POST["lanzamiento"]??"";

    if ($cop=="edit") {
        //editado
        $sql ="UPDATE `juegos` SET `idGen` = '$genero', `titulo` = '$titulo', `nota` = '$nota', `lanzamiento` = '$lanzamiento' WHERE `juegos`.`idJue` = $iden;";

        echo $sql;

        $res = $lnk->query($sql);
    } else if ($cop=="add") {
        //añadido
        $sql = "INSERT INTO `juegos` (`idJue`, `idGen`, `titulo`, `nota`, `lanzamiento`) VALUES ('$iden', '$genero', '$titulo', '$nota', '$lanzamiento');";
        echo $sql;

        $res = $lnk->query($sql);
    } else {
        //si no es ninguna de las anteriores es borrado
        $sql = "DELETE FROM juegos WHERE idJue='$iden' ;" ;

        $res = $lnk->query($sql);
    }

    // Cerramos la conexión con el servidor
	$lnk->close() ;