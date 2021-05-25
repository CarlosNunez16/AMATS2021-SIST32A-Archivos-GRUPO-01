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
    <h1>REGISTRO DE USUARIO.</h1>
    <form method="post">
        <label for="carnet">Carnet:</label>
        <input type="text" name="carnet" required>
        <br>
        <label for="clave">Contraseña:</label>
        <input type="text" name="clave" required>
        <br>
        <label for="tipoUsuario">Tipo de usuario:</label>
        <select name="tipoUsuario" id="tipoUsuario" required>
        <option value="Administrador">Administrador</option>
        <option value="Empleado">Empleado</option>
        <option value="Estudiante">Estudiante</option>
        </select>
        <br>

        <input type="submit" name="enviar" value="enviar">
    </form>
    <?php
    if (isset($_POST["enviar"])) 
    {
        $datos[] = $_POST["carnet"];
        $datos[] = $_POST["clave"];
        $datos[] = $_POST["tipoUsuario"];

        $tabla = "usuario";
        $consulta = $objeto -> SQL_consultaGeneral($tabla, "*", "carnet = '$datos[0]' and contraseña = '$datos[1]'");

        if ($consulta -> num_rows > 0)
        {
            $fila = $consulta -> fetch_assoc(); 
            if ($fila["tipo_usuario"] == "admin")
            {
                header("location:Registro.php");
            }
            elseif ($fila["tipo_usuario"] == "estudiante")
            {
                header("location: ");
            }
            elseif ($fila["tipo_usuario"] == "empleado")
            {
                header("location: ");
            }
        }
        else 
        {
            echo"<script>alert('Datos incorrectos.')</script>";
        }
    }
    ?>
</body>
</html>