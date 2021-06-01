<br><br>
<div class="container">
    <div class="row">
        <div class="col-md-4 ">
        </div>
    <div class="col-md-4 float-left" > <!--justify-content-center -->
        
    </div>
    <div class="col-md-4 ">
    </div>
</div>
<!--Primer contenedor-->
<form method="post">
<div class="container">
    <div class="row">
        <div class="col-md-3 "> 
        </div>
<!-- PRINCIPAL CNT-->
<div class="col-md-5 bg-ligth text-center border border-danger rounded-3">
    <h2 style="color:#8B0000">REGISTRO DE USUARIO.</h2>
    <label for="nombres"><p class="text-danger">Nombres:</label></p>
    <input class="form-control" type="text" name="nombres" required>
    <br>
    <label for="apellidos"><p class="text-danger">Apellidos:</label></p>
    <input class="form-control" type="text" name="apellidos" required>
    <br>
    <label for="carnet"><p class="text-danger">Carnet:</label></p>
    <input class="form-control"  type="number" min="0" name="carnet" required>
    <br>
    <label for="correo"><p class="text-danger">Correo Institucional:</label></p>
    <input class="form-control" type="email" class="form-control" name="correo" pattern="+@itca.edu.sv" placeholder="+@itca.edu.sv" required>
    <br>
    <label for="direccion"><p class="text-danger">Dirección:</label></p>
    <input class="form-control" type="text" name="direccion" required>
    <br>
    <label for="clave>"><p class="text-danger">Contraseña:</label></p>
    <input type="password" class="form-control" name="clave" required>
    <br>
    <div class="form-group">
    <label for="tipoUsuario"><p class="text-danger">Tipo de usuario:</label>
    <br><br>
    <select name="tipoUsuario" class="form-control" id="tipoUsuario" required>
    
    <option value="Administrador">Administrador</option>
    <option value="Empleado">Empleado</option>
    <option value="Estudiante">Estudiante</option>
    </select></p>
</div>
<br>
    <label for="carreras"><p class="text-danger">Carrera/s:</label>
<br>
<div class="form-check text-start">
    <input class="form-check-input" type="checkbox" name="carreras[]" value="Técnico en Ingeniería de Sistemas Informáticos">
    <label class="form-check-label" for="Técnico en Ingeniería de Sistemas Informáticos"><p class="text-dark">Técnico en Ingeniería de Sistemas Informáticos</p>
</div>
<br>
<div class="form-check text-start">
    <input class="form-check-input" type="checkbox" name="carreras[]" value="Técnico en Hardware Computacional">
    <label class="form-check-label" for="Técnico en Hardware Computacional"><p class="text-dark">Técnico en Hardware Computacional</p>
</div>
    <br>
<div class="form-check text-start">
    <input class="form-check-input" type="checkbox" name="carreras[]" value="Técnico en Gestión Tecnológica del Patrimonio Cultural" >
    <label class="form-check-label" for="Técnico en Gestión Tecnológica del Patrimonio Cultural"><p class="text-dark">Téc. en Gestión Tecnológica del Patrimonio Cultural</p>
</div>
<br>
    <div class="form-check  text-start">
    <input class="form-check-input" type="checkbox" name="carreras[]" value="Técnico en Ingeniería Eléctrica" >
    <label class="form-check-label" for="Técnico en Ingeniería Eléctrica"><p class="text-dark">Técnico en Ingeniería Eléctrica</p>
</div>
<br>
    <input class="btn btn-primary" type="submit" name="enviar" value="Registrarme">
    <br>
    <br>
    <p class="text-dark"> ¿Ya tienes cuenta? <a href="index.php?pagina=Login.php">Inicia sesión.</a></p>
    </form>
</div>
<!--Tercer contenedor--> 
<div class="col-md-3 ">
</div>

<!-- Option 1: Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" 
integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
<?php
if (isset($_POST["enviar"])) 
{
    $datos[] = $_POST["carnet"];
    $datos[] = $_POST["nombres"];
    $datos[] = $_POST["apellidos"];
    $datos[]= $_POST["correo"];
    $datos[] = $_POST["direccion"];
    $datos[] = $objeto -> SQL_Encriptar_Desencriptar("encriptar", $_POST["clave"]);
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
            echo "<script>var resultado = window.confirm('¿Quieres iniciar sesión ahora?');
                if (resultado === true) {
                    window.location='index.php';
                } else { 
                    window.alert('¡Gracias por registrarte!');
                }</script>";
        }
}
?>