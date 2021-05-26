<?php
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

        $tabla = "usuario";
        $consulta = $objeto -> SQL_consultaGeneral($tabla, "*", "carnet = '$datos[0]' and contraseña = '$datos[1]'");

        if ($consulta -> num_rows > 0)
        {
            $fila = $consulta -> fetch_assoc(); 
            if ($fila["tipo_usuario"] == "Administrador")
            {
                header("location:Administrador");
                $_SESSION["Administrador"]= $fila["carnet"];
            }
            elseif ($fila["tipo_usuario"] == "Estudiante")
            {
                header("location:Empleado_Estudiante");
                $_SESSION["Estudiante"]= $fila["carnet"];
            }
            elseif ($fila["tipo_usuario"] == "Empleado")
            {
                header("location:Empleado_Estudiante");
                $_SESSION["Empleado"]= $fila["carnet"];
            }
        }
        else 
        {
            echo"<script>alert('Usted no está registrado o sus datos son incorrectos.')</script>";
        }
    }
    ?>
</body>
</html>