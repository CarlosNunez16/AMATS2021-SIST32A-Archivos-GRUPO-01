<?php
	ob_start();
	@session_start();
	include 'plantilla.php';
	require_once("../Connect.php"); 
    $objeto = new ClsConnection();

if($_GET["tabla"] == "misPrestamos")
{
	$tabla = "prestamo INNER JOIN usuarios ON (prestamo.carnet_FK2 = usuarios.carnet) INNER JOIN inventario ON (prestamo.idActivo_FK = inventario.IdActivo) where carnet = ".$_SESSION["Estudiante_Empleado"][0]."";
	$campos = "idPrestamo, usuarios.carnet  AS carnet, inventario.nombre AS Nombre_Ac, inventario.numero_serie AS Serie_Ac, fecha_prestamo, hora_pretamo, fecha_entrega, estado, calidad_entrega";
    $consulta = $objeto -> SQL_consulta($tabla, $campos);

	$pdf = new PDF('L','mm','Letter');
	$pdf->SetLeftMargin(12); 
	$pdf->AliasNbPages(); 
	$pdf->AddPage();
	
	// $pdf->Cell(0,10, "", 0, 1);
	$pdf->SetFont('Arial','B',15);
	$pdf->Cell(250,10,utf8_decode('REPORTE DE MIS PRÉSTAMOS'),10,1,'C');
	$pdf->Ln(5);

	$pdf->SetFillColor(232,232,232);
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(10,6,'ID',1,0,'C',1);
	$pdf->Cell(15,6,'Usuario',1,0,'C',1);
	$pdf->Cell(40,6,'Activo Fijo',1,0,'C',1);
	$pdf->Cell(40,6,'Serie',1,0,'C',1);
	$pdf->Cell(30,6,utf8_decode('Fecha de préstamo'),1,0,'C',1);
	$pdf->Cell(30,6,utf8_decode('Hora de préstamo'),1,0,'C',1);
	$pdf->Cell(30,6,utf8_decode('Fecha de entrega'),1,0,'C',1);
	$pdf->Cell(25,6,utf8_decode('Estado'),1,0,'C',1);
	$pdf->Cell(35,6,utf8_decode('Calidad en la entrega'),1,1,'C',1);
	
	
	while($row = $consulta->fetch_assoc())
	{
		$pdf->SetFont('Arial','',8);
		$pdf->Cell(10,6,$row['idPrestamo'],1,0,'C', 1);
		$pdf->Cell(15,6,$row['carnet'],1,0,'C', 1);
		$pdf->Cell(40,6,utf8_decode($row['Nombre_Ac']),1,0,'C', 1);
		$pdf->Cell(40,6,$row['Serie_Ac'],1,0,'C', 1);
		$pdf->Cell(30,6,$row['fecha_prestamo'],1,0,'C', 1);
		$pdf->Cell(30,6,$row['hora_pretamo'],1,0,'C', 1);
		$pdf->Cell(30,6,$row['fecha_entrega'],1,0,'C', 1);
		$pdf->Cell(25,6,utf8_decode($row['estado']),1,0,'C', 1);
		$pdf->Cell(35,6,utf8_decode($row['calidad_entrega']),1,1,'C', 1);
	}
	$pdf->Output();
}
elseif($_GET["tabla"] == "misMantenimientos")
{
	$tabla = "mantenimientos INNER JOIN inventario ON (mantenimientos.idActivo_FK2 = inventario.idActivo) INNER JOIN usuarios ON (mantenimientos.carnet_FK3 = usuarios.carnet) where carnet = ".$_SESSION["Estudiante_Empleado"][0]."";
	$campos = "idMantenimiento, inventario.nombre AS Activo, fecha, detalles, usuarios.carnet as carnet, total";
    $consulta = $objeto -> SQL_consulta($tabla, $campos);

	$pdf = new PDF('L','mm','Letter');
	$pdf->AliasNbPages(); 
	$pdf->AddPage();

	$pdf->SetFont('Arial','B',15);
	$pdf->Cell(250,10,utf8_decode('REPORTE DE MANTENIMIENTOS'),10,1,'C');
	$pdf->Ln(5);

	$pdf->SetLeftMargin(80); 
	$pdf->SetFillColor(232,232,232);
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(10,6,'ID',1,0,'C',1);
	$pdf->Cell(15,6,'Usuario',1,0,'C',1); 
	$pdf->Cell(35,6,'ActivoFijo',1,0,'C',1);
	$pdf->Cell(25,6,'Fecha',1,0,'C',1);
	$pdf->Cell(25,6,utf8_decode('Total ($)'),1,1,'C',1);
	
	
	while($row = $consulta->fetch_assoc())
	{
		$pdf->SetFont('Arial','',8);
		$pdf->Cell(10,6,$row['idMantenimiento'],1,0,'C', 1);
		$pdf->Cell(15,6,$row['carnet'],1,0,'C', 1);
		$pdf->Cell(35,6,utf8_decode($row['Activo']),1,0,'C', 1);
		$pdf->Cell(25,6,$row['fecha'],1,0,'C', 1);
		$pdf->Cell(25,6,$row['total'],1,1,'C', 1);
	}
	$pdf->Output();
}
elseif($_GET["tabla"] == "EnMantenimientoMy")
{
	$tabla = "inventario INNER JOIN mantenimientos ON (inventario.idActivo = mantenimientos.idActivo_FK2)";
	$campos = "idActivo, nombre";
	$condicion= "calidad_nueva = 'Sin revisar' and carnet_FK3 = ".$_SESSION["Estudiante_Empleado"][0]."";
	$consulta = $objeto -> SQL_consulta_condicional($tabla, $campos, $condicion);

	$pdf = new PDF('L','mm','Letter'); 
	$pdf->AliasNbPages(); 
	$pdf->AddPage();
	

	$pdf->SetFont('Arial','B',15);
	$pdf->Cell(250,10, utf8_decode('REPORTE DE ACTIVOS FIJOS EN MANTENIMIENTO'),10,1,'C');
	$pdf->Ln(5);

	$pdf->SetLeftMargin(90);
	$pdf->SetFillColor(232,232,232);
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(10,6,'ID',1,0,'C',1);
	$pdf->Cell(40,6,utf8_decode('Nombre'),1,0,'C',1);
	$pdf->Cell(40,6,utf8_decode('Estado'),1,1,'C',1);
	
	
	while($row = $consulta->fetch_assoc())
	{
		$pdf->SetFont('Arial','',8);
		$pdf->Cell(10,6,$row['idActivo'],1,0,'C', 1);
		$pdf->Cell(40,6,utf8_decode($row['nombre']),1,0,'C', 1);
		$pdf->Cell(40,6,utf8_decode("Sin terminar"),1,1,'C', 1);
	}
	$pdf->Output();	
}
?>