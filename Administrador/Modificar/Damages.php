<?php
@session_start();
$objeto = new ClsConnection();

	if (isset($_POST["Modificar"]))
	{
		$datoPres["calidad_entrega"] = $_POST["calidad"];
        $datoAct["calidad"] = $_POST["calidad"];

		$condicionPres = "idPrestamo = ".$_GET["Prestamo"]."";
		$rsPres = $objeto -> SQL_modificar("prestamo", $datoPres, $condicionPres);

        $condicionAct = "numero_serie = ".$_GET["Serie_Ac"]."";
		$rsAct = $objeto -> SQL_modificar("inventario", $datoAct, $condicionAct);

		echo "<script>alert('CALIDAD MODIFICADA'); window.location='?pagina=Prestamos.php&opcion=all';</script>";
	}
	$tabla = "inventario";
	$consulta = $objeto -> SQL_consulta_condicional($tabla, "*", "numero_serie = ".$_GET["Serie_Ac"]."");
	while ($fila = $consulta -> fetch_assoc())
	{
		echo "
			<div class='row d-flex justify-content-center'>
				<div class='col-4 m-3 s-1 p-3 border border-dark rounded-3 d-block' style='background-color:#F5F5F5'>
					<form class='row g-3 needs-validation' method='post'>
                        <div class='col-12'>
                            <label class='form-label' for='calidad'>Seleccione la nueva calidad del activo ".$_GET["Serie_Ac"]."</label>
                            <select name='calidad' class='form-select' required>";
                                    $calidad = "$fila[calidad]";

                                        echo "<Option value='Excelente'";
                                        if ($calidad == "Excelente")
                                        {
                                            echo "selected";
                                        }
                                        echo ">Excelente</Option>";

                                        echo "<Option value='Muy bueno'";
                                        if ($calidad == 'Muy bueno')
                                        {
                                            echo "selected";
                                        }
                                        echo ">Muy bueno</Option>";

                                        echo "<Option value='Bueno'";
                                        if ($calidad == 'Bueno')
                                        {
                                            echo "selected";
                                        }
                                        echo ">Bueno</Option>";

                                        echo "<Option value='Malo'";
                                        if ($calidad == 'Malo')
                                        {
                                            echo "selected";
                                        }
                                        echo ">Malo</Option>";

                                        echo "<Option value='Necesita reparación'";
                                        if ($calidad == 'Necesita reparación')
                                        {
                                            echo "selected";
                                        }
                                        echo ">Necesita reparación</Option>";
                                }
                            echo"</select>
                        </div>
						<div class='col-12'>
							<input class='btn btn-success' type='submit' name='Modificar' value='Modificar'>
                            <td><a class='btn btn-danger' href='Administrador.php?pagina=Modificar/Reportar.php&Prestamo=$_GET[Prestamo]'>Reportar</a></td>
						</div>
					</form>
				</div>
			</div>
			";
?>

