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
    <label for="nombre">Nombre: </label>
	<input type="text" name="nombre" required>
	<label for="descripcion">Descripción: </label>
	<input type="text" name="descripcion" required>

	<input type="submit" name="enviar" value="Guardar">
</form>

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
        <th>Nombre</th>
        <th>Descripción</th>
        <th>Acción</th>
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