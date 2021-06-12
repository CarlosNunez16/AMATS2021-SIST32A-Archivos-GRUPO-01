<h1 class="text-center m-3 fs-2">REASIGNACIONES</h1>
<div class="row d-flex justify-content-center">
	<div class="col-5 m-3 s-1 p-3 border border-dark rounded-3 d-block" style="background-color:#F5F5F5">
		<h1 class="text-center fs-4">REGISTRO</h1>
		<form class="row g-3 needs-validation" method="post">
			<div class="col-md-6">
				<label for="anterior" class="form-label">Usuario anterior:</label>
				<input type="number" class="form-control" value="<?php echo $_GET["Anterior"]?>" name="anterior"  disabled>
			</div>
            <div class="col-md-6">
				<label for="nuevo" class="form-label">Nuevo usuario:</label>
				<input type="number" class="form-control" value="<?php echo $_GET["Nuevo"]?>" name="nuevo"  disabled>
			</div>
            <div class="col-md-6">
				<label for="activo" class="form-label">Activo fijo N°:</label>
				<input type="number" class="form-control" value="<?php echo $_GET["Activo"]?>" name="activo"  disabled>
			</div>
            <div class="col-md-6">
				<label for="calidad" class="form-label">Calidad actual:</label>
				<input type="text" class="form-control" value="<?php echo $_GET["Calidad"]?>" name="calidad" disabled>
			</div>
			<div class="col-md-12">
                <label class="form-label" for="justificacion">Justificación: </label>
                <div class="form-floating">
                    <textarea class="form-control" name="justificacion" required></textarea>
                    <label for="floatingTextarea">Escriba aquí</label>
                </div>
            </div>
			<div class="col-12">
				<input class="btn btn-primary" type="submit" name="enviar" value="Registrar">
			</div>
		</form>
	</div>
</div>

<?php
    if(isset($_POST["enviar"]))
    {
        $datos[] = $_GET["Activo"];
        $datos[] = $_GET["Anterior"];
        $datos[] = $_GET["Nuevo"];
        $datos[] = $_GET["Calidad"];
        $datos[] = $_POST['justificacion'];
        $datos[] = date("Y-m-d");

        $tabla = "reasignaciones";
        $campos = array('idActivo_FK3','usuario_anterior','usuario_nuevo','calidad_actual','justificacion','fecha');

        $rs = $objeto -> SQL_insert($tabla, $campos, $datos);
        echo "<script>
                    var resultado = window.confirm('Reasignación registrada. ¿Quieres consultar las reasignaciones?');
                    if (resultado === true) 
                    {
                        window.location='?pagina=ConsReasignaciones.php&opcion=all';
                    } 
                    else 
                    {
                        alert('REASIGNACIÓN REGISTRADA'); window.location='?pagina=Inventario.php&opcion=all';
                    }
                </script>";
    }


?>