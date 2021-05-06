<?php
@session_start();
date_default_timezone_set('America/El_Salvador');
require_once('Ejercicio2.php');
echo ContadorVisitas();
echo "<hr align='center'>";
?>
<?php
    if (isset($_SESSION["estado"]))
    {
        ob_start();
        echo "
        <div class='formulario'>
        <h2>Realizar la siguiente encuesta.</h2>
        <form method='POST'>
        <label class='preguntas' for='nombre'><b>Nombre.</b></label>
        <input type='text' name='nombre' required>
        <br>
        <label class='preguntas' for='sexo'><b>Sexo:</b></label>
        <label  for='masculino'>Masculino:</label>
        <input type='radio' id='masculino' name='sexo' value='masculino'>
        <label  for='femenino'>Femenino:</label>
        <input type='radio' id='femenino' name='sexo' value='femenino'>
        <br>
        <label class='preguntas' for='deporte'><b>Deporte favorito:</b></label>
        <label  for='futbol'>Fútbol:</label>
        <input type='radio' id='futbol' name='deporte' value='futbol'>
        <label  for='basquetbol'>Básquetbol:</label>
        <input type='radio' id='basquetbol' name='deporte' value='basquetbol'>
        <label  for='hockey'>Hockey:</label>
        <input type='radio' id='hockey' name='deporte' value='hockey'>
        <label  for='beisbol'>Béisbol:</label>
        <input type='radio' id='beisbol' name='deporte' value='beisbol'>
        <label  for='golf'>Golf:</label>
        <input type='radio' id='golf' name='deporte' value='golf'>
        <br>
        <label class='preguntas' for='estudio'><b>Nivel de estudio:</b></label>
        <select  name='estudio' id='estudio' required>
        <option value='nulo'>Nulo</option>
        <option value='basico'>Básico</option>
        <option value='intermedio'>Intermedio</option>
        <option value='superior'>Superior</option>
        </select>
        <br>
        <label class='preguntas' for='tema'><b>Tema favorito:</b></label>
        <label  for='tv'>Televisión:</label>
        <input type='radio' id='tv' name='tema' value='tv'>
        <label  for='cocina'>Cocina:</label>
        <input type='radio' id='cocina' name='tema' value='cocina'>
        <label  for='tecnologia'>Tecnología:</label>
        <input type='radio' id='tecnologia' name='tema' value='tecnologia'>
        <label  for='musica'>Música:</label>
        <input type='radio' id='musica' name='tema' value='musica'>
        <label  for='deportes'>Deportes:</label>
        <input type='radio' id='deportes' name='tema' value='deportes'>

        <input class='btn_Enviar' type='submit' value='Enviar' name='BtnEncuesta'>
        </form>
        <form method='POST'>
        <input class='btn_Enviar' type='submit' value='CERRAR ENCUESTA' name='BtnCerrar'>
        </form>
    </div>
    ";
    if (isset($_POST["BtnEncuesta"]))
    {
        $nombre = $_POST["nombre"];
        $sexo = $_POST["sexo"];
        $deporte = $_POST["deporte"];
        $estudio = $_POST["estudio"];
        $tema = $_POST["tema"];

            if (isset($_SESSION["encuesta"]))
            {
                    $sesion = $_SESSION["encuesta"]; 
                    $n = count($sesion);
                    $num=0;

                    foreach ($_SESSION["encuesta"] as $llave => $valor)
                    {
                        if ($llave==$nombre)    
                        {
                            $num+=1;
                        }
                    }
                    if ($num > 0)
                    {
                        echo"<script>alert('Usted ya ha contestado este encuesta.')</script>";
                        echo "<h2 align='center'>Usted ya ha contestado esta encuesta.</h2>";
                    }
                    else
                    {
                        $datos = $_SESSION["encuesta"];
                        $info[] = $sexo;
                        $info[] = $deporte;
                        $info[] = $estudio;
                        $info[] = $tema;
                        $info[] = date('o-m-d');
                        $info[] = date('h:i:s A');
                        $datos[$nombre] = $info;
                        $_SESSION["encuesta"] = $datos;
                        echo"<script>alert('Agregado')</script>";
                    }
                }
                else 
                {
                    $info[] = $sexo;
                    $info[] = $deporte;
                    $info[] = $estudio;
                    $info[] = $tema;
                    $info[] = date('o-m-d');
                    $info[] = date('h:i:s A');
                    $_SESSION["encuesta"][$nombre]= $info;
                    echo"<script>alert('Agregado')</script>";
                }
            }
            elseif (isset($_POST["BtnCerrar"]))
            {
                unset($_SESSION["encuesta"]);
                unset($_SESSION["estado"]);
                header("location:?pagina=Ejercicio4.php");
            } 
    }
    else 
    {
        echo "
            <div class='formulario'>
            <h2>La encuesta está cerrada</h2>
            <form method='POST'>
                <label class='preguntas' for='nombre'>¿Quieres responderla?</label>
                <input class='btn_Enviar' type='submit' value='ABRIR ENCUESTA' name='BtnAbrir'>
                </form>
            </div>
            ";
        if (isset($_POST["BtnAbrir"]))
        {
            $_SESSION["estado"] = "Activada";
            header("location:?pagina=Ejercicio4.php");
        }

    }
?>
