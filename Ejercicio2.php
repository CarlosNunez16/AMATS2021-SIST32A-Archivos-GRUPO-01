<?php
@session_start();
function ContadorVisitas ()
{
    if(isset($_SESSION["visitasSession"]))
    {
        $_SESSION["visitasSession"]+=1;
        $mensaje = 'Cantidad de visitas: '.$_SESSION["visitasSession"];   
    }
    else
    {
        $_SESSION["visitasSession"] = 1;
        $mensaje = 'La actual, es la primer visita a la web, bienvenido!';
    }
    echo "<p>$mensaje</p>";
}
?>