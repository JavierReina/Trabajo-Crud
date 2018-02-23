<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Trabajo CRUD</title>
    <!-- Bootstrap -->
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/css/bootstrap.min.css" />
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

	<!-- JQUERY -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="jquery.js"></script>
    <!-- JQUERY UI -->
    <script src="jquery-ui/jquery-ui.js"></script>

    <!-- css de jquery ui -->
    <link href="jquery-ui/jquery-ui.css" rel="stylesheet">

    <style>
        #icons {
		margin: 0;
		padding: 0;
        }

        #icons li {
            margin: 2px;
            position: relative;
            padding: 4px 8px;
            cursor: pointer;
            float: left;
            list-style: none;
        }

        ul.pagination {
            display: inline-block;
            padding: 0;
            margin: 0;
        }

        ul.pagination li {display: inline;}

        ul.pagination li a {
            color:black;
            float: left;
            padding: 8px 16px;
            text-decoration: none;
        }
        .actual{
            color:red !important;
        }

        label, input { 
            display:block; 
        }

    </style>

    <script>

        var pagina = 1;
        var iden;
        var titulo;
        var genero;
        var nota;
        var lanzamiento;
        var cop;
        var orden;

        function listar(pagina) {

            $.ajax({
                method: "post",
                url: "listado.php",
                dataType: "json", 
                data: {"pagina": pagina, "orden": orden}
            })
            .fail(function(data) {
                console.log(data);
            })
            .done(function(html) {
                $("#resultado").html(html["codigo"]);
                //$("#paginacion").html(html["paginado"]);
                
                //tambien vamos a cambiar la pagina actual
                pagina = html["actual"];
            }) ;
        }

        function selecciona(iden) {
            $.ajax({
                    method: "post",
                    url: "seleccionado.php",
                    dataType: "json",
                    data: { "iden": iden }
                })
                .fail(function(data) {
                    console.log(data);
                })
                .done(function(html) {
                    iden = html["iden"];
                    titulo = html["titulo"];
                    genero = html["genero"];
                    nota = html["nota"];
                    lanzamiento = html["lanzamiento"];
                }) ;
        }

        //dialog
        $(function() {
            var dialog, form,
            allFields = $([]).add(iden).add(titulo).add(genero).add(nota).add(lanzamiento);

            function Enviar (iden) {
                $.ajax({
                    method: "post",
                    url: "manipulaBase.php",
                    data: {"iden": iden, "cop": cop, "titulo": titulo, "genero": genero, "nota": nota, "lanzamiento": lanzamiento}
                })
                .fail(function(data) {
                    console.log(data);
                })
                .done(function(html) {
                    //al meter con éxito en la base de datos volvemos a listar
                    listar(1);
                    console.log(html);
                    $("#dialog").dialog("close");
                    
                })
            }

            dialog = $("#dialog").dialog({
                autoOpen: false,
                height: 500,
                width: 350,
                modal: true,
                buttons: {
                    "Enviar": function() {
                        iden = $("#iden").val();
                        titulo = $("#titulo").val();
                        genero = $("#genero").val();
                        nota = $("#nota").val();
                        lanzamiento = $("#lanzamiento").val();
                        Enviar(iden);
                    },
                    "Cancelar": function() {
                        dialog.dialog( "close" );
                    }
                },
                    close: function() {
                        form[ 0 ].reset();
                        allFields.removeClass( "ui-state-error" );
                        
                    },

                    open: function(event, ui ) {
                        $("#iden").val(iden);
                        $("#titulo").val(titulo);
                        $("#genero").val(genero);
                        $("#nota").val(nota);
                        $("#lanzamiento").val(lanzamiento);
                    }
                });

                form = dialog.find( "form" ).on( "submit", function( event ) {
                    event.preventDefault();
                    Enviar(iden);
                });

                // Definimos un evento para editar
                $( "#resultado" ).on( "click",".accionEditar" , function() {
                    iden = $(this).data("iden") ;
                    selecciona(iden);
                    cop = "edit";
                    //también le vamos a restringir al usuario cambiar la clave
                    //le vamos a dejar verla, pero no cambiarla
                    $('#iden').prop('readonly', true);
                    setTimeout(function() {
                        abrir();
                    }, 200);
                    
                });

                // Definimos un evento para añadir
                $( ".accionAdd" ).on( "click", function() {
                    cop = "add";
                    abrir();
                    
                });

                // Definimos un evento para eliminar
                $("#resultado").on("click",".accionBorrar",function() {
                    iden = $(this).data("iden") ;
                    selecciona(iden);
                    cop = "";
                    //abrir segundo dialog
                    Enviar(iden);
                    }) ;

                function abrir () {
                    dialog.dialog("open");
                }

            });

            //sesion dialog
            $(function() {
                var dialog, form;

                function sesion(user, pass) {

                    $.ajax({
                        method: "post",
                        url: "sesion.php",
                        data: {"user": user, "pass": pass}
                    })
                    .done(function(html) {
                        $("#sesionForm").dialog("close");

                    })
                }

                dialog = $("#sesionForm").dialog({
                    autoOpen: false,
                    height: 350,
                    width: 350,
                    modal: true,
                    buttons: {
                        "Enviar": function() {
                            var user = $("#user").val();
                            var pass = $("#pass").val();
                            sesion(user, pass);
                        },
                        "Cancelar": function() {
                            dialog.dialog("close");
                        }
                    }
                })

                form = dialog.find( "form" ).on( "submit", function( event ) {
                    event.preventDefault();
                    sesion(user, pass);
                });

                //evento para abrir el dialogo del form iniciar sesion
                $("#inicia").on("click", function() {
                    dialog.dialog("open");
                })
            });

        //segundo dialog
        /*$(function() {
            var dialog, form;

            dialog = $("#confirma").dialog({
                autoOpen: false,
                modal: true,
                buttons: {
                    "Enviar": Enviar,
                    "Cancelar": function() {
                        dialogo.dialog( "close" );
                    }
                },
                close: function() {
                    form[ 0 ].reset();
                    allFields.removeClass( "ui-state-error" );
                }


            });//segundo dialog
            */


        //datepicker
        $( function() {
            $( "#lanzamiento" ).datepicker({
                dateFormat: "yy-mm-dd"
            });
        });

        $(document).ready(function () {
            listar(pagina);

            

            $("#paginacion").on("click",".pagination li a",function(){
                pagina = $(this).data("page");
                listar(pagina);
            });
            
            function ordenacion() {
                orden = $("#ordena").val();
                listar(1);
            }

            $("#cierra").on("click", function(){

                $.ajax({
                        method: "post",
                        url: "sesion.php",
                        data: {"cierra": true}
                    })
                    .done(function(html) {
                        listar(1);

                    })

            });

        }) ;//ready
    </script>
    
</head>
<body>
    <!--<select id="ordena" onchange="ordenacion()">
        <option value="titulo">Título</option>
        <option value="idGen">Género</option>
        <option value="nota">Nota</option>
        <option value="lanzamiento">Fecha de Salida</option>
    </select>-->
    <?php
        if (empty($_SESSION)) {
            ?>
            <strong><a href="#" id="inicia">Inicia Sesión</a></strong>
            <?php
        } else {
            ?>
            <strong><a href="#" id="cierra">Log Out</a></strong>
            <?php
        }
    ?>
    <button class="btn btn-sm btn-primary accionAdd">Añadir</button>
    <div id="contenedor">
        <strong>
            <div class="row">
                    <div class="col">Título</div>
                    <div class="col">Género</div>
                    <div class="col">Nota</div>
                    <div class="col">Fecha Salida</div>
                    <div class="col"></div><!-- está vacío para dejar espacio a los botones -->  
            </div>
        </strong>
        <div id="resultado"></div>
    </div>
    <p class="text-center mt-2">
        <div id="paginacion"></div>
    </p>

    <!-- Esto es el dialog -->
    <div id="dialog">
        
        <form>
            <fieldset>
                <label for="iden">Identificador del Juego</label>
                <input type="number" name="iden" id="iden" class="text ui-widget-content ui-corner-all">
                <label for="titulo">Titulo</label>
                <input type="text" name="titulo" id="titulo" class="text ui-widget-content ui-corner-all">
                <label for="genero">Género</label>
                <select name="genero" id="genero" class="text ui-widget-content ui-corner-all">
                    <?php
                        include_once("conexion.php");
                        $sql = "SELECT * FROM generos ;";

                        $res = $lnk->query($sql);
                        while ($obj = $res->fetch_object()) {

                            echo "<option value=\"$obj->idGen\">$obj->nombre</option>";
                        }
                        $lnk->close() ;
                    ?>
                </select>
                <label for="nota">Nota en Metacritic</label>
                <input type="number" name="nota" id="nota" class="text ui-widget-content ui-corner-all">
                <label for="lanzamiento">Fecha de Lanzamineto</label>
                <input type="text" name="lanzamiento" id="lanzamiento" class="text ui-widget-content ui-corner-all">
            
                <!-- Allow form submission with keyboard without duplicating the dialog button -->
                <input type="submit" tabindex="-1" style="position:absolute; top:-1000px">
            </fieldset>
        </form>
    </div>

    <div id="sesionForm"> 
        <fieldset>
            <label for="user">Usuario</label>
            <input type="text" name="user" id="user" class="text ui-widget-content ui-corner-all">
            <label for="pass">Contraseña</label>
            <input type="password" name="pass" id="pass" class="text ui-widget-content ui-corner-all">

            <!-- Allow form submission with keyboard without duplicating the dialog button -->
            <input type="submit" tabindex="-1" style="position:absolute; top:-1000px">
        </fieldset>
    </div>
    

    


    <!--<div id="confirma">
        <h3>Confirmación de Eliminación</h3>
        <p>Está a punto de borrar un campo de la base de datos.</p>
        <strong><p>¿Estás seguro?</p></strong>
    </div>-->
</body>
</html>