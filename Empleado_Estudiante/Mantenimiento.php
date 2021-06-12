<h1 class="text-center m-3 fs-2">MIS ASIGNACIONES</h1>
<div class="row d-flex justify-content-center">
	<div class="col-6 m-3 s-1 p-3 border border-dark rounded-3 d-block" style="background-color:#F5F5F5">
        <h1 class="text-center fs-4">CONSULTA</h1>
		<form class="row g-3 needs-validation" name='form1' method="post" target='_self'>
            <div class="col-md-6">
                <?php
                    if(isset($_GET["opcion"]))
                    {
                        if($_GET["opcion"] == "Activo" || $_GET["opcion"] == "Usuario")
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
                    <option value='?pagina=Mantenimiento.php&opcion=Activo'>Activo fijo</option>
                    <option value='?pagina=Mantenimiento.php&opcion=Usuario'>Usuario</option>
                    <option value='?pagina=Mantenimiento.php&opcion=Fecha'>Fecha de registro</option>
                </select>
            </div>
            <div class="col-md-12">
                <input class='btn btn-success' type='submit' name='buscar'  value='Buscar'>
            </div>
        </form>
    </div>
</div>

<div class="row d-flex justify-content-center">
    <div class="col-11">
        <a href="imprimir.php?tabla=misMantenimientos" target="_blank" class="btn btn-secondary" title="IMPRIMIR">
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
        <div class='col-11 m-3'>
            <table class='table table-dark table-striped table-hover'>
            <form method='post'>
                <thead>
                    <tr>
                        <th scope='col'>ID</th>
                        <th scope='col'>Activo Fijo</th>
                        <th scope='col'>Fecha</th>
                        <th scope='col'>Detalles</th>
                        <th scope='col'>Refacciones</th>
                        <th scope='col'>Usuario</th>
                        <th scope='col'>Total</th>
                        <th scope='col'>Justificación</th>
                        <th scope='col'>Duración</th>
                        <th scope='col'>Próximo mantenimiento</th>
                        <th scope='col'>Nueva calidad</th>
                    </tr>
                </thead>
                <tbody>";
    
                    $tabla = "mantenimientos INNER JOIN inventario ON (mantenimientos.idActivo_FK2 = inventario.idActivo) INNER JOIN usuarios ON (mantenimientos.carnet_FK3 = usuarios.carnet)";
                    $campos = "idMantenimiento, inventario.idActivo as idActivo, inventario.nombre AS Activo, fecha, detalles, usuarios.nombres AS nombre_U, usuarios.apellidos AS apellido_U, usuarios.carnet AS carnet, total, justificacion, tiempo, proximo_mantenimiento, calidad_nueva, mantenimientos.refacciones as Refacciones";
                    if($_GET["opcion"] == "Activo" || $_GET["opcion"] == "all")
                    {
                    $condicion = " where inventario.nombre like '%$dato%' and carnet = ".$_SESSION["Estudiante_Empleado"][0]."";
                    }
                    elseif($_GET["opcion"] == "Fecha")
                    {
                        $condicion = " where fecha like '%$dato%' and carnet = ".$_SESSION["Estudiante_Empleado"][0]."";
                    }
                    elseif($_GET["opcion"] == "Usuario")
                    {
                        $condicion = " where carnet = ".$_SESSION["Estudiante_Empleado"][0]." and usuarios.nombres like '%$dato%' or usuarios.apellidos like '%$dato%'";
                    }
                    $tablaCondicion = $tabla.$condicion;
                    $consulta = $objeto -> SQL_consulta($tablaCondicion, $campos);
                    
                    if (mysqli_num_rows($consulta) < 1) 
                    {
                        echo "<tr><td colspan='11' class='text-center'>NO HAY COINCIDENCIAS.</td></tr>";
                    }
                    else
                    {
                        while ($fila = $consulta -> fetch_assoc())
                        {
                            echo "<tr>
                                <th scope='row'>$fila[idMantenimiento]</th>
                                <td>$fila[Activo]</td>
                                <td>$fila[fecha]</td>
                                <td>$fila[detalles]</td>
                                <td>$fila[Refacciones]</td>
                                <td>$fila[nombre_U] $fila[apellido_U]</td>
                                <td>$fila[total]</td>
                                <td>$fila[justificacion]</td>
                                <td>$fila[tiempo]</td>
                                <td>$fila[proximo_mantenimiento]</td>
                                <td>$fila[calidad_nueva]</td>
                            </tr>";
                        }
                    }
                    ?>
                    <tr>
                        <td colspan="11"><div class="d-flex justify-content-center"><a class="btn btn-info justify-content-center" href='Empleado_Estudiante.php?pagina=Mantenimiento.php&opcion=all'>Ver todos</a></div></td>
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
        <div class='col-11 m-3'>
            <table class='table table-dark table-striped table-hover'>
            <form method='post'>
                <thead>
                    <tr>
                        <th scope='col'>ID</th>
                        <th scope='col'>Activo Fijo</th>
                        <th scope='col'>Fecha</th>
                        <th scope='col'>Detalles</th>
                        <th scope='col'>Refacciones</th>
                        <th scope='col'>Usuario</th>
                        <th scope='col'>Total</th>
                        <th scope='col'>Justificación</th>
                        <th scope='col'>Duración</th>
                        <th scope='col'>Próximo mantenimiento</th>
                        <th scope='col'>Nueva calidad</th>
                    </tr>
                </thead>
                <tbody>";
        
                    $tabla = "mantenimientos INNER JOIN inventario ON (mantenimientos.idActivo_FK2 = inventario.idActivo) INNER JOIN usuarios ON (mantenimientos.carnet_FK3 = usuarios.carnet) where carnet = ".$_SESSION["Estudiante_Empleado"][0]."";
                    $campos = "idMantenimiento, inventario.idActivo as idActivo, inventario.nombre AS Activo, fecha, detalles, usuarios.nombres AS nombre_U, usuarios.apellidos AS apellido_U, usuarios.carnet as carnet, total, justificacion, tiempo, proximo_mantenimiento, calidad_nueva, mantenimientos.refacciones as Refacciones";

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
                                <th scope='row'>$fila[idMantenimiento]</th>
                                <td>$fila[Activo]</td>
                                <td>$fila[fecha]</td>
                                <td>$fila[detalles]</td>
                                <td>$fila[Refacciones]</td>
                                <td>$fila[nombre_U] $fila[apellido_U]</td>
                                <td>$fila[total]</td>
                                <td>$fila[justificacion]</td>
                                <td>$fila[tiempo]</td>
                                <td>$fila[proximo_mantenimiento]</td>
                                <td>$fila[calidad_nueva]</td>
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