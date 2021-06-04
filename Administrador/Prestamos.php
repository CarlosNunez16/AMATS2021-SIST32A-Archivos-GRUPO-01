<?php
@session_start();
$objeto = new ClsConnection();
?>

<div class="row d-flex justify-content-center">
	<div class="col-8 m-3 s-1 p-3 border border-dark rounded-3 d-block" style="background-color:#F5F5F5">
		<form class="row g-3 needs-validation" name='form1' method="post" target='_self'>
            <div class="col-md-6">
                <?php
                    if(isset($_GET["opcion"]))
                    {
                        if($_GET["opcion"] == "Activo" || $_GET["opcion"] == "Usuario")
                        {
                            echo"
                                <label class='form-label' for='dato'>Escriba aquí:</label>
                                <input class='form-control' placeholder='Nombre...'type='text' name='dato' required>
                            ";
                        }
                        elseif($_GET["opcion"] == "Fecha")
                        {
                            echo"
                                <label class='form-label' for='dato'>Escriba aquí:</label>
                                <input class='form-control' type='date' title='Ingrese nombre o apellido...'  name='dato' required>
                            ";
                        }
                        else
                        {
                            echo"
                                <label class='form-label' for='dato'>Escriba aquí:</label>
                                <input class='form-control' placeholder='Nombre...'type='text' name='dato' required>
                            ";
                        }
                    }
                ?>
            </div> 
            <div class="col-md-6">
                <label class="form-label" for="tipo">Buscar por...</label>
                <select class="form-select" name="tipo" onChange='javascript:abreSitio()' required>
                    <option value='#'>Elegir...</option>
                    <option value='?pagina=Prestamos.php&opcion=Usuario'>Usuario</option>
                    <option value='?pagina=Prestamos.php&opcion=Activo'>Activo fijo</option>
                    <option value='?pagina=Prestamos.php&opcion=Fecha'>Fecha de préstamo</option>
                </select>
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
                    </tr>
                </thead>
                <tbody>";
    
                    $tabla = "prestamo INNER JOIN usuarios ON (prestamo.carnet_FK2 = usuarios.carnet) INNER JOIN inventario ON (prestamo.idActivo_FK = inventario.IdActivo)";
                    $campos = "idPrestamo, usuarios.nombres AS nombre_U, usuarios.apellidos AS apellido_U, inventario.nombre AS Nombre_Ac, inventario.numero_serie AS Serie_Ac, fecha_prestamo, hora_pretamo, fecha_entrega, estado, calidad_entrega";
                    if($_GET["opcion"] == "Activo" || $_GET["opcion"] == "all")
                    {
                        $condicion = " where inventario.nombre like '%$dato%'";
                    }
                    elseif($_GET["opcion"] == "Fecha")
                    {
                        $condicion = " where fecha_prestamo like '%$dato%'";
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
                            echo "<tr>
                            <th scope='row'>$fila[idPrestamo]</th>
                            <td>$fila[nombre_U] $fila[apellido_U]</td>
                            <td>$fila[Nombre_Ac] ($fila[Serie_Ac])</td>
                            <td>$fila[fecha_prestamo]</td>
                            <td>$fila[hora_pretamo]</td>
                            <td>$fila[fecha_entrega]</td>
                            <td>$fila[estado]</td>
                            <td>$fila[calidad_entrega]</td>
                            </tr>";
                        }
                    }
                    ?>
                    <tr>
                        <td colspan="8"><div class="d-flex justify-content-center"><a class="btn btn-info justify-content-center" href='Empleado_Estudiante.php?pagina=Prestamo.php&opcion=all'>Ver todos</a></div></td>
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

            foreach($seleccionados as $idActivo)
            {
                $rs = $objeto -> SQL_eliminar("inventario", "idActivo = $idActivo");
                echo "<script>alert('SUBGRUPO/S ELIMINADO');window.location='?pagina=Inventario.php';</script>";
            }
        }
}
else{
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
                   
                    $consulta = $objeto -> SQL_consulta($tabla, $campos);

                    if (mysqli_num_rows($consulta) < 1) 
                    {
                        echo "<tr><td colspan='14' class='text-center'>NO HAY REGISTROS.</td></tr>";
                    }
                    else
                    {
                        while ($fila = $consulta -> fetch_assoc())
                        {
                        echo "<tr>
                                <th scope='row'>$fila[idPrestamo]</th>
                                <td>$fila[nombre_U] $fila[apellido_U]</td>
                                <td>$fila[Nombre_Ac] ($fila[Serie_Ac])</td>
                                <td>$fila[fecha_prestamo]</td>
                                <td>$fila[hora_pretamo]</td>
                                <td>$fila[fecha_entrega]</td>
                                <td>$fila[estado]</td>
                                <td>$fila[calidad_entrega]</td>
                                <td><a class='btn btn-warning' href='Administrador.php?pagina=Modificar/Damages.php&Serie_Ac=$fila[Serie_Ac]&Prestamo=$fila[idPrestamo]'>Revisar</a></td>
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