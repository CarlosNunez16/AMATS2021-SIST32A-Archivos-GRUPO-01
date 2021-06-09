<?php
$consulta = $objeto -> SQL_consulta("prestamo", "estado");  

while ($fila = $consulta -> fetch_assoc())
{
    if ($fila["estado"] == "No entregó") 
    {
        $datos["estado"] = "Entrega tardía";
        $condicion = "idPrestamo=".$_GET["idPrestamo"]." and estado = 'En préstamo' or estado = 'No entregó'";
        $rs = $objeto -> SQL_modificar("prestamo", $datos, $condicion);
        echo "<script>alert('ENTREGADO'); window.location='?pagina=Prestamo.php&opcion=all';</script>";
    }
    else
    {
        $datos["estado"] = "Entregado";
        $condicion = "idPrestamo=".$_GET["idPrestamo"]." and estado = 'En préstamo' or estado = 'No entregó'";
        $rs = $objeto -> SQL_modificar("prestamo", $datos, $condicion);
        // echo "<script>alert('ENTREGADO'); window.location='?pagina=Prestamo.php&opcion=all';</script>";
    }
}
                            
?>