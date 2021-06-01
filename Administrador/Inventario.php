<?php
@session_start();
$objeto = new ClsConnection();
?>

<form method="post">
    <select name="grupos" required>
        <?php
            $tabla = 'grupos';
            $consulta = $objeto -> SQL_consulta($tabla, "idGrupo, nombre");
            while ($fila = $consulta -> fetch_assoc())
            {
                echo "<Option value='$fila[idGrupo]'>$fila[nombre]</Option>";
            }
        ?>
    </select>
    <select name="subgrupos" required>
        <?php
            $tabla = 'subgrupos';
            $consulta = $objeto -> SQL_consulta($tabla, "idSubgrupo, nombre");
            while ($fila = $consulta -> fetch_assoc())
            {
                echo "<Option value='$fila[idGrupo]'>$fila[nombre]</Option>";
            }
        ?>
    </select>

    <label for="nombre">Nombre: </label>
	<input type="text" name="nombre" title="Ingresa tu nombre" required>
	<label for="marca">Marca: </label>
	<input type="text" name="marca" required>
    <label for="modelo">Modelo: </label>
	<input type="text" name="modelo" required>
    <label for="color">Color: </label>
	<input type="color" class="form-control form-control-color" id="exampleColorInput" title="Choose your color" required>
    <label for="serie">Número de serie: </label>
	<input type="text" name="serie" required>
    
    <select name="usuarios" required>
        <?php
            $tabla = 'usuarios';
            $consulta = $objeto -> SQL_consulta($tabla, "carnet, nombres, apellidos");
            while ($fila = $consulta -> fetch_assoc())
            {
                echo "<Option value='$fila[idGrupo]'>$fila[nombres] $fila[apellidos]</Option>";
            }
        ?>
    </select>

    <label for="ubicacion">Ubicación: </label>
	<input type="text" name="ubicacion" required>
    <select name="calidad" required>
        <Option value='5'>Excelente</Option>
        <Option value='4'>Muy bueno</Option>
        <Option value='3'>Bueno</Option>
        <Option value='2'>Malo</Option>
        <Option value='1'>Necesita reparación</Option>
    </select>

	<input type="submit" name="enviar" value="Guardar">
</form>

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
    $datos[] = date("Y - m - d");
    $datos[] = $_POST['calidad'];


	$tabla = "subgrupos";
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

<form method="post">
	<label for="nombre">Buscar por nombre.</label>
	<input type="text" name="nombre" required>

	<input type="submit" name="buscar"  value="Buscar">
</form>

<?php
if(isset($_POST["buscar"]))
{
	$nombre = $_POST["nombre"];
	echo "<table border='1'>
		<form method='post'>
		<tr>
			<th></th>
			<th>ID</th>
            <th>Grupo</th>
			<th>Nombre</th>
			<th>Descripción</th>
			<th>Acción</th>
		</tr>";
            $tabla = "subgrupos INNER JOIN grupos ON (subgrupos.idGrupo_FK = grupos.idGrupo)";
            $campos = "subgrupos.idSubgrupo, grupos.nombre AS nombre_SG, subgrupos.nombre, subgrupos.descripcion";
			$consulta = $objeto -> SQL_consulta_condicional($tabla, $campos, "subgrupos.nombre like '%$nombre%'");
			while ($fila = $consulta -> fetch_assoc())
			{
			echo "<tr>
					<td><input type='checkbox' name='seleccionados[]' value='$fila[idSubgrupo]'></td>
					<td>$fila[idSubgrupo]</td>
                    <td>$fila[nombre_SG]</td>
					<td>$fila[nombre]</td>
					<td>$fila[descripcion]</td>
					<td><a href='Administrador.php?pagina=Modificar/Edit_Subgrupos.php&grupo=$fila[idSubgrupo]'>Modificar</a></td>
				</tr>";
			}
		?>
		<tr>
			<td colspan="5"><input type="submit" name="eliminar" value="Eliminar"></td>
            <td><a href='Administrador.php?pagina=Subgrupos.php'>Ver todos</a></td>
		</tr>
		</form>
		</table>
		<?php
		if(isset($_POST["eliminar"]))
		{
			$seleccionados = $_POST["seleccionados"];

			foreach($seleccionados as $idSubgrupo)
			{
				$rs = $objeto -> SQL_eliminar("subgrupos", "idSubgrupo = $idSubgrupo");
				echo "<script>alert('SUBGRUPO ELIMINADO');window.location='?pagina=Subgrupos.php';</script>";
			}
		}
}
else{
    echo "<table border='1'>
    <form method='post'>
    <tr>
        <th></th>
        <th>ID</th>
        <th>Grupo</th>
        <th>Subgrupo</th>
        <th>Nombre</th>
        <th>Marca</th>
        <th>Modelo</th>
        <th>Color</th>
        <th>Número de serie</th>
        <th>Usuario encargado</th>
        <th>Ubicación del activo</th>
        <th>Fecha de asignación</th>
        <th>Calidad del activo</th>
    </tr>";
    
        $tabla = "subgrupos INNER JOIN grupos ON (subgrupos.idGrupo_FK = grupos.idGrupo)";
        $campos = "subgrupos.idSubgrupo, grupos.nombre AS nombre_SG, subgrupos.nombre, subgrupos.descripcion";
        $consulta = $objeto -> SQL_consulta($tabla, $campos);
       
        while ($fila = $consulta -> fetch_assoc())
        {
        echo "<tr>
                <td><input type='checkbox' name='seleccionados[]' value='$fila[idSubgrupo]'></td>
                <td>$fila[idSubgrupo]</td>
                <td>$fila[nombre_SG]</td>
                <td>$fila[nombre]</td>
                <td>$fila[descripcion]</td>
                <td><a href='Administrador.php?pagina=Modificar/Edit_Subgrupos.php&Subgrupo=$fila[idSubgrupo]'>Modificar</a></td>
            </tr>";
        }
    ?>
    <tr>
        <td colspan="6"><input type="submit" name="eliminar" value="Eliminar"></td>
    </tr>
    </form>
    </table>
    <?php
    if(isset($_POST["eliminar"]))
    {
        $seleccionados = $_POST["seleccionados"];

        foreach($seleccionados as $idSubgrupo)
        {
            $rs = $objeto -> SQL_eliminar("subgrupos", "idSubgrupo = $idSubgrupo");
            echo "<script>alert('SUBGRUPO ELIMINADO');window.location='?pagina=Subgrupos.php';</script>";
        }
    }
	}
?>