<?php
@session_start();
$objeto = new ClsConnection();
?>
<h1 class="text-center m-3 fs-2">INVENTARIO</h1>
<div class="row d-flex justify-content-center">
	<div class="col-8 m-3 s-1 p-3 border border-dark rounded-3 d-block" style="background-color:#F5F5F5">
        <h1 class="text-center fs-4">FORMULARIO DE REGISTRO</h1>
		<form class="row g-3 needs-validation" method="post">
            <div class="col-md-6">
                <label for="grupos" class="form-label">Grupo:</label>
                <select class="form-select" name="grupos">
                    <?php
                        $tabla = 'grupos';
                        $consulta = $objeto -> SQL_consulta($tabla, "idGrupo, nombre");
                        while ($fila = $consulta -> fetch_assoc())
                        {
                            echo "<Option value='$fila[idGrupo]'>$fila[nombre]</Option>";
                        }
                    ?>
                </select>
            </div>
            <div class="col-md-6">
                <label for="subgrupos" class="form-label">Subgrupo:</label>
                <select class="form-select" name="subgrupos">
                    <?php
                        $tabla = 'subgrupos';
                        $consulta = $objeto -> SQL_consulta($tabla, "idSubgrupo, nombre");
                        while ($fila = $consulta -> fetch_assoc())
                        {
                            echo "<Option value='$fila[idSubgrupo]'>$fila[nombre]</Option>";
                        }
                    ?>
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label" for="nombre">Nombre: </label>
                <input class="form-control" type="text" name="nombre" title="Ingresa tu nombre" required>        
            </div>
            <div class="col-md-6">
                <label class="form-label" for="marca">Marca: </label>
                <input class="form-control" type="text" name="marca" required>      
            </div>
            <div class="col-md-6">
                <label class="form-label" for="modelo">Modelo: </label>
                <input class="form-control" type="text" name="modelo" required>    
            </div>
            <div class="col-md-1">
                <label class="form-label" for="color">Color: </label>
                <input class="form-control form-control-color" type="color" name="color" required>    
            </div>
            <div class="col-md-6">
                <label class="form-label" for="serie">N??mero de serie: </label>
                <input class="form-control" type="text" name="serie" required>    
            </div>
            <div class="col-md-6">
                <label for="usuarios" class="form-label">Usuario:</label>
                <select class="form-select" name="usuarios">
                    <?php
                        $tabla = 'usuarios';
                        $consulta = $objeto -> SQL_consulta($tabla." where tipo_usuario='Administrador' or tipo_usuario='Empleado'", "carnet, nombres, apellidos");
                        while ($fila = $consulta -> fetch_assoc())
                        {
                            echo "<Option value='$fila[carnet]'>$fila[nombres] $fila[apellidos]</Option>";
                        }
                    ?>
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label" for="ubicacion">Ubicaci??n: </label>
                <input class="form-control" type="text" name="ubicacion" required>   
            </div>
            <div class="col-md-6">
                <label class="form-label" for="calidad">Calidad: </label>
                <select class="form-select" name="calidad">
                    <Option value='Excelente'>Excelente</Option>
                    <Option value='Muy bueno'>Muy bueno</Option>
                    <Option value='Bueno'>Bueno</Option>
                    <Option value='Malo'>Malo</Option>
                    <Option value='Necesita reparaci??n'>Necesita reparaci??n</Option>
                </select>     
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
    $datos[] = $_POST['grupos'];
	$datos[] = $_POST['subgrupos'];
	$datos[] = $_POST['nombre'];
    $datos[] = $_POST['marca'];
    $datos[] = $_POST['modelo'];
    $datos[] = $_POST['color'];
    $datos[] = $_POST['serie'];
    $datos[] = $_POST['usuarios']; 
    $datos[] = $_POST['ubicacion'];
    $datos[] = date("Y-m-d");
    $datos[] = $_POST['calidad'];

	$tabla = "inventario";
	$consulta = $objeto -> SQL_consulta_condicional($tabla, "*", "numero_serie = '$datos[6]'");

	if (mysqli_num_rows($consulta) > 0) 
    {
        echo "<script>alert('El activo fijo ya existe (N Serie = $datos[6]).')</script>";
    }
    else
    {
        $campos = array('idGrupo_FK2','idSubgrupo_FK','nombre','marca','modelo','color','numero_serie','carnet_FK', 'ubicacion', 'fecha_asignacion', 'calidad');

        $rs = $objeto -> SQL_insert($tabla, $campos, $datos);
        echo "<script>alert('ACTIVO FIJO GUARDADO')</script>";
    }
}
?>

<div class="row d-flex justify-content-center">
	<div class="col-4 m-3 s-1 p-3 border border-dark rounded-3 d-block" style="background-color:#F5F5F5">
        <h1 class="text-center fs-4">CONSULTA DEL INVENTARIO</h1>
		<form class="row g-3 needs-validation" name='form1' method="post" target='_self'>
            <div class="col-md-6">
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
                        elseif($_GET["opcion"] == "Usuario")
                        {
                            echo"
                                <label class='form-label' for='dato'>Escriba aqu??:</label>
                                <input class='form-control' type='text' placeholder='Nombre o apellido...'   name='dato' required>
                            ";
                        }
                        else
                        {
                            echo"
                                <label class='form-label' for='dato'>Escriba aqu??:</label>
                                <input class='form-control' type='text' name='dato' required>
                            ";
                        }
                    }
                ?>
            </div> 
            <div class="col-md-6">
                <label class="form-label" for="tipo">Buscar por...</label>
                <select class="form-select" name="tipo" onChange='javascript:abreSitio()' required>
                    <option value='#'>Elegir...</option>
                    <option value='?pagina=Inventario.php&opcion=Grupo'>Grupo</option>
                    <option value='?pagina=Inventario.php&opcion=Subgrupo'>Subgrupo</option>
                    <option value='?pagina=Inventario.php&opcion=Nombre'>Nombre</option>
                    <option value='?pagina=Inventario.php&opcion=Marca'>Marca</option>
                    <option value='?pagina=Inventario.php&opcion=Modelo'>Modelo</option>
                    <option value='?pagina=Inventario.php&opcion=Serie'>N??mero de serie</option>
                    <option value='?pagina=Inventario.php&opcion=Usuario'>Usuario responsable</option>
                    <option value='?pagina=Inventario.php&opcion=Ubicacion'>Ubicaci??n</option>
                    <option value='?pagina=Inventario.php&opcion=Fecha'>Fecha de asignaci??n</option>
                    <option value='?pagina=Inventario.php&opcion=Calidad'>Calidad del activo</option>
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
        <a href="imprimir.php?tabla=inventario" target="_blank" class="btn btn-secondary" title="IMPRIMIR">
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
    <div class='row d-flex justify-content-center' id='tabla'>
        <div class='col-12 m-3'>
            <table class='table table-dark table-striped table-hover'>
            <form method='post'>
                <thead>
                    <tr>
                        <th scope='col'></th>
                        <th scope='col'>ID</th>
                        <th scope='col'>Grupo</th>
                        <th scope='col'>Subgrupo</th>
                        <th scope='col'>Nombre</th>
                        <th scope='col'>Marca</th>
                        <th scope='col'>Modelo</th>
                        <th scope='col'>Color</th>
                        <th scope='col'>N??mero de serie</th>
                        <th scope='col'>Usuario encargado</th>
                        <th scope='col'>Ubicaci??n del activo</th>
                        <th scope='col'>Fecha de registro</th>
                        <th scope='col'>Calidad del activo</th>
                        <th scope='col'>Acci??n</th>
                    </tr>
                </thead>
                <tbody>";
    
                    $tabla = "inventario INNER JOIN grupos ON (inventario.idGrupo_FK2 = grupos.idGrupo) INNER JOIN subgrupos ON (inventario.idSubgrupo_FK = subgrupos.idSubgrupo) INNER JOIN usuarios ON (inventario.carnet_FK = usuarios.carnet)";
                    $campos = "inventario.idActivo, grupos.nombre AS nombre_G, subgrupos.nombre AS nombre_SG, inventario.nombre as Nombre, marca, modelo, color, numero_serie, usuarios.nombres AS User_Name, usuarios.apellidos AS User_Lastname, usuarios.carnet as Carnet, ubicacion, fecha_asignacion, calidad";
                    if($_GET["opcion"] == "Grupo" || $_GET["opcion"] == "all")
                    {
                        $condicion = " where grupos.nombre like '%$dato%'";
                    }
                    elseif($_GET["opcion"] == "Subgrupo")
                    {
                        $condicion = " where subgrupos.nombre like '%$dato%'";
                    }
                    elseif($_GET["opcion"] == "Nombre")
                    {
                        $condicion = " where inventario.nombre like '%$dato%'";
                    }
                    elseif($_GET["opcion"] == "Marca")
                    {
                        $condicion = " where marca like '%$dato%'";
                    }
                    elseif($_GET["opcion"] == "Modelo")
                    {
                        $condicion = " where modelo like '%$dato%'";
                    }
                    elseif($_GET["opcion"] == "Serie")
                    {
                        $condicion = " where numero_serie like '%$dato%'";
                    }
                    elseif($_GET["opcion"] == "Usuario")
                    {
                        $condicion = " where usuarios.nombres like '%$dato%' or usuarios.apellidos like '%$dato%'";
                    }
                    elseif($_GET["opcion"] == "Ubicacion")
                    {
                        $condicion = " where ubicacion like '%$dato%'";
                    }
                    elseif($_GET["opcion"] == "Calidad")
                    {
                        $condicion = " where calidad like '%$dato%'";
                    }
                    elseif($_GET["opcion"] == "Fecha")
                    {
                        $condicion = " where fecha_asignacion like '%$dato%'";
                    }
                    $tablaCondicion = $tabla.$condicion;
                    $consulta = $objeto -> SQL_consulta($tablaCondicion, $campos);
                    
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
                            $idActivo="$fila[idActivo]";
                        echo "<tr>
                                <td><input type='checkbox' id='$fila[idActivo]' name='seleccionados[]' value='$fila[idActivo]'></td>
                                <th scope='row'>$fila[idActivo]</th>
                                <td>$fila[nombre_G]</td>
                                <td>$fila[nombre_SG]</td>
                                <td>$fila[Nombre]</td>
                                <td>$fila[marca]</td>
                                <td>$fila[modelo]</td>
                                <td>$fila[color]</td>
                                <td>$fila[numero_serie]</td>
                                <td>$fila[User_Name] $fila[User_Lastname]</td>
                                <td>$fila[ubicacion]</td>
                                <td>$fila[fecha_asignacion]</td>
                                <td>$fila[calidad]</td>
                                <td><a class='btn btn-warning' href='Administrador.php?pagina=Modificar/Edit_Inventario.php&idActivo=$fila[idActivo]&Carnet=$fila[Carnet]'>Modificar</a></td>
                            </tr>";
                            echo"<script type='text/javascript'>
                                    $(document).ready(function(){
                                        $('#BtnEliminar').prop('disabled', true);
                                        $('#".$idActivo."').prop('checked',false);
                                        $('#".$idActivo."').click(function(){
                                            if($('#".$idActivo."').is(':checked')){
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
                            <td colspan="13"><div class="d-flex justify-content-center"><input class="btn btn-danger justify-content-center" type="submit" id="BtnEliminar" name="eliminar" value="Eliminar"></div></td>
                            <td><a class="btn btn-info" href='Administrador.php?pagina=Inventario.php&opcion=all'>Ver todos</a></td>
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
    <div class='row d-flex justify-content-center' id='tabla'>
        <div class='col-12 m-3'>
            <table class='table table-dark table-striped table-hover'>
            <form method='post'>
                <thead>
                    <tr>
                        <th scope='col'></th>
                        <th scope='col'>ID</th>
                        <th scope='col'>Grupo</th>
                        <th scope='col'>Subgrupo</th>
                        <th scope='col'>Nombre</th>
                        <th scope='col'>Marca</th>
                        <th scope='col'>Modelo</th>
                        <th scope='col'>Color</th>
                        <th scope='col'>N??mero de serie</th>
                        <th scope='col'>Usuario encargado</th>
                        <th scope='col'>Ubicaci??n del activo</th>
                        <th scope='col'>Fecha de registro</th>
                        <th scope='col'>Calidad del activo</th>
                        <th scope='col'>Acci??n</th>
                    </tr>
                </thead>
                <tbody>";
        
                    $tabla = "inventario INNER JOIN grupos ON (inventario.idGrupo_FK2 = grupos.idGrupo) INNER JOIN subgrupos ON (inventario.idSubgrupo_FK = subgrupos.idSubgrupo) INNER JOIN usuarios ON (inventario.carnet_FK = usuarios.carnet)";
                    $campos = "inventario.idActivo, grupos.nombre AS nombre_G, subgrupos.nombre AS nombre_SG, usuarios.carnet as Carnet, inventario.nombre as Nombre, marca, modelo, color, numero_serie, usuarios.nombres AS User_Name, usuarios.apellidos AS User_Lastname, ubicacion, fecha_asignacion, calidad";
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
                            $idActivo="$fila[idActivo]";
                        echo "<tr>
                                <td><input type='checkbox' id='$fila[idActivo]' name='seleccionados[]' value='$fila[idActivo]'></td>
                                <th scope='row'>$fila[idActivo]</th>
                                <td>$fila[nombre_G]</td>
                                <td>$fila[nombre_SG]</td>
                                <td>$fila[Nombre]</td>
                                <td>$fila[marca]</td>
                                <td>$fila[modelo]</td>
                                <td>$fila[color]</td>
                                <td>$fila[numero_serie]</td>
                                <td>$fila[User_Name] $fila[User_Lastname]</td>
                                <td>$fila[ubicacion]</td>
                                <td>$fila[fecha_asignacion]</td>
                                <td>$fila[calidad]</td>
                                <td><a class='btn btn-warning' href='Administrador.php?pagina=Modificar/Edit_Inventario.php&idActivo=$fila[idActivo]&Carnet=$fila[Carnet]'>Modificar</a></td>
                            </tr>";
                            echo"<script type='text/javascript'>
                                    $(document).ready(function(){
                                        $('#BtnEliminar').prop('disabled', true);
                                        $('#".$idActivo."').prop('checked',false);
                                        $('#".$idActivo."').click(function(){
                                            if($('#".$idActivo."').is(':checked')){
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
                            <td colspan="14"><div class="d-flex justify-content-center"><input class="btn btn-danger justify-content-center" id="BtnEliminar" type="submit" name="eliminar" value="Eliminar"></div></td>
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
                $tablaPres = "prestamo INNER JOIN inventario ON (prestamo.idActivo_FK=inventario.idActivo) WHERE idActivo_FK=$idActivo";
				$camposPres= "idActivo_FK";

				$tablaMant ="mantenimientos inner join inventario on (mantenimientos.idActivo_FK2=inventario.idActivo) where idActivo_FK2=$idActivo";
				$camposMant="idActivo_FK2";

				$consultaPres = $objeto -> SQL_consulta($tablaPres, $camposPres);
				$consultaMant = $objeto -> SQL_consulta($tablaMant, $camposMant);
				if (mysqli_num_rows($consultaPres) > 0 || mysqli_num_rows($consultaMant) > 0) 
				{
					echo "<script>alert('El activo fijo puede estar en las tablas pr??stamo o mantenimiento, eliminalo primero de dichas tablas.')</script>";
				}
				else
				{
					$rs = $objeto -> SQL_eliminar("inventario", "idActivo = $idActivo");
                    echo "<script>alert('ACTIVO FIJO ELIMINADO');window.location='?pagina=Inventario.php&opcion=all';</script>";
				}
            }
        }
	}
?>