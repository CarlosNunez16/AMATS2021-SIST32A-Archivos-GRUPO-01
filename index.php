<?php
@session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="Style/style.css">
    <link rel="stylesheet" type="text/css" href="Style/Form_Style.css">
    <title>Examen 2</title>
</head>
<body>
<div class="agrupar">
        <header>
            <h1>EXAMEN PRÁCTICO 2</h1>
        </header> 
        <nav class="menu">
            <ul>
            <li><a href="index.php?pagina=Ejercicio3.php">Ejercicio 3</a>
                <ul>
                    <li><a href="index.php?pagina=Ejercicio3.php">Formulario</a>
                    <li><a href="index.php?pagina=Ejercicio3_Consulta.php">Consulta del formulario</a></li>
                </ul>
            </li>
            <li><a href="index.php?pagina=Ejercicio4.php">Ejercicio 4</a>
                <ul>
                <li><a href="index.php?pagina=Ejercicio4.php">Encuesta</a>
                <li><a href="index.php?pagina=Ejercicio4/Resumen.php">Resumen de la encuesta</a></li>
                <li><a href="index.php?pagina=Ejercicio4/Consultas.php">Consultas de la encuesta</a></li>
                </ul>
            </li>
            </ul>
        </nav>
        <section class="seccion">
        <div class="php">
                <?php
                    if(isset($_GET["pagina"]))
                    {
                        include ($_GET["pagina"]);
                    }
                    else 
                    {
                        echo "<img width='100%'src='bg.jpg'>";
                    }
                ?>
            </div>
        </section>
        <footer>
                <p>Escuela Especializada en Ingeniería ITCA-FEPADE</p>
        </footer>
</div>
</body>
</html>