<?php

date_default_timezone_set('America/Buenos_Aires');

include ('../includes/funcionesUsuarios.php');
include ('../includes/funciones.php');
include ('../includes/funcionesHTML.php');
include ('../includes/funcionesReferencias.php');


$serviciosUsuarios  		= new ServiciosUsuarios();
$serviciosFunciones 		= new Servicios();
$serviciosHTML				= new ServiciosHTML();
$serviciosReferencias 		= new ServiciosReferencias();
//$serviciosReportes			= new ServiciosReportes();

$fecha = date('Y-m-d');

require('fpdf.php');

//$header = array("Hora", "Cancha 1", "Cancha 2", "Cancha 3");

$id				=	$_GET['id'];

//$resEmpresa		=	$serviciosEmpresas->traerEmpresasPorId($id);

$empresa		=	'C y C';

$datos			=	$serviciosReferencias->traerDetalleventasPorVenta($id);

$TotalIngresos = 0;
$TotalEgresos = 0;
$Totales = 0;
$Caja = 0;


/*
class PDF extends FPDF
{
// Cargar los datos




// Tabla coloreada
function ingresosFacturacion($header, $data, &$TotalIngresos)
{
	$this->SetFont('Arial','',12);
	$this->Ln();
	$this->Ln();
	$this->Cell(60,7,'Facturación General',0,0,'L',false);
	$this->SetFont('Arial','',11);
    // Colores, ancho de línea y fuente en negrita
    $this->SetFillColor(255,0,0);
    $this->SetTextColor(255);
    $this->SetDrawColor(128,0,0);
    $this->SetLineWidth(.3);
	$this->Ln();
	
	
    // Cabecera
    $w = array(80,30,30,30);
    for($i=0;$i<count($header);$i++)
        $this->Cell($w[$i],6,$header[$i],1,0,'C',true);
    $this->Ln();
    // Restauración de colores y fuentes
    $this->SetFillColor(224,235,255);
    $this->SetTextColor(0);
    $this->SetFont('');
    // Datos
    $fill = false;
	
	$total = 0;
	$totalcant = 0;
	$sumSaldos = 0;
	$sumAbonos = 0;
	
	$this->SetFont('Arial','',9);
    while ($row = mysql_fetch_array($data))
    {
		$total = $total + $row['total'];
		$totalcant = $totalcant + 1;
		
        $this->Cell($w[0],5,$row['nombre'],'LR',0,'L',$fill);
		$this->Cell($w[1],5,$row['cantidad'],'LR',0,'C',$fill);
		$this->Cell($w[2],5,number_format($row['precio'],2,',','.'),'LR',0,'R',$fill);
		$this->Cell($w[3],5,number_format($row['total'],2,',','.'),'LR',0,'R',$fill);
        $this->Ln();
        
		
		if ($totalcant == 25) {
			$this->AddPage();
			$this->SetFont('Arial','',11);
			// Colores, ancho de línea y fuente en negrita
			$this->SetFillColor(255,0,0);
			$this->SetTextColor(255);
			$this->SetDrawColor(128,0,0);
			$this->SetLineWidth(.3);
			for($i=0;$i<count($header);$i++)
				$this->Cell($w[$i],6,$header[$i],1,0,'C',true);
			$this->Ln();
			$this->SetFillColor(224,235,255);
			$this->SetTextColor(0);
			$this->SetFont('');
			// Datos
			$fill = false;
			$this->SetFont('Arial','',9);
		}
    }
	
	$this->Cell($w[0]+$w[1]+$w[2],5,'Totales:','LRT',0,'L',$fill);
	$this->Cell($w[3],5,number_format($total,2,',','.'),'LRT',0,'R',$fill);

	$fill = !$fill;
	$this->Ln();
    // Línea de cierre
    $this->Cell(array_sum($w),0,'','T');
	$this->SetFont('Arial','',12);
	$this->Ln();
	$this->Ln();
	$this->Cell(60,7,'Cantidad de Facturas: '.$totalcant,0,0,'L',false);
	$this->Ln();
	$this->Cell(60,7,'Total: $'.number_format($sumSaldos, 2, '.', ','),0,0,'L',false);
	
	$TotalIngresos = $TotalIngresos + $total;
}

}
*/





$pdf = new FPDF("L");


// Títulos de las columnas

$headerFacturacion = array("Detalle", "Cantidad", "Precio","SubTotal");
// Carga de datos

$pdf->AddPage();

$pdf->SetFont('Arial','U',17);
$pdf->Cell(260,7,'Reporte General de Facturación',0,0,'C',false);
$pdf->Ln();
$pdf->SetFont('Arial','U',14);
$pdf->Cell(260,7,"Empresa: ".strtoupper($empresa),0,0,'C',false);
$pdf->Ln();
$pdf->Cell(260,7,'Fecha: '.date('Y-m-d'),0,0,'C',false);
$pdf->Ln();

$pdf->SetFont('Arial','',10);
/*
$pdf->ingresosFacturacion($headerFacturacion,$datos,$TotalFacturacion);
*/


$pdf->Ln();

$pdf->SetFont('Arial','',13);

$nombreTurno = "rptFacturacionGeneral-".$fecha.".pdf";

$pdf->Output($nombreTurno,'D');

/*
require('fpdf.php');

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);
$pdf->Cell(40,10,'¡Hola, Mundo!');
$pdf->Output();
*/
?>

