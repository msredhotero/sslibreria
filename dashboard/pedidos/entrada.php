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
$resMenu = $serviciosHTML->menu(utf8_encode($_SESSION['nombre_predio']),"Pedidos",$_SESSION['refroll_predio'],'');

$id	= $_GET['id'];

$resResult	=	$serviciosReferencias->traerDetallepedidoPorPedido($id);

/////////////////////// Opciones pagina ///////////////////////////////////////////////
$singular = "Pedido";

$plural = "Pedidos";

$eliminar = "eliminarPedidos";

$insertar = "insertarPedidos";

$tituloWeb = "Gestión: Libreria";
//////////////////////// Fin opciones ////////////////////////////////////////////////


/////////////////////// Opciones para la creacion del formulario  /////////////////////
$tabla 			= "dbpedidos";

$lblCambio	 	= array();
$lblreemplazo	= array();


$cadRef 	= '';

$resProductos	=	$serviciosReferencias->traerProductos();

$refdescripcion = array();
$refCampo 	=  array();
//////////////////////////////////////////////  FIN de los opciones //////////////////////////




/////////////////////// Opciones para la creacion del view  patente,refmodelo,reftipovehiculo,anio/////////////////////
$cabeceras 		= "	<th>Referencia</th>
                    <th>Fecha Pedido</th>
                    <th>Fecha Entrega</th>
					<th>Total</th>
					<th>Estado</th>
                    <th>Obserbaciones</th>";

$cabecerasProductos 		= "<th>Prdoucto</th>
                    <th>Cantidad</th>
					<th>Stock</th>
					<th>Stock Min.</th>
					<th>Precio</th>";
//////////////////////////////////////////////  FIN de los opciones //////////////////////////




//$formulario 	= $serviciosFunciones->camposTabla($insertar ,$tabla,$lblCambio,$lblreemplazo,$refdescripcion,$refCampo);

$lstCargados 	= $serviciosFunciones->camposTablaView($cabeceras,$serviciosReferencias->traerProductos(),10);

$lstCargadosProductosFaltantes 	= $serviciosFunciones->camposTablaView($cabecerasProductos,$serviciosReferencias->traerProductosFaltantes(),5);

$pedidosTemporal = $serviciosReferencias->traerDetallepedidoaux();

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
    <link rel="stylesheet" href="../../css/bootstrap-datetimepicker.min.css">
	<link rel="stylesheet" href="../../css/chosen.css">
	<style type="text/css">
		#table-6 {
			border:2px solid #C0C0C0;
		}
		
		#table-6 thead {
		text-align: center;
		}
		#table-6 thead th {
		background: -moz-linear-gradient(top, #F0F0F0 0, #DBDBDB 100%);
		background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #F0F0F0), color-stop(100%, #DBDBDB));
		filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#F0F0F0', endColorstr='#DBDBDB', GradientType=0);
		border: 1px solid #C0C0C0;
		color: #444;
		font-size: 16px;
		font-weight: bold;
		padding: 3px 10px;
		}
		
		#table-6 tbody td .cent {
			text-align:center;	
		}
  
		
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

<h3><?php echo $plural; ?> <span style="color:#006666;"><span class="glyphicon glyphicon-chevron-right"></span> Confirmar</span></h3>
    
    <div class="boxInfoLargo">
        <div id="headBoxInfo">
        	<p style="color: #fff; font-size:18px; height:16px;">Confirmar <?php echo $plural; ?></p>
        	
        </div>
    	<div class="cuerpoBox">
        	<div class="alert alert-info">
            	<p><span class="glyphicon glyphicon-info-sign"></span> Recuerde cargar la fecha de entrega y una referencia</p>
            </div>
        	<form class="form-inline formulario" role="form">

            
            <div class="col-md-12">
            <table class="table table-striped" id="table-6">
                <thead>
                    <tr>
                        <th class="text-center">Id</th>
                        <th class="text-center">Producto</th>
                        <th class="text-center">Cantidad</th>
                        <th class="text-center">Nuevo Stock</th>
                        <th class="text-center">Precio</th>
                        <th class="text-center">Sub-Total</th>
                    </tr>
                </thead>
                <tbody class="detalle">
                	<?php
						$total = 0;
						$fechaentrega = '';
						$fechasolicitud= '';
						$referencia = '';
						$observaciones = '';
						if (mysql_num_rows($resResult)>0) {
							
							while ($rowT = mysql_fetch_array($resResult)) {
								$total += $rowT['precio'] * $rowT['cantidad'];
								$fechaentrega = $rowT['fechaentrega'];
								$fechasolicitud = $rowT['fechasolicitud'];
								$referencia = $rowT['referencia'];
								$observaciones = $rowT['observacion'];
								
					?>
                    		<tr>
                    		<td><?php echo $rowT['refproductos']; ?></td>
                    		<td><?php echo $rowT['nombre']; ?></td>
                            <td align="center"><input type="number" id="cantidad" value="<?php echo $rowT['cantidad']; ?>" /></td>
                            <td align="right"><?php echo $rowT['stock']; ?> <span class="text-success">+ <?php echo $rowT['cantidad']; ?></span> = <?php echo $rowT['stock']+$rowT['cantidad']; ?></td>
                            <td align="right"><?php echo $rowT['precio']; ?></td>
                            <td align="right"><?php echo $rowT['precio'] * $rowT['cantidad']; ?></td>
                    		</tr>
                    <?php
							}
						}
					?>
                </tbody>
                <tfoot>
                    <tr style="background-color:#CCC; font-weight:bold; font-size:18px;">
                        <td colspan="5" align="right">
                            Total $
                        </td>
                        <td>
                            <input type="text" readonly name="total" id="total" value="<?php echo $total; ?>" style="border:none; background-color:#CCC;"/>
                        </td>
                    </tr>
                </tfoot>
            </table>
            </div>
            
            <div class="form-group col-md-3">
                <label for="fechaentrega" class="control-label" style="text-align:left">Fecha de Solicitud</label>
                <div class="input-group col-md-12">
                    <h4><?php echo $fechasolicitud; ?></h4>
                </div>
                
            </div>
            
            <div class="form-group col-md-3">
                <label for="fechaentrega" class="control-label" style="text-align:left">Fecha de Entrega</label>
                <div class="input-group col-md-12">
                    <h4><?php echo $fechaentrega; ?></h4>
                </div>
                
            </div>
            
            <div class="form-group col-md-6" style="display:block">
                <label class="control-label" for="referencia" style="text-align:left">Referencia</label>
                <div class="input-group col-md-12">
                    <h4><?php echo $referencia; ?></h4>
                </div>
            </div>
            
            <div class="form-group col-md-12" style="display:block">
                <label class="control-label" for="observaciones" style="text-align:left">Observaciones</label>
                <div class="input-group col-md-12">
                    <h4><?php echo $observaciones; ?></h4>
                </div>
            </div>
                    
            <div class="row">
                <div class="col-md-12">
                <ul class="list-inline" style="margin-left:15px;">
                    <li>
                        <button type="button" class="btn btn-primary" id="cargar" style="margin-left:0px;">Cargar</button>
                    </li>
                    <li>
                        <button type="button" class="btn btn-default volver" id="volver" style="margin-left:0px;">Volver</button>
                    </li>
                </ul>
                </div>
            </div>
            
            <div class="row" id="aviso" style="display:none;">
            	<div class="col-md-12">
                	<div class='alert alert-info'>
                		<p>Se guardo temporalmente el pedido para una posterior modificación</p>
                	</div>
                </div>
            </div>
            <input type="hidden" name="accion" id="accion" value="" />
            
            </form>
    	</div>
    </div>
 
    
   
</div>


</div>



<script type="text/javascript" src="../../js/jquery.dataTables.min.js"></script>
<script src="../../bootstrap/js/dataTables.bootstrap.js"></script>
<script src="../../js/bootstrap-datetimepicker.min.js"></script>
<script src="../../js/bootstrap-datetimepicker.es.js"></script>

<script type="text/javascript">
$(document).ready(function(){
	
	
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
	
	$('.volver').click(function(event){
		 
		url = "index.php";
		$(location).attr('href',url);
	});//fin del boton modificar
	

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
	
	function insertarDetalleAux(idProducto, cantidad, precio, total) {
		$.ajax({
				data:  {refproductos: idProducto, 
						cantidad: cantidad, 
						precio: precio, 
						total: total, 
						accion: 'insertarDetallepedidoaux'},
				url:   '../../ajax/ajax.php',
				type:  'post',
				beforeSend: function () {
						
				},
				success:  function (response) {
					setTimeout(function() {
						$("#aviso").fadeOut(1500);
					},3000);	
						
				}
		});
	}
	
	
	function eliminarDetalleAux(idProducto) {
		$.ajax({
				data:  {id: idProducto, 
						accion: 'eliminarDetallepedidoaux'},
				url:   '../../ajax/ajax.php',
				type:  'post',
				beforeSend: function () {
						
				},
				success:  function (response) {
						
						
				}
		});
	}
	
	

	function getProducto(idProd) {
		$.ajax({
					data:  {idproducto: idProd,
							accion: 'traerProductoPorCodigo'},
					url:   '../../ajax/ajax.php',
					type:  'post',
					beforeSend: function () {
							
					},
					success:  function (response) {
						if(response){
							//idproducto,codigo,nombre,descripcion,stock,stockmin,preciocosto,precioventa,utilidad,estado,imagen,idcategoria,tipoimagen,nroserie,codigobarra
							json = $.parseJSON(response);

							
							//var producto = [json[0].nombre, json[0].preciocosto];
							$('#prodNombre').val(json[0].nombre);
							$('#prodPrecio').val(json[0].preciocosto);
							monto = parseFloat(json[0].preciocosto) * parseInt($('#cantidadbuscar').val()).toFixed(2);
							$('.detalle').prepend('<tr><td>'+$('#refproductobuscar').chosen().val()+'</td><td>'+json[0].nombre+'</td><td>'+$('#cantidadbuscar').val()+'</td><td>'+json[0].preciocosto+'</td><td>'+monto.toFixed(2)+'</td><td><button type="button" class="btn btn-danger eliminarfila" id="eliminar" style="margin-left:0px;">Eliminar</button></td></tr>');
								
							$('#total').val(SumarTabla());
							$('#cantidadbuscar').val(1);
							
							$("#aviso").show();
							
							//inserta en la tabla temperal para que me guarde el pedido por si quiero salir y volver a entrar
							insertarDetalleAux($('#refproductobuscar').chosen().val(), $('#cantidadbuscar').val(), json[0].preciocosto, monto);
							
						} else {
							//var producto = ['', 0];
							$('#prodNombre').val('');
							$('#prodPrecio').val(0);
						}
					}
			});	
	}
	
	
	$('#agregar').click(function(e) {
		
		getProducto($('#refproductobuscar').chosen().val());
		
    });
	
	
	function SumarTabla() {
		var suma = 0;
		$('.detalle tr').each(function(){
			
			suma += parseFloat($(this).find('td').eq(4).text()||0,10); //numero de la celda 3
		})
		return suma.toFixed(2);

	  }
	  
	//elimina una fila
	  $(document).on("click",".eliminarfila",function(){
		var padre = $(this).parents().get(1);

		$(padre).remove();
		
		id =  $(this).attr("id");
		
		eliminarDetalleAux(id);
		
		$('#total').val(SumarTabla());
	  });
	  
	//al enviar el formulario
    $('#cargar').click(function(){
		

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
		
    });
    


});
</script>
<script type="text/javascript">
$('.form_date').datetimepicker({
	language:  'es',
	weekStart: 1,
	todayBtn:  1,
	autoclose: 1,
	todayHighlight: 1,
	startView: 2,
	minView: 2,
	forceParse: 0,
	format: 'dd/mm/yyyy'
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
