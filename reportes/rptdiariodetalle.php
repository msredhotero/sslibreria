<?php

date_default_timezone_set('America/Buenos_Aires');

include ('../includes/funcionesUsuarios.php');
include ('../includes/funciones.php');
include ('../includes/funcionesHTML.php');
include ('../includes/funcionesReferencias.php');


$serviciosUsuarios  		= new ServiciosUsuarios();
$serviciosFunciones 		= new Servicios();
$serviciosHTML				= new ServiciosHTML();
$serviciosReferancias 		= new ServiciosReferencias();

$fecha = date('Y-m-d');

require('fpdf.php');

//$header = array("Hora", "Cancha 1", "Cancha 2", "Cancha 3");

$fechaPost		= 	$_GET['fecha'];

$resEmpresa		= $serviciosReferancias->traerConfiguracionUltima();

if (mysql_num_rows($resEmpresa)>0) {
	$empresa = mysql_result($resEmpresa,0,'empresa');	
} else {
	$empresa = '';	
}


$res1	= $serviciosReferancias->traerVentasPorDiaPorTipoTotales($fechaPost, 1);
$res2	= $serviciosReferancias->traerVentasPorDiaPorTipoTotales($fechaPost, 2);
$res3	= $serviciosReferancias->traerVentasPorDiaPorTipoTotales($fechaPost, 3);


$TotalIngresos = 0;
$TotalEgresos = 0;
$Totales = 0;
$Caja = 0;

class PDF extends FPDF
{
// Cargar los datos



	
	// Tabla coloreada
	function detalleCaja($header, $data, &$TotalIngresos)
	{
		$this->SetFont('Arial','',12);
		$this->Ln();
		$this->Ln();
		$this->Cell(60,7,'Ingresos de Fiestas',0,0,'L',false);
		$this->SetFont('Arial','',10);
		// Colores, ancho de línea y fuente en negrita
		$this->SetFillColor(255,0,0);
		$this->SetTextColor(255);
		$this->SetDrawColor(128,0,0);
		$this->SetLineWidth(.3);
		$this->Ln();
		
		
		// Cabecera
		$w = array(90, 20,25,25,25);
		for($i=0;$i<count($header);$i++)
			$this->Cell($w[$i],7,$header[$i],1,0,'C',true);
		$this->Ln();
		// Restauración de colores y fuentes
		$this->SetFillColor(224,235,255);
		$this->SetTextColor(0);
		$this->SetFont('');
		// Datos
		$fill = false;
		
		$total = 0;
		$totalcant = 0;
		while ($row = mysql_fetch_array($data))
		{
			$total = $total + $row[0];
			$totalcant = $totalcant + $row[2];
			
			$this->Cell($w[0],6,$row[1],'LR',0,'L',$fill);
			$this->Cell($w[1],6,$row[0],'LR',0,'R',$fill);
			$this->Cell($w[2],6,$row[2],'LR',0,'C',$fill);
			$this->Cell($w[3],6,$row[3],'LR',0,'C',$fill);
			$this->Cell($w[4],6,$row[4],'LR',0,'C',$fill);
			$this->Cell($w[3],6,$row[3],'LR',0,'C',$fill);
			$this->Cell($w[4],6,$row[4],'LR',0,'C',$fill);
			$this->Ln();
			$fill = !$fill;
		}
		
		// Línea de cierre
		$this->Cell(array_sum($w),0,'','T');
		$this->SetFont('Arial','',12);
		$this->Ln();
		$this->Ln();
		$this->Cell(60,7,'Cantidad de Fiestas:'.number_format($totalcant, 2, '.', ','),0,0,'L',false);
		$this->Ln();
		$this->Cell(60,7,'Total de Fiestas: $'.number_format($total, 2, '.', ','),0,0,'L',false);
		
		$TotalIngresos = $TotalIngresos + $total;
	}
	
	
	// Tabla coloreada
	function detalleCreditos($header, $data, &$TotalIngresos)
	{
		$this->SetFont('Arial','',12);
		$this->Ln();
		$this->Ln();
		$this->Cell(60,7,'Ingresos de Fiestas',0,0,'L',false);
		$this->SetFont('Arial','',10);
		// Colores, ancho de línea y fuente en negrita
		$this->SetFillColor(255,0,0);
		$this->SetTextColor(255);
		$this->SetDrawColor(128,0,0);
		$this->SetLineWidth(.3);
		$this->Ln();
		
		
		// Cabecera
		$w = array(90, 20,25,25,25);
		for($i=0;$i<count($header);$i++)
			$this->Cell($w[$i],7,$header[$i],1,0,'C',true);
		$this->Ln();
		// Restauración de colores y fuentes
		$this->SetFillColor(224,235,255);
		$this->SetTextColor(0);
		$this->SetFont('');
		// Datos
		$fill = false;
		
		$total = 0;
		$totalcant = 0;
		while ($row = mysql_fetch_array($data))
		{
			$total = $total + $row[0];
			$totalcant = $totalcant + $row[2];
			
			$this->Cell($w[0],6,$row[1],'LR',0,'L',$fill);
			$this->Cell($w[1],6,$row[0],'LR',0,'R',$fill);
			$this->Cell($w[2],6,$row[2],'LR',0,'C',$fill);
			$this->Cell($w[3],6,$row[3],'LR',0,'C',$fill);
			$this->Cell($w[4],6,$row[4],'LR',0,'C',$fill);
			$this->Cell($w[3],6,$row[3],'LR',0,'C',$fill);
			$this->Cell($w[4],6,$row[4],'LR',0,'C',$fill);
			$this->Ln();
			$fill = !$fill;
		}
		
		// Línea de cierre
		$this->Cell(array_sum($w),0,'','T');
		$this->SetFont('Arial','',12);
		$this->Ln();
		$this->Ln();
		$this->Cell(60,7,'Cantidad de Fiestas:'.number_format($totalcant, 2, '.', ','),0,0,'L',false);
		$this->Ln();
		$this->Cell(60,7,'Total de Fiestas: $'.number_format($total, 2, '.', ','),0,0,'L',false);
		
		$TotalIngresos = $TotalIngresos + $total;
	}


	
	// Tabla coloreada
	function detalleEgresos($header, $data, &$TotalIngresos)
	{
		$this->SetFont('Arial','',12);
		$this->Ln();
		$this->Ln();
		$this->Cell(60,7,'Ingresos de Fiestas',0,0,'L',false);
		$this->SetFont('Arial','',10);
		// Colores, ancho de línea y fuente en negrita
		$this->SetFillColor(255,0,0);
		$this->SetTextColor(255);
		$this->SetDrawColor(128,0,0);
		$this->SetLineWidth(.3);
		$this->Ln();
		
		
		// Cabecera
		$w = array(90, 20,25,25,25);
		for($i=0;$i<count($header);$i++)
			$this->Cell($w[$i],7,$header[$i],1,0,'C',true);
		$this->Ln();
		// Restauración de colores y fuentes
		$this->SetFillColor(224,235,255);
		$this->SetTextColor(0);
		$this->SetFont('');
		// Datos
		$fill = false;
		
		$total = 0;
		$totalcant = 0;
		while ($row = mysql_fetch_array($data))
		{
			$total = $total + $row[0];
			$totalcant = $totalcant + $row[2];
			
			$this->Cell($w[0],6,$row[1],'LR',0,'L',$fill);
			$this->Cell($w[1],6,$row[0],'LR',0,'R',$fill);
			$this->Cell($w[2],6,$row[2],'LR',0,'C',$fill);
			$this->Cell($w[3],6,$row[3],'LR',0,'C',$fill);
			$this->Cell($w[4],6,$row[4],'LR',0,'C',$fill);
			$this->Cell($w[3],6,$row[3],'LR',0,'C',$fill);
			$this->Cell($w[4],6,$row[4],'LR',0,'C',$fill);
			$this->Ln();
			$fill = !$fill;
		}
		
		// Línea de cierre
		$this->Cell(array_sum($w),0,'','T');
		$this->SetFont('Arial','',12);
		$this->Ln();
		$this->Ln();
		$this->Cell(60,7,'Cantidad de Fiestas:'.number_format($totalcant, 2, '.', ','),0,0,'L',false);
		$this->Ln();
		$this->Cell(60,7,'Total de Fiestas: $'.number_format($total, 2, '.', ','),0,0,'L',false);
		
		$TotalIngresos = $TotalIngresos + $total;
	}


}

$pdf = new FPDF();

$pdf->AddPage();

$pdf->SetFont('Arial','U',17);
$pdf->Cell(180,7,'Reporte Caja Diaria Totales',0,0,'C',false);
$pdf->Ln();
$pdf->SetFont('Arial','U',14);
$pdf->Cell(180,7,"Empresa: ".strtoupper($empresa),0,0,'C',false);
$pdf->Ln();
$pdf->Cell(180,7,'Fecha: '.date('Y-m-d'),0,0,'C',false);
$pdf->Ln();

$pdf->SetFont('Arial','',10);

$pdf->Ln();

$pdf->SetFont('Arial','',10);

// Títulos de las columnas
$headerFacturacion = array("Factura", "Cliente", "Producto","Cantidad", "Importe", "Total");
$pdf->detalleCaja($headerFacturacion,$resIngresosFacturacion,$TotalFacturacion);

$pdf->Ln();


// Títulos de las columnas
$headerFacturacion = array("Factura", "Cliente", "Producto","Cantidad", "Importe", "Total");
$pdf->detalleCreditos($headerFacturacion,$resIngresosFacturacion,$TotalFacturacion);

$pdf->Ln();


// Títulos de las columnas
$headerFacturacion = array("Factura", "Cliente", "Producto","Cantidad", "Importe", "Total");
$pdf->detalleEgresos($headerFacturacion,$resIngresosFacturacion,$TotalFacturacion);

$pdf->Ln();


$pdf->SetFont('Arial','',14);

if (mysql_num_rows($res1)>0) {
	$pdf->Ln();
	$pdf->Cell(60,7,'Caja Real: $ '.number_format(mysql_result($res1,0,0), 2, '.', ','),0,0,'L',false);
	$Totales = mysql_result($res1,0,0);
} else {
	$pdf->Ln();
	$pdf->Cell(60,7,'Caja Real: $ 0',0,0,'L',false);
}

if (mysql_num_rows($res2)>0) {
	$pdf->Ln();
	$pdf->Cell(60,7,'Creditos: $ '.number_format(mysql_result($res2,0,0), 2, '.', ','),0,0,'L',false);
	$TotalIngresos = mysql_result($res2,0,0);
} else {
	$pdf->Ln();
	$pdf->Cell(60,7,'Creditos: $ 0',0,0,'L',false);
} 

if (mysql_num_rows($res3)>0) {
	$pdf->Ln();
	$pdf->Cell(60,7,'Gastos: $ '.number_format(mysql_result($res3,0,0), 2, '.', ','),0,0,'L',false);
	$TotalEgresos = mysql_result($res3,0,0);
} else {
	$pdf->Ln();
	$pdf->Cell(60,7,'Gastos: $ 0',0,0,'L',false);
} 

$pdf->Ln();
$pdf->Cell(60,7,'Total Caja: $ '.number_format((float)$Totales - (float)$TotalEgresos, 2, '.', ','),0,0,'L',false);

$pdf->Ln();
$pdf->Cell(60,7,'Total Dia: $ '.number_format((float)$TotalIngresos + (float)$Totales, 2, '.', ','),0,0,'L',false);

$nombreTurno = "CajaDiaria-".$fecha.".pdf";

$pdf->Output($nombreTurno,'D');


?>

