<?php
@session_start();
$objeto = new ClsConnection();

	if (isset($_POST["Modificar"]))
	{
        $datos["refacciones"] = $_POST["refacciones"];

		$condicion = "idRefacciones = ".$_GET["idRefacciones"]."";
		$rs = $objeto -> SQL_modificar("refacciones", $datos, $condicion);
		echo "<script>alert('REFACCIONES EDITADAS'); window.location='?pagina=Refacciones.php';</script>";
	}
	$tabla = "refacciones";
	$consulta = $objeto -> SQL_consulta_condicional($tabla, "refacciones", "idRefacciones = ".$_GET["idRefacciones"]."");
	while ($fila = $consulta -> fetch_assoc())
	{
        echo"
            <div class='row d-flex justify-content-center'>
                <div class='col-5 m-3 s-1 p-3 border border-dark rounded-3 d-block' style='background-color:#F5F5F5'>
                    <form class='row g-3 needs-validation' method='post'>
                        <div class='col-md-12'>
                            <label class='form-label' for='refacciones'>Listado de refacciones: </label>
                            <div class='form-floating'>
                                <textarea class='form-control' name='refacciones'>$fila[refacciones]</textarea>
                                <label for='floatingTextarea'>Escriba aquí</label>
                            </div>
                        </div>
                        <div class='col-12'>
                            <input class='btn btn-success' type='submit' name='Modificar' value='Modificar'>
                        </div>
                    </form>
                </div>
            </div>
        ";
	}
?>