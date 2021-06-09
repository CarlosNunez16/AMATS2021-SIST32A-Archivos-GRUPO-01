<?php
    if(isset($_POST["Siguiente"]))
    {
        $datos = $objeto -> SQL_Encriptar_Desencriptar("encriptar", $_POST["claveAnterior"]);

        $tabla = "usuarios";
        $consulta = $objeto -> SQL_consulta_condicional($tabla, "*", "contraseña like '".$datos."' and carnet 
        like '".$_SESSION["Administrador"][0]."'");
        if (mysqli_num_rows($consulta) > 0) 
        {
            echo"
                <div class='row d-flex justify-content-center'>
                    <div class='col-4 m-3 s-1 p-3 border border-dark rounded-3 d-block' style='background-color:#F5F5F5'>
                        <form class='row g-3 needs-validation' method='post'>
                            <div class='col-md-12'>
                                <label for='claveNew' class='form-label'>Ingrese su nueva contraseña.</label>
                                <input type='password' class='form-control' name='claveNew'  required>
                            </div>
                            <div class='col-md-12'>
                                <label for='claveConf'410 lass='form-label'>Confirme su nueva contraseña.</label>
                                <input type='password' class='form-control' name='claveConf'  required>
                            </div>
                            <div class='col-12'>
                                <input class='btn btn-success' type='submit' name='Guardar' value='Guardar'>
                                <a class='btn btn-danger' href='Empleado_Estudiante.php?pagina=Inventario.php&opcion=all'>Cancelar</a>
                            </div>
                        </form> 
                    </div>
                </div>
            ";
        }
        else
        {
            echo "<script>alert('Contraseña incorrecta'); window.location='?pagina=Modificar/Password.php&opcion=all';</script>";
        }
    }
    else
    {
        echo"
            <div class='row d-flex justify-content-center'>
                <div class='col-4 m-3 s-1 p-3 border border-dark rounded-3 d-block' style='background-color:#F5F5F5'>
                    <form class='row g-3 needs-validation' method='post'>
                        <div class='col-md-12'>
                            <label for='claveAnterior' class='form-label'>Para continuar ingrese su contraseña actual</label>
                            <input type='password' class='form-control' name='claveAnterior'  required>
                        </div>
                        <div class='col-12'>
                            <input class='btn btn-success' type='submit' name='Siguiente' value='Siguiente'>
                            <a class='btn btn-danger' href='Empleado_Estudiante.php?pagina=Inventario.php&opcion=all'>Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        ";
    }

if(isset($_POST["Guardar"]))
{
    $claveNew["contraseña"] = $objeto -> SQL_Encriptar_Desencriptar("encriptar", $_POST["claveNew"]);
    $claveConf["contraseña"] = $objeto -> SQL_Encriptar_Desencriptar("encriptar", $_POST["claveConf"]);

    if($claveNew["contraseña"] == $claveConf["contraseña"])
    {
        $condicion = "carnet = ".$_SESSION["Administrador"][0]."";
		$rs = $objeto -> SQL_modificar("usuarios", $claveNew, $condicion);
		echo "<script>alert('CONTRASEÑA MODIFICADA'); window.location='?pagina=Inventario.php&opcion=all';</script>";
    }
    else
    {
        echo "<script>alert('Las contraseñas no coinciden');</script>";
    }
}
?>