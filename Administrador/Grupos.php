<?php
@session_start();
$objeto = new ClsConnection(); 
?>
<h1 class="text-center m-3 fs-2">GRUPOS</h1>
<div class="row d-flex justify-content-center">
	<div class="col-5 m-3 s-1 p-3 border border-dark rounded-3 d-block" style="background-color:#F5F5F5">
		<h1 class="text-center fs-4">REGISTRO</h1>
		<form class="row g-3 needs-validation" method="post">
			<div class="col-md-6">
				<label for="nombre" class="form-label">Nombre</label>
				<input type="text" class="form-control" name="nombre"  required>
			</div>
			<div class="col-md-12">
				<label for="descripcion" class="form-label">Descripción:</label>
				<input type="textarea" class="form-control" name="descripcion" required>
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
<div class="row d-flex justify-content-center">
	<div class="col-5 d-block m-3 p-3 border border-dark rounded-3" style="background-color:#F5F5F5">
		<h1 class="text-center fs-4">CONSULTA</h1>
		<form class="row g-3 needs-validation" method="post">
			<div class="col-md-12">
				<label for="nombre" class="form-label">Buscar por nombre:</label>
				<input type="text" class="form-control" name="nombre" id="validationCustom01" required>
				<div class="valid-feedback">
				Looks good!
				</div>
			</div>
			<div class="col-12">
				<input class="btn btn-success" type="submit" name="buscar" value="Buscar">
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
						<th scope='col'>Descripción</th>
						<th scope='col'>Acción</th>
					</tr>
				</thead>
				<tbody>";
					$tabla = 'grupos';
					$consulta = $objeto -> SQL_consulta_condicional($tabla, "*", "nombre like '%$nombre%'");
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
								<td><input type='checkbox' name='seleccionados[]' value='$fila[idGrupo]'></td>
								<th scope='row'>$fila[idGrupo]</th>
								<td>$fila[nombre]</td>
								<td>$fila[descripcion]</td>
								<td><a class='btn btn-warning' href='Administrador.php?pagina=Modificar/Edit_Grupos.php&grupo=$fila[idGrupo]'>Modificar</a></td>
							</tr>";
							$_SESSION["Btn_Eliminar"]="Enabled";
						}
					}
					?>
					<tr>
						<td colspan="4"><div class="d-flex justify-content-center"><input class="btn btn-danger justify-content-center"type="submit" name="eliminar" value="Eliminar" <?php echo $_SESSION["Btn_Eliminar"]?>></div></td>
						<td><a class="btn btn-info" href='Administrador.php?pagina=Grupos.php'>Ver todos</a></td>
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

			foreach($seleccionados as $idGrupos)
			{
				$tablaInventario = "inventario INNER JOIN grupos ON (inventario.idGrupo_FK2 = grupos.idGrupo) WHERE idGrupo=$idGrupo";
				$camposInventario = "idGrupo_FK2";
				$tablaSubgrupo ="subgrupos INNER JOIN grupos ON (subgrupos.idGrupo_FK = grupos.idGrupo) WHERE idGrupo=$idGrupo";
				$camposSubgrupo="idGrupo_FK";
				$consultaInv = $objeto -> SQL_consulta($tablaInventario, $camposInventario);
				$consultaSub = $objeto -> SQL_consulta($tablaSubgrupo, $camposSubgrupo);
				if (mysqli_num_rows($consultaInv) > 0 || mysqli_num_rows($consultaSub) > 0) 
				{
					echo "<script>alert('El grupo puede estar en las tablas inventario o subgrupos, eliminalo primero de dichas tablas.')</script>";
				}
				else
				{
					$rs = $objeto -> SQL_eliminar("grupos", "idGrupo = $idGrupo");
					echo "<script>alert('GRUPO ELIMINADO');window.location='?pagina=Grupos.php';</script>";
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
								<th scope='col'>Descripción</th>
								<th scope='col'>Acción</th>
							</tr>
						</thead>
						<tbody>";
								$tabla = 'grupos';
								$consulta = $objeto -> SQL_consulta($tabla, "*");
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
											<td><input type='checkbox' id='seleccionados[]' name='seleccionados[]' value='$fila[idGrupo]'></td>
											<th scope='row'>$fila[idGrupo]</th>
											<td>$fila[nombre]</td>
											<td>$fila[descripcion]</td>
											<td><a class='btn btn-warning' href='Administrador.php?pagina=Modificar/Edit_Grupos.php&grupo=$fila[idGrupo]'>Modificar</a></td>
										</tr>";
										$_SESSION["Btn_Eliminar"]="Enabled";
									}
								}
							?>
							<tr>
								<td colspan="5"><div class="d-flex justify-content-center"><input class="btn btn-danger justify-content-center" type="submit" name="eliminar" value="Eliminar" <?php echo $_SESSION["Btn_Eliminar"]?>></div></td>
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

			foreach($seleccionados as $idGrupo)
			{
				$tablaInventario = "inventario INNER JOIN grupos ON (inventario.idGrupo_FK2 = grupos.idGrupo) WHERE idGrupo=$idGrupo";
				$camposInventario = "idGrupo_FK2";
				$tablaSubgrupo ="subgrupos INNER JOIN grupos ON (subgrupos.idGrupo_FK = grupos.idGrupo) WHERE idGrupo=$idGrupo";
				$camposSubgrupo="idGrupo_FK";
				$consultaInv = $objeto -> SQL_consulta($tablaInventario, $camposInventario);
				$consultaSub = $objeto -> SQL_consulta($tablaSubgrupo, $camposSubgrupo);
				if (mysqli_num_rows($consultaInv) > 0 || mysqli_num_rows($consultaSub) > 0) 
				{
					echo "<script>alert('El grupo puede estar en las tablas inventario o subgrupos, eliminalo primero de dichas tablas.')</script>";
				}
				else
				{
					$rs = $objeto -> SQL_eliminar("grupos", "idGrupo = $idGrupo");
					echo "<script>alert('GRUPO ELIMINADO');window.location='?pagina=Grupos.php';</script>";
				}
			}
		}
	}
?>