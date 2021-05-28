<?php
@session_start();
$objeto = new ClsConnection();



$consulta = $objeto -> SQL_consulta("usuarios", "*");

if ($consulta -> num_rows == 0)
{
	echo "No hay nada";
}
else 
{
	echo "<table border='1'>
				<tr>
					<th>Carnet</th>
					<th>Nombres</th>
					<th>Apellidos</th>
					<th>Correo</th>
					<th>Dirección</th>
					<th>Tipo de Usuario</th>
					<th>Carrera</th>
					<th>Cantidad de reportes</th>
					<th>Acción</th>
				</tr>";
	while ($fila = $consulta -> fetch_assoc())
	{
		echo "<tr>
				<td>$fila[carnet]</td>
				<td>$fila[nombres]</td>
				<td>$fila[apellidos]</td>
				<td>$fila[correo]</td>
				<td>$fila[direccion]</td>
				<td>$fila[tipo_usuario]</td>
				<td>$fila[carrera]</td>
				<td>$fila[cantidad_reportes]</td>
				<td><a href='Administrador.php?pagina=Damages.php&usuario=$fila[carnet]'>Reportar daños</a></td>
			</tr>";
	}
	echo "</table>";
}
?>

