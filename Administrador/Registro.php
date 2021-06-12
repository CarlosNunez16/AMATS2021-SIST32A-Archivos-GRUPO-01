<div class="row d-flex justify-content-center">
	<div class="col-5 m-3 s-1 p-3 border border-danger rounded-3 d-block" style="background-color:#F5F5F5">
		<h1 class="text-center fs-4" style="color:#8B0000">REGISTRO</h1> 
		<form class="row g-3 needs-validation" method="post">
            <div class="col-md-6">
                <label for="nombres" class="form-label" style="color:#8B0000">Nombres:</label>
                <input class="form-control" type="text" name="nombres" required> 
            </div>
            <div class="col-md-6">
                <label class="form-label" for="apellidos" style="color:#8B0000">Apellidos:</label>
                <input class="form-control" type="text" name="apellidos" required>
            </div>
            <div class="col-md-6">
                <label for="carnet" class="form-label" style="color:#8B0000">Carnet:</label>
                <input class="form-control"  type="number" min="0" name="carnet" required>
            </div>
            <div class="col-md-6">
                <label for="correo" class="form-label" style="color:#8B0000">Correo Institucional:</label>
                <input class="form-control" type="email" class="form-control" name="correo" pattern="+@itca.edu.sv" placeholder="+@itca.edu.sv" required>
            </div>
            <div class="col-md-6">
                <label for="direccion" class="form-label" style="color:#8B0000">Dirección:</label>
                <input class="form-control" type="text" name="direccion" required>
            </div>
            <div class="col-md-6">
                <label for="tipoUsuario" class="form-label" style="color:#8B0000">Tipo de usuario:</label>
                <select name="tipoUsuario" class="form-select" id="tipoUsuario" required>
                    <option value="Administrador">Administrador</option>
                    <option value="Empleado">Empleado</option>
                    <option value="Estudiante">Estudiante</option> 
                </select>
            </div>
            <div class="col-md-12">
                <label for="carreras" class="form-label" style="color:#8B0000">Carrera/s:</label>
                    <div class="form-check text-start">
                        <input class="form-check-input" type="checkbox" name="carreras[]" value="Técnico en Ingeniería de Sistemas Informáticos">
                        <label class="form-check-label" for="Técnico en Ingeniería de Sistemas Informáticos">Técnico en Ingeniería de Sistemas Informáticos</label>
                    </div>
                    <div class="form-check text-start">
                        <input class="form-check-input" type="checkbox" name="carreras[]" value="Técnico en Hardware Computacional">
                        <label class="form-check-label" for="Técnico en Hardware Computacional">Técnico en Hardware Computacional</label>
                    </div>
                    <div class="form-check text-start">
                        <input class="form-check-input" type="checkbox" name="carreras[]" value="Técnico en Gestión Tecnológica del Patrimonio Cultural" >
                        <label class="form-check-label" for="Técnico en Gestión Tecnológica del Patrimonio Cultural">Téc. en Gestión Tecnológica del Patrimonio Cultural</label>
                    </div>
                    <div class="form-check text-start">
                        <input class="form-check-input" type="checkbox" name="carreras[]" value="Técnico en Ingeniería Eléctrica" >
                        <label class="form-check-label" for="Técnico en Ingeniería Eléctrica">Técnico en Ingeniería Eléctrica</label>
                    </div>
            </div>
            <div class="col-md-12">
                <div class="d-flex justify-content-center"><input class="btn btn-primary" type="submit" name="enviar" value="Registrar"></div> 
            </div>
        </form>
    </div>
</div>

<?php
if (isset($_POST["enviar"])) 
{
    $datos[] = $_POST["carnet"];
    $datos[] = $_POST["nombres"];
    $datos[] = $_POST["apellidos"];
    $datos[]= $_POST["correo"]; 
    $datos[] = $_POST["direccion"];
    $datos[] = $objeto -> SQL_Encriptar_Desencriptar("encriptar", "user2021");
    $datos[] = $_POST["tipoUsuario"];
    if (isset($_POST["carreras"])) 
    {
        $carrera = implode(",", $_REQUEST["carreras"]);
        $datos[] = $carrera;
    }
    $datos[]=0;

    $tabla = "usuarios";
    $consulta = $objeto -> SQL_consulta_condicional($tabla, "carnet", "carnet = ".$datos[0]."");


        if (mysqli_num_rows($consulta) > 0) 
        {
            echo "<script>alert('Ya existe')</script>";
        }
        else
        {
            $campos = array('carnet','nombres','apellidos', 'correo', 'direccion', 'contraseña', 'tipo_usuario', 'carrera', 'cantidad_reportes');

            $rs = $objeto -> SQL_insert($tabla, $campos, $datos);
            echo "<script>window.alert('¡Usuario registrado!');</script>";
        } 
}
?>