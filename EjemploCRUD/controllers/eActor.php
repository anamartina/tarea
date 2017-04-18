<?php
	ini_set('display_errors', 'on');
	session_start();
	include_once("../models/class.actor.php");
	$obj = new actor();
	if (isset($_POST['id_actor'])){
		echo $obj->delete($_POST['id_actor']);
	}
	else{
		echo "-2";
	}
?>
