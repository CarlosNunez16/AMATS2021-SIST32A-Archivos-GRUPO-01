<?php
    session_start();
    if (!(isset($_SESSION["Administrador"])))
    {
        header("location:../Login.php");
    }
    require_once("../Connect.php");
    $objeto = new ClsConnection();
    ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" 
    rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <title>Administrador</title>
</head>
<body onload="mueveReloj()">
    <header>
        <?php
            echo "<h1>Bienvenido ". $_SESSION["Administrador"][1]." ".$_SESSION["Administrador"][2]."</h1>";
            echo "<script type='text/javascript' src='../Hora.js'></script>";
        ?>  
        <form name="form_reloj">
        <input class="border-0" type="text" name="reloj" size="10" disabled>
        </form>
    </header>
    <nav>
        <ul>
            <li><a href="Administrador.php">Inicio</a></li>
            <li><a href="">Usuarios</a>
                <ul>
                    <li><a href="Administrador.php?pagina=Usuarios.php">Consulta de usuarios</a></li>
                    <li><a href="Administrador.php?pagina=Baneados.php">Baneados</a></li>
                </ul>
            </li>
            <li><a href="">Préstamos</a>
                <ul>
                    <li><a href="Administrador.php?pagina=Prestamos.php">Préstamos</a></li>
                    <li><a href="Administrador.php?pagina=Damages.php">Reportes de daños</a></li>
                </ul>
            </li>
            <li><a href="">Activos fijos</a>
                <ul>
                    <li><a href="Administrador.php?pagina=Inventario.php">Inventario</a></li>
                    <li><a href="Administrador.php?pagina=Grupos.php">Grupos</a></li>
                    <li><a href="Administrador.php?pagina=Subgrupos.php">Subgrupos</a></li>
                </ul>
            </li>
            <li><a href="">Mantenimiento</a>
                <ul>
                    <li><a href="Administrador.php?pagina=Mantenimiento.php">Mantenimiento</a></li>
                    <li><a href="Administrador.php?pagina=Refacciones.php">Refacciones</a></li>
                </ul>
            </li>
            <li><a href="Administrador.php?pagina=Cerrar.php">Cerrar sesión</a></li>
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