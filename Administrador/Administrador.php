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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrador</title>
</head>
<body onload="mueveReloj()">
    <header>
        <?php
            echo "<h1>Bienvenido ". $_SESSION["Administrador"][1]." ".$_SESSION["Administrador"][2]."</h1>";
            echo "
            <script language='JavaScript'>
            function mueveReloj(){
                momentoActual = new Date()
                hora = momentoActual.getHours()
                minuto = momentoActual.getMinutes()
                segundo = momentoActual.getSeconds()

                str_segundo = new String (segundo)
                if (str_segundo.length == 1)
                segundo = '0' + segundo

                str_minuto = new String (minuto)
                if (str_minuto.length == 1)
                minuto = '0' + minuto

                str_hora = new String (hora)
                if (str_hora.length == 1)
                hora = '0' + hora

                horaImprimible = hora + ' : ' + minuto + ' : ' + segundo

                document.form_reloj.reloj.value = horaImprimible

                setTimeout('mueveReloj()',1000)
            }
            </script>
            ";
        ?>  
        <form name="form_reloj">
        <input type="text" name="reloj" size="10">
        </form>
    </header>
    <nav>
        <ul>
            <li><a href="Administrador.php">Inicio</a></li>
            <li><a href="">Usuarios</a>
                <ul>
                    <li><a href="Administrador.php?pagina=Prestamos.php">Consulta de usuarios</a></li>
                    <li><a href="Administrador.php?pagina=Reportes.php">Baneados</a></li>
                </ul>
            </li>
            <li><a href="">Préstamos</a>
                <ul>
                    <li><a href="Administrador.php?pagina=Prestamos.php">Préstamos</a></li>
                    <li><a href="Administrador.php?pagina=Reportes.php">Reportes de daños</a></li>
                </ul>
            </li>
            <li><a href="">Activos fijos</a>
                <ul>
                    <li><a href="Administrador.php?pagina=Prestamos.php">Inventario</a></li>
                    <li><a href="Administrador.php?pagina=Reportes.php">Grupos</a></li>
                    <li><a href="Administrador.php?pagina=Reportes.php">Subgrupos</a></li>
                </ul>
            </li>
            <li><a href="">Mantenimiento</a>
                <ul>
                    <li><a href="Administrador.php?pagina=Prestamos.php">Mantenimiento</a></li>
                    <li><a href="Administrador.php?pagina=Reportes.php">Refacciones</a></li>
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