<?php

    require_once("conexion.php");

    //iniciamos las variables
    $resultado ="";
    $paginado ="";
    $pagina = $_POST["pagina"]??1;
    $orden = $_POST["orden"]??"";
    $totalRegistros = 5;

    $anterior = $pagina - 1;
    $siguiente = $pagina + 1;
    
    //contruimos la consulta
    $ini = $totalRegistros * ($pagina-1) ;
    $lim = " LIMIT $ini, $totalRegistros" ;
    if (empty($orden)) {
        $ord = "";
    } else {
        $ord = " ORDER BY $orden";
    }
    
    $sql = "SELECT * FROM `juegos` INNER JOIN generos on juegos.idGen=generos.idGen";

    // Buscamos en la base de datos los juegos
    //$res = $lnk->query($sql . $lim . $ord) ;
    $res = $lnk->query($sql) ;

    
    if (!$res->num_rows) {
        //en el caso de que la base de datos no de resultados
    } else {
        //procedemos a contruir los datos en forma de tabla para verlos de forma amigable

        while ($obj = $res->fetch_object()) {
            $resultado.="<div class=\"row\">";//aqui comienza cada fila
            $resultado.="<div class=\"col\">";
            $resultado.="$obj->titulo";
            $resultado.="</div>";
            $resultado.="<div class=\"col\">";
            $resultado.="$obj->nombre";
            $resultado.="</div>";
            $resultado.="<div class=\"col\">";
            $resultado.="$obj->nota";
            $resultado.="</div>";
            $resultado.="<div class=\"col\">";
            $resultado.="$obj->lanzamiento";
            $resultado.="</div>";

           // if (empty($_SESSION)) {
                //no ponemos los botones
             //   $resultado.="<div class=\"col\">";
              //  $resultado.="</div>";
                //los pongo para que sea consistente la tabla
            //} else {

                //ahora vamos a insertar los botones de borrar y editar
                $resultado.="<div class=\"col\">";
                $resultado.="<ul id=\"icons\" class=\"ui-widget ui-helper-clearfix\">";
                $resultado.="<li class=\"ui-state-default ui-corner-all\">";
                $resultado.="<span class=\"ui-icon ui-icon-pencil accionEditar\" data-iden=\"$obj->idJue\"></span></li>";
                $resultado.="<li class=\"ui-state-default ui-corner-all\">";
                $resultado.="<span class=\"ui-icon ui-icon-closethick accionBorrar\" data-iden=\"$obj->idJue\"></span></li>";
                $resultado.="</ul>";
                $resultado.="</div>";
            //}    
            $resultado.="</div>";//este es el cierre de la fila
            
        }//close while
    }//close if $res

    //pondremos las páginas

    //Cuantas páginas
    $resultado2 = $lnk->query($sql);
    $total = $resultado2->num_rows;
    $numpaginas=intval($total / $totalRegistros)+1;

    $paginado="<ul class=\"pagination\">";
        if ($pagina!=1){
            $paginado.="
            <li><a href=\"#\" data-page=\"1\">Primero</a></li>
            <li><a href=\"#\" data-page=\"$anterior\"><<</a></li>";
        };

        for ($i=1;$i<=$numpaginas;$i++){
            $paginado.="<li><a href=\"#\" data-page=\"$i\" ";
            if ($i==$pagina) {
                $paginado.=" class=\"actual\"";
            }
            $paginado.=" > $i</a></li>";
        }

        if ($pagina!=$numpaginas){
            $paginado.=" 
            <li><a href=\"#\" data-page=\"$siguiente\">>></a></li>
            <li><a href=\"#\" data-page=\"$numpaginas\">Ultimo</a></li>";
        }
    $paginado.="</ul>";

    // Escribir el resultado
    echo json_encode(["filas" => $res->num_rows, "codigo" => $resultado, "paginado" => $paginado, "actual" => $pagina]) ;

    // Cerramos la conexión con el servidor
	$lnk->close() ;