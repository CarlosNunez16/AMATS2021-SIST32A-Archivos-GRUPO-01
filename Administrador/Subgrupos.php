<?php
@session_start();
$objeto = new ClsConnection();
?>
<h1 class="text-center m-3 fs-2">SUBGRUPOS</h1>
<div class="row d-flex justify-content-center">
	<div class="col-5 m-3 s-1 p-3 border border-dark rounded-3 d-block" style="background-color:#F5F5F5">
        <h1 class="text-center fs-4">REGISTRO</h1>
		<form class="row g-3 needs-validation" method="post">
            <div class="col-md-6">
                <label for="grupos" class="form-label">Grupo:</label>
                <select name="grupos" class="form-select" required>
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
                <label class="form-label" for="nombre">Nombre: </label>
                <input class="form-control" type="text" name="nombre" required>
            </div>
            <div class="col-md-12">
                <label class="form-label" for="descripcion">Descripción: </label>
                <input class="form-control" type="text" name="descripcion" required>
            </div>
            <div class="col-12">
                <input class="btn btn-primary" type="submit" name="enviar" value="Guardar">
            </div>
        </form>
    </div>
</div>

<?php
if (isset($_POST['enviar']))
{
    $datos[] = $_POST['grupos'];
	$datos[] = $_POST['nombre'];
	$datos[] = $_POST['descripcion'];

	$tabla = "subgrupos";
	$consulta = $objeto -> SQL_consulta_condicional($tabla, "*", "nombre = '$datos[1]'");

	if (mysqli_num_rows($consulta) > 0) 
    {
        echo "<script>alert('El subgrupo ya existe.')</script>";
    }
    else
    {
        $campos = array('idGrupo_FK','nombre','descripcion');

        $rs = $objeto -> SQL_insert($tabla, $campos, $datos);
        echo "<script>alert('SUBGRUPO GUARDADO')</script>";
    }
}
?>
<div class="row d-flex justify-content-center">
	<div class="col-5 m-3 s-1 p-3 border border-dark rounded-3 d-block" style="background-color:#F5F5F5">
        <h1 class="text-center fs-4">CONSULTA</h1>
		<form class="row g-3 needs-validation" method="post">
            <div class="col-md-12">
                <label class="form-label" for="nombre">Buscar por nombre.</label>
                <input class="form-control" type="text" name="nombre" required>
            </div>
            <div class="col-md-12">
                <input class="btn btn-success" type="submit" name="buscar"  value="Buscar">
            </div>
        </form>
    </div>
</div>

<?php
if(isset($_POST["buscar"]))
{
	$nombre = $_POST["nombre"];
	echo "
    <div class='row d-flex justify-content-center'>
        <div class='col-6 m-3'>
            <table class='table table-dark table-striped table-hover'>
                <form method='post'>
                <thead>
                    <tr>
                        <th scope='col'></th>
                        <th scope='col'>ID</th>
                        <th scope='col'>Nombre</th>
                        <th scope='col'>Grupo</th>
                        <th scope='col'>Descripción</th>
                        <th scope='col'>Acción</th>
                    </tr>
                </thead>
                <tbody>";
                $tabla = "subgrupos INNER JOIN grupos ON (subgrupos.idGrupo_FK = grupos.idGrupo)";
                $campos = "subgrupos.idSubgrupo, grupos.nombre AS nombre_G, subgrupos.nombre, subgrupos.descripcion";
                $consulta = $objeto -> SQL_consulta_condicional($tabla, $campos, "subgrupos.nombre like '%$nombre%'");
                if (mysqli_num_rows($consulta) < 1) 
                {
                    echo "<tr><td colspan='14' class='text-center'>NO HAY COINCIDENCIAS.</td></tr>";
                    $_SESSION["Btn_Eliminar"]="Disabled";
                }
                else
                {
                    while ($fila = $consulta -> fetch_assoc())
                    {
                    echo "<tr>
                            <td><input type='checkbox' name='seleccionados[]' value='$fila[idSubgrupo]'></td>
                            <th scope='row'>$fila[idSubgrupo]</th>
                            <td>$fila[nombre]</td>
                            <td>$fila[nombre_G]</td>
                            <td>$fila[descripcion]</td>
                            <td><a class='btn btn-warning' href='Administrador.php?pagina=Modificar/Edit_Subgrupos.php&grupo=$fila[idSubgrupo]'>Modificar</a></td>
                        </tr>";
                        $_SESSION["Btn_Eliminar"]="Enabled";
                    }
                }
            ?>
                    <tr>
                        <td colspan="5"><div class="d-flex justify-content-center"><input class="btn btn-danger justify-content-center" type="submit" name="eliminar" value="Eliminar" <?php echo $_SESSION["Btn_Eliminar"]?>></div></td>
                        <td><a class="btn btn-info" href='Administrador.php?pagina=Subgrupos.php'>Ver todos</a></td>
                    </tr>
                <tbody>
		        </form>
		    </table>
        </div>
    </div>
		<?php
		if(isset($_POST["eliminar"]))
		{
			$seleccionados = $_POST["seleccionados"];

			foreach($seleccionados as $idSubgrupo)
			{
				$tabla = "inventario INNER JOIN subgrupos ON (inventario.idSubgrupo_FK = subgrupos.idSubgrupo) WHERE idSubgrupo=$idSubgrupo";
                $campos = "idSubgrupo_FK";
                $consulta = $objeto -> SQL_consulta($tabla, $campos);
                if (mysqli_num_rows($consulta) > 0) 
                {
                    echo "<script>alert('El subgrupo está en la tabla inventario, eliminalo primero.')</script>";
                }
                else
                {
                    $rs = $objeto -> SQL_eliminar("subgrupos", "idSubgrupo = $idSubgrupo");
                    echo "<script>alert('SUBGRUPO ELIMINADO');window.location='?pagina=Subgrupos.php';</script>";
                }
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
                        <th scope='col'>Nombre</th>
                        <th scope='col'>Grupo</th>
                        <th scope='col'>Descripción</th>
                        <th scope='col'>Acción</th>
                    </tr>
                </thead>
                <tbody>";

            $tabla = "subgrupos INNER JOIN grupos ON (subgrupos.idGrupo_FK = grupos.idGrupo)";
            $campos = "subgrupos.idSubgrupo, grupos.nombre AS nombre_G, subgrupos.nombre, subgrupos.descripcion";
            $consulta = $objeto -> SQL_consulta($tabla, $campos);
                if (mysqli_num_rows($consulta) < 1) 
                {
                    echo "<tr><td colspan='14' class='text-center'>NO HAY REGISTROS.</td></tr>";
                    $_SESSION["Btn_Eliminar"]="Disabled";
                }
                else
                {
                    while ($fila = $consulta -> fetch_assoc())
                    {
                    echo "<tr>
                            <td><input type='checkbox' name='seleccionados[]' value='$fila[idSubgrupo]'></td>
                            <th scope='row'>$fila[idSubgrupo]</th>
                            <td>$fila[nombre]</td>
                            <td>$fila[nombre_G]</td>
                            <td>$fila[descripcion]</td>
                            <td><a class='btn btn-warning' href='Administrador.php?pagina=Modificar/Edit_Subgrupos.php&Subgrupo=$fila[idSubgrupo]'>Modificar</a></td>
                        </tr>";
                        $_SESSION["Btn_Eliminar"]="Enabled";
                    }
                }
                ?>
                    <tr>
                        <td colspan="6"><div class="d-flex justify-content-center"><input class="btn btn-danger justify-content-center" type="submit" name="eliminar" value="Eliminar" <?php echo $_SESSION["Btn_Eliminar"]?>></div></td>
                    </tr>
                    </form>
                </tbody>
            </table>
        </div>
    </div>
    <?php
    if(isset($_POST["eliminar"]))
    {
        $seleccionados = $_POST["seleccionados"];

        foreach($seleccionados as $idSubgrupo)
        {
            $tabla = "inventario INNER JOIN subgrupos ON (inventario.idSubgrupo_FK = subgrupos.idSubgrupo) WHERE idSubgrupo=$idSubgrupo";
            $campos = "idSubgrupo_FK";
            $consulta = $objeto -> SQL_consulta($tabla, $campos);
            if (mysqli_num_rows($consulta) > 0) 
            {
                echo "<script>alert('El subgrupo está en la tabla inventario, eliminalo primero.')</script>";
            }
            else
            {
                $rs = $objeto -> SQL_eliminar("subgrupos", "idSubgrupo = $idSubgrupo");
                echo "<script>alert('SUBGRUPO ELIMINADO');window.location='?pagina=Subgrupos.php';</script>";
            }
        }
    }
	}
?>