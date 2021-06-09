<?php
    if(isset($_GET["carnet"]))
    {
        $uno=1;
        $datosUser["cantidad_reportes"]= "4";
        $condicion = "carnet = ".$_GET["carnet"]."";
        $reporte = $objeto -> SQL_modificar("usuarios", $datosUser, $condicion);
        echo "<script>alert('SE DESBANEÓ AL USUARIO ".$_GET["carnet"]."'); window.location='?pagina=Baneados.php&opcion=all';</script>";
    }
?>