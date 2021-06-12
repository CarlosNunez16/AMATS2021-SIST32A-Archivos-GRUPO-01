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

        $tabla= "inventario INNER JOIN grupos ON (inventario.idGrupo_FK2 = grupos.idGrupo) INNER JOIN subgrupos ON (inventario.idSubgrupo_FK = subgrupos.idSubgrupo) INNER JOIN usuarios ON (inventario.carnet_FK = usuarios.carnet)";
        $consulta = $objeto -> SQL_consulta($tabla, "idActivo, carnet_FK, calidad");
        while ($fila = $consulta -> fetch_assoc())
        {
            if(!($fila["carnet_FK"] == $_GET["Carnet"]))
            {
                    echo "<script>
                            var resultado = window.confirm('Se ha hecho una reasignación. ¿Quieres registrar este cambio?');
                            if (resultado === true) 
                            {
                                window.location='?pagina=Reasignacion.php&Anterior=".$_GET["Carnet"]."&Nuevo=".$datos["carnet_FK"]."&Calidad=$fila[calidad]&Activo=$fila[idActivo]';
                            } 
                            else 
                            {
                                alert('ACTIVO FIJO EDITADO'); window.location='?pagina=Inventario.php&opcion=all';
                            }
                        </script>";
            }
        }
	}
	$tabla = "inventario";
	$consulta = $objeto -> SQL_consulta_condicional($tabla, "*", "idActivo= ".$_GET["idActivo"]."");
	while ($filas = $consulta -> fetch_assoc())
	{
		echo "
        <div class='row d-flex justify-content-center'>
	        <div class='col-8 m-3 s-1 p-3 border border-dark rounded-3 d-block' style='background-color:#F5F5F5'>
		        <form class='row g-3 needs-validation' method='post'>
                    <div class='col-md-6'>
                        <label for='grupos' class='form-label'>Grupo:</label>
                        <select class='form-select' name='grupos'>";
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
                    </div>
                    <div class='col-md-6'>
                        <label for='subgrupos' class='form-label'>Subgrupo:</label>
                        <select class='form-select' name='subgrupos'>";
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
                    </div>
                    <div class='col-md-6'>
                        <label class='form-label' for='nombre'>Nombre: </label>
                        <input class='form-control' type='text' value='$filas[nombre]' name='nombre' required>
                    </div>
                    <div class='col-md-6'>
                        <label class='form-label' for='marca'>Marca: </label>
                        <input class='form-control' type='text' value='$filas[marca]' name='marca' required>
                    </div>
                    <div class='col-md-6'>
                        <label class='form-label' for='modelo'>Modelo: </label>
                        <input class='form-control' type='text' value='$filas[modelo]' name='modelo' required>
                    </div>
                    <div class='col-md-6'>
                        <label class='form-label' for='color'>Color: </label>
                        <input class='form-control form-control-color' type='color' value='$filas[color]' name='color' required>
                    </div>
                    <div class='col-md-6'>
                        <label for='usuarios' class='form-label'>Usuario:</label>
                        <select class='form-select' name='usuarios'>
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
                    </div>
                    <div class='col-md-6'>
                        <label class='form-label' for='ubicacion'>Ubicación: </label>
                        <input class='form-control' type='text' value='$filas[ubicacion]' name='ubicacion' required>
                    </div>
                    <div class='col-md-6'>
                        <label class='form-label' for='calidad'>Calidad: </label>
                        <select class='form-select' name='calidad'>
                            <Option value='Excelente' "; if($calidad == "5"){ echo "selected";} echo">Excelente</Option>
                            <Option value='Muy bueno' "; if($calidad == "4"){ echo "selected";} echo">Muy bueno</Option>
                            <Option value='Bueno' "; if($calidad == "3"){ echo "selected";} echo">Bueno</Option>
                            <Option value='Malo' "; if($calidad == "2"){ echo "selected";} echo">Malo</Option>
                            <Option value='Necesita reparación'" ; if($calidad == "1"){ echo "selected";} echo">Necesita reparación</Option>
                        </select>
                    </div>
                    <div class='col-md-12'>
                        <input class='btn btn-success' type='submit' name='Modificar' value='Modificar'>
                    </div>
                </form>
            </div>
        </div>
        ";
	}
?>