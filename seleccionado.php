<?php

    include_once("conexion.php");

    $identificador = $_POST["iden"];

    $sql = "SELECT * FROM `juegos` WHERE juegos.idJue='$identificador'";

    $res = $lnk->query($sql);

    $obj = $res->fetch_object();

    echo json_encode(["iden" => $obj->idJue, "titulo" => $obj->titulo, "genero" => $obj->idGen,"nota" => $obj->nota , "lanzamiento" => $obj->lanzamiento]) ;

    // Cerramos la conexión con el servidor
	$lnk->close() ;