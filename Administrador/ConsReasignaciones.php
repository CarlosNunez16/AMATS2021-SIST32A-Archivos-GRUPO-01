<h1 class="text-center m-3 fs-2">REASIGNACIONES</h1>
<div class="row d-flex justify-content-center">
	<div class="col-4 m-3 s-1 p-3 border border-dark rounded-3 d-block" style="background-color:#F5F5F5">
        <h1 class="text-center fs-4">CONSULTA</h1>
		<form class="row g-3 needs-validation" name='form1' method="post" target='_self'>
            <div class="col-md-5">
                <?php
                    if(isset($_GET["opcion"]))
                    {
                        if($_GET["opcion"] == "Fecha")
                        {
                            echo"
                                <label class='form-label' for='dato'>Ingresar fecha:</label>
                                <input class='form-control' type='date' max=".date("Y-m-d")." name='dato' required>
                            ";
                        }
                        elseif($_GET["opcion"] == "Activo")
                        {
                            echo"
                                <label class='form-label' for='dato'>Escriba aquí:</label>
                                <input class='form-control' type='text' name='dato' required>
                            ";
                        }
                        else
                        {
                            echo"
                                <label class='form-label' for='dato'>Escriba aquí:</label>
                                <input class='form-control' type='number' min='0' name='dato' required>
                            ";
                        }
                    }
                ?>
            </div> 
            <div class="col-md-7">
                <label class="form-label" for="tipo">Buscar por...</label>
                <select class="form-select" name="tipo" onChange='javascript:abreSitio()' required>
                    <option value='#'>Elegir...</option>
                    <option value='?pagina=ConsReasignaciones.php&opcion=Activo'>Activo</option>
                    <option value='?pagina=ConsReasignaciones.php&opcion=Anterior'>Usuario anterior</option>
                    <option value='?pagina=ConsReasignaciones.php&opcion=Nuevo'>Nuevo usuario</option>
                    <option value='?pagina=ConsReasignaciones.php&opcion=Fecha'>Fecha</option>
                </select>
            </div>
            <div class="col-md-12">
                <input class='btn btn-success' type='submit' name='buscar'  value='Buscar'>
            </div>
        </form>
    </div>
</div>

<div class="row d-flex justify-content-center">
    <div class="col-9">
        <a href="imprimir.php?tabla=reasignaciones" target="_blank" class="btn btn-secondary" title="IMPRIMIR">
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
        <div class='col-9 m-3'>
            <table class='table table-dark table-striped table-hover'>
            <form method='post'>
                <thead>
                    <tr>
                        <th scope='col'>ID</th>
                        <th scope='col'>Activo</th>
                        <th scope='col'>Usuario anterior</th>
                        <th scope='col'>Nuevo usuario</th>
                        <th scope='col'>Calidad</th>
                        <th scope='col'>Justificación</th>
                        <th scope='col'>Fecha</th>
                        <th scope='col'>Acción</th>
                    </tr>
                </thead>
                <tbody>";

                    $tabla = "reasignaciones INNER JOIN inventario ON (reasignaciones.idActivo_FK3 = inventario.idActivo)";
                    $campos = "idReasignaciones, inventario.nombre as Activo, usuario_anterior, usuario_nuevo, calidad_actual, justificacion, fecha";
                    if($_GET["opcion"] == "Activo" || $_GET["opcion"] == "all")
                    {
                        $condicion = " where inventario.nombre like '%$dato%'";
                    }
                    elseif($_GET["opcion"] == "Anterior")
                    {
                        $condicion = " where usuario_anterior = $dato";
                    }
                    elseif($_GET["opcion"] == "Nuevo")
                    {
                        $condicion = " where usuario_nuevo = $dato";
                    }
                    elseif($_GET["opcion"] == "Fecha")
                    {
                        $condicion = " where fecha like '%$dato%'";
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
                            $idReasignaciones="$fila[idReasignaciones]";
                        echo "<tr>
                                <th scope='row'>$fila[idReasignaciones]</th>
                                <td>$fila[Activo]</td>
                                <td>$fila[usuario_anterior]</td>
                                <td>$fila[usuario_nuevo]</td>
                                <td>$fila[calidad_actual]</td>
                                <td>$fila[justificacion]</td>
                                <td>$fila[fecha]</td>
                                <td><a class='btn btn-warning' href='Administrador.php?pagina=Modificar/Edit_Reasignaciones.php&idReasignaciones=$fila[idReasignaciones]'>Modificar</a></td>
                            </tr>";
                        }
                    }
                    ?>
                        <tr>
                            <td colspan="8"><div class="d-flex justify-content-center"><a class="btn btn-info" href='Administrador.php?pagina=ConsReasignaciones.php&opcion=all'>Ver todos</a></div></td>
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
        <div class='col-9 m-3'>
            <table class='table table-dark table-striped table-hover'>
            <form method='post'>
                <thead>
                    <tr>
                        <th scope='col'>ID</th>
                        <th scope='col'>Activo</th>
                        <th scope='col'>Usuario anterior</th>
                        <th scope='col'>Nuevo usuario</th>
                        <th scope='col'>Calidad</th>
                        <th scope='col'>Justificación</th>
                        <th scope='col'>Fecha</th>
                        <th scope='col'>Acción</th>
                    </tr>
                </thead>
                <tbody>";

                    $tabla = "reasignaciones INNER JOIN inventario ON (reasignaciones.idActivo_FK3 = inventario.idActivo)";
                    $campos = "idReasignaciones, inventario.nombre as Activo, usuario_anterior, usuario_nuevo, calidad_actual, justificacion, fecha";

                    $consulta = $objeto -> SQL_consulta($tabla, $campos);
                
                    if (mysqli_num_rows($consulta) < 1) 
                    {
                        echo "<tr><td colspan='14' class='text-center'>NO HAY COINCIDENCIAS.</td></tr>";
                    }                    
                    else
                    {
                        while ($fila = $consulta -> fetch_assoc()) 
                        {
                            $idReasignaciones="$fila[idReasignaciones]";
                        echo "<tr>
                                <th scope='row'>$fila[idReasignaciones]</th>
                                <td>$fila[Activo]</td>
                                <td>$fila[usuario_anterior]</td>
                                <td>$fila[usuario_nuevo]</td>
                                <td>$fila[calidad_actual]</td>
                                <td>$fila[justificacion]</td>
                                <td>$fila[fecha]</td>
                                <td><a class='btn btn-warning' href='Administrador.php?pagina=Modificar/Edit_Reasig.php&idReasignaciones=$fila[idReasignaciones]'>Modificar</a></td>
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