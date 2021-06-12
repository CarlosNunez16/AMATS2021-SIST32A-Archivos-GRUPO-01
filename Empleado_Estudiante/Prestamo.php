<?php
@session_start();
$objeto = new ClsConnection();

$tabla = "prestamo";
$consulta = $objeto -> SQL_consulta($tabla, "idPrestamo, fecha_entrega");
while ($fila = $consulta -> fetch_assoc())
{
    $fecha_actual = strtotime(date("Y-m-d"));
    $fecha_entrega = strtotime("$fila[fecha_entrega]");
            
    if($fecha_actual > $fecha_entrega)
    {
        $datos["estado"] = "No entregó";
        $condicion = "estado = 'En préstamo' and idPrestamo=$fila[idPrestamo]";
        $rs = $objeto -> SQL_modificar("prestamo", $datos, $condicion);
    }
}
?>
<h1 class="text-center m-3 fs-2">PRÉSTAMOS</h1>
<div class="row d-flex justify-content-center">
	<div class="col-8 m-3 s-1 p-3 border border-dark rounded-3 d-block" style="background-color:#F5F5F5">
        <h1 class="text-center fs-4">REGISTRO</h1>
		<form class="row g-3 needs-validation" method="post">
            <div class="col-md-6">
                <label for="activos" class="form-label">Activo fijo:</label>
                <select class="form-select" name="activos">
                    <?php
                        $tabla = 'inventario';
                        $consulta = $objeto -> SQL_consulta($tabla, "idActivo, nombre, numero_serie");
                        while ($fila = $consulta -> fetch_assoc())
                        {
                            echo "<Option value='$fila[idActivo]'>$fila[nombre]</Option>";
                        }
                    ?>
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label" for="fechaEntrega">Fecha de entrega: </label>
                <input class='form-control' type='date' min='<?php echo date("Y-m-d");?>' name='fechaEntrega' required>      
            </div>
            <div class="col-md-12">
                <input class="btn btn-primary" type="submit" name="enviar" value="Guardar">
            </div>
        </form>
    </div>
</div>
<?php
    if (isset($_POST['enviar']))
    {
        $datos[] = $_SESSION["Estudiante_Empleado"][0];
        $datos[] = $_POST['activos'];
        $datos[] = date("Y-m-d");
        $datos[] = date("h:s");
        $datos[] = $_POST['fechaEntrega'];
        $datos[] = "En préstamo";
        $datos[] = "Sin comprobar";

        $tablaPres = "prestamo"; 
        $consultaPres = $objeto -> SQL_consulta_condicional($tablaPres, "idActivo_FK", "idActivo_FK = $datos[1] AND estado = 'En préstamo' OR estado = 'No entregó'");
        $tablaMant = "mantenimientos";
        $consultaMant = $objeto -> SQL_consulta_condicional($tablaMant, "idActivo_FK2", "idActivo_FK2 = $datos[1] AND calidad_nueva='Sin revisar'");

        if (mysqli_num_rows($consultaPres) > 0) 
        {
            echo "<script>alert('El activo fijo ya está en préstamo.')</script>";
        }
        elseif (mysqli_num_rows($consultaMant) > 0) 
        {
            echo "<script>alert('El activo fijo está en mantenimiento.')</script>";
        }
        else
        {
            $tabla = "prestamo";
            $campos = array('carnet_FK2','idActivo_FK','fecha_prestamo','hora_pretamo','fecha_entrega','estado', 'calidad_entrega');

            $rs = $objeto -> SQL_insert($tabla, $campos, $datos);
            echo "<script>alert('PRESTAMO REALIZADO')</script>";
        }
    }
?>

<div class="row d-flex justify-content-center">
	<div class="col-8 m-3 s-1 p-3 border border-dark rounded-3 d-block" style="background-color:#F5F5F5">
        <h1 class="text-center fs-4">CONSULTA</h1>
		<form class="row g-3 needs-validation" name='form1' method="post" target='_self'>
            <div class="col-md-6">
                <?php
                    if(isset($_GET["opcion"]))
                    {
                        if($_GET["opcion"] == "Activo" || $_GET["opcion"] == "Estado")
                        {
                            echo"
                                <label class='form-label' for='dato'>Escriba aquí:</label>
                                <input class='form-control' type='text' name='dato' required>
                            ";
                        }
                        elseif($_GET["opcion"] == "Fecha")
                        {
                            echo"
                                <label class='form-label' for='dato'>Seleccione la fecha:</label>
                                <input class='form-control' type='date' max=".date("Y-m-d")." name='dato' required>
                            ";
                        }
                        else
                        {
                            echo"
                                <label class='form-label' for='dato'>Escriba aquí:</label>
                                <input class='form-control' placeholder='Nombre del activo' type='text' name='dato' required>
                            ";
                        }
                    }
                ?>
            </div> 
            <div class="col-md-6">
                <label class="form-label" for="tipo">Buscar por...</label>
                <select class="form-select" name="tipo" onChange='javascript:abreSitio()' required>
                    <option value='#'>Elegir...</option>
                    <option value='?pagina=Prestamo.php&opcion=Activo'>Activo fijo</option>
                    <option value='?pagina=Prestamo.php&opcion=Fecha'>Fecha de préstamo</option>
                    <option value='?pagina=Prestamo.php&opcion=Estado'>Estado del préstamo</option>
                </select>
            </div>
            <div class="col-md-12">
                <input class='btn btn-success' type='submit' name='buscar'  value='Buscar'>
            </div>
        </form>
    </div>
</div>

<div class="row">
    <div class="col-1">
        <a href="imprimir.php?tabla=misPrestamos" target="_blank" class="btn btn-secondary" title="IMPRIMIR">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-printer" viewBox="0 0 16 16">
                <path d="M2.5 8a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z"/>
                <path d="M5 1a2 2 0 0 0-2 2v2H2a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h1v1a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-1h1a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-1V3a2 2 0 0 0-2-2H5zM4 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2H4V3zm1 5a2 2 0 0 0-2 2v1H2a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-1v-1a2 2 0 0 0-2-2H5zm7 2v3a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1z"/>
            </svg>
        </a>
    </div>
</div>

<?php
if(isset($_POST["buscar"]))
{
	$dato = $_POST["dato"];
	echo "
    <div class='row d-flex justify-content-center'>
        <div class='col-12 m-3'>
            <table class='table table-dark table-striped table-hover'>
            <form method='post'>
                <thead>
                    <tr>
                        <th scope='col'>ID</th>
                        <th scope='col'>Usuario</th>
                        <th scope='col'>Activo Fijo</th>
                        <th scope='col'>Fecha de préstamo</th>
                        <th scope='col'>Hora de préstamo</th>
                        <th scope='col'>Fecha de entrega</th>
                        <th scope='col'>Estado del préstamo</th>
                        <th scope='col'>Calidad en la entrega</th>
                        <th scope='col'>Acción</th>
                    </tr>
                </thead>
                <tbody>";
    
                    $tabla = "prestamo INNER JOIN usuarios ON (prestamo.carnet_FK2 = usuarios.carnet) INNER JOIN inventario ON (prestamo.idActivo_FK = inventario.IdActivo)";
                    $campos = "idPrestamo, usuarios.nombres AS nombre_U, usuarios.apellidos AS apellido_U, inventario.nombre AS Nombre_Ac, inventario.numero_serie AS Serie_Ac, fecha_prestamo, hora_pretamo, fecha_entrega, estado, calidad_entrega";
                    if($_GET["opcion"] == "Activo" || $_GET["opcion"] == "all")
                    {
                        $condicion = " where inventario.nombre like '%$dato%' and carnet = ".$_SESSION["Estudiante_Empleado"][0]."";
                    }
                    elseif($_GET["opcion"] == "Fecha")
                    {
                        $condicion = " where fecha_prestamo like '%$dato%' and carnet = ".$_SESSION["Estudiante_Empleado"][0]."";
                    }
                    elseif($_GET["opcion"] == "Estado")
                    {
                        $condicion = " where estado like '%$dato%' and carnet = ".$_SESSION["Estudiante_Empleado"][0]."";
                    }
                    $tablaCondicion = $tabla.$condicion;
                    $consulta = $objeto -> SQL_consulta($tablaCondicion, $campos);
                    
                    if (mysqli_num_rows($consulta) < 1) 
                    {
                        echo "<tr><td colspan='14' class='text-center'>NO HAY COINCIDENCIAS.</td></tr>";
                    }
                    else
                    {
                        while ($fila = $consulta -> fetch_assoc())
                        {
                            $estado="$fila[estado]";
                            if($estado == "En préstamo" || $estado == "No entregó")
                            {
                                $_SESSION["BtnEntregar"]="Enabled";
                            }
                            else
                            {
                                $_SESSION["BtnEntregar"]="Disabled";
                            }
                            echo "<tr>
                            <th scope='row'>$fila[idPrestamo]</th>
                            <td>$fila[nombre_U] $fila[apellido_U]</td>
                            <td>$fila[Nombre_Ac]</td>
                            <td>$fila[fecha_prestamo]</td>
                            <td>$fila[hora_pretamo]</td>
                            <td>$fila[fecha_entrega]</td>
                            <td>$fila[estado]</td>
                            <td>$fila[calidad_entrega]</td>
                            <td><div class='d-flex justify-content-center'><a class='btn btn-success justify-content-center ".$_SESSION["BtnEntregar"]."'href='Empleado_Estudiante.php?pagina=Modificar/Entrega_Prestamo.php&idPrestamo=$fila[idPrestamo]'>Entregar</a></div></td>
                            </tr>";
                        }
                    }
                    ?>
                    <tr>
                        <td colspan="9"><div class="d-flex justify-content-center"><a class="btn btn-info justify-content-center" href='Empleado_Estudiante.php?pagina=Prestamo.php&opcion=all'>Ver todos</a></div></td>
                    </tr>
                </tbody>
            </form>
            </table>
        </div>
    </div>
        <?php
}
else
{
    echo "
    <div class='row d-flex justify-content-center'>
        <div class='col-12 m-3'>
            <table class='table table-dark table-striped table-hover'>
            <form method='post'>
                <thead>
                    <tr>
                        <th scope='col'>ID</th>
                        <th scope='col'>Usuario</th>
                        <th scope='col'>Activo Fijo</th>
                        <th scope='col'>Fecha de préstamo</th>
                        <th scope='col'>Hora de préstamo</th>
                        <th scope='col'>Fecha de entrega</th>
                        <th scope='col'>Estado del préstamo</th>
                        <th scope='col'>Calidad en la entrega</th>
                        <th scope='col'>Acción</th>
                    </tr>
                </thead>
                <tbody>";
        
                    $tabla = "prestamo INNER JOIN usuarios ON (prestamo.carnet_FK2 = usuarios.carnet) INNER JOIN inventario ON (prestamo.idActivo_FK = inventario.IdActivo)";
                    $campos = "idPrestamo, usuarios.nombres AS nombre_U, usuarios.apellidos AS apellido_U, inventario.nombre AS Nombre_Ac, inventario.numero_serie AS Serie_Ac, fecha_prestamo, hora_pretamo, fecha_entrega, estado, calidad_entrega";
                    $condicion =" where carnet = ".$_SESSION["Estudiante_Empleado"][0]."";
                    $tablaCondicion = $tabla.$condicion;
                    $consulta = $objeto -> SQL_consulta($tablaCondicion, $campos);

                    if (mysqli_num_rows($consulta) < 1) 
                    {
                        echo "<tr><td colspan='14' class='text-center'>NO HAY REGISTROS.</td></tr>";
                    }
                    else
                    {
                        while ($fila = $consulta -> fetch_assoc())
                        {
                            $estado="$fila[estado]";
                            if($estado == "En préstamo" || $estado == "No entregó")
                            {
                                $_SESSION["BtnEntregar"]="";
                            }
                            else
                            {
                                $_SESSION["BtnEntregar"]="disabled";
                            }
                            echo "<tr>
                                <th scope='row'>$fila[idPrestamo]</th>
                                <td>$fila[nombre_U] $fila[apellido_U]</td>
                                <td>$fila[Nombre_Ac]</td>
                                <td>$fila[fecha_prestamo]</td>
                                <td>$fila[hora_pretamo]</td>
                                <td>$fila[fecha_entrega]</td>
                                <td>$fila[estado]</td>
                                <td>$fila[calidad_entrega]</td>
                                <td><div class='d-flex justify-content-center'><a class='btn btn-success justify-content-center ".$_SESSION["BtnEntregar"]."'href='Empleado_Estudiante.php?pagina=Modificar/Entrega_Prestamo.php&idPrestamo=$fila[idPrestamo]'>Entregar</a></div></td>
                            </tr>";
                        }
                    }
                
}
                        ?>
                </tbody>
            </form>
            </table>
        </div>
    </div>
