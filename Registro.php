<?php
require_once("Connect.php");

$objeto = new ClsConnection();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
</head>
<body>
    <h1>REGISTRO DE USUARIO.</h1>
    <form method="post">
        <label for="nombres">Nombres:</label>
        <input type="text" name="nombres" required>
        <br>
        <label for="apellidos">Apellidos:</label>
        <input type="text" name="apellidos" required>
        <br>
        <label for="carnet">Carnet:</label>
        <input type="text" name="carnet" required>
        <br>
        <label for="direccion">Dirección:</label>
        <input type="text" name="direccion" required>
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
        <label for="sistemas">Técnico en Ingeniería de Sistemas Informáticos</label>
        <input type="checkbox" name="carreras[]" value="sistemas" >
        <label for="hardware">Técnico en Hardware Computacional</label>
        <input type="checkbox" name="carreras[]" value="hardware" >
        <label for="patrimonio">Técnico en Gestión Tecnológica del Patrimonio Cultural</label>
        <input type="checkbox" name="carreras[]" value="patrimonio">
        <label for="electrica">Técnico en Ingeniería Eléctrica</label>
        <input type="checkbox" name="carreras[]" value="electrica">

        <input type="submit" name="enviar" value="enviar">
    </form>
    <?php
    if (isset($_POST["enviar"])) 
    {
        $datos[] = $_POST["carnet"];
        $datos[] = $_POST["nombres"];
        $datos[] = $_POST["apellidos"];
        $datos[] = $_POST["direccion"];
        $datos[] = $_POST["clave"];
        $datos[] = $_POST["tipoUsuario"];
        if (isset($_POST["carreras"])) 
        {
            $carrera = implode(",", $_REQUEST["carreras"]);
            $datos[] = $carrera;
        }
        $datos[]=0;

        $tabla = "usuario";
        $consulta = $objeto -> SQL_consulta_condicional($tabla, "carnet", "carnet = ".$datos[0]."");

            

            if (mysqli_num_rows($consulta) > 0)
            {
                echo "<script>alert('Ya existe')</script>";
            }
            else
            {
                $campos = array('carnet','nombres','apellidos', 'direccion', 'contraseña', 'tipo_usuario', 'carrera', 'cantidad_reportes');

                $rs = $objeto -> SQL_insert($tabla, $campos, $datos);
            }
    }
    ?>
</body>
</html>