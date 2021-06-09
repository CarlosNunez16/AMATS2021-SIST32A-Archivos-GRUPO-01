<?php
    if(isset($_GET["carnet"]))
    {
        $uno=1;
        $datosUser["cantidad_reportes"]= "cantidad_reportes-".$uno;
        $condicion = "carnet = ".$_GET["carnet"]."";
        $reporte = $objeto -> SQL_modificarReporte("usuarios", $datosUser, $condicion);
        echo "<script>alert('SE RESTÓ UN REPORTE AL USUARIO ".$_GET["carnet"]."'); window.location='?pagina=Usuarios.php&opcion=all';</script>";
    }
?>