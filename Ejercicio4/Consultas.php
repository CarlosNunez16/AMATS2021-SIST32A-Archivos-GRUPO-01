<?php
@session_start();
require_once('Ejercicio2.php');
echo ContadorVisitas();
echo "<hr align='center'>";
ob_start();
?>

<?php

if (isset($_SESSION["encuesta"]))
	{
		echo "
		<div class='formulario'>
			<h2>Consultas</h2>
			<form method='POST'>
				<label class='preguntas' for='nombre'>Por nombre.</label>
				<input type='text' name='nombre' required>
				<input class='btn_Enviar' type='submit' value='BUSCAR' name='BtnNombre'>
			</form>
			<form method='POST'>
				<label class='preguntas' for='fecha'>Por fecha.</label>
				<input type='date' name='fecha' required>
				<input class='btn_Enviar' type='submit' value='BUSCAR' name='BtnFecha'>
			</form>
		</div>
		";

		if (isset($_POST["BtnNombre"]))
		{
			$nombre = $_POST["nombre"];
			echo "<table>
				<form method='post'>
				<thead>
					<tr>
						<th></th>
						<th>Nombre</th>
						<th>Sexo</th>
						<th>Deporte Favorito</th>
						<th>Nivel de estudio</th>
						<th>Tema Favorito</th>
						<th>Fecha</th>
						<th>Hora</th>
						<th>Acción</th>
					</tr>
				</thead>
				<tbody>";
				foreach ($_SESSION["encuesta"] as $llave => $valor)
				{
					if ($llave==$nombre)    
					{
						echo "
						<tr>
							<td>
								<input type='checkbox' name='seleccionados[]' value='$llave'>
							</td>
							<td>
								$llave
							</td>
							<td>
							$valor[0]
							</td>
							<td>
							$valor[1]
							</td>
							<td>
							$valor[2]
							</td>
							<td>
							$valor[3]
							</td>
							<td>
							$valor[4]
							</td>
							<td>
							$valor[5]
							</td>
							<td>
							<a href='?pagina=Editar.php&encuesta=$llave'>Modificar</a>
							</td>
						</tr>
						";
					}
					
				}

				echo "<tr>	
							<td colspan='9'>
								<input type='submit' name='BtnEliminar' value='ELIMINAR'>
							</td>
						</tr>
					</tbody>
				</form>
			</table>";

			if (isset($_POST["BtnEliminar"])) 
			{
				if (isset($_POST["seleccionados"])) 
				{
					foreach ($_POST["seleccionados"] as $valor)
					{
						unset($_SESSION["encuesta"][$valor]);
						header("location:?pagina=Ejercicio4/Consultas.php");
						if ($n==0)
						{
							session_destroy($_SESSION["encuesta"]);
						}
					}
				}
			}
		}
		elseif (isset($_POST["BtnFecha"]))
		{
			$fecha = $_POST["fecha"];
			echo "<table>
				<form method='post'>
				<thead>
					<tr>
						<th></th>
						<th>Nombre</th>
						<th>Sexo</th>
						<th>Deporte Favorito</th>
						<th>Nivel de estudio</th>
						<th>Tema Favorito</th>
						<th>Fecha</th>
						<th>Hora</th>
						<th>Acción</th>
					</tr>
				</thead>
				<tbody>";
				foreach ($_SESSION["encuesta"] as $llave => $valor)
				{
					if ($valor[4]==$fecha)    
					{
						echo "
						<tr>
							<td>
								<input type='checkbox' name='seleccionados[]' value='$llave'>
							</td>
							<td>
								$llave
							</td>
							<td>
							$valor[0]
							</td>
							<td>
							$valor[1]
							</td>
							<td>
							$valor[2]
							</td>
							<td>
							$valor[3]
							</td>
							<td>
							$valor[4]
							</td>
							<td>
							$valor[5]
							</td>
							<td>
							<a href='?pagina=Editar.php&encuesta=$llave'>Modificar</a>
							</td>
						</tr>
						";
					}
					
				}
				echo "<tr>	
							<td colspan='9'>
								<input type='submit' name='BtnEliminar' value='ELIMINAR'>
							</td>
						</tr>
					</tbody>
				</form>
			</table>";

			if (isset($_POST["BtnEliminar"])) 
			{
				if (isset($_POST["seleccionados"])) 
				{
					foreach ($_POST["seleccionados"] as $valor)
					{
						unset($_SESSION["encuesta"][$valor]);
						header("location:?pagina=Ejercicio4/Consultas.php");
						if ($n==0)
						{
							session_destroy($_SESSION["encuesta"]);
						}
					}
				}
			}
		} 
		else {
			echo "<table>
				<form method='post'>
				<thead>
					<tr>
						<th></th>
						<th>Nombre</th>
						<th>Sexo</th>
						<th>Deporte Favorito</th>
						<th>Nivel de estudio</th>
						<th>Tema Favorito</th>
						<th>Fecha</th>
						<th>Hora</th>
						<th>Acción</th>
					</tr>
				</thead>
				<tbody>";
				if (isset($_SESSION["encuesta"]))
				{
					foreach ($_SESSION["encuesta"] as $llave => $valor) 
					{
						echo "
						<tr>
							<td>
								<input type='checkbox' name='seleccionados[]' value='$llave'>
							</td>
							<td>
								$llave
							</td>
							<td>
							$valor[0]
							</td>
							<td>
							$valor[1]
							</td>
							<td>
							$valor[2]
							</td>
							<td>
							$valor[3]
							</td>
							<td>
							$valor[4]
							</td>
							<td>
							$valor[5]
							</td>
							<td>
							<a href='?pagina=Editar.php&encuesta=$llave'>Modificar</a>
							</td>
						</tr>
						";
					}
				}
				else 
				{
					echo "<tr><td colspan='9'>10Nadie ha realizado la encuesta todavía :(</td></tr>";
				}
						echo "<tr>	
							<td colspan='9'>
								<input type='submit' name='BtnEliminar' value='ELIMINAR'>
							</td>
						</tr>
					</tbody>
				</form>
			</table>";

			if (isset($_POST["BtnEliminar"])) 
			{
				if (isset($_POST["seleccionados"])) 
				{
					foreach ($_POST["seleccionados"] as $valor)
					{
						unset($_SESSION["encuesta"][$valor]);
						header("location:?pagina=Ejercicio4/Consultas.php");
						$n=count($_SESSION["encuesta"]);
						if ($n==0)
						{
							session_destroy($_SESSION["encuesta"]);
						}
					}
				}
			}
		}
	}
	else
	{
		echo "<table><tr><td>Nadie ha realizado la encuesta todavía :(</td></tr></table>";
	}
?>