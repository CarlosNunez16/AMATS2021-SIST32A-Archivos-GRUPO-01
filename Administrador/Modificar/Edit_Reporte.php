<?php
@session_start();
$objeto = new ClsConnection();

	if (isset($_POST["Modificar"]))
	{
        $datos["detalles"] = $_POST["descripcion"];

		$condicion = "idDanos = ".$_GET["idDanos"]."";
		$rs = $objeto -> SQL_modificar("reportes", $datos, $condicion);
		echo "<script>alert('REPORTE EDITADO'); window.location='?pagina=Reporte_daños.php';</script>";
	}
	$tabla = "reportes";
	$consulta = $objeto -> SQL_consulta_condicional($tabla, "detalles", "idDanos = ".$_GET["idDanos"]."");
	while ($filas = $consulta -> fetch_assoc())
	{
        echo"
            <div class='row d-flex justify-content-center'>
                <div class='col-5 m-3 s-1 p-3 border border-dark rounded-3 d-block' style='background-color:#F5F5F5'>
                    <form class='row g-3 needs-validation' method='post'>
                        <div class='col-md-12'>
                            <label class='form-label' for='descripcion'>Detalles del reporte: </label>
                            <div class='form-floating'>
                                <textarea class='form-control' name='descripcion' required>$filas[detalles]</textarea>
                                <label for='floatingTextarea'>Escriba aquí</label>
                            </div>
                        </div>
                        <div class='col-12'>
                            <input class='btn btn-success' type='submit' name='Modificar' value='Modificar'>
                            <a class='btn btn-danger' href='Administrador.php?pagina=Reporte_daños.php'>Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        ";
	}
?>