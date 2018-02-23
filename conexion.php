<?php

    $lnk = @new mysqli("localhost","root","") ;

	if ($lnk->connect_errno>0) {
		echo "ERROR ($lnk->connect_errno): $lnk->connect_error<br/>" ;
		exit() ;
	}

	// Configurar la conexión para que acepte codificación UTF8
	$lnk->set_charset("utf8") ;

	// Accedemos a la base de datos
    $lnk->select_db("ajax") ;