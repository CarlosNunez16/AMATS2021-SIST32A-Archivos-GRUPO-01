<?php
@session_start();
$objeto = new ClsConnection();

	if (isset($_POST["Modificar"]))
	{
        $datos["idGrupo_FK2"] = $_POST["grupos"];
		$datos["idSubgrupo_FK"] = $_POST["subgrupos"];
		$datos["nombre"] = $_POST["nombre"];
        $datos["marca"] = $_POST["marca"];
        $datos["modelo"] = $_POST["modelo"];
        $datos["color"] = $_POST["color"];
        $datos["carnet_FK"] = $_POST["usuarios"];
        $datos["ubicacion"] = $_POST["ubicacion"];
        $datos["calidad"] = $_POST["calidad"];

		$condicion = "idActivo = ".$_GET["idActivo"]."";
		$rs = $objeto -> SQL_modificar("inventario", $datos, $condicion);
		echo "<script>alert('ACTIVO FIJO EDITADO'); window.location='?pagina=Inventario.php&opcion=all';</script>";
	}
	$tabla = "inventario";
	$consulta = $objeto -> SQL_consulta_condicional($tabla, "*", "idActivo= ".$_GET["idActivo"]."");
	while ($filas = $consulta -> fetch_assoc())
	{
		echo "<form method='post'>
        <select name='grupos'>";
            $tabla = 'grupos';
            $consultas = $objeto -> SQL_consulta($tabla, 'idGrupo, nombre');
            while ($fila = $consultas -> fetch_assoc())
            {
                $idGrupo = "$fila[idGrupo]";
                $idGrupo_FK2 = "$filas[idGrupo_FK2]";

                    echo "<Option value='$fila[idGrupo]'";
                    if ($idGrupo == $idGrupo_FK2)
                    {
                        echo "selected";
                    }
                    echo ">$fila[nombre]</Option>";
            }
        echo "</select>
        <select name='subgrupos'>";
        $tabla = 'subgrupos';
        $consulta = $objeto -> SQL_consulta($tabla, 'idSubgrupo, nombre');
        while ($fila = $consulta -> fetch_assoc())
        {
            $idSubgrupo = "$fila[idSubgrupo]";
            $idSubgrupo_FK = "$filas[idSubgrupo_FK]";

            echo "<Option value='$fila[idSubgrupo]'";
            if ($idSubgrupo == $idSubgrupo_FK)
            {
                echo "selected";
            }
            echo ">$fila[nombre]</Option>";
        }
        echo "
        </select>

        <label for='nombre'>Nombre: </label>
        <input type='text' value='$filas[nombre]' name='nombre' required>
        <label for='marca'>Marca: </label>
        <input type='text' value='$filas[marca]' name='marca' required>
        <label for='modelo'>Modelo: </label>
        <input type='text' value='$filas[modelo]' name='modelo' required>
        <label for='color'>Color: </label>
        <input type='color' value='$filas[color]' name='color' required>
        <select name='usuarios'>
        ";
        $tabla = 'usuarios';
        $consulta = $objeto -> SQL_consulta($tabla, 'carnet, nombres, apellidos');
        while ($fila = $consulta -> fetch_assoc())
        {
            $carnet = "$fila[carnet]";
            $carnet_FK = "$filas[carnet_FK]";

            echo "<Option value='$fila[carnet]'";
            if ($carnet == $carnet_FK)
            {
                echo "selected";
            }
            echo ">$fila[nombres] $fila[apellidos]</Option>";
        }
        $calidad="$filas[calidad]";
        echo "
        </select>
            <label for='ubicacion'>Ubicación: </label>
            <input type='text' value='$filas[ubicacion]' name='ubicacion' required>
            <select name='calidad'>
                <Option value='Excelente' "; if($calidad == "5"){ echo "selected";} echo">Excelente</Option>
                <Option value='Muy bueno' "; if($calidad == "4"){ echo "selected";} echo">Muy bueno</Option>
                <Option value='Bueno' "; if($calidad == "3"){ echo "selected";} echo">Bueno</Option>
                <Option value='Malo' "; if($calidad == "2"){ echo "selected";} echo">Malo</Option>
                <Option value='Necesita reparación'" ; if($calidad == "1"){ echo "selected";} echo">Necesita reparación</Option>
            </select>

            <input type='submit' name='Modificar' value='Modificar'>
        </form>
        ";
	}
?>