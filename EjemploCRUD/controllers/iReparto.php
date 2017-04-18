<?php
	ini_set('display_errors', 'on');
	session_start();
	include_once("../models/class.reparto.php");
	$obj = new reparto();
	if (isset($_POST['id_reparto']) && isset($_POST['descripcion_reparto']) && isset($_POST['nombre_reparto'])){
		$obj->id=$_POST['id_reparto'];
		$obj->descripcion=$_POST['descripcion_reparto'];
		$obj->descripcion=$_POST['nombre_reparto'];
		echo $obj->insert();
	}
	else{
		echo "-1";
	}
?>
