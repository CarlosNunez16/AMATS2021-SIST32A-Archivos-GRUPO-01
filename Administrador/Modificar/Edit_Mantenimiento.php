
<?php
    if (isset($_POST["enviar"]))
    {
        $datos[]= $_GET["id"];
        $datos[]= $_GET["User"];
        $datos[]= $_POST["refacciones"];

        $tabla = "refacciones";
        $campos = array('idMantenimiento_FK','carnet_FK4','refacciones');
        $rs = $objeto -> SQL_insert($tabla, $campos, $datos);

        $datosMant["refacciones"]= $datos[2];
        $condicion = "idMantenimiento = ".$_GET["id"]."";
        $reporte = $objeto -> SQL_modificar("mantenimientos", $datosMant, $condicion);

        echo "<script>alert('Refacciónes guardadas')</script>";
    }
    else
    {
        $datosMant["refacciones"]= "Sin refacciones";
        $condicion = "idMantenimiento = ".$_GET["id"]."";
        $reporte = $objeto -> SQL_modificar("mantenimientos", $datosMant, $condicion);
    }
?>

<div class="row d-flex justify-content-center">
    <div class="col-4 m-3 s-1 p-3 border border-dark rounded-3 d-block" style="background-color:#F5F5F5">
        <form class="row g-3 needs-validation" method="post">
            <div class="col-md-12">
                <label class='form-label' for='refacciones'>Listado de refacciones (opcional): </label>
                <div class='form-floating'>
                    <textarea class='form-control' name='refacciones'></textarea>
                    <label for='floatingTextarea'>Escriba aquí</label>
                </div>
            </div>
            <div class="col-md-12">
                <label for="gasto" class="form-label">Gasto total ($):</label>
                <input class="form-control" type="number" placeholder="$" step="0.01" name="gasto" required>
            </div>
            <div class="col-md-12">
                <label for="duracion" class="form-label">Duración:</label>
                <input class="form-control" type="text" placeholder="Días, horas o minutos" name="duracion" required>
            </div>
            <div class="col-md-12">
            <?php
            $tabla = "inventario";
            $consulta = $objeto -> SQL_consulta_condicional($tabla, "*", "idActivo = ".$_GET["Activo"]."");
            while ($fila = $consulta -> fetch_assoc())
            {
                echo "
                <label for='calidad' class='form-label'>Nueva calidad del activo:</label>
                <select name='calidad' class='form-select' required>";
                $calidad = "$fila[calidad]";

                if($calidad == "Necesita reparación")
                {
                    echo "<Option value='Excelente'";
                    if ($calidad == "Excelente")
                    {
                        echo "selected";
                    }
                    echo ">Excelente</Option>";

                    echo "<Option value='Muy bueno'";
                    if ($calidad == 'Muy bueno')
                    {
                        echo "selected";
                    }
                    echo ">Muy bueno</Option>";

                    echo "<Option value='Bueno'";
                    if ($calidad == 'Bueno')
                    {
                        echo "selected";
                    }
                    echo ">Bueno</Option>";

                    echo "<Option value='Malo'";
                    if ($calidad == 'Malo')
                    {
                        echo "selected";
                    }
                    echo ">Malo</Option>";

                    echo "<Option value='Necesita reparación'";
                    if ($calidad == 'Necesita reparación')
                    {
                        echo "selected";
                    }
                    echo ">Necesita reparación</Option>";
                }       
                elseif($calidad == "Malo")
                {
                    echo "<Option value='Excelente'";
                    if ($calidad == "Excelente")
                    {
                        echo "selected";
                    }
                    echo ">Excelente</Option>";


                    echo "<Option value='Muy bueno'";
                    if ($calidad == 'Muy bueno')
                    {
                        echo "selected";
                    }
                    echo ">Muy bueno</Option>";

                    echo "<Option value='Bueno'";
                    if ($calidad == 'Bueno')
                    {
                        echo "selected";
                    }
                    echo ">Bueno</Option>";

                    echo "<Option value='Malo'";
                    if ($calidad == 'Malo')
                    {
                        echo "selected";
                    }
                    echo ">Malo</Option>";

                }
                elseif($calidad == "Bueno")
                {
                    echo "<Option value='Excelente'";
                    if ($calidad == "Excelente")
                    {
                        echo "selected";
                    }
                    echo ">Excelente</Option>";


                    echo "<Option value='Muy bueno'";
                    if ($calidad == 'Muy bueno')
                    {
                        echo "selected";
                    }
                    echo ">Muy bueno</Option>"; 

                    echo "<Option value='Bueno'";
                    if ($calidad == 'Bueno')
                    {
                        echo "selected";
                    }
                    echo ">Bueno</Option>";   
                }
                elseif($calidad == "Muy bueno")
                {
                    echo "<Option value='Excelente'";
                    if ($calidad == "Excelente")
                    {
                        echo "selected";
                    }
                    echo ">Excelente</Option>";

                    echo "<Option value='Muy bueno'";
                    if ($calidad == 'Muy bueno')
                    {
                        echo "selected";
                    }
                    echo ">Muy bueno</Option>";
                }
                elseif($calidad == "Excelente")
                {
                    echo "<Option value='Excelente'";
                    if ($calidad == "Excelente")
                    {
                        echo "selected";
                    }
                    echo ">Excelente</Option>";
                }
                    
                echo"</select>";
            }
            ?>
            </div>
            <div class="col-12">
                <input class="btn btn-success" type="submit" name="Terminar" value="Terminar">
            </div>
        </form>
    </div>
</div>
<?php
if (isset($_POST["Terminar"])) 
{
    $datosAct["calidad"] = $_POST["calidad"];
    $condicionAct = "idActivo = ".$_GET["Activo"]."";
	$Act = $objeto -> SQL_modificar("inventario", $datosAct, $condicionAct);


    $datosRef[]= $_GET["id"];
    $datosRef[]= $_GET["User"];
    $datosRef[]= $_POST["refacciones"];
    if($datosRef[2]=="")
    {
        $datos["total"] = $_POST["gasto"];
        $datos["tiempo"] = $_POST["duracion"];
        $datos["calidad_nueva"] = $_POST["calidad"];
        $datos["refacciones"]= "Sin refacciones";
        $condicion = "idMantenimiento = ".$_GET["id"]."";
        $mantenimiento = $objeto -> SQL_modificar("mantenimientos", $datos, $condicion);
    }
    else
    {
        $tabla = "refacciones";
        $campos = array('idMantenimiento_FK','carnet_FK4','refacciones');
        $rs = $objeto -> SQL_insert($tabla, $campos, $datosRef);

        $datos["total"] = $_POST["gasto"];
        $datos["tiempo"] = $_POST["duracion"];
        $datos["calidad_nueva"] = $_POST["calidad"];
        $datos["refacciones"]= $datosRef[2];
        $condicion = "idMantenimiento = ".$_GET["id"]."";
        $mantenimiento = $objeto -> SQL_modificar("mantenimientos", $datos, $condicion);
    }

    echo "<script>alert('Mantenimiento terminado'); window.location='?pagina=Mantenimiento.php&opcion=all';</script>";
}
?>