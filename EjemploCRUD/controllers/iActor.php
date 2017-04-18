<?php
	ini_set('display_errors', 'on');
	session_start();
	include_once("../models/class.actor.php");
	$obj = new actor();
	if (isset($_POST['id_actor']) && isset($_POST['descripcion_actor']) && isset($_POST['nombre_actor'])){
		$obj->id=$_POST['id_actor'];
		$obj->descripcion=$_POST['descripcion_actor'];
		$obj->descripcion=$_POST['nombre_actor'];
		echo $obj->insert();
	}
	else{
		echo "-1";
	}
?>
