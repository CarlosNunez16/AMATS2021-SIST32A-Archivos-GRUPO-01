<?php
@session_start();
$objeto = new ClsConnection();

	if (isset($_POST["Modificar"]))
	{
		$datos["nombre"] = $_POST["nombre"];
		$datos["descripcion"] = $_POST["descripcion"];

		$condicion = "idGrupo = ".$_GET["grupo"]."";
		$rs = $objeto -> SQL_modificar("grupos", $datos, $condicion);
		echo "<script>alert('GRUPO EDITADO'); window.location='?pagina=Grupos.php';</script>";
	}
	$tabla = "grupos";
	$consulta = $objeto -> SQL_consulta_condicional($tabla, "*", "idGrupo = ".$_GET["grupo"]."");
	while ($fila = $consulta -> fetch_assoc())
	{
		echo "
			<form method='post'>
				<label for='nombre'>Nombre: </label>
				<input type='text' name='nombre' value='$fila[nombre]' required>

				<label for='descripcion'>Descripción: </label>
				<input type='text' name='descripcion' value='$fila[descripcion]' required>

				<input type='submit' name='Modificar' value='Modificar'>
			</form>
		";
	}
?>