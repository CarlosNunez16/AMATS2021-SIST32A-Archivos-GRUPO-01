<?php
$tabla = "usuarios";
$consulta = $objeto -> SQL_consulta($tabla, "*");
if (mysqli_num_rows($consulta) < 1) 
{
    ?>
<div class="row d-flex justify-content-center">
	<div class="col-5 m-3 s-1 p-3 border border-danger rounded-3 d-block" style="background-color:#F5F5F5">
		<h1 class="text-center fs-4" style="color:#8B0000">REGISTRO DE ADMINISTRADOR</h1> 
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
                <label for="clave" class="form-label" style="color:#8B0000">Contraseña:</label>
                <input type="password" class="form-control" name="clave" required>
            </div>
            <div class="col-md-12">
                <div class="d-flex justify-content-center"><input class="btn btn-primary" type="submit" name="enviar" value="Registrarme"></div> 
            </div>
        </form>
    </div>
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
        $datos[] = "Administrador";
        $datos[] = "Regional Santa Ana"; 
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

}
else
{
    ?>
    <div class="row d-flex justify-content-center">
	    <div class="col-3 m-3 s-1 p-3 border border-danger rounded-3 d-block" style="background-color:#F5F5F5">
		    <h1 class="text-center fs-4" style="color:#8B0000">LOGIN</h1>
		    <form class="row g-3 needs-validation" method="post"> 
                <div class="col-md-12">
                    <label class="form-label" for="carnet" style="color:#8B0000">Carnet:</label>
                    <input class="form-control" type="number" min="0" name="carnet" required>
                </div>
                <div class="col-md-12">
                    <label class="form-label" for="clave" style="color:#8B0000">Contraseña:</label>
                    <input class="form-control" type="password" name="clave" required>
                </div>
                <div class="col-md-12">
                    <div class="d-flex justify-content-center"><input class="btn btn-primary" type="submit" name="enviar" value="Iniciar sesión"></div>
                </div>
            </form>
        </div>
    </div>

        <!-- Option 1: Bootstrap Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" 
        integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
    <?php
    if (isset($_POST["enviar"])) 
    {
        $datos[] = $_POST["carnet"];
        $datos[] = $objeto -> SQL_Encriptar_Desencriptar("encriptar", $_POST["clave"]);
        $tabla = "usuarios";
        $consulta = $objeto -> SQL_consultaGeneral($tabla, "*", "carnet = '$datos[0]' and contraseña = '$datos[1]'");
        
        if ($consulta -> num_rows > 0)
        {
            $fila = $consulta -> fetch_assoc(); 
            if ($fila["tipo_usuario"] == "Administrador")
            {
                if ($fila["cantidad_reportes"] > 5) 
                {
                    echo"<script>alert('Usted esta baneado.')</script>";
                }
                else 
                {
                    header("location:Administrador/Administrador.php?pagina=Inventario.php&opcion=all");
                    $datos[0]= $fila["carnet"];
                    $datos[1]= $fila["nombres"];
                    $datos[2]= $fila["apellidos"];
                    $datos[3]= $fila["tipo_usuario"];
                    $_SESSION["Administrador"]= $datos;
                }
            }
            elseif ($fila["tipo_usuario"] == "Estudiante")
            {
                if ($fila["cantidad_reportes"] > 5) 
                {
                    echo"<script>alert('Usted esta baneado.')</script>";
                }
                else 
                {
                    header("location:Empleado_Estudiante/Empleado_Estudiante.php?pagina=Prestamo.php&opcion=all");
                    $datos[0]= $fila["carnet"];
                    $datos[1]= $fila["nombres"];
                    $datos[2]= $fila["apellidos"];
                    $datos[3]= $fila["tipo_usuario"];
                    $_SESSION["Estudiante_Empleado"]= $datos;
                }
            }
            elseif ($fila["tipo_usuario"] == "Empleado")
            {
                if ($fila["cantidad_reportes"] > 5) 
                {
                    echo"<script>alert('Usted esta baneado.')</script>";
                }
                else 
                {
                    header("location:Empleado_Estudiante/Empleado_Estudiante.php?pagina=Prestamo.php&opcion=all");
                    $datos[0]= $fila["carnet"];
                    $datos[1]= $fila["nombres"];
                    $datos[2]= $fila["apellidos"];
                    $datos[3]= $fila["tipo_usuario"];
                    $_SESSION["Estudiante_Empleado"]= $datos;
                }
            }
        }
        else 
        {
            echo"<script>alert('Usted no está registrado o sus datos son incorrectos.')</script>";
        }
    }
}
