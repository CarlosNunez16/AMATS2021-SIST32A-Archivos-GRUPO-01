<?php
if($_SESSION["Estudiante_Empleado"][3] == "Estudiante")
{
    echo "<script>alert('No tienes privilegios de adminsitrador o empleado bobo'); window.location='?pagina=Prestamo.php&opcion=all';</script>";
}
else
{?>
    <h1 class="text-center m-3 fs-2">MIS ACTIVOS FIJOS</h1>
    <div class="row d-flex justify-content-center">
        <div class="col-4 m-3 s-1 p-3 border border-dark rounded-3 d-block" style="background-color:#F5F5F5">
            <h1 class="text-center fs-4">CONSULTA</h1>
            <form class="row g-3 needs-validation" name='form1' method="post" target='_self'>
                <div class="col-md-6">
                    <?php
                        if(isset($_GET["opcion"]))
                        {
                            if($_GET["opcion"] == "Fecha")
                            {
                                echo"
                                    <label class='form-label' for='dato'>Ingresar fecha:</label>
                                    <input class='form-control' type='date' max=".date("Y-m-d")." name='dato' required>
                                ";
                            }
                            elseif($_GET["opcion"] == "Usuario")
                            {
                                echo"
                                    <label class='form-label' for='dato'>Escriba aquí:</label>
                                    <input class='form-control' type='text' placeholder='Nombre o apellido...'   name='dato' required>
                                ";
                            }
                            else
                            {
                                echo"
                                    <label class='form-label' for='dato'>Escriba aquí:</label>
                                    <input class='form-control' type='text' name='dato' required>
                                ";
                            }
                        }
                    ?>
                </div> 
                <div class="col-md-6">
                    <label class="form-label" for="tipo">Buscar por...</label>
                    <select class="form-select" name="tipo" onChange='javascript:abreSitio()' required>
                        <option value='#'>Elegir...</option>
                        <option value='?pagina=ActivosFijos.php&opcion=Grupo'>Grupo</option>
                        <option value='?pagina=ActivosFijos.php&opcion=Subgrupo'>Subgrupo</option>
                        <option value='?pagina=ActivosFijos.php&opcion=Nombre'>Nombre</option>
                        <option value='?pagina=ActivosFijos.php&opcion=Marca'>Marca</option>
                        <option value='?pagina=ActivosFijos.php&opcion=Modelo'>Modelo</option>
                        <option value='?pagina=ActivosFijos.php&opcion=Serie'>Número de serie</option>
                        <option value='?pagina=ActivosFijos.php&opcion=Usuario'>Usuario responsable</option>
                        <option value='?pagina=ActivosFijos.php&opcion=Ubicacion'>Ubicación</option>
                        <option value='?pagina=ActivosFijos.php&opcion=Fecha'>Fecha de asignación</option>
                        <option value='?pagina=ActivosFijos.php&opcion=Calidad'>Calidad del activo</option>
                    </select>
                </div>
                <div class="col-md-12">
                    <input class='btn btn-success' type='submit' name='buscar'  value='Buscar'>
                </div>
            </form>
        </div>
    </div>

    <?php
    if(isset($_POST["buscar"]))
    {
        $dato = $_POST["dato"];
        echo "
        <div class='row d-flex justify-content-center'>
            <div class='col-12 m-3'>
                <table class='table table-dark table-striped table-hover'>
                <form method='post'>
                    <thead>
                        <tr>
                            <th scope='col'>ID</th>
                            <th scope='col'>Grupo</th>
                            <th scope='col'>Subgrupo</th>
                            <th scope='col'>Nombre</th>
                            <th scope='col'>Marca</th>
                            <th scope='col'>Modelo</th>
                            <th scope='col'>Color</th>
                            <th scope='col'>Número de serie</th>
                            <th scope='col'>Usuario encargado</th>
                            <th scope='col'>Ubicación del activo</th>
                            <th scope='col'>Fecha de registro</th>
                            <th scope='col'>Calidad del activo</th>
                        </tr>
                    </thead>
                    <tbody>";
        
                        $tabla = "inventario INNER JOIN grupos ON (inventario.idGrupo_FK2 = grupos.idGrupo) INNER JOIN subgrupos ON (inventario.idSubgrupo_FK = subgrupos.idSubgrupo) INNER JOIN usuarios ON (inventario.carnet_FK = usuarios.carnet)";
                        $campos = "inventario.idActivo, grupos.nombre AS nombre_G, subgrupos.nombre AS nombre_SG, inventario.nombre as Nombre, marca, modelo, color, numero_serie, usuarios.nombres AS User_Name, usuarios.apellidos AS User_Lastname, ubicacion, fecha_asignacion, calidad";
                        if($_GET["opcion"] == "Grupo" || $_GET["opcion"] == "all")
                        {
                            $condicion = " where grupos.nombre like '%$dato%' and where carnet_FK=".$_SESSION["Estudiante_Empleado"][0]."";
                        }
                        elseif($_GET["opcion"] == "Subgrupo")
                        {
                            $condicion = " where subgrupos.nombre like '%$dato%' and where carnet_FK=".$_SESSION["Estudiante_Empleado"][0]."";
                        }
                        elseif($_GET["opcion"] == "Nombre")
                        {
                            $condicion = " where inventario.nombre like '%$dato%' and where carnet_FK=".$_SESSION["Estudiante_Empleado"][0]."";
                        }
                        elseif($_GET["opcion"] == "Marca")
                        {
                            $condicion = " where marca like '%$dato%' and where carnet_FK=".$_SESSION["Estudiante_Empleado"][0]."";
                        }
                        elseif($_GET["opcion"] == "Modelo")
                        {
                            $condicion = " where modelo like '%$dato%' and where carnet_FK=".$_SESSION["Estudiante_Empleado"][0]."";
                        }
                        elseif($_GET["opcion"] == "Serie")
                        {
                            $condicion = " where numero_serie like '%$dato%' and where carnet_FK=".$_SESSION["Estudiante_Empleado"][0]."";
                        }
                        elseif($_GET["opcion"] == "Usuario")
                        {
                            $condicion = " where usuarios.nombres like '%$dato%' or usuarios.apellidos like '%$dato%' and where carnet_FK=".$_SESSION["Estudiante_Empleado"][0]."";
                        }
                        elseif($_GET["opcion"] == "Ubicacion")
                        {
                            $condicion = " where ubicacion like '%$dato%' and where carnet_FK=".$_SESSION["Estudiante_Empleado"][0]."";
                        }
                        elseif($_GET["opcion"] == "Calidad")
                        {
                            $condicion = " where calidad like '%$dato%' and where carnet_FK=".$_SESSION["Estudiante_Empleado"][0]."";
                        }
                        elseif($_GET["opcion"] == "Fecha")
                        {
                            $condicion = " where fecha_asignacion like '%$dato%' and where carnet_FK=".$_SESSION["Estudiante_Empleado"][0]."";
                        }
                        $tablaCondicion = $tabla.$condicion;
                        $consulta = $objeto -> SQL_consulta($tablaCondicion, $campos);
                        
                        if (mysqli_num_rows($consulta) < 1) 
                        {
                            echo "<tr><td colspan='14' class='text-center'>NO HAY COINCIDENCIAS.</td></tr>";
                        }                    
                        else
                        {
                            while ($fila = $consulta -> fetch_assoc()) 
                            {
                            echo "<tr>
                                    <th scope='row'>$fila[idActivo]</th>
                                    <td>$fila[nombre_G]</td>
                                    <td>$fila[nombre_SG]</td>
                                    <td>$fila[Nombre]</td>
                                    <td>$fila[marca]</td>
                                    <td>$fila[modelo]</td>
                                    <td>$fila[color]</td>
                                    <td>$fila[numero_serie]</td>
                                    <td>$fila[User_Name] $fila[User_Lastname]</td>
                                    <td>$fila[ubicacion]</td>
                                    <td>$fila[fecha_asignacion]</td>
                                    <td>$fila[calidad]</td>
                                </tr>";
                            }
                        }
                        ?>
                            <tr>
                                <td colspan="13"><div class="d-flex justify-content-center"><a class="btn btn-info" href='Empleado_Estudiante.php?pagina=ActivosFijos.php&opcion=all'>Ver todos</a></div></td>
                            </tr>
                    </tbody>
                </form>
                </table> 
            </div>
        </div>
            <?php
    }
    else
    {
        echo "
        <div class='row d-flex justify-content-center'>
            <div class='col-12 m-3'>
                <table class='table table-dark table-striped table-hover'>
                <form method='post'>
                    <thead>
                        <tr>
                            <th scope='col'>ID</th>
                            <th scope='col'>Grupo</th>
                            <th scope='col'>Subgrupo</th>
                            <th scope='col'>Nombre</th>
                            <th scope='col'>Marca</th>
                            <th scope='col'>Modelo</th>
                            <th scope='col'>Color</th>
                            <th scope='col'>Número de serie</th>
                            <th scope='col'>Usuario encargado</th>
                            <th scope='col'>Ubicación del activo</th>
                            <th scope='col'>Fecha de registro</th>
                            <th scope='col'>Calidad del activo</th>
                        </tr>
                    </thead>
                    <tbody>";
            
                        $tabla = "inventario INNER JOIN grupos ON (inventario.idGrupo_FK2 = grupos.idGrupo) INNER JOIN subgrupos ON (inventario.idSubgrupo_FK = subgrupos.idSubgrupo) INNER JOIN usuarios ON (inventario.carnet_FK = usuarios.carnet) where carnet_FK=".$_SESSION["Estudiante_Empleado"][0]."";
                        $campos = "inventario.idActivo, grupos.nombre AS nombre_G, subgrupos.nombre AS nombre_SG, inventario.nombre as Nombre, marca, modelo, color, numero_serie, usuarios.nombres AS User_Name, usuarios.apellidos AS User_Lastname, ubicacion, fecha_asignacion, calidad";
                        $consulta = $objeto -> SQL_consulta($tabla, $campos);

                        if (mysqli_num_rows($consulta) < 1) 
                        {
                            echo "<tr><td colspan='14' class='text-center'>NO HAY REGISTROS.</td></tr>";
                        }
                        else
                        {
                            while ($fila = $consulta -> fetch_assoc())
                            {
                            echo "<tr>
                                    <th scope='row'>$fila[idActivo]</th>
                                    <td>$fila[nombre_G]</td>
                                    <td>$fila[nombre_SG]</td>
                                    <td>$fila[Nombre]</td>
                                    <td>$fila[marca]</td>
                                    <td>$fila[modelo]</td>
                                    <td>$fila[color]</td>
                                    <td>$fila[numero_serie]</td>
                                    <td>$fila[User_Name] $fila[User_Lastname]</td>
                                    <td>$fila[ubicacion]</td>
                                    <td>$fila[fecha_asignacion]</td>
                                    <td>$fila[calidad]</td>
                                </tr>";
                            }
                        }                   
                        echo"</tbody>
                    </form>
                    </table>
                </div>
            </div>";    
    }
}
    
?>