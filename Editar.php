<?php
@session_start();
date_default_timezone_set('America/El_Salvador');
require_once('Ejercicio2.php');
echo ContadorVisitas();
echo "<hr align='center'>";
ob_start();
?>
<?php
if (isset($_SESSION["encuesta"]))
{
    foreach ($_SESSION["encuesta"] as $llave => $valor)
    {
        if ($_GET["encuesta"]== $llave)
        {
                echo "
                <div class='formulario'>
                <h2>Modifica tus respuestas.</h2>
                <form method='POST'>
                <label class='preguntas' for='nombre'><b>Nombre.</b></label>
                <input type='text' name='nombre' value='$llave' required disabled>
                <br>
                <label class='preguntas' for='sexo'><b>Sexo:</b></label>";
                if ($valor[0]== "masculino")
                {
                    echo "<label  for='masculino'>Masculino:</label>
                    <input type='radio' id='masculino' name='sexo' value='masculino' checked>
                    <label  for='femenino'>Femenino:</label>
                    <input type='radio' id='femenino' name='sexo' value='femenino' disabled>";
                }
                else 
                {
                    echo "<label  for='masculino'>Masculino:</label>
                    <input type='radio' id='masculino' name='sexo' value='masculino' disabled>
                    <label  for='femenino'>Femenino:</label>
                    <input type='radio' id='femenino' name='sexo' value='femenino' checked>";
                }
                if ($valor[1] == "futbol")
                {
                    echo "
                    <br>
                    <label class='preguntas' for='deporte'><b>Deporte favorito:</b></label>
                    <label  for='futbol'>Fútbol:</label>
                    <input type='radio' id='futbol' name='deporte' value='futbol' checked>
                    <label  for='basquetbol'>Básquetbol:</label>
                    <input type='radio' id='basquetbol' name='deporte' value='basquetbol'>
                    <label  for='hockey'>Hockey:</label>
                    <input type='radio' id='hockey' name='deporte' value='hockey'>
                    <label  for='beisbol'>Béisbol:</label>
                    <input type='radio' id='beisbol' name='deporte' value='beisbol'>
                    <label  for='golf'>Golf:</label>
                    <input type='radio' id='golf' name='deporte' value='golf'>";
                }
                elseif ($valor[1] == "basquetbol")
                {
                    echo "
                    <br>
                    <label class='preguntas' for='deporte'><b>Deporte favorito:</b></label>
                    <label  for='futbol'>Fútbol:</label>
                    <input type='radio' id='futbol' name='deporte' value='futbol'>
                    <label  for='basquetbol'>Básquetbol:</label>
                    <input type='radio' id='basquetbol' name='deporte' value='basquetbol' checked>
                    <label  for='hockey'>Hockey:</label>
                    <input type='radio' id='hockey' name='deporte' value='hockey'>
                    <label  for='beisbol'>Béisbol:</label>
                    <input type='radio' id='beisbol' name='deporte' value='beisbol'>
                    <label  for='golf'>Golf:</label>
                    <input type='radio' id='golf' name='deporte' value='golf'>";
                }
                elseif ($valor[1] == "hockey")
                {
                    echo "
                    <br>
                    <label class='preguntas' for='deporte'><b>Deporte favorito:</b></label>
                    <label  for='futbol'>Fútbol:</label>
                    <input type='radio' id='futbol' name='deporte' value='futbol'>
                    <label  for='basquetbol'>Básquetbol:</label>
                    <input type='radio' id='basquetbol' name='deporte' value='basquetbol'>
                    <label  for='hockey'>Hockey:</label>
                    <input type='radio' id='hockey' name='deporte' value='hockey' checked>
                    <label  for='beisbol'>Béisbol:</label>
                    <input type='radio' id='beisbol' name='deporte' value='beisbol'>
                    <label  for='golf'>Golf:</label>
                    <input type='radio' id='golf' name='deporte' value='golf'>";
                }
                elseif ($valor[1] == "beisbol")
                {
                    echo "
                    <br>
                    <label class='preguntas' for='deporte'><b>Deporte favorito:</b></label>
                    <label  for='futbol'>Fútbol:</label>
                    <input type='radio' id='futbol' name='deporte' value='futbol'>
                    <label  for='basquetbol'>Básquetbol:</label>
                    <input type='radio' id='basquetbol' name='deporte' value='basquetbol'>
                    <label  for='hockey'>Hockey:</label>
                    <input type='radio' id='hockey' name='deporte' value='hockey'>
                    <label  for='beisbol'>Béisbol:</label>
                    <input type='radio' id='beisbol' name='deporte' value='beisbol' checked>
                    <label  for='golf'>Golf:</label>
                    <input type='radio' id='golf' name='deporte' value='golf'>
                    <br>";
                }
                elseif ($valor[1] == "golf")
                {
                    echo "
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
                    <input type='radio' id='golf' name='deporte' value='golf' checked>";
                }
                if ($valor[2] == "nulo")
                {
                    echo "<br>
                    <label class='preguntas' for='estudio'><b>Nivel de estudio:</b></label>
                    <select  name='estudio' id='estudio' required>
                    <option value='nulo' selected>Nulo</option>
                    <option value='basico'>Básico</option>
                    <option value='intermedio'>Intermedio</option>
                    <option value='superior'>Superior</option>
                    </select>";
                }
                elseif ($valor[2] == "basico")
                {
                    echo "<br>
                    <label class='preguntas' for='estudio'><b>Nivel de estudio:</b></label>
                    <select  name='estudio' id='estudio' required>
                    <option value='nulo'>Nulo</option>
                    <option value='basico' selected>Básico</option>
                    <option value='intermedio'>Intermedio</option>
                    <option value='superior'>Superior</option>
                    </select>";
                }
                elseif ($valor[2] == "intermedio")
                {
                    echo "<br>
                    <label class='preguntas' for='estudio'><b>Nivel de estudio:</b></label>
                    <select  name='estudio' id='estudio' required>
                    <option value='nulo'>Nulo</option>
                    <option value='basico'>Básico</option>
                    <option value='intermedio' selected>Intermedio</option>
                    <option value='superior'>Superior</option>
                    </select>";
                }
                elseif ($valor[2] == "superior")
                {
                    echo "<br>
                    <label class='preguntas' for='estudio'><b>Nivel de estudio:</b></label>
                    <select  name='estudio' id='estudio' required>
                    <option value='nulo'>Nulo</option>
                    <option value='basico'>Básico</option>
                    <option value='intermedio'>Intermedio</option>
                    <option value='superior' selected>Superior</option>
                    </select>";
                }
                if ($valor[3] == "tv")
                {
                    echo "
                    <br>
                    <label class='preguntas' for='tema'><b>Tema favorito:</b></label>
                    <label  for='tv'>Televisión:</label>
                    <input type='radio' id='tv' name='tema' value='tv' checked>
                    <label  for='cocina'>Cocina:</label>
                    <input type='radio' id='cocina' name='tema' value='cocina'>
                    <label  for='tecnologia'>Tecnología:</label>
                    <input type='radio' id='tecnologia' name='tema' value='tecnologia'>
                    <label  for='musica'>Música:</label>
                    <input type='radio' id='musica' name='tema' value='musica'>
                    <label  for='deportes'>Deportes:</label>
                    <input type='radio' id='deportes' name='tema' value='deportes'>";
                }
                elseif ($valor[3] == "cocina")
                {
                    echo "
                    <br>
                    <label class='preguntas' for='tema'><b>Tema favorito:</b></label>
                    <label  for='tv'>Televisión:</label>
                    <input type='radio' id='tv' name='tema' value='tv'>
                    <label  for='cocina'>Cocina:</label>
                    <input type='radio' id='cocina' name='tema' value='cocina' checked>
                    <label  for='tecnologia'>Tecnología:</label>
                    <input type='radio' id='tecnologia' name='tema' value='tecnologia'>
                    <label  for='musica'>Música:</label>
                    <input type='radio' id='musica' name='tema' value='musica'>
                    <label  for='deportes'>Deportes:</label>
                    <input type='radio' id='deportes' name='tema' value='deportes'>";
                }
                elseif ($valor[3] == "tecnologia")
                {
                    echo "
                    <br>
                    <label class='preguntas' for='tema'><b>Tema favorito:</b></label>
                    <label  for='tv'>Televisión:</label>
                    <input type='radio' id='tv' name='tema' value='tv'>
                    <label  for='cocina'>Cocina:</label>
                    <input type='radio' id='cocina' name='tema' value='cocina'>
                    <label  for='tecnologia'>Tecnología:</label>
                    <input type='radio' id='tecnologia' name='tema' value='tecnologia' checked>
                    <label  for='musica'>Música:</label>
                    <input type='radio' id='musica' name='tema' value='musica'>
                    <label  for='deportes'>Deportes:</label>
                    <input type='radio' id='deportes' name='tema' value='deportes'>";
                }
                elseif ($valor[3] == "musica")
                {
                    echo "
                    <br>
                    <label class='preguntas' for='tema'><b>Tema favorito:</b></label>
                    <label  for='tv'>Televisión:</label>
                    <input type='radio' id='tv' name='tema' value='tv'>
                    <label  for='cocina'>Cocina:</label>
                    <input type='radio' id='cocina' name='tema' value='cocina'>
                    <label  for='tecnologia'>Tecnología:</label>
                    <input type='radio' id='tecnologia' name='tema' value='tecnologia'>
                    <label  for='musica'>Música:</label>
                    <input type='radio' id='musica' name='tema' value='musica' checked>
                    <label  for='deportes'>Deportes:</label>
                    <input type='radio' id='deportes' name='tema' value='deportes'>";
                }
                elseif ($valor[3] == "deportes")
                {
                    echo "
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
                    <input type='radio' id='deportes' name='tema' value='deportes' checked>";
                }

                echo "<input class='btn_Enviar' type='submit' value='Actualizar' name='BtnEncuesta'>
                </form>
            </div>
            ";
        }
    }
    if (isset($_POST["BtnEncuesta"]))
    {
        $deporte = $_POST["deporte"];
        $estudio = $_POST["estudio"];
        $tema = $_POST["tema"];



        foreach ($_SESSION["encuesta"] as $llave => $valor)
        {
            if ($_GET["encuesta"]== $llave)
            {
                $_SESSION["encuesta"][$llave][1] = $deporte;
                $_SESSION["encuesta"][$llave][2] = $estudio;
                $_SESSION["encuesta"][$llave][3] = $tema;
                $_SESSION["encuesta"][$llave][4] = date('o-m-d');
                $_SESSION["encuesta"][$llave][5] = date('h:i:s A')." (editado)";
                // array_replace($_SESSION["encuesta"]
            }
        }
        header("location:?pagina=Ejercicio4/Consultas.php");
    }
} 
?>