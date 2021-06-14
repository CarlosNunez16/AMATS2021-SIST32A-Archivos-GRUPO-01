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
			<div class='row d-flex justify-content-center'>
				<div class='col-5 m-3 s-1 p-3 border border-dark rounded-3 d-block' style='background-color:#F5F5F5'>
					<form class='row g-3 needs-validation' method='post'>
						<div class='col-md-6'>
							<label for='nombre' class='form-label'>Nombre</label>
							<input type='text' value='$fila[nombre]' class='form-control' name='nombre'  required>
						</div>
						<div class='col-md-12'>
							<label for='descripcion' class='form-label'>Descripción:</label>
							<input type='textarea' value='$fila[descripcion]' class='form-control' name='descripcion' required>
						</div>
						<div class='col-12'>
							<input class='btn btn-success' type='submit' name='Modificar' value='Modificar'>
							<a class='btn btn-danger' href='Administrador.php?pagina=Grupos.php'>Cancelar</a>
						</div>
					</form>
				</div>
			</div>
			";
	}
?>