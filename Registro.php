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
        <option value="admin">Administrador</option>
        <option value="empleado">Empleado</option>
        <option value="estudiante">Estudiante</option>
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
    </form>
</body>
</html>