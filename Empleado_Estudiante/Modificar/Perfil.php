<div class="row d-flex justify-content-center">
	<div class="col-6 m-3 s-1 p-3 border border-dark rounded-3 d-block" style="background-color:#F5F5F5">
        <h1 class="text-center fs-4">Información del <?php echo $_SESSION["Estudiante_Empleado"][3];?></h1>
		<form class="row g-3 needs-validation" name='form1' method="post" target='_self'>
        <?php
        $tabla = "usuarios where carnet = ".$_SESSION["Estudiante_Empleado"][0]."";
        $campos = "*";

        $consulta = $objeto -> SQL_consulta($tabla, $campos);
        while ($fila = $consulta -> fetch_assoc())
        {
            echo "<div class='col-md-4'>
                    <h5>Carnet:</h5>
                    <p>$fila[carnet]</p>
                </div>
                <div class='col-md-4'>
                    <h5>Nombres:</h5>
                    <p>$fila[nombres]</p>
                </div>
                <div class='col-md-4'>
                    <h5>Apellidos:</h5>
                    <p>$fila[apellidos]</p>
                </div>
                <div class='col-md-4'>
                    <h5>Correo:</h5>
                    <p>$fila[correo]</p>
                </div>
                <div class='col-md-4'>
                    <h5>Dirección:</h5>
                    <p>$fila[direccion]</p>
                </div>
                <div class='col-md-4'>
                    <h5>Tipo de usuario:</h5>
                    <p>$fila[tipo_usuario]</p>
                </div>
                <div class='col-md-4'>
                    <h5>Carrera/s:</h5>
                    <p>$fila[carrera]</p>
                </div>
                <div class='col-md-4'>
                    <h5>Cantidad de reportes:</h5>
                    <p>$fila[cantidad_reportes]</p>
                </div>


                
                ";
        }
        ?>
        </form>
    </div>
</div>