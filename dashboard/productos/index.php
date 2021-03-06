<?php


session_start();

if (!isset($_SESSION['usua_predio']))
{
	header('Location: ../../error.php');
} else {


include ('../../includes/funciones.php');
include ('../../includes/funcionesUsuarios.php');
include ('../../includes/funcionesHTML.php');
include ('../../includes/funcionesReferencias.php');

$serviciosFunciones 	= new Servicios();
$serviciosUsuario 		= new ServiciosUsuarios();
$serviciosHTML 			= new ServiciosHTML();
$serviciosReferencias 	= new ServiciosReferencias();

$fecha = date('Y-m-d');

//$resProductos = $serviciosProductos->traerProductosLimite(6);
$resMenu = $serviciosHTML->menu(utf8_encode($_SESSION['nombre_predio']),"Productos",$_SESSION['refroll_predio'],'');


/////////////////////// Opciones pagina ///////////////////////////////////////////////
$singular = "Producto";

$plural = "Productos";

$eliminar = "eliminarProductos";

$insertar = "insertarProductos";

$tituloWeb = "Gestión: Libreria";
//////////////////////// Fin opciones ////////////////////////////////////////////////


/////////////////////// Opciones para la creacion del formulario  /////////////////////
$tabla 			= "dbproductos";

$codigo			= $serviciosReferencias->generarCodigo();

$lblCambio	 	= array("codigobarra","stockmin","preciocosto","precioventa","refcategorias");
$lblreemplazo	= array("Cod. Barra","Stock Minimo","Precio Costo","Precio Venta","Categoria");


$resCategorias 	= $serviciosReferencias->traerCategorias();
$cadRef 	= $serviciosFunciones->devolverSelectBox($resCategorias,array(1),'');

$refdescripcion = array(0 => $cadRef);
$refCampo 	=  array("refcategorias");
//////////////////////////////////////////////  FIN de los opciones //////////////////////////




/////////////////////// Opciones para la creacion del view  patente,refmodelo,reftipovehiculo,anio/////////////////////
$cabeceras 		= "	<th>Codigo</th>
                    <th>Cod.Barra</th>
                    <th>Nombre</th>
					<th>Descripción</th>
					<th>Stock</th>
                    <th>Stock Min.</th>
                    <th>Precio</th>
                    <th>Imagen</th>
                    <th>Categoria</th>
                    <th>Unidades</th>";

//////////////////////////////////////////////  FIN de los opciones //////////////////////////

$resCategoriasModi 	= $serviciosReferencias->traerCategorias();


$formulario 	= $serviciosFunciones->camposTabla($insertar ,$tabla,$lblCambio,$lblreemplazo,$refdescripcion,$refCampo);



if ($_SESSION['refroll_predio'] != 1) {

} else {

	
}


?>

<!DOCTYPE HTML>
<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">



<title><?php echo $tituloWeb; ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">


<link href="../../css/estiloDash.css" rel="stylesheet" type="text/css">
    

    
    <script type="text/javascript" src="../../js/jquery-1.8.3.min.js"></script>
    <link rel="stylesheet" href="../../css/jquery-ui.css">

    <script src="../../js/jquery-ui.js"></script>
    
	<!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css"/>
	<link href='http://fonts.googleapis.com/css?family=Lato&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
    <!-- Latest compiled and minified JavaScript -->
    <script src="../../bootstrap/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="../../css/chosen.css">
	<style type="text/css">
		
  
		
	</style>
    
   
   <link href="../../css/perfect-scrollbar.css" rel="stylesheet">
      <!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>-->
      <script src="../../js/jquery.mousewheel.js"></script>
      <script src="../../js/perfect-scrollbar.js"></script>
      <script>
      jQuery(document).ready(function ($) {
        "use strict";
        $('#navigation').perfectScrollbar();
      });
    </script>
</head>

<body>

 <?php echo $resMenu; ?>

<div id="content">

<h3><?php echo $plural; ?></h3>

    <div class="panel panel-success">
        <div class="panel-heading" id="headBoxInfo">
        	<p style="color: #fff; font-size:18px; height:16px;">Carga de <?php echo $plural; ?></p>
        	
        </div>
    	<div class="panel-body">
        	<form class="form-inline formulario" role="form">
        	<div class="row">
			<?php echo $formulario; ?>
            </div>

            
            <div class='row' style="margin-left:25px; margin-right:25px;">
                <div class='alert'>
                
                </div>
                <div id='load'>
                
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-12">
                <ul class="list-inline" style="margin-left:15px;">
                    <li>
                        <button type="button" class="btn btn-primary" id="cargar" style="margin-left:0px;">Guardar</button>
                    </li>
                </ul>
                </div>
            </div>
            </form>
            <hr>
            
            <div class='row' style="margin-left:25px; margin-right:25px;">
            	<h4>Seleccione una categoria para modificar los precios masivamente</h4>
                <div class="form-group col-md-6">
                 <label class="control-label" style="text-align:left" for="torneo">Categorias</label>
                    <div class="input-group col-md-12" style="display:block">
                    	<select data-placeholder="selecione el producto..." id="categoriamodificar" name="categoriamodificar" class="chosen-select" tabindex="2" style="z-index:9999999; width:100%;">
                        
                            <option value="0">--Seleccione--</option>
                            <?php echo $cadRef; ?>
                            
                        </select>
                    </div>
                    
                </div>
                
                <div class="form-group col-md-6">
                	<label class="control-label" style="text-align:left" for="torneo"></label>
                     <ul class="list-inline" style="margin-top:5px;">
                        <li>
                         <button id="modificarmasivo" class="btn btn-warning" style="margin-left:0px;" type="button">Modificar</button>
                        </li>
                    </ul>

                </div>
            </div>
    	</div>
    </div>
    
    <div class="panel panel-success" style="margin-top:10px;">
        <div class="panel-heading" id="headBoxInfo">
        	<p style="color: #fff; font-size:18px; height:16px;"><?php echo $plural; ?> Cargados</p>
        	
        </div>
    	<div class="panel-body" style="z-index:1;">
        	<form class="form-inline formulario" role="form">
            	
                <div class="row">
                    
                    
                    <div class="form-group col-md-6">
                     <label class="control-label" style="text-align:left" for="torneo">Tipo de Busqueda</label>
                        <div class="input-group col-md-12">
                            <select id="tipobusqueda" class="form-control" name="tipobusqueda">
                                <option value="0">--Seleccione--</option>
                                <option value="1">Nombre</option>
                                <option value="2">Codigo Barra</option>
                                <option value="3">Codigo</option>
                                
                            </select>
                        </div>
                        
                    </div>
                    
                    <div class="form-group col-md-6">
                     <label class="control-label" style="text-align:left" for="torneo">Busqueda</label>
                        <div class="input-group col-md-12">
                            <input type="text" name="busqueda" id="busqueda" class="form-control">
                        </div>

                    </div>
                    
                    <div class="form-group col-md-12">
                    	 <ul class="list-inline" style="margin-top:15px;">
                            <li>
                             <button id="buscar" class="btn btn-primary" style="margin-left:0px;" type="button">Buscar</button>
                            </li>
                        </ul>

                    </div>
                    
                    <div class="form-group col-md-12">
                    	<div class="cuerpoBox" id="resultados">
        
       		 			</div>
					</div>
                
                </div>
                
                <div class="row">
                    <div class="alert" id="errorBusqueda"> </div>
                    <div id="load"> </div>
                </div>

            <input type="hidden" id="accion" name="accion" value="eliminarMasivo" />
            </form>
    	</div>
    </div>
    
    

    
    
   
</div>


</div>
<div id="dialog2" title="Eliminar <?php echo $singular; ?>">
    	<p>
        	<span class="ui-icon ui-icon-alert" style="float: left; margin: 0 7px 20px 0;"></span>
            ¿Esta seguro que desea eliminar el <?php echo $singular; ?>?.<span id="proveedorEli"></span>
        </p>
        <p><strong>Importante: </strong>Si elimina el <?php echo $singular; ?> se perderan todos los datos de este</p>
        <input type="hidden" value="" id="idEliminar" name="idEliminar">
</div>
<script type="text/javascript" src="../../js/jquery.dataTables.min.js"></script>
<script src="../../bootstrap/js/dataTables.bootstrap.js"></script>

<script type="text/javascript">
$(document).ready(function(){
	
	$(".formulario").bind("keypress", function(e) {
	  if (e.keyCode == 13) {               
		e.preventDefault();
		return false;
	  }
	});

	function buscarProducto(busqueda, tipobusqueda) {
		$.ajax({
				data:  {busqueda: busqueda,
						tipobusqueda: tipobusqueda,
						tipo: 'Pedido',
						accion: 'buscarProductos'},
				url:   '../../ajax/ajax.php',
				type:  'post',
				beforeSend: function () {
						
				},
				success:  function (response) {
						$('#resultados').html(response);
						
				}
		});
	}
	
	$('#buscar').click(function(e) {
        buscarProducto($('#busqueda').val(), $('#tipobusqueda').val());
		
	});
	
	
	$('#activo').prop('checked',true);
	
	$('#example').dataTable({
		"order": [[ 0, "asc" ]],
		"language": {
			"emptyTable":     "No hay datos cargados",
			"info":           "Mostrar _START_ hasta _END_ del total de _TOTAL_ filas",
			"infoEmpty":      "Mostrar 0 hasta 0 del total de 0 filas",
			"infoFiltered":   "(filtrados del total de _MAX_ filas)",
			"infoPostFix":    "",
			"thousands":      ",",
			"lengthMenu":     "Mostrar _MENU_ filas",
			"loadingRecords": "Cargando...",
			"processing":     "Procesando...",
			"search":         "Buscar:",
			"zeroRecords":    "No se encontraron resultados",
			"paginate": {
				"first":      "Primero",
				"last":       "Ultimo",
				"next":       "Siguiente",
				"previous":   "Anterior"
			},
			"aria": {
				"sortAscending":  ": activate to sort column ascending",
				"sortDescending": ": activate to sort column descending"
			}
		  }
	} );
	
	$('#codigo').attr('value','<?php echo $codigo; ?>');

	$("#example").on("click",'.varborrar', function(){
		  usersid =  $(this).attr("id");
		  if (!isNaN(usersid)) {
			$("#idEliminar").val(usersid);
			$("#dialog2").dialog("open");

			
			//url = "../clienteseleccionado/index.php?idcliente=" + usersid;
			//$(location).attr('href',url);
		  } else {
			alert("Error, vuelva a realizar la acción.");	
		  }
	});//fin del boton eliminar
	
	$("#example").on("click",'.varmodificar', function(){
		  usersid =  $(this).attr("id");
		  if (!isNaN(usersid)) {
			
			url = "modificar.php?id=" + usersid;
			$(location).attr('href',url);
		  } else {
			alert("Error, vuelva a realizar la acción.");	
		  }
	});//fin del boton modificar
	
	$('#modificarmasivo').click(function() {
		url = "modificarprecios.php?idcategoria=" + $('#categoriamodificar').chosen().val();
		$(location).attr('href',url);
	});

	 $( "#dialog2" ).dialog({
		 	
			    autoOpen: false,
			 	resizable: false,
				width:600,
				height:240,
				modal: true,
				buttons: {
				    "Eliminar": function() {
	
						$.ajax({
									data:  {id: $('#idEliminar').val(), accion: '<?php echo $eliminar; ?>'},
									url:   '../../ajax/ajax.php',
									type:  'post',
									beforeSend: function () {
											
									},
									success:  function (response) {
											url = "index.php";
											$(location).attr('href',url);
											
									}
							});
						$( this ).dialog( "close" );
						$( this ).dialog( "close" );
							$('html, body').animate({
	           					scrollTop: '1000px'
	       					},
	       					1500);
				    },
				    Cancelar: function() {
						$( this ).dialog( "close" );
				    }
				}
		 
		 
	 		}); //fin del dialogo para eliminar
			
	<?php 
		echo $serviciosHTML->validacion($tabla);
	
	?>
	

	
	
	//al enviar el formulario
    $('#cargar').click(function(){
		
		if (validador() == "")
        {
			//información del formulario
			var formData = new FormData($(".formulario")[0]);
			var message = "";
			//hacemos la petición ajax  
			$.ajax({
				url: '../../ajax/ajax.php',  
				type: 'POST',
				// Form data
				//datos del formulario
				data: formData,
				//necesario para subir archivos via ajax
				cache: false,
				contentType: false,
				processData: false,
				//mientras enviamos el archivo
				beforeSend: function(){
					$("#load").html('<img src="../../imagenes/load13.gif" width="50" height="50" />');       
				},
				//una vez finalizado correctamente
				success: function(data){

					if (data == '') {
                                            $(".alert").removeClass("alert-danger");
											$(".alert").removeClass("alert-info");
                                            $(".alert").addClass("alert-success");
                                            $(".alert").html('<strong>Ok!</strong> Se cargo exitosamente el <strong><?php echo $singular; ?></strong>. ');
											$(".alert").delay(3000).queue(function(){
												/*aca lo que quiero hacer 
												  después de los 2 segundos de retraso*/
												$(this).dequeue(); //continúo con el siguiente ítem en la cola
												
											});
											$("#load").html('');
											url = "index.php";
											$(location).attr('href',url);
                                            
											
                                        } else {
                                        	$(".alert").removeClass("alert-danger");
                                            $(".alert").addClass("alert-danger");
                                            $(".alert").html('<strong>Error!</strong> '+data);
                                            $("#load").html('');
                                        }
				},
				//si ha ocurrido un error
				error: function(){
					$(".alert").html('<strong>Error!</strong> Actualice la pagina');
                    $("#load").html('');
				}
			});
		}
    });
	
	
	$("#resultados").on("click",'#borrarMasivo', function(){
		//información del formulario
		var formData = new FormData($(".formulario")[1]);
		var message = "";
		//hacemos la petición ajax  
		$.ajax({
			url: '../../ajax/ajax.php',  
			type: 'POST',
			// Form data
			//datos del formulario
			data: formData,
			//necesario para subir archivos via ajax
			cache: false,
			contentType: false,
			processData: false,
			//mientras enviamos el archivo
			beforeSend: function(){
				$("#load").html('<img src="../../imagenes/load13.gif" width="50" height="50" />');       
			},
			//una vez finalizado correctamente
			success: function(data){

				if (data == '') {
					$("#errorBusqueda").removeClass("alert-danger");
					$("#errorBusqueda").removeClass("alert-info");
					$("#errorBusqueda").addClass("alert-success");
					$("#errorBusqueda").html('<strong>Ok!</strong> Se eliminaron todos los productos cargados. ');
					buscarProducto($('#busqueda').val(), $('#tipobusqueda').val());
					
					
				} else {
					$("#errorBusqueda").removeClass("alert-danger");
					$("#errorBusqueda").addClass("alert-danger");
					$("#errorBusqueda").html('<strong>Error!</strong> '+data);
					$("#load").html('');
				}
			},
			//si ha ocurrido un error
			error: function(){
				$("#errorBusqueda").html('<strong>Error!</strong> Actualice la pagina');
				$("#load").html('');
			}
		});
	});
    
    $('#imagen1').on('change', function(e) {
	  var Lector,
		  oFileInput = this;
	 
	  if (oFileInput.files.length === 0) {
		return;
	  };
	 
	  Lector = new FileReader();
	  Lector.onloadend = function(e) {
		$('#vistaPrevia1').attr('src', e.target.result);         
	  };
	  Lector.readAsDataURL(oFileInput.files[0]);
	 
	});

});
</script>
<script src="../../js/chosen.jquery.js" type="text/javascript"></script>
<script type="text/javascript">
    var config = {
      '.chosen-select'           : {},
      '.chosen-select-deselect'  : {allow_single_deselect:true},
      '.chosen-select-no-single' : {disable_search_threshold:10},
      '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
      '.chosen-select-width'     : {width:"95%"}
    }
    for (var selector in config) {
      $(selector).chosen(config[selector]);
    }
  </script>
<?php } ?>
</body>
</html>
