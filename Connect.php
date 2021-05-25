<?php
date_default_timezone_set('America/El_Salvador');

define("SERVIDOR", "localhost");
define("USUARIO", "root");
define("CLAVE", "");
define("DATABASE", "inventario");

class ClsConnection
{
    private $connect;

    public function __construct()
    {
        try 
        {
            $this -> connect= new mysqli(SERVIDOR, USUARIO, CLAVE, DATABASE);
        }
        catch(Exception $e)
        {
            echo $e -> errorMessage();
        }
    }

    public function SQL_consulta($tabla, $campos)
    {
        $sentencia = "select $campos from $tabla";

        $respuesta = $this -> connect -> query($sentencia);
        return $respuesta;
    }
    public function SQL_consulta_condicional($tabla, $campos, $condicion)
    {
        $sentencia = "select $campos from $tabla where $condicion";

        $respuesta = $this -> connect -> query($sentencia);
        return $respuesta;
    }
    public function SQL_insert($tabla, $campos, $datos)
    {
        $campos_String = implode(",", $campos);
        $Nuevosdatos= "'".implode("','", $datos)."'";

        $sentencia = "insert into $tabla ($campos_String) values ($Nuevosdatos)";
        $respuesta = $this -> connect -> query($sentencia);
        return $respuesta;
    }

}


?>