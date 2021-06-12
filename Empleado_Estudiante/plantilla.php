<?php 
	ob_start();
	require '../Administrador/fpdf/fpdf.php';
	date_default_timezone_set('America/El_Salvador');

	class PDF extends FPDF 
	{
		function Header()
		{
			$this->Cell(0,10, "", 0, 1);
			$this->Image('../images/logoJPG.jpg', 8, 17, 60 );
			$this->SetFont('Arial','',10);
			$this->Cell(20);
			$this->Cell(175,5, utf8_decode('ESCUELA ESPECIALIZADA EN INGENIERÍA ITCA-FEPADE'),10,1,'C');
			$this->Cell(195,5, utf8_decode('SISTEMA DE INVENTARIO DE ACTIVOS FIJOS'),10,0,'C');
			$this->Cell(60,5, date("Y-m-d G:i"),10,0,'R');
			$this->Ln(10);
		}
		
		function Footer()
		{
			$this->SetY(-15);
			$this->SetFont('Arial','I', 8);
			$this->Cell(0,10, 'Pagina '.$this->PageNo().'/{nb}',0,0,'C' );
		}		
	}
?>