<h1 class="text-center m-3 fs-2">REFACCIONES</h1>
<div class="row d-flex justify-content-center">
	<div class="col-3 m-3 s-1 p-3 border border-dark rounded-3 d-block" style="background-color:#F5F5F5">
        <h1 class="text-center fs-4">CONSULTA</h1>
		<form class="row g-3 needs-validation" name='form1' method="post" target='_self'>
            <div class="col-md-12">
                <label class='form-label' for='dato'>Escribe aquí:</label>
                <input class='form-control' placeholder="Refacciones..." type='text' name='dato' required>     
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
        <div class='col-6 m-3'>
            <table class='table table-dark table-striped table-hover'>
            <form method='post'> 
                <thead>
                    <tr>
                        <th scope='col'></th>
                        <th scope='col'>ID</th>
                        <th scope='col'>ID Mantenimiento</th>
                        <th scope='col'>Usuario</th>
                        <th scope='col'>Refacciones</th>
                        <th scope='col'>Acción</th>
                    </tr>
                </thead>
                <tbody>";
    
                    $tabla = "refacciones INNER JOIN usuarios ON (refacciones.carnet_FK4 = usuarios.carnet) where refacciones like '%$dato%'";
                    $campos = "idRefacciones, idMantenimiento_FK, usuarios.nombres as NombreU, usuarios.apellidos as ApellidosU, refacciones ";
                    $consulta = $objeto -> SQL_consulta($tabla, $campos);
                    
                    if (mysqli_num_rows($consulta) < 1) 
                    {
                        echo "<tr><td colspan='14' class='text-center'>NO HAY COINCIDENCIAS.</td></tr>";
                        echo"<script type='text/javascript'>
                                $(document).ready(function(){
                                    $('#BtnEliminar').prop('disabled', true);
                                });
                            </script>";
                    }                    
                    else
                    {
                        while ($fila = $consulta -> fetch_assoc()) 
                        {
                            $idRefacciones="$fila[idRefacciones]";
                        echo "<tr>
                                <td><input type='checkbox' id='$fila[idRefacciones]' name='seleccionados[]' value='$fila[idRefacciones]' required></td>
                                <th scope='row'>$fila[idRefacciones]</th>
                                <td>$fila[idMantenimiento_FK]</td>
                                <td>$fila[NombreU] $fila[ApellidosU]</td>
                                <td>$fila[refacciones]</td>
                                <td><a class='btn btn-warning' href='Administrador.php?pagina=Modificar/Edit_Refacciones.php&idRefacciones=$fila[idRefacciones]'>Modificar</a></td>
                            </tr>";
                            echo"<script type='text/javascript'>
                                    $(document).ready(function(){
                                        $('#BtnEliminar').prop('disabled', true);
                                        $('#".$idRefacciones."').prop('checked',false);
                                        $('#".$idRefacciones."').click(function(){
                                            if($('#".$idRefacciones."').is(':checked')){
                                                $('#BtnEliminar').prop('disabled', false);
                                            }else{
                                                $('#BtnEliminar').prop('disabled', true);
                                            }
                                        });
                                    });
                                </script>";
                        }
                    }
                        
                    echo"<tr>
                            <td colspan='5'><div class='d-flex justify-content-center'><input class='btn btn-danger justify-content-center' id='BtnEliminar' type='submit' name='eliminar' value='Eliminar'></div></td>
                            <td><div class='d-flex justify-content-center'><a class='btn btn-info' href='Administrador.php?pagina=Refacciones.php'>Ver todos</a></div></td>
                        </tr>
                    </tbody>
                </form>
                </table> 
            </div>
        </div>";
        if(isset($_POST["eliminar"]))
        {
            $seleccionados = $_POST["seleccionados"];

            foreach($seleccionados as $idRefacciones)
            {
                $rs = $objeto -> SQL_eliminar("refacciones", "idRefacciones = $idRefacciones");
                echo "<script>alert('REFACCIONES ELIMINADAS');window.location='?pagina=Refacciones.php';</script>";


            }
        }
}
else{
    echo "
    <div class='row d-flex justify-content-center'>
        <div class='col-6 m-3'>
            <table class='table table-dark table-striped table-hover'>
            <form method='post'> 
                <thead>
                    <tr>
                        <th scope='col'></th>
                        <th scope='col'>ID</th>
                        <th scope='col'>ID Mantenimiento</th>
                        <th scope='col'>Usuario</th>
                        <th scope='col'>Refacciones</th>
                        <th scope='col'>Acción</th>
                    </tr>
                </thead>
                <tbody>";
    
                    $tabla = "refacciones INNER JOIN usuarios ON (refacciones.carnet_FK4 = usuarios.carnet)";
                    $campos = "idRefacciones, idMantenimiento_FK, usuarios.nombres as NombreU, usuarios.apellidos as ApellidosU, refacciones ";
                    $consulta = $objeto -> SQL_consulta($tabla, $campos);
                    
                    if (mysqli_num_rows($consulta) < 1) 
                    {
                        echo "<tr><td colspan='14' class='text-center'>NO HAY REGISTROS.</td></tr>";
                        echo"<script type='text/javascript'>
                                $(document).ready(function(){
                                    $('#BtnEliminar').prop('disabled', true);
                                });
                            </script>";
                    }                    
                    else
                    {
                        while ($fila = $consulta -> fetch_assoc()) 
                        {
                            $idRefacciones="$fila[idRefacciones]";
                        echo "<tr>
                                <td><input type='checkbox' id='$fila[idRefacciones]' name='seleccionados[]' value='$fila[idRefacciones]' required></td>
                                <th scope='row'>$fila[idRefacciones]</th>
                                <td>$fila[idMantenimiento_FK]</td>
                                <td>$fila[NombreU] $fila[ApellidosU]</td>
                                <td>$fila[refacciones]</td>
                                <td><a class='btn btn-warning' href='Administrador.php?pagina=Modificar/Edit_Refacciones.php&idRefacciones=$fila[idRefacciones]'>Modificar</a></td>
                            </tr>";
                            echo"<script type='text/javascript'>
                                    $(document).ready(function(){
                                        $('#BtnEliminar').prop('disabled', true);
                                        $('#".$idRefacciones."').prop('checked',false);
                                        $('#".$idRefacciones."').click(function(){
                                            if($('#".$idRefacciones."').is(':checked')){
                                                $('#BtnEliminar').prop('disabled', false);
                                            }else{
                                                $('#BtnEliminar').prop('disabled', true);
                                            }
                                        });
                                    });
                                </script>";
                        }
                    }
                        
                    echo"<tr>
                            <td colspan='6'><div class='d-flex justify-content-center'><input class='btn btn-danger justify-content-center' type='submit' id='BtnEliminar' name='eliminar' value='Eliminar'></div></td>
                        </tr>
                    </tbody>
                </form>
                </table> 
            </div>
        </div>";
        if(isset($_POST["eliminar"]))
        {
            $seleccionados = $_POST["seleccionados"];

            foreach($seleccionados as $idRefacciones)
            {
                $rs = $objeto -> SQL_eliminar("refacciones", "idRefacciones = $idRefacciones");
                echo "<script>alert('REFACCIONES ELIMINADAS');window.location='?pagina=Refacciones.php';</script>";


            }
        }
    }
?>