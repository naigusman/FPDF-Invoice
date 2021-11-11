<?php
/*call the FPDF library*/
require('fpdf/fpdf.php');

	
/*A4 width : 219mm*/

$pdf = new FPDF('P','mm','A4');

$pdf->AddPage();
/*output the result*/

/*set font to arial, bold, 14pt*/
$pdf->SetFont('Arial','B',20);

?>