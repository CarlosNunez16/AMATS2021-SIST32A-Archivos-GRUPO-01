<?php
@session_start();
$objeto = new ClsConnection();

	if (isset($_POST["Modificar"]))
	{
        $datos["justificacion"] = $_POST["justificacion"];

		$condicion = "idReasignaciones = ".$_GET["idReasignaciones"]."";
		$rs = $objeto -> SQL_modificar("reasignaciones", $datos, $condicion);
		echo "<script>alert('REASIGNACIÓN EDITADA'); window.location='?pagina=ConsReasignaciones.php&opcion=all';</script>";
	}
	$tabla = "reasignaciones";
	$consulta = $objeto -> SQL_consulta_condicional($tabla, "justificacion", "idReasignaciones = ".$_GET["idReasignaciones"]."");
	while ($filas = $consulta -> fetch_assoc())
	{
        echo"
            <div class='row d-flex justify-content-center'>
                <div class='col-5 m-3 s-1 p-3 border border-dark rounded-3 d-block' style='background-color:#F5F5F5'>
                    <h1 class='text-center fs-4'>MODIFICAR REASIGNACIÓN</h1>
                    <form class='row g-3 needs-validation' method='post'>
                        <div class='col-md-12'>
                            <label class='form-label' for='justificacion'>Justificación: </label>
                            <div class='form-floating'>
                                <textarea class='form-control' name='justificacion' required>$filas[justificacion]</textarea>
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