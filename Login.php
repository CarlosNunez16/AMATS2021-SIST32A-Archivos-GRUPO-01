<?php
@session_start();
if (isset($_SESSION["Estudiante_Empleado"]))
{
    header("location:Empleado_Estudiante/Empleado_Estudiante.php");
}
elseif(isset($_SESSION["Administrador"]))
{
    header("location:Administrador/Administrador.php");
}
require_once("Connect.php");
$objeto = new ClsConnection();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h1>LOGIN.</h1>
    <form method="post">
        <label for="carnet">Carnet:</label>
        <input type="text" name="carnet" required>
        <br>
        <label for="clave">Contraseña:</label>
        <input type="password" name="clave" required>
        <br>

        <input type="submit" name="enviar" value="Iniciar sesión">

        ¿No tienes cuenta? <a href="Registro.php">Registrate.</a>
    </form>
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
                    header("location:Administrador/Administrador.php");
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
                    header("location:Empleado_Estudiante/Empleado_Estudiante.php");
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
                    header("location:Empleado_Estudiante/Empleado_Estudiante.php");
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
    echo "<pre>";
    var_dump($_SESSION["Estudiante_Empleado"]);
    echo "</pre>";
    ?>
</body>
</html>