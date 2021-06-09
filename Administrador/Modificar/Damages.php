<?php
@session_start();
$objeto = new ClsConnection();

	if (isset($_POST["Modificar"]))
	{
        $dato["calidad_entrega"] = $_POST["calidad"];

        $tabla = "inventario INNER JOIN prestamo ON (prestamo.idActivo_FK = inventario.IdActivo) where idPrestamo = ".$_GET["Prestamo"]."";

        $consulta = $objeto -> SQL_consulta($tabla, "calidad");
        while ($fila = $consulta -> fetch_assoc())
        { 

            $calidad="$fila[calidad]";
            if($calidad == "Excelente")
            {
                $n=5;
            }
            elseif($calidad == "Muy bueno")
            {
                $n=4;
            }
            elseif($calidad == "Bueno")
            {
                $n=3;
            }
            elseif($calidad == "Malo")
            {
                $n=2;
            }
            elseif($calidad == "Necesita reparación")
            {
                $n=1;
            }
            if($dato["calidad_entrega"] == "Excelente")
            {
                $m=5;
            }
            elseif($dato["calidad_entrega"] == "Muy bueno")
            {
                $m=4;
            }
            elseif($dato["calidad_entrega"] == "Bueno")
            {
                $m=3;
            }
            elseif($dato["calidad_entrega"] == "Malo")
            {
                $m=2;
            }
            elseif($dato["calidad_entrega"] == "Necesita reparación")
            {
                $m=1;
            }
  
            if($n > $m)
            {
                $datoPres["calidad_entrega"] = $_POST["calidad"];  
                $condicionPres = "idPrestamo = ".$_GET["Prestamo"]."";
                $rsPres = $objeto -> SQL_modificar("prestamo", $datoPres, $condicionPres);

                $datoAct["calidad"] = $_POST["calidad"];
                $condicionAct = "numero_serie like '".$_GET["Serie_Ac"]."'";
                $rsAct = $objeto -> SQL_modificar("inventario", $datoAct, $condicionAct);

                $tabla = "prestamo";
                $consulta = $objeto -> SQL_consulta($tabla, "idPrestamo");
                while ($fila = $consulta -> fetch_assoc())
                {         
                    $datos["estado"] = "Revisado";
                    $condicion = "idPrestamo = ".$_GET["Prestamo"]."";
                    $rs = $objeto -> SQL_modificar("prestamo", $datos, $condicion);
                }
                echo    "<script>
                                var resultado = window.confirm('La calidad ha bajado. ¿Quieres reportar a este usuario?');
                                if (resultado === true) 
                                {
                                    window.location='?pagina=Modificar/Reportar.php&Prestamo=".$_GET["Prestamo"]."&User=".$_GET["User"]."';
                                } 
                                else 
                                {
                                    alert('CALIDAD MODIFICADA'); window.location='?pagina=Prestamos.php&opcion=all';
                                }
                            </script>";
            }
            elseif($n==$m)
            {
                $tabla = "prestamo";
                $consulta = $objeto -> SQL_consulta($tabla, "idPrestamo");
                while ($fila = $consulta -> fetch_assoc())
                {         
                    $datos["estado"] = "Revisado";
                    $condicion = "idPrestamo = ".$_GET["Prestamo"]."";
                    $rs = $objeto -> SQL_modificar("prestamo", $datos, $condicion);
                }
                echo "<script>alert('PRESTAMO REVISADO'); window.location='?pagina=Prestamos.php&opcion=all';</script>";
            }
        }
	}
	$tabla = "inventario";
	$consulta = $objeto -> SQL_consulta_condicional($tabla, "*", "numero_serie like '".$_GET["Serie_Ac"]."'");
	while ($fila = $consulta -> fetch_assoc())
	{
		echo "
			<div class='row d-flex justify-content-center'>
				<div class='col-5 m-3 s-1 p-3 border border-dark rounded-3 d-block' style='background-color:#F5F5F5'>
					<form class='row g-3 needs-validation' method='post'>
                        <label class='form-label' for='calidad'>Seleccione la nueva calidad del activo de ID: ".$_GET["Serie_Ac"]." (Calidad $fila[calidad])</label>
                        <div class='col-6'>
                            <select name='calidad' class='form-select' required>";
                                    $calidad = "$fila[calidad]";

                                        if($calidad == "Excelente")
                                        {
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
                                        elseif($calidad == "Muy bueno")
                                        {
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
                                        elseif($calidad == "Bueno")
                                        {
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
                                        elseif($calidad == "Malo")
                                        {
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
                                        elseif($calidad == "Necesita reparación")
                                        {
                                            echo "<Option value='Necesita reparación'";
                                            if ($calidad == 'Necesita reparación')
                                            {
                                                echo "selected";
                                            }
                                            echo ">Necesita reparación</Option>";
                                        }
                                }
                            echo"</select>
                        </div>
						<div class='col-12'>
							<input class='btn btn-success' type='submit' name='Modificar' value='Modificar'>
						</div>
					</form>
				</div>
			</div>
			";
?>

