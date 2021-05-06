<?php
@session_start();
require_once('Ejercicio2.php');
echo ContadorVisitas();
echo "<hr align='center'>";
?>

<div class='formulario'>
    <h2>CONSULTA DE DATOS.</h2>
        <form method='POST'>
            <label class='preguntas' for='dui'>Ingrese su número de DUI</label>
            <input type='text' name='dui' placeholder='00000000-0' pattern='[0-9]{8}-[0-9]{1}' required>

            <input class='btn_Enviar' type='submit' value='Enviar' name='BtnConsulta'>
        </form>
</div>

<?php
if (isset($_POST["BtnConsulta"]))
{
    if (isset($_SESSION["datos"]))
    {
        $dui = $_POST["dui"];

            $num=0;

        foreach ($_SESSION["datos"] as $item)
        {
            if ($item[6]==$dui)
            {
                $num+=1;
                $duiSelect = $item; 
            }
        }
        if ($num > 0)
        {
            echo "
                <table>
                <tr>
                    <th>Nombres</th>
                    <th>Apellidos</th>
                    <th>Direción</th>
                    <th>Telefono 1</th>
                    <th>Telefono 2</th>
                    <th>Telefono 3</th>
                    <th>DUI</th>
                </tr>
                <tr>
                <td>".$duiSelect[0]."</td>
                <td>".$duiSelect[1]."</td>
                <td>".$duiSelect[2]."</td>
                <td>".$duiSelect[3]."</td>";
                if ($duiSelect[4] == "")
                {
                    echo "<td>-</td>";
                }
                else 
                {
                    echo "<td>".$duiSelect[4]."</td>";
                }
                if ($duiSelect[5] == "")
                {
                    echo "<td>-</td>";
                }
                else 
                {
                    echo "<td>".$duiSelect[5]."</td>";
                }

                echo "<td>".$duiSelect[6]."</td>
            </tr>
        </table>
        ";
        }
        else
        {
            echo "<table><tr><th>El DUI ".$dui." no está registrado</th></tr></table>";
        }
    } 
    else
    {
        echo "<table><tr><th>¡ADVERTENCIA! Programa sin registros.</th></tr></table>";
    }              
}
?>