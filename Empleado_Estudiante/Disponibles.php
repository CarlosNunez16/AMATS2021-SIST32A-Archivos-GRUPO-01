<?php
    echo "
    <h1 class='text-center m-3 fs-4'>ACTIVOS FIJOS DISPONIBLES</h1>
    <div class='row d-flex justify-content-center'>
        <div class='col-5 m-2'>
            <table class='table table-dark table-striped table-hover'>
                <form method='post'>
                <thead>
                    <tr>
                        <th scope='col'>ID</th>
                        <th scope='col'>Activo Fijo</th>
                        <th scope='col'>Estado</th>
                    </tr>
                </thead>
                <tbody>";
                    $tabla = "inventario";
                    $campos = "idActivo, nombre";
                    $condicion= "(SELECT COUNT(*) FROM prestamo WHERE inventario.idActivo = prestamo.idActivo_FK AND estado = 'En préstamo' OR estado = 'No entregó')=0 AND (SELECT COUNT(*) FROM mantenimientos WHERE inventario.idActivo = mantenimientos.idActivo_FK2 AND calidad_nueva = 'Sin revisar')=0";
                    $consulta = $objeto -> SQL_consulta_condicional($tabla, $campos, $condicion);
                    if (mysqli_num_rows($consulta) < 1) 
                    {
                        echo "<tr><td colspan='3' class='text-center'>NO HAY ACTIVOS FIJOS DISPONIBLES.</td></tr>"; 
                    }
                    else
                    {
                        while ($fila = $consulta -> fetch_assoc())
                        {
                        echo "<tr>
                                <th scope='row'>$fila[idActivo]</th>
                                <td>$fila[nombre]</td>
                                <td>Disponible</td>
                            </tr>";
                        }
                    }
                echo "<tbody>
                </form>
            </table>
        </div>
    </div>";

?>