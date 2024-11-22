<?php

session_start();
date_default_timezone_set('Europe/Lisbon');

if ($_SERVER['SERVER_NAME']=="localhost") {
	// Servidor local/desenvolvimento
	$bd_host="localhost";
	$bd_user="root";
	$bd_password="";
	$bd_database="bd_alojamento";
}
else {
	// Servidor de produção | Fora do nosso servidor local 
	$bd_host="localhost";
	$bd_user="";
	$bd_password="";
	$bd_database="";
}

$link=mysqli_connect($bd_host,$bd_user,$bd_password,$bd_database);



if (mysqli_connect_errno()){
	die("Ocorreu um erro na ligação à base de dados. Erro: ".mysqli_connect_error());
}
$link->set_charset("utf8");
?>