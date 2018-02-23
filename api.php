<?php

    require_once("conexion.php");

    $api = $_GET["api"]??"";

    if (empty($api)) { 
		header("Content-Type: application/json;charset=utf-8") ;
		echo json_encode(["mensaje" => "No se ha dado Api Key", "success" => false]) ;
	} else {

        //la api key es el campo api en la tabla usuarios
        $sql = "SELECT * FROM `usuarios` WHERE api = '$api'";
        $res = $lnk->query($sql) ;

        if (!$res->num_rows) { 	
			header("Content-Type: application/json;charset=utf-8") ;
			echo json_encode(["mensaje" => "Api Key incorrecta", "success" => false]) ;
		} else {
            //con este sabremos que es lo que se desea buscar
            $cop = $_GET["cop"]??"";

            if ($cop=="gen") {
                header("Content-Type: application/json;charset=utf-8") ;
                $salida=[];

                $sql = "SELECT * FROM `generos`";
                $res = $lnk->query($sql);

                while ($obj=$res->fetch_object()) {
                    array_push($salida, $obj);
                }
			    echo json_encode(["datos" => $salida, "success"=>true]);
            } else if ($cop=="jue"){
                header("Content-Type: application/json;charset=utf-8") ;

                $salida=[];
                //si se desea se puede ordenar el listado, es opcional pero los parámetros son concretos
                if (isset($_GET["orden"])) {
                    $orden = $_GET["orden"];
                    //los parámetros de $orden son idJue, idGen, titulo, nota o lanzamiento

                    $sql = "SELECT * FROM `juegos` ORDER BY $orden";
                    $res = $lnk->query($sql);
                } else {
                    $sql = "SELECT * FROM `juegos`";
                    $res = $lnk->query($sql);
                }
                

                while ($obj=$res->fetch_object()) {
                    array_push($salida, $obj);
                }
			    echo json_encode(["datos" => $salida, "success"=>true]);
            } else {
                header("Content-Type: application/json;charset=utf-8") ;
                echo json_encode(["mensaje" => "No ha especificado lo que se desea buscar", "success" => false]) ;
            }
        }
    }

    $lnk->close();