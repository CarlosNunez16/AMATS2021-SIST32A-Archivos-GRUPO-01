<?php
    echo "
    <h1 class='text-center m-3 fs-4'>ACTIVOS FIJOS EN PRÉSTAMO</h1>
    <div class='row d-flex justify-content-center'>
        <div class='row d-flex justify-content-center'>
            <div class='col-5'>
                <a href='imprimir.php?tabla=EnPrestamo' target='_blank' class='btn btn-secondary' title='IMPRIMIR'>
                    <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-printer' viewBox='0 0 16 16'>
                        <path d='M2.5 8a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z'/>
                        <path d='M5 1a2 2 0 0 0-2 2v2H2a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h1v1a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-1h1a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-1V3a2 2 0 0 0-2-2H5zM4 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2H4V3zm1 5a2 2 0 0 0-2 2v1H2a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-1v-1a2 2 0 0 0-2-2H5zm7 2v3a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1z'/>
                    </svg>
                </a>
            </div>
        </div>
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
                    $tabla = "inventario INNER JOIN prestamo ON (inventario.idActivo = prestamo.idActivo_FK)";
                    $campos = "idActivo, nombre, estado";
                    $condicion= "estado = 'En préstamo' OR estado = 'No entregó'";
                    $consulta = $objeto -> SQL_consulta_condicional($tabla, $campos, $condicion);
                    if (mysqli_num_rows($consulta) < 1) 
                    {
                        echo "<tr><td colspan='4' class='text-center'>NO HAY ACTIVOS FIJOS EN PRÉSTAMO.</td></tr>"; 
                    }
                    else
                    {
                        while ($fila = $consulta -> fetch_assoc())
                        {
                        echo "<tr>
                                <th scope='row'>$fila[idActivo]</th>
                                <td>$fila[nombre]</td>
                                <td>$fila[estado]</td>
                            </tr>";
                        }
                    }
                echo "<tbody>
                </form>
            </table>
        </div>
    </div>";
    echo "
    <h1 class='text-center m-3 fs-4'>ACTIVOS FIJOS EN MANTENIMIENTO</h1>
    <div class='row d-flex justify-content-center'>
        <div class='row d-flex justify-content-center'>
            <div class='col-5'>
                <a href='imprimir.php?tabla=EnMantenimiento' target='_blank' class='btn btn-secondary' title='IMPRIMIR'>
                    <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-printer' viewBox='0 0 16 16'>
                        <path d='M2.5 8a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z'/>
                        <path d='M5 1a2 2 0 0 0-2 2v2H2a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h1v1a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-1h1a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-1V3a2 2 0 0 0-2-2H5zM4 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2H4V3zm1 5a2 2 0 0 0-2 2v1H2a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-1v-1a2 2 0 0 0-2-2H5zm7 2v3a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1z'/>
                    </svg>
                </a>
            </div>
        </div>
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
                    $tabla = "inventario INNER JOIN mantenimientos ON (inventario.idActivo = mantenimientos.idActivo_FK2)";
                    $campos = "idActivo, nombre";
                    $condicion= "calidad_nueva = 'Sin revisar'";
                    $consulta = $objeto -> SQL_consulta_condicional($tabla, $campos, $condicion);
                    if (mysqli_num_rows($consulta) < 1) 
                    {
                        echo "<tr><td colspan='3' class='text-center'>NO HAY ACTIVOS FIJOS EN MANTENIMIENTO.</td></tr>"; 
                    }
                    else
                    {
                        while ($fila = $consulta -> fetch_assoc())
                        {
                        echo "<tr>
                                <th scope='row'>$fila[idActivo]</th>
                                <td>$fila[nombre]</td>
                                <td>Sin terminar</td>
                            </tr>";
                        }
                    }
                echo "<tbody>
                </form>
            </table>
        </div>
    </div>";

    echo "
    <h1 class='text-center m-3 fs-4'>ACTIVOS FIJOS DISPONIBLES</h1>
    <div class='row d-flex justify-content-center'>
        <div class='row d-flex justify-content-center'>
            <div class='col-5'>
                <a href='imprimir.php?tabla=disponibles' target='_blank' class='btn btn-secondary' title='IMPRIMIR'>
                    <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-printer' viewBox='0 0 16 16'>
                        <path d='M2.5 8a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z'/>
                        <path d='M5 1a2 2 0 0 0-2 2v2H2a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h1v1a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-1h1a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-1V3a2 2 0 0 0-2-2H5zM4 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2H4V3zm1 5a2 2 0 0 0-2 2v1H2a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-1v-1a2 2 0 0 0-2-2H5zm7 2v3a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1z'/>
                    </svg>
                </a>
            </div>
        </div>
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