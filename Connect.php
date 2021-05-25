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
        $sql = "select $campos from $tabla";

        $respuesta = $this -> connect -> query($sql);
        return $respuesta;
    }
    public function SQL_consultaGeneral($tabla, $campos, $condicion=null)
    {
        $condicionB = "";
        if (!(is_null($condicion)))
        {
            $condicionB = "where $condicion";
        }
        $sql = "select $campos from $tabla $condicionB";

        $respuesta = $this -> connect -> query($sql);
        return $respuesta;
    }
    public function SQL_consulta_condicional($tabla, $campos, $condicion)
    {
        $sql = "select $campos from $tabla where $condicion";

        $respuesta = $this -> connect -> query($sql);
        return $respuesta;
    }
    public function SQL_insert($tabla, $campos, $datos)
    {
        $campos_String = implode(",", $campos);
        $Nuevosdatos= "'".implode("','", $datos)."'";

        $sql = "insert into $tabla ($campos_String) values ($Nuevosdatos)";
        $respuesta = $this -> connect -> query($sql);
        return $respuesta;
    }

}


?>