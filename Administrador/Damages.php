<?php
@session_start();
$objeto = new ClsConnection();

$consulta = $objeto -> SQL_consulta("usuario", "*");

