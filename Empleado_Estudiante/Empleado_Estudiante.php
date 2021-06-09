<?php
    session_start();
    if (!(isset($_SESSION["Estudiante_Empleado"])))
    {
        header("location:../index.php");
    }
    require_once("../Connect.php"); 
    $objeto = new ClsConnection();
    ob_start();
    ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script type='text/javascript' src='../Hora.js'></script>
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous">
    </script>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" 
    rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <script LANGUAGE="JavaScript">
        function abreSitio()
        { 
            var URL = "http://localhost/PROYECTO/AMATS2021-SIST32A-Archivos-GRUPO-01/Empleado_Estudiante/Empleado_Estudiante.php";
            var web = document.form1.tipo.options[document.form1.tipo.selectedIndex].value;
            window.open(URL+web, '_self', '');
        }
    </script>
    <title>Administrador</title> 
</head>
<body onload="mueveReloj()"> 
    <div class="container-fluid">
        <div class="row">
            <header>
                <div class="col-12 d-flex justify-content-between align-items-center" style="background-color:#fff">
                    <img class="img-fluid rounded float-start" src="../images/logo.png" alt="ITCA-FEPADE">
                    
                    <h1 class="d-inline text-center fw-bold fs-4 text-dark">
                    <?php 
                    if ($_SESSION["Estudiante_Empleado"][3] == "Estudiante")
                    {
                        echo "ESTUDIANTE";
                    }
                    elseif($_SESSION["Estudiante_Empleado"][3] == "Empleado")
                    {
                        echo "EMPLEADO";
                    }
                    ?> 
                    - SISTEMA DE INVENTARIO DE ACTIVOS FIJOS.
                    </h1>
                    <div class="d-inline col-1 text-center">
                        <form name="form_reloj">
                            <input class="border-0" type="text" name="reloj" size="10" disabled>
                        </form>
                    </div>
                </div>
            </header>
        </div>
        <nav class="row navbar navbar-expand-lg"  style="background-color:#8B0000">
                <div class="col-10 d-inline collapse navbar-collapse d-flex" id="navbarNavDropdown">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link text-white active" aria-current="page" href="Empleado_Estudiante.php?pagina=Prestamo.php&opcion=all">Inicio</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white active" aria-current="page" href="Empleado_Estudiante.php?pagina=Prestamo.php&opcion=all">Préstamos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white active" aria-current="page" href="Empleado_Estudiante.php?pagina=ActivosFijos.php&opcion=all">Activos fijos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white active" aria-current="page" href="Empleado_Estudiante.php?pagina=MyDamages.php">Mis reportes</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white active" aria-current="page" href="Empleado_Estudiante.php?pagina=Mantenimiento.php&opcion=all">Mantenimiento</a>
                        </li>
                </div>
                <div class="col-2 d-inline collapse">
                    <ul class="nav justify-content-end">
                        <li class="nav-item dropdown">
                            <a class="nav-link text-white nav-item dropdown"  aria-current="page" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<img src="../Administrador/userIcon.gif" alt="User" width="25" height="25">&nbsp <?php echo $_SESSION["Estudiante_Empleado"][0];?></a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                <li><a class="dropdown-item" href="Empleado_Estudiante.php?pagina=Modificar/Perfil.php">Perfil</a></li> 
                                <li><a class="dropdown-item" href="Empleado_Estudiante.php?pagina=Modificar/Password.php">Cambiar contraseña</a></li>
                                <li><a class="dropdown-item" href="Empleado_Estudiante.php?pagina=Cerrar.php">Cerrar sesión</a></li>
                            </ul>
                        </li>
                    </ul>  
                </div>
            </ul>
        </nav>
        <section class="row d-flex justify-content-center">
            <?php
                if(isset($_GET["pagina"]))
                {
                    include ($_GET["pagina"]);
                }
                else 
                {
                    header("location:?pagina=Prestamo.php");
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