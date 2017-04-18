<?php
	ini_set('display_errors', 'on');
	session_start();
	include_once("../models/class.reparto.php");
	$obj = new reparto();
	if (isset($_POST['id_reparto'])){
		echo $obj->delete($_POST['id_reparto']);
	}
	else{
		echo "-2";
	}
?>
