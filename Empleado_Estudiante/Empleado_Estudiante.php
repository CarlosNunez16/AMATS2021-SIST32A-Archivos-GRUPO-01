<?php
session_start();
if (!(isset($_SESSION["Estudiante_Empleado"])))
{
    header("location:../Login.php");
}
require_once("../Connect.php");
$objeto = new ClsConnection();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php
    echo $_SESSION["Estudiante_Empleado"][3];
    ?></title>
</head>
<body>
    <header>
    <h1><?php echo "Bienvenido ". $_SESSION["Estudiante_Empleado"][1]." ".$_SESSION["Estudiante_Empleado"][2];?></h1>
    </header>
    <nav>
        <ul>
            <li><a href="Empleado_Estudiante.php?pagina=Ejemplo.php">Prestamos</a>
                <ul>
                    <li><a href="Administrador.php?pagina=Prestamos.php">Realizar prestamo</a></li>
                    <li><a href="Administrador.php?pagina=Reportes.php">Consulta de inventario</a></li>
                </ul>
            </li>
            <li><a href="Empleado_Estudiante.php?pagina=Cerrar.php">Mis reportes de daños</a></li>
            <li><a href="Empleado_Estudiante.php?pagina=Cerrar.php">Cerrar sesión</a></li>
            <li></li>
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