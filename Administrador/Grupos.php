<?php
@session_start();
$objeto = new ClsConnection();
?>

<form method="post">
	<label for="nombre">Nombre: </label>
	<input type="text" name="nombre" required>

	<label for="descripcion">Descripción: </label>
	<input type="text" name="descripcion" required>

	<input type="submit" name="enviar" value="Guardar">
</form>

<?php
if (isset($_POST['enviar']))
{
	$datos[] = $_POST['nombre'];
	$datos[] = $_POST['descripcion'];

	$tabla = "grupos";
	$consulta = $objeto -> SQL_consulta_condicional($tabla, "*", "nombre = '$datos[0]'");

	if (mysqli_num_rows($consulta) > 0) 
    {
        echo "<script>alert('El grupo ya existe.')</script>";
    }
    else
    {
        $campos = array('nombre','descripcion');

        $rs = $objeto -> SQL_insert($tabla, $campos, $datos);
        echo "<script>alert('GRUPO GUARDADO')</script>";
    }
}
?>

<table border="1">
	<form method="post">
	<tr>
		<th></th>
		<th>ID</th>
		<th>Nombre</th>
		<th>Descripción</th>
		<th>Acción</th>
	</tr>
	<?php
		$tabla = "grupos";
		$consulta = $objeto -> SQL_consulta($tabla, "*");
		while ($fila = $consulta -> fetch_assoc())
		{
		echo "<tr>
				<td><input type='checkbox' name='seleccionados[]' value='$fila[idGrupo]'></td>
				<td>$fila[idGrupo]</td>
				<td>$fila[nombre]</td>
				<td>$fila[descripcion]</td>
				<td><a href='Administrador.php?pagina=Modificar/Edit_Grupos.php&grupo=$fila[idGrupo]'>Modificar</a></td>
			</tr>";
		}
	?>
	<tr>
		<td colspan="5"><input type="submit" name="eliminar" value="Eliminar"></td>
	</tr>
</form>
</table>
<?php
if(isset($_POST["eliminar"]))
{
	$seleccionados = $_POST["seleccionados"];

	foreach($seleccionados as $idGrupos)
	{
		$rs = $objeto -> SQL_eliminar("grupos", "idGrupo = $idGrupos");
        echo "<script>alert('GRUPO ELIMINADO');window.location='?pagina=Grupos.php';</script>";
	}
}
?>