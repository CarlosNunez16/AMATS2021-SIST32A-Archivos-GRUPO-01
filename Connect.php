<?php
date_default_timezone_set('America/El_Salvador');

define("SERVIDOR", "localhost");
define("USUARIO", "root");
define("CLAVE", "");
define("DATABASE", "inventario_DB");

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
    public function SQL_Encriptar_Desencriptar($accion, $string)
    {
        $metodo = "AES-256-CBC";
        $palabraClave = "Te amo meci";
        $iv = 'C9fBxl1EWtYTL1/M8jfstw=="';

        $key = hash('sha256', $palabraClave);
        $siv = substr(hash('sha256', $iv), 0,16);

        if($accion=="encriptar")
        {
            $salida = openssl_encrypt($string, $metodo, $key, 0, $siv);
            $salida=base64_encode($salida);
        }
        return $salida;
    }

    public function SQL_consulta($tabla, $campos)
    {
        $sql = "select $campos from $tabla";

        $respuesta = $this -> connect -> query($sql);
        return $respuesta;
    }

    public function ejecutaSQL($sql)
    {
		$respuesta=$this->connect->query($sql);
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

    public function SQL_modificar($tabla, $nuevosValores, $condicion)
    {
        $nuevos = "";
        foreach ($nuevosValores as $key => $item) {
            if($item === end($nuevosValores))
            {
                $nuevos.= "$key = '$item'";
            }
            else
            {
                $nuevos.= "$key = '$item',";
            }
        }

        $sql = "update $tabla set $nuevos where $condicion";
        $respuesta = $this -> connect -> query($sql);
        return $respuesta;
    }
    public function SQL_modificarReporte($tabla, $nuevosValores, $condicion)
    {
        $nuevos = "";
        foreach ($nuevosValores as $key => $item) {
            if($item === end($nuevosValores))
            {
                $nuevos.= "$key = $item";
            }
            else
            {
                $nuevos.= "$key = $item,";
            }
        }

        $sql = "update $tabla set $nuevos where $condicion";
        $respuesta = $this -> connect -> query($sql);
        return $respuesta;
    }
    public function SQL_eliminar($tabla, $condicion)
    {
        $sql = "delete from $tabla where $condicion";
        $respuesta = $this -> connect -> query($sql);
        return $respuesta;
    }
}


?>