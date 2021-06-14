<?php
@session_start();
@$objeto = new ClsConnection();
?>

<h1 class="text-center m-3 fs-2">USUARIOS BANEADOS</h1>
<div class="row d-flex justify-content-center">
	<div class="col-5 m-3 s-1 p-3 border border-dark rounded-3 d-block" style="background-color:#F5F5F5">
		<h1 class="text-center fs-4">CONSULTA</h1>
		<form class="row g-3 needs-validation" name='form1' method="post" target='_self'>
            <div class="col-md-9">
                <?php
                    if(isset($_GET["opcion"]))
                    {
                        if($_GET["opcion"] == "Carnet")
                        {
                            echo"
                                <label class='form-label' for='dato'>Ingresar carnet:</label> 
                                <input class='form-control' type='number' min='0' name='dato' required>
                            ";
                        }
                        else
                        {
                            echo"
                                <label class='form-label' for='dato'>Escriba aquí:</label>
                                <input class='form-control' type='text' name='dato' required>
                            ";
                        }
                    }
                ?>
            </div> 
            <div class="col-md-3">
                <label class="form-label" for="tipo">Buscar por...</label>
                <select class="form-select" name="tipo" onChange='javascript:abreSitio()' required>
                    <option value='#'>Elegir...</option>
					<option value='?pagina=Baneados.php&opcion=Carnet'>Carnet</option>
                    <option value='?pagina=Baneados.php&opcion=Nombres'>Nombres</option>
                    <option value='?pagina=Baneados.php&opcion=Apellidos'>Apellidos</option>
                    <option value='?pagina=Baneados.php&opcion=Tipo'>Tipo de usuario</option>
                    <option value='?pagina=Baneados.php&opcion=Carrera'>Carrera</option>
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
        <a href="imprimir.php?tabla=baneados" target="_blank" class="btn btn-secondary" title="IMPRIMIR">
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
			<div class='col-12 m-3'>
				<table class='table table-dark table-striped table-hover'>
					<form method='post'>
						<thead>
							<tr>
								<th scope='col'>Carnet</th>
								<th scope='col'>Nombres</th>
								<th scope='col'>Apellidos</th>
								<th scope='col'>Correo</th>
								<th scope='col'>Dirección</th>
								<th scope='col'>Tipo de Usuario</th>
								<th scope='col'>Carrera</th>
								<th scope='col'>Cantidad de reportes</th>
								<th scope='col'>Acción</th>
							</tr>
						</thead>
						<tbody>";
						if($_GET["opcion"] == "Carnet" || $_GET["opcion"] == "all")
						{
							$condicion = "carnet like '%$dato%' and cantidad_reportes > 4";
						}
						elseif($_GET["opcion"] == "Nombres")
						{
							$condicion = "nombres like '%$dato%' and cantidad_reportes > 4";
						}
						elseif($_GET["opcion"] == "Apellidos")
						{
							$condicion = "apellidos like '%$dato%' and cantidad_reportes > 4";
						}
						elseif($_GET["opcion"] == "Tipo")
						{
							$condicion = "tipo_usuario like '%$dato%' and cantidad_reportes > 4";
						}
						elseif($_GET["opcion"] == "Carrera")
						{
							$condicion = "carrera like '%$dato%' and cantidad_reportes > 4";
						}
								$tabla = 'usuarios';
								$consulta = $objeto -> SQL_consulta_condicional($tabla, "*", $condicion);

								if (mysqli_num_rows($consulta) < 1) 
								{
									echo "<tr><td colspan='14' class='text-center'>NO HAY COINCIDENCIAS.</td></tr>";
								}
								else
								{
									while ($fila = $consulta -> fetch_assoc())
									{
										if($fila["cantidad_reportes"]<1)
										{
											$_SESSION["Btn_Restar"]="Disabled";
										}
										else
										{
											$_SESSION["Btn_Restar"]="Enabled";
										}
									echo "<tr>
											<th scope='row'>$fila[carnet]</th>
											<td>$fila[nombres]</td>
											<td>$fila[apellidos]</td>
											<td>$fila[correo]</td>
											<td>$fila[direccion]</td>
											<td>$fila[tipo_usuario]</td>
											<td>$fila[carrera]</td>
											<td>$fila[cantidad_reportes]</td>
											<td><a class='btn btn-warning btn-sm ".$_SESSION["Btn_Restar"]."' href='Administrador.php?pagina=Modificar/Desbanear.php&carnet=$fila[carnet]'>Desbanear</a></td>
										</tr>";
									}
								}
									echo"<tr>
											<td colspan='9'><div class='d-flex justify-content-center'><a class='btn btn-info' href='Administrador.php?pagina=Baneados.php&opcion=all'>Ver todos</a></div></td>
										</tr>
						</tbody>
					</form>
				</table>
			</div>
		</div>";
}
else
{
		echo "
		<div class='row d-flex justify-content-center'>
			<div class='col-12 m-3'>
				<table class='table table-dark table-striped table-hover'>
					<form method='post'>
						<thead>
							<tr>
								<th scope='col'>Carnet</th>
								<th scope='col'>Nombres</th>
								<th scope='col'>Apellidos</th>
								<th scope='col'>Correo</th>
								<th scope='col'>Dirección</th>
								<th scope='col'>Tipo de Usuario</th>
								<th scope='col'>Carrera</th>
								<th scope='col'>Cantidad de reportes</th>
								<th scope='col'>Acción</th>
							</tr>
						</thead>
						<tbody>";
								$tabla = 'usuarios';
                                $condicion = " where cantidad_reportes > 4";
								$consulta = $objeto -> SQL_consulta($tabla.$condicion, "*");

								if (mysqli_num_rows($consulta) < 1) 
								{
									echo "<tr><td colspan='14' class='text-center'>NO HAY USUARIOS BANEADOS.</td></tr>";
								}
								else
								{
									while ($fila = $consulta -> fetch_assoc())
									{
										if($fila["cantidad_reportes"]<1)
										{
											$_SESSION["Btn_Restar"]="disabled";
										}
										else
										{
											$_SESSION["Btn_Restar"]="";
										}
									echo "<tr>
											<th scope='row'>$fila[carnet]</th>
											<td>$fila[nombres]</td>
											<td>$fila[apellidos]</td>
											<td>$fila[correo]</td>
											<td>$fila[direccion]</td>
											<td>$fila[tipo_usuario]</td>
											<td>$fila[carrera]</td>
											<td>$fila[cantidad_reportes]</td>
											<td><a class='btn btn-warning btn-sm ".$_SESSION["Btn_Restar"]."' href='Administrador.php?pagina=Modificar/Desbanear.php&carnet=$fila[carnet]'>Desbanear</a></td>
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