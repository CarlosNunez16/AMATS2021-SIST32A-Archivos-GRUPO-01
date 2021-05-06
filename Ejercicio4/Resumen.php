<?php
@session_start();
require_once('Ejercicio2.php');
echo ContadorVisitas();
echo "<hr align='center'>";
ob_start();

$hombre=0;
$mujer=0;
$futbol=0;
$basquetbol=0;
$hockey=0;
$beisbol=0;
$golf=0;
$nulo=0;
$basico=0;
$intermedio=0;
$superior=0;
$tv=0;
$cocina=0;
$tecnologia=0;
$musica=0;
$deportes=0;
$deporteFemenino=0;
$cocinaH=0;
if (isset($_SESSION["encuesta"]))
{
    foreach ($_SESSION["encuesta"] as $llave => $valor)
    {
        if($valor[0] == "masculino")
        {
            $hombre++;
        }
        elseif ($valor[0] == "femenino")
        {
            $mujer++;
        }
        if ($valor[1] == "futbol")
        {
            $futbol++;
        }
        elseif ($valor[1] == "basquetbol")
        {
            $basquetbol++;
        }
        elseif ($valor[1] == "hockey")
        {
            $hockey++;
        }
        elseif ($valor[1] == "beisbol")
        {
            $beisbol++;
        }
        elseif ($valor[1] == "golf")
        {
            $golf++;
        }
        if ($valor[2] == "nulo")
        {
            $nulo++;
        }
        elseif ($valor[2] == "basico")
        {
            $basico++;
        }
        elseif ($valor[2] == "intermedio")
        {
            $intermedio++;
        }
        elseif ($valor[2] == "superior")
        {
            $superior++;
        }
        if ($valor[3] == "tv")
        {
            $tv++;
        }
        elseif ($valor[3] == "cocina")
        {
            $cocina++;
        }
        elseif ($valor[3] == "tecnologia")
        {
            $tecnologia++;
        }
        elseif ($valor[3] == "musica")
        {
            $musica++;
        }
        elseif ($valor[3] == "deporte")
        {
            $deportes++;
        }
        if ($valor[0] == "femenino" && $valor[1] == "futbol")
        {
            $deporteFemenino++;
        }
        if ($valor[0] == "masculino" && $valor[3] == "cocina")
        {
            $cocinaH++;
        }

    }

        echo "
                <div class='formulario'>
                <h2>Género.</h2>
                <form method='post'>
                <label class='preguntas' for='nombre'>Total de encuestas: ".($hombre+$mujer)."</label>
                <input type='range' disabled value='".($hombre+$mujer)."' max='".($hombre+$mujer)."'>
                <label class='preguntas' for='nombre'>$hombre Hombres</label>
                <input type='range' disabled value='$hombre' max='".($hombre+$mujer)."'>
                <label class='preguntas' for='nombre'>$mujer Mujeres</label>
                <input type='range' disabled value='$mujer' max='".($hombre+$mujer)."'>
                </form>

                <h2>Deporte Favorito.</h2>
                <form method='post'>
                <label class='preguntas' for='nombre'>$futbol Fútbol</label>
                <input type='range' disabled value='$futbol' max='".($futbol+$basquetbol+$hockey+$golf+$beisbol)."'>
                <label class='preguntas' for='nombre'>$basquetbol Básquetbol</label>
                <input type='range' disabled value='$basquetbol' max='".($futbol+$basquetbol+$hockey+$golf+$beisbol)."'>
                <label class='preguntas' for='nombre'>$hockey Hockey</label>
                <input type='range' disabled value='$hockey' max='".($futbol+$basquetbol+$hockey+$golf+$beisbol)."'>
                <label class='preguntas' for='nombre'>$beisbol Béisbol</label>
                <input type='range' disabled value='$beisbol' max='".($futbol+$basquetbol+$hockey+$golf+$beisbol)."'>
                <label class='preguntas' for='nombre'>$golf Golf</label>
                <input type='range' disabled value='$golf' max='".($futbol+$basquetbol+$hockey+$golf+$beisbol)."'>
                </form>

                <h2>Nivel de estudio.</h2>
                <form method='post'>
                <label class='preguntas' for='nombre'>$nulo Nulo</label>
                <input type='range' disabled value='$nulo' max='".($basico+$nulo+$intermedio+$superior)."'>
                <label class='preguntas' for='nombre'>$basico Básico</label>
                <input type='range' disabled value='$basico' max='".($basico+$nulo+$intermedio+$superior)."'>
                <label class='preguntas' for='nombre'>$intermedio Intermedio</label>
                <input type='range' disabled value='$intermedio' max='".($basico+$nulo+$intermedio+$superior)."'>
                <label class='preguntas' for='nombre'>$superior Superior</label>
                <input type='range' disabled value='$superior' max='".($basico+$nulo+$intermedio+$superior)."'>
                </form>

                <h2>Tema favorito.</h2>
                <form method='post'>
                <label class='preguntas' for='nombre'>$tv Televisión</label>
                <input type='range' disabled value='$tv' max='".($tv+$cocina+$tecnologia+$musica+$deportes)."'>
                <label class='preguntas' for='nombre'>$cocina Cocina</label>
                <input type='range' disabled value='$cocina' max='".($tv+$cocina+$tecnologia+$musica+$deportes)."'>
                <label class='preguntas' for='nombre'>$tecnologia Tecnología</label>
                <input type='range' disabled value='$tecnologia' max='".($tv+$cocina+$tecnologia+$musica+$deportes)."'>
                <label class='preguntas' for='nombre'>$musica Música</label>
                <input type='range' disabled value='$musica' max='".($tv+$cocina+$tecnologia+$musica+$deportes)."'>
                <label class='preguntas' for='nombre'>$deportes Deportes</label>
                <input type='range' disabled value='$deportes' max='".($tv+$cocina+$tecnologia+$musica+$deportes)."'>
                </form>";
                if ($mujer>0)
                {
                    echo "<h2>Porcentaje de mujeres que les gusta el futbol.</h2>
                    <p>".($deporteFemenino/$mujer*100)."% de Mujeres</p>";
                }
                else 
                {
                    echo "<h2>Porcentaje de mujeres que les gusta el futbol.</h2>
                    <p>0% de Mujeres</p>";
                }
                if($hombre>0)
                {
                    echo "<h2>Porcentaje de hombres que les gusta la cocina.</h2>
                    <p>".($cocinaH/$hombre*100)."% Hombres</p>
                    </div>";
                }
                else 
                {
                    echo "<h2>Porcentaje de hombres que les gusta la cocina.</h2>
                    <p>0% Hombres</p>
                    </div>";
                }
}
else
{
    echo "<table><tr><td>Nadie ha realizado la encuesta todavía :(</td></tr></table>";
}
?>
