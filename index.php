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
    <link rel="stylesheet" type="text/css" href="style.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" 
    rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <title>INICIO</title>
</head>
<body>
    <header>
        <p>SISTEMA DE INVENTARIO DE ACTIVOS FIJOS - ITCA FEPADE SANTA ANA.</p>
    </header>
    <nav>
        <ul>
            <li><a href="index.php?pagina=Login.php">LOGIN</a></li>
            <li><a href="index.php?pagina=Registro.php">REGISTRO</a></li>
        </ul>
    </nav>
    <section>
        <?php
            if(isset($_GET["pagina"]))
            {
                include ($_GET["pagina"]);
            }
            else 
            {
                header("location:?pagina=Login.php");
            }
        ?>
    </section>
    <footer>
        <p>ESCUELA ESPECIALIZADA EN INGENIERÍA ITCA-FEPADE, TODOS LOS DERECHOS RESERVADOS.</p>
        <p>CARRETERA A SANTA TECLA KM. 11, LA LIBERTAD, EL SALVADOR C.A.</p>
        <p>TEL. (503) 2132-7400</p>
    </footer>
</body>
</html>