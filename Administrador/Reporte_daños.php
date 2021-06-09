<div class="row d-flex justify-content-center">
	<div class="col-3 m-3 s-1 p-3 border border-dark rounded-3 d-block" style="background-color:#F5F5F5">
		<form class="row g-3 needs-validation" name='form1' method="post" target='_self'>
            <div class="col-md-12">
                <label class='form-label' for='dato'>Ingresar fecha:</label>
                <input class='form-control' type='date' max="<?php date("Y-m-d");?>" name='dato' required>     
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
                    }                    
                    else
                    {
                        while ($fila = $consulta -> fetch_assoc()) 
                        {
                        echo "<tr>
                                <th scope='row'>$fila[idDanos]</th>
                                <td>$fila[idPrestamo_FK]</td>
                                <td>$fila[fecha]</td>
                                <td>$fila[detalles]</td>
                                <td><a class='btn btn-warning' href='Administrador.php?pagina=Modificar/Edit_Reporte.php&idDanos=$fila[idDanos]'>Modificar</a></td>
                            </tr>";
                        }
                    }
                    ?>
                        <tr>
                            <td colspan="4"><div class="d-flex justify-content-center"><a class="btn btn-info" href='Administrador.php?pagina=Reporte_daños.php'>Ver todos</a></div></td>
                        </tr>
                </tbody>
            </form>
            </table> 
        </div>
    </div>
        <?php
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
                        <th scope='col' colspan='2'>Detalles</th>
                        <th scope='col'>Acción</th>
                    </tr>
                </thead>
                <tbody>";
    
                    $tabla = "reportes INNER JOIN prestamo ON (reportes.idPrestamo_FK = prestamo.idPrestamo)";
                    $campos = "idDanos, idPrestamo_FK, fecha, detalles";
                    $consulta = $objeto -> SQL_consulta($tabla, $campos);
                    
                    if (mysqli_num_rows($consulta) < 1) 
                    {
                        echo "<tr><td colspan='14' class='text-center'>NO HAY COINCIDENCIAS.</td></tr>";
                    }                    
                    else
                    {
                        while ($fila = $consulta -> fetch_assoc()) 
                        {
                        echo "<tr>
                                <th scope='row'>$fila[idDanos]</th>
                                <td>$fila[idPrestamo_FK]</td>
                                <td>$fila[fecha]</td>
                                <td colspan='2'>$fila[detalles]</td>
                                <td><a class='btn btn-warning' href='Administrador.php?pagina=Modificar/Edit_Reporte.php&idDanos=$fila[idDanos]'>Modificar</a></td>
                            </tr>";
                        }
                    }
                        
                    echo"</tbody>
                </form>
                </table> 
            </div>
        </div>";
    }
?>