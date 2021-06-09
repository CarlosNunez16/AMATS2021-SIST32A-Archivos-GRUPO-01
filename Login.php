<?php
$tabla = "usuarios";
$consulta = $objeto -> SQL_consulta($tabla, "*");
if (mysqli_num_rows($consulta) < 1) 
{
    ?><br><br>
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
        <h2 style="color:#8B0000">REGISTRO DEL ADMINISTRADOR.</h2>
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
        <br>
        <input class="btn btn-primary" type="submit" name="enviar" value="Registrarme">
        <br>
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
    <br><br>
    <div class="container">
        <div class="row">
            <div class="col-md-4 ">
            </div>
            <div class="col-md-4    float-left" > <!--justify-content-center -->
                

            <!-- </div> -->
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
        <div class="col-md-5 bg-ligth text-center   border border-danger rounded-3 ">
        <h2 style="color:#8B0000">LOGIN.</h2>
            <form method="post">
                <br>

                <label for="carnet"><p style="color:#8B0000">Carnet:</label></p>
                <input class="form-control"  type="number" min="0" name="carnet" required>
                <br>
            
                <label for="clave>"><p style="color:#8B0000">Contraseña:</label></p>
                <input type="password" class="form-control" name="clave" required>
                <br>
            
                <input class="btn btn-primary" type="submit" name="enviar" value="Iniciar sesión">
                <br>
                <br>
                <br>
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
    echo"<br><br>";
}
