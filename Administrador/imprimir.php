<?php
	ob_start();
	include 'plantilla.php';
	require_once("../Connect.php"); 
    $objeto = new ClsConnection();
	

if($_GET["tabla"] == "inventario")
{
	$tabla = "inventario INNER JOIN grupos ON (inventario.idGrupo_FK2 = grupos.idGrupo) INNER JOIN subgrupos ON (inventario.idSubgrupo_FK = subgrupos.idSubgrupo) INNER JOIN usuarios ON (inventario.carnet_FK = usuarios.carnet)";
    $campos = "inventario.idActivo, grupos.nombre AS nombre_G, subgrupos.nombre AS nombre_SG, inventario.nombre as Nombre, marca, modelo, color, numero_serie, usuarios.nombres AS User_Name, usuarios.apellidos AS User_Lastname,usuarios.carnet as User, ubicacion, fecha_asignacion, calidad";
    $consulta = $objeto -> SQL_consulta($tabla, $campos);

	$pdf = new PDF('L','mm','Letter');
	$pdf->SetLeftMargin(15); 
	$pdf->AliasNbPages(); 
	$pdf->AddPage();
	
	// $pdf->Cell(0,10, "", 0, 1);
	$pdf->SetFont('Arial','B',15);
	$pdf->Cell(250,10, 'REPORTE DE INVENTARIO',10,1,'C');
	$pdf->Ln(5);

	$pdf->SetFillColor(232,232,232);
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(10,6,'ID',1,0,'C',1);
	$pdf->Cell(30,6,'Grupo',1,0,'C',1);
	$pdf->Cell(30,6,'Subgrupo',1,0,'C',1);
	$pdf->Cell(40,6,'Nombre',1,0,'C',1);
	$pdf->Cell(35,6,'Marca',1,0,'C',1);
	$pdf->Cell(25,6,'Encargado',1,0,'C',1);
	$pdf->Cell(25,6,utf8_decode('Ubicación'),1,0,'C',1);
	$pdf->Cell(30,6,utf8_decode('Fecha de asignación'),1,0,'C',1);
	$pdf->Cell(25,6,'Calidad',1,1,'C',1);
	
	
	while($row = $consulta->fetch_assoc())
	{
		$pdf->SetFont('Arial','',8);
		$pdf->Cell(10,6,$row['idActivo'],1,0,'C', 1);
		$pdf->Cell(30,6,utf8_decode($row['nombre_G']),1,0,'C', 1);
		$pdf->Cell(30,6,utf8_decode($row['nombre_SG']),1,0,'C', 1);
		$pdf->Cell(40,6,utf8_decode($row['Nombre']),1,0,'C', 1);
		$pdf->Cell(35,6,utf8_decode($row['marca']),1,0,'C', 1);
		$pdf->Cell(25,6,utf8_decode($row['User']),1,0,'C', 1);
		$pdf->Cell(25,6,utf8_decode($row['ubicacion']),1,0,'C', 1);
		$pdf->Cell(30,6,utf8_decode($row['fecha_asignacion']),1,0,'C', 1);
		$pdf->Cell(25,6,utf8_decode($row['calidad']),1,1,'C', 1);
	}
	$pdf->Output();
}
elseif($_GET["tabla"] == "EnPrestamo")
{
	$tabla = "inventario INNER JOIN prestamo ON (inventario.idActivo = prestamo.idActivo_FK) ";
	$campos = "idActivo, nombre, estado";
	$condicion= "estado = 'En préstamo' OR estado = 'No entregó'";
	$consulta = $objeto -> SQL_consulta_condicional($tabla, $campos, $condicion);

	$pdf = new PDF('L','mm','Letter'); 
	$pdf->AliasNbPages(); 
	$pdf->AddPage();
	

	$pdf->SetFont('Arial','B',15);
	$pdf->Cell(250,10, utf8_decode('REPORTE DE ACTIVOS FIJOS EN PRÉSTAMO'),10,1,'C');
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
		$pdf->Cell(40,6,utf8_decode($row['estado']),1,1,'C', 1);
	}
	$pdf->Output();	
}
elseif($_GET["tabla"] == "EnMantenimiento")
{
	$tabla = "inventario INNER JOIN mantenimientos ON (inventario.idActivo = mantenimientos.idActivo_FK2)";
	$campos = "idActivo, nombre";
	$condicion= "calidad_nueva = 'Sin revisar'";
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
elseif($_GET["tabla"] == "disponibles")
{
	$tabla = "inventario";
	$campos = "idActivo, nombre";
	$condicion= "(SELECT COUNT(*) FROM prestamo WHERE inventario.idActivo = prestamo.idActivo_FK AND estado = 'En préstamo' OR estado = 'No entregó')=0 AND (SELECT COUNT(*) FROM mantenimientos WHERE inventario.idActivo = mantenimientos.idActivo_FK2 AND calidad_nueva = 'Sin revisar')=0";
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
		$pdf->Cell(40,6,utf8_decode("Disponible"),1,1,'C', 1);
	}
	$pdf->Output();	
}
elseif($_GET["tabla"] == "prestamos")
{
	$tabla = "prestamo INNER JOIN usuarios ON (prestamo.carnet_FK2 = usuarios.carnet) INNER JOIN inventario ON (prestamo.idActivo_FK = inventario.IdActivo)";
	$campos = "idPrestamo, usuarios.carnet  AS carnet, inventario.nombre AS Nombre_Ac, inventario.numero_serie AS Serie_Ac, fecha_prestamo, hora_pretamo, fecha_entrega, estado, calidad_entrega";
    $consulta = $objeto -> SQL_consulta($tabla, $campos);

	$pdf = new PDF('L','mm','Letter');
	$pdf->SetLeftMargin(12); 
	$pdf->AliasNbPages(); 
	$pdf->AddPage();
	
	// $pdf->Cell(0,10, "", 0, 1);
	$pdf->SetFont('Arial','B',15);
	$pdf->Cell(250,10,utf8_decode('REPORTE DE PRÉSTAMOS'),10,1,'C');
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
elseif($_GET["tabla"] == "mantenimientos")
{
	$tabla = "mantenimientos INNER JOIN inventario ON (mantenimientos.idActivo_FK2 = inventario.idActivo) INNER JOIN usuarios ON (mantenimientos.carnet_FK3 = usuarios.carnet)";
	$campos = "idMantenimiento, inventario.nombre AS Activo, fecha, detalles, usuarios.carnet as carnet, total";
    $consulta = $objeto -> SQL_consulta($tabla, $campos);

	$pdf = new PDF('L','mm','Letter');
	$pdf->AliasNbPages(); 
	$pdf->AddPage();

	$pdf->SetFont('Arial','B',15);
	$pdf->Cell(250,10,utf8_decode('REPORTE DE MANTENIMIENTOS'),10,1,'C');
	$pdf->Ln(5);

	$pdf->SetLeftMargin(82); 
	$pdf->SetFillColor(232,232,232);
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(10,6,'ID',1,0,'C',1);
	$pdf->Cell(15,6,'Usuario',1,0,'C',1); 
	$pdf->Cell(30,6,'ActivoFijo',1,0,'C',1);
	$pdf->Cell(25,6,'Fecha',1,0,'C',1);
	$pdf->Cell(25,6,utf8_decode('Total ($)'),1,1,'C',1);
	
	
	while($row = $consulta->fetch_assoc())
	{
		$pdf->SetFont('Arial','',8);
		$pdf->Cell(10,6,$row['idMantenimiento'],1,0,'C', 1);
		$pdf->Cell(15,6,$row['carnet'],1,0,'C', 1);
		$pdf->Cell(30,6,utf8_decode($row['Activo']),1,0,'C', 1);
		$pdf->Cell(25,6,$row['fecha'],1,0,'C', 1);
		$pdf->Cell(25,6,$row['total'],1,1,'C', 1);
	}
	$pdf->Output();
}
elseif($_GET["tabla"] == "usuarios")
{
	$tabla = 'usuarios';
	$consulta = $objeto -> SQL_consulta($tabla, "*");

	$pdf = new PDF('L','mm','Letter');
	$pdf->AliasNbPages(); 
	$pdf->AddPage();

	$pdf->SetFont('Arial','B',15);
	$pdf->Cell(250,10,utf8_decode('REPORTE DE USUARIOS'),10,1,'C');
	$pdf->Ln(5);

	$pdf->SetLeftMargin(12); 
	$pdf->SetFillColor(232,232,232);
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(15,6,'Carnet',1,0,'C',1);
	$pdf->Cell(35,6,'Nombres',1,0,'C',1); 
	$pdf->Cell(35,6,'Apellidos',1,0,'C',1);
	$pdf->Cell(40,6,'Correo',1,0,'C',1);
	$pdf->Cell(25,6,'Tipo de Usuario',1,0,'C',1);
	$pdf->Cell(77,6,'Carrera',1,0,'C',1);
	$pdf->Cell(30,6,'Cantidad de reportes',1,1,'C',1);
	
	
	while($row = $consulta->fetch_assoc())
	{
		$pdf->SetFont('Arial','',8);
		$pdf->Cell(15,6,$row['carnet'],1,0,'C', 1);
		$pdf->Cell(35,6,utf8_decode($row['nombres']),1,0,'C', 1);
		$pdf->Cell(35,6,utf8_decode($row['apellidos']),1,0,'C', 1);
		$pdf->Cell(40,6,$row['correo'],1,0,'C', 1);
		$pdf->Cell(25,6,$row['tipo_usuario'],1,0,'C', 1);
		$pdf->Cell(77,6,utf8_decode($row['carrera']),1,0,'C', 1);
		$pdf->Cell(30,6,$row['cantidad_reportes'],1,1,'C', 1);
	}
	$pdf->Output();
}
elseif($_GET["tabla"] == "baneados")
{
	$tabla = 'usuarios';
	$condicion = " where cantidad_reportes > 5";
	$consulta = $objeto -> SQL_consulta($tabla.$condicion, "*");

	$pdf = new PDF('L','mm','Letter');
	$pdf->AliasNbPages(); 
	$pdf->AddPage();

	$pdf->SetFont('Arial','B',15);
	$pdf->Cell(250,10,utf8_decode('REPORTE DE USUARIOS BANEADOS'),10,1,'C');
	$pdf->Ln(5);

	$pdf->SetLeftMargin(12); 
	$pdf->SetFillColor(232,232,232);
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(15,6,'Carnet',1,0,'C',1);
	$pdf->Cell(35,6,'Nombres',1,0,'C',1); 
	$pdf->Cell(35,6,'Apellidos',1,0,'C',1);
	$pdf->Cell(40,6,'Correo',1,0,'C',1);
	$pdf->Cell(25,6,'Tipo de Usuario',1,0,'C',1);
	$pdf->Cell(77,6,'Carrera',1,0,'C',1);
	$pdf->Cell(30,6,'Cantidad de reportes',1,1,'C',1);
	
	
	while($row = $consulta->fetch_assoc())
	{
		$pdf->SetFont('Arial','',8);
		$pdf->Cell(15,6,$row['carnet'],1,0,'C', 1);
		$pdf->Cell(35,6,utf8_decode($row['nombres']),1,0,'C', 1);
		$pdf->Cell(35,6,utf8_decode($row['apellidos']),1,0,'C', 1);
		$pdf->Cell(40,6,$row['correo'],1,0,'C', 1);
		$pdf->Cell(25,6,$row['tipo_usuario'],1,0,'C', 1);
		$pdf->Cell(77,6,utf8_decode($row['carrera']),1,0,'C', 1);
		$pdf->Cell(30,6,$row['cantidad_reportes'],1,1,'C', 1);
	}
	$pdf->Output();
}
elseif($_GET["tabla"] == "reasignaciones")
{
	$tabla = "reasignaciones INNER JOIN inventario ON (reasignaciones.idActivo_FK3 = inventario.idActivo)";
    $campos = "idReasignaciones, inventario.nombre as Activo, usuario_anterior, usuario_nuevo, calidad_actual, justificacion, fecha";
	$consulta = $objeto -> SQL_consulta($tabla, $campos);

	$pdf = new PDF('L','mm','Letter');
	$pdf->AliasNbPages(); 
	$pdf->AddPage();

	$pdf->SetFont('Arial','B',15);
	$pdf->Cell(250,10,utf8_decode('REPORTE DE REASIGNACIONES'),10,1,'C');
	$pdf->Ln(5);

	$pdf->SetLeftMargin(14); 
	$pdf->SetFillColor(232,232,232);
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(15,6,'ID',1,0,'C',1);
	$pdf->Cell(35,6,'Activo',1,0,'C',1); 
	$pdf->Cell(25,6,'Usuario anterior',1,0,'C',1);
	$pdf->Cell(25,6,'Nuevo usuario',1,0,'C',1);
	$pdf->Cell(30,6,'Calidad registrada',1,0,'C',1);
	$pdf->Cell(90,6,utf8_decode('Justificación'),1,0,'C',1);
	$pdf->Cell(30,6,'Fecha',1,1,'C',1);
	
	
	while($row = $consulta->fetch_assoc())
	{
		$pdf->SetFont('Arial','',8);
		$pdf->Cell(15,6,$row['idReasignaciones'],1,0,'C', 1);
		$pdf->Cell(35,6,utf8_decode($row['Activo']),1,0,'C', 1);
		$pdf->Cell(25,6,$row['usuario_anterior'],1,0,'C', 1);
		$pdf->Cell(25,6,$row['usuario_nuevo'],1,0,'C', 1);
		$pdf->Cell(30,6,utf8_decode($row['calidad_actual']),1,0,'C', 1);
		$pdf->Cell(90,6,utf8_decode($row['justificacion']),1,0,'C', 1);
		$pdf->Cell(30,6,$row['fecha'],1,1,'C', 1);
	}
	$pdf->Output();
}
?>