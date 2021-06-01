<?php
@session_start();
$objeto = new ClsConnection();

	if (isset($_POST["Modificar"]))
	{
        $datos["idGrupo_FK"] = $_POST["grupos"];
		$datos["nombre"] = $_POST["nombre"];
		$datos["descripcion"] = $_POST["descripcion"];

		$condicion = "idSubgrupo = ".$_GET["Subgrupo"]."";
		$rs = $objeto -> SQL_modificar("subgrupos", $datos, $condicion);
		echo "<script>alert('SUBGRUPO EDITADO'); window.location='?pagina=Subgrupos.php';</script>";
	}
	$tabla = "subgrupos";
	$consulta = $objeto -> SQL_consulta_condicional($tabla, "*", "idSubgrupo = ".$_GET["Subgrupo"]."");
	while ($filas = $consulta -> fetch_assoc())
	{
        $subgrupo = "$filas[idSubgrupo]";
		echo "<form method='post'>
                <select name='grupos' required>";
                        $tabla = 'grupos';
                        $consultas = $objeto -> SQL_consulta($tabla, 'idGrupo, nombre');
                        while ($fila = $consultas -> fetch_assoc())
                        {
                            $idGrupo = "$fila[idGrupo]";
                            $subGrupo_FK = "$filas[idGrupo_FK]";

                                echo "<Option value='$fila[idGrupo]'";
                                if ($idGrupo == $subGrupo_FK)
                                {
                                    echo "selected";
                                }
                                echo ">$fila[nombre]</Option>";
                        }
                echo"</select>
                <label for='nombre'>Nombre: </label>
                <input type='text' name='nombre' value='$filas[nombre]' required>
                <label for='descripcion'>Descripción: </label>
                <input type='text' name='descripcion' value='$filas[descripcion]' required>

                <input type='submit' name='Modificar' value='Modificar'>
            </form> ";
	}
?>
