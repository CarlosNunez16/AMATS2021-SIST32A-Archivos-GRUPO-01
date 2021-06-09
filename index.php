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
    ob_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css">
    <script type='text/javascript' src='Hora.js'></script>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" 
    rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <title>INICIO</title>
</head>
<body onload="mueveReloj()">
    <div class="container-fluid">
        <div class="row">
            <header>
                <div class="col-12 d-flex justify-content-between align-items-center" style="background-color:#fff">
                    <img class="img-fluid rounded float-start" src="images/logo.png" alt="ITCA-FEPADE">
                    <!-- Option 1: Bootstrap Bundle with Popper -->
                    
                    <h1 class="d-inline text-center fw-bold fs-4 text-dark">SISTEMA DE INVENTARIO DE ACTIVOS FIJOS - ITCA FEPADE SANTA ANA.</h1>
                    <div class="d-inline col-1 text-center">
                        <form name="form_reloj">
                            <input class="border-0" type="text" name="reloj" size="10" disabled>
                        </form>
                    </div>
                </div>
            </header>
        </div>
        <nav class="row">
            <ul class="nav justify-content-end" style="background-color:#8B0000">
                <li class="nav-item">
                    <a class="nav-link text-white" href="https://apps.itca.edu.sv/portalestudiantil/index.php">Portal Estudiantil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="https://www.itca.edu.sv/">Sitio Web ITCA</a>
                </li>
            </ul>
        </nav>
        <section>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" 
        integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
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
        <br>
        <footer class="row border-top border-danger" style="background-color:#F5F5F5">
            <p class="text-center fs-9">ESCUELA ESPECIALIZADA EN INGENIERÍA ITCA-FEPADE, TODOS LOS DERECHOS RESERVADOS.<br>
            CARRETERA A SANTA TECLA KM. 11, LA LIBERTAD, EL SALVADOR C.A.<br>
            TEL. (503) 2132-7400</p>
        </footer>
    </div>
</body>
</html>