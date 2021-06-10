<h1 class="text-center m-3 fs-2">REPORTE DE DAÑOS</h1>
<div class="row d-flex justify-content-center">
	<div class="col-3 m-3 s-1 p-3 border border-dark rounded-3 d-block" style="background-color:#F5F5F5">
        <h1 class="text-center fs-4">CONSULTA</h1>
		<form class="row g-3 needs-validation" name='form1' method="post" target='_self'>
            <div class="col-md-12">
                <label class='form-label' for='dato'>Ingresar fecha:</label>
                <input class='form-control' type='date' max="<?php echo date("Y-m-d");?>" name='dato' required>     
            </div> 
            <div class="col-md-12">
                <input class='btn btn-success' type='submit' name='buscar'  value='Buscar'>
            </div>
        </form>
    </div>
</div>

<?php
if(isset($_POST["buscar"]))
{
	$dato = $_POST["dato"];
	echo "
    <div class='row d-flex justify-content-center'>
        <div class='col-6 m-3'>
            <table class='table table-dark table-striped table-hover'>
            <form method='post'>
                <thead>
                    <tr>
                        <th scope='col'></th>
                        <th scope='col'>ID</th>
                        <th scope='col'>ID Préstamo</th>
                        <th scope='col'>Fecha</th>
                        <th scope='col'>Detalles</th>
                        <th scope='col'>Acción</th>
                    </tr>
                </thead>
                <tbody>";
    
                    $tabla = "reportes INNER JOIN prestamo ON (reportes.idPrestamo_FK = prestamo.idPrestamo) where fecha like '%$dato%'";
                    $campos = "idDanos, idPrestamo_FK, fecha, detalles";
                    $consulta = $objeto -> SQL_consulta($tabla, $campos);
                    
                    if (mysqli_num_rows($consulta) < 1) 
                    {
                        echo "<tr><td colspan='14' class='text-center'>NO HAY COINCIDENCIAS.</td></tr>";
                        echo"<script type='text/javascript'>
                                $(document).ready(function(){
                                    $('#BtnEliminar').prop('disabled', true);
                                });
                            </script>"; 
                    }                    
                    else
                    {
                        while ($fila = $consulta -> fetch_assoc()) 
                        {
                            $idPrestamo_FK="$fila[idPrestamo_FK]";
                        echo "<tr>
                                <td><input type='checkbox' id='$fila[idPrestamo_FK]' name='seleccionados[]' value='$fila[idPrestamo_FK]'></td>
                                <th scope='row'>$fila[idDanos]</th>
                                <td>$fila[idPrestamo_FK]</td>
                                <td>$fila[fecha]</td>
                                <td>$fila[detalles]</td>
                                <td><a class='btn btn-warning' href='Administrador.php?pagina=Modificar/Edit_Reporte.php&idDanos=$fila[idDanos]'>Modificar</a></td>
                            </tr>";
                            echo"<script type='text/javascript'>
                                    $(document).ready(function(){
                                        $('#BtnEliminar').prop('disabled', true);
                                        $('#".$idPrestamo_FK."').prop('checked',false);
                                        $('#".$idPrestamo_FK."').click(function(){
                                            if($('#".$idPrestamo_FK."').is(':checked')){
                                                $('#BtnEliminar').prop('disabled', false);
                                            }else{
                                                $('#BtnEliminar').prop('disabled', true);
                                            }
                                        });
                                    });
                                </script>";
                        }
                    }
                    ?>
                        <tr>
                            <td colspan='5'><div class='d-flex justify-content-center'><input class='btn btn-danger justify-content-center' type='submit' id="BtnEliminar" name='eliminar' value='Eliminar'></div></td>
                            <td><div class="d-flex justify-content-center"><a class="btn btn-info" href='Administrador.php?pagina=Reporte_daños.php'>Ver todos</a></div></td>
                        </tr> 
                </tbody>
            </form>
            </table> 
        </div>
    </div>
        <?php
        if(isset($_POST["eliminar"]))
        {
            $seleccionados = $_POST["seleccionados"];

            foreach($seleccionados as $idPrestamo_FK)
            {
                $rs = $objeto -> SQL_eliminar("reportes", "idPrestamo_FK = $idPrestamo_FK");

                $tabla = "prestamo INNER JOIN usuarios ON (prestamo.carnet_FK2 = usuarios.carnet)";
	            $consulta = $objeto -> SQL_consulta_condicional($tabla, "carnet_FK2", "idPrestamo= ".$idPrestamo_FK."");
                while ($fila = $consulta -> fetch_assoc())
	            {
                    $uno=1;
                    $datosUser["cantidad_reportes"]= "cantidad_reportes-".$uno;
                    $condicion = "carnet = $fila[carnet_FK2]";
                    $reporte = $objeto -> SQL_modificarReporte("usuarios", $datosUser, $condicion);
                }


                echo "<script>alert('REPORTE ELIMINADO');window.location='?pagina=Reporte_daños.php';</script>";


            }
        }
}
else{
    echo "
    <div class='row d-flex justify-content-center'>
        <div class='col-6 m-3'>
            <table class='table table-dark table-striped table-hover'>
            <form method='post'> 
                <thead>
                    <tr>
                        <th scope='col'></th>
                        <th scope='col'>ID</th>
                        <th scope='col'>ID Préstamo</th>
                        <th scope='col'>Fecha</th>
                        <th scope='col'>Detalles</th>
                        <th scope='col'>Acción</th>
                    </tr>
                </thead>
                <tbody>";
    
                    $tabla = "reportes INNER JOIN prestamo ON (reportes.idPrestamo_FK = prestamo.idPrestamo)";
                    $campos = "idDanos, idPrestamo_FK, fecha, detalles";
                    $consulta = $objeto -> SQL_consulta($tabla, $campos);
                    
                    if (mysqli_num_rows($consulta) < 1) 
                    {
                        echo "<tr><td colspan='14' class='text-center'>NO HAY REGISTROS.</td></tr>";
                        echo"<script type='text/javascript'>
                                $(document).ready(function(){
                                    $('#BtnEliminar').prop('disabled', true);
                                });
                            </script>"; 
                    }                    
                    else
                    {
                        while ($fila = $consulta -> fetch_assoc()) 
                        {
                            $idPrestamo_FK="$fila[idPrestamo_FK]";
                        echo "<tr>
                                <td><input type='checkbox' id='$fila[idPrestamo_FK]' name='seleccionados[]' value='$fila[idPrestamo_FK]'></td>
                                <th scope='row'>$fila[idDanos]</th>
                                <td>$fila[idPrestamo_FK]</td>
                                <td>$fila[fecha]</td>
                                <td>$fila[detalles]</td>
                                <td><a class='btn btn-warning' href='Administrador.php?pagina=Modificar/Edit_Reporte.php&idDanos=$fila[idDanos]'>Modificar</a></td>
                            </tr>";
                            echo"<script type='text/javascript'>
                                    $(document).ready(function(){
                                        $('#BtnEliminar').prop('disabled', true);
                                        $('#".$idPrestamo_FK."').prop('checked',false);
                                        $('#".$idPrestamo_FK."').click(function(){
                                            if($('#".$idPrestamo_FK."').is(':checked')){
                                                $('#BtnEliminar').prop('disabled', false);
                                            }else{
                                                $('#BtnEliminar').prop('disabled', true);
                                            }
                                        });
                                    });
                                </script>";
                        }
                    }
                        
                    echo"<tr>
                            <td colspan='6'><div class='d-flex justify-content-center'><input class='btn btn-danger justify-content-center' type='submit' id='BtnEliminar' name='eliminar' value='Eliminar'></div></td>
                        </tr>
                    </tbody>
                </form>
                </table> 
            </div>
        </div>";
        if(isset($_POST["eliminar"]))
        {
            $seleccionados = $_POST["seleccionados"];

            foreach($seleccionados as $idPrestamo_FK)
            {
                $rs = $objeto -> SQL_eliminar("reportes", "idPrestamo_FK = $idPrestamo_FK");

                $tabla = "prestamo INNER JOIN usuarios ON (prestamo.carnet_FK2 = usuarios.carnet)";
	            $consulta = $objeto -> SQL_consulta_condicional($tabla, "carnet_FK2", "idPrestamo= ".$idPrestamo_FK."");
                while ($fila = $consulta -> fetch_assoc())
	            {
                    $uno=1;
                    $datosUser["cantidad_reportes"]= "cantidad_reportes-".$uno;
                    $condicion = "carnet = $fila[carnet_FK2]";
                    $reporte = $objeto -> SQL_modificarReporte("usuarios", $datosUser, $condicion);
                }


                echo "<script>alert('REPORTE ELIMINADO');window.location='?pagina=Reporte_daños.php';</script>";


            }
        }
    }
?>