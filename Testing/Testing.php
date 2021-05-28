<?php
use PHPUnit\Framework\TestCase;

Final Class Testing extends TestCase
{
	/** @test */
	public function TestEncript() 
	{
		$ClsProc = new ClsConnection;
		$this -> assertSame("NnNGWTh0ODlpbUJaVnZjWWQxK0hmZz09", $ClsProc->SQL_Encriptar_Desencriptar("encriptar", "admin");
	}
	/** @test */
	public function TestCarnet()
	{
		$ClsProc = new ClsConnection;
		$this -> assertEquals(num_rows > 0, $ClsProc->SQL_consulta_condicional("usuario", "carnet", "carnet = 128820");
	}
}
?>
// TE ODIO TESTING