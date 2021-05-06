<?php
@session_start();
require_once('Ejercicio2.php');
echo ContadorVisitas();
echo "<hr align='center'>";
?>

<div class='formulario'>
<h2>Llena el siguiente formulario.</h2>
    <form method='POST'>
    <label class='preguntas' for='nombres'>Nombres.</label>
    <input type='text' name='nombres' required>

    <label class='preguntas' for='apellidos'>Apellidos.</label>
    <input type='text' name='apellidos' required>

    <label class='preguntas' for='direccion'>Dirección.</label>
    <input type='text'name='direccion' required>

    <label class='preguntas' for='primerTel'>Telefono 1 (obligatorio)</label>
    <input type='text' name='primerTel' placeholder='0000-0000' pattern='[0-9]{4}-[0-9]{4}' required>
    <label class='preguntas' for='segundoTel'>Telefono 2</label>
    <input type='text' name='segundoTel' placeholder='0000-0000' pattern='[0-9]{4}-[0-9]{4}'>
    <label class='preguntas' for='tercerTel'>Telefono 3</label>
    <input type='text' name='tercerTel' placeholder='0000-0000' pattern='[0-9]{4}-[0-9]{4}'>

    <label class='preguntas' for='dui'>DUI</label>
    <input type='text' name='dui' placeholder='00000000-0' pattern='[0-9]{8}-[0-9]{1}' required>

    <input class='btn_Enviar' type='submit' value='Enviar' name='BtnForm'>
    </form>
</div>
<?php
if (isset($_POST["BtnForm"]))
{
    $nombres = $_POST["nombres"];
    $apellidos = $_POST["apellidos"];
    $direccion = $_POST["direccion"];
    $primerTel = $_POST["primerTel"];
    $segundoTel = $_POST["segundoTel"];
    $tercerTel = $_POST["tercerTel"];
    $dui = $_POST["dui"];


    if (isset($_SESSION["datos"]))
        {
            $sesion = $_SESSION["datos"]; 
            $n = count($sesion);
            $num=0;

            for ($i=0; $i<$n; $i++)
            {
                if ($_SESSION["datos"][$i][6]==$dui)
                {
                    $num+=1;
                }
            }
            if ($num > 0)
            {
                echo "<h2 align='center'>Usted ya ha contestado este formulario.</h2>";
                echo"<script>alert('Usted ya ha contestado este formulario.')</script>";
            }
            else
            {
                $datos = $_SESSION["datos"];
                $info[] = $nombres;
                $info[] = $apellidos;
                $info[] = $direccion;
                $info[] = $primerTel;
                $info[] = $segundoTel;
                $info[] = $tercerTel;
                $info[] = $dui;
                $datos[] = $info;
                $_SESSION["datos"] = $datos;
                echo"<script>alert('Agregado')</script>";
            }
        }
        else 
        {
            $info[] = $nombres;
            $info[] = $apellidos;
            $info[] = $direccion;
            $info[] = $primerTel;
            $info[] = $segundoTel;
            $info[] = $tercerTel;
            $info[] = $dui;
            $_SESSION["datos"][]= $info;
            echo"<script>alert('Agregado')</script>";
        }
}

?>