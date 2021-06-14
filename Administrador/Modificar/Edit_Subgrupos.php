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
        echo"
            <div class='row d-flex justify-content-center'>
                <div class='col-5 m-3 s-1 p-3 border border-dark rounded-3 d-block' style='background-color:#F5F5F5'>
                    <form class='row g-3 needs-validation' method='post'>
                        <div class='col-md-6'>
                            <label for='grupos' class='form-label'>Grupo:</label>
                            <select name='grupos' class='form-control' required>";
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
                        </div>
                        <div class='col-md-6'>
                            <label class='form-label' for='nombre'>Nombre: </label>
                            <input class='form-control' value='$filas[nombre]' type='text' name='nombre' required>
                        </div>
                        <div class='col-md-12'>
                            <label class='form-label' for='descripcion'>Descripción: </label>
                            <input class='form-control' value='$filas[descripcion]' type='text' name='descripcion' required>
                        </div>
                        <div class='col-12'>
                            <input class='btn btn-success' type='submit' name='Modificar' value='Modificar'>
                            <a class='btn btn-danger' href='Administrador.php?pagina=Subgrupos.php'>Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        ";
	}
?>
