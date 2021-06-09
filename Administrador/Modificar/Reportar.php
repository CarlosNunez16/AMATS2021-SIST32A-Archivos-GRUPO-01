<div class="row d-flex justify-content-center">
    <div class="col-5 m-3 s-1 p-3 border border-dark rounded-3 d-block" style="background-color:#F5F5F5">
        <form class="row g-3 needs-validation" method="post">
            <div class="col-md-6">
                <label for="prestamo" class="form-label">ID del préstamo:</label>
                <input class="form-control" value='<?php echo $_GET["Prestamo"];?>' type="text" name="prestamo" disabled>
            </div>
            <div class="col-md-12">
                <label class="form-label" for="descripcion">Detalles del reporte: </label>
                <div class="form-floating">
                    <textarea class="form-control" name="descripcion" required></textarea>
                    <label for="floatingTextarea">Escriba aquí</label>
                </div>
            </div>
            <div class="col-12">
                <input class="btn btn-danger" type="submit" name="Reportar" value="Reportar">
            </div>
        </form>
    </div>
</div>
<?php
if (isset($_POST["Reportar"]))
{
    $datos[] = $_GET["Prestamo"];
	$datos[] = date("Y-m-d");
	$datos[] = $_POST["descripcion"];

    $campos = array('idPrestamo_FK','fecha','detalles');
    $tabla = "reportes";
    $rs = $objeto -> SQL_insert($tabla, $campos, $datos);

    $uno=1;
    $datosUser["cantidad_reportes"]= "cantidad_reportes+".$uno;
    $condicion = "carnet = ".$_GET["User"]."";
	$reporte = $objeto -> SQL_modificarReporte("usuarios", $datosUser, $condicion);

    echo "<script>alert('REPORTE GUARDADO'); window.location='?pagina=Prestamos.php&opcion=all';</script>";
}
?>