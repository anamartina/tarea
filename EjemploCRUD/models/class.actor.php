<?php
ini_set('display_errors', 'off');
include_once("resources/class.database.php");

class reparto{
	var $id_actor;
  	var $descripcion_actor;
	var $nombre_actor;

function actor(){
}

function select($id_actor){
	$sql =  "SELECT * FROM administrador.tbl_actor WHERE id_actor = '$id_actor'";
	try {
		$row = pg::query($sql);
		$row=pg_fetch_array($row);
		$this->id_actor = $row['id_actor'];
		$this->descripcion_actor = $row['descripcion_actor'];
		$this->nombre_actor = $row['nombre_actor'];
		return true;
	}
	catch (DependencyException $e) {
	}
}

function delete($id_actor){
	$sql = "DELETE FROM administrador.tbl_actividad WHERE id_actor = '$id_actor'";
	try {
		pg::query("begin");
		$row = pg::query($sql);
		pg::query("commit");
		return "1";
	}
	catch (DependencyException $e) {
		pg::query("rollback");
		return "-1";
	}
}

function insert(){
//echo "me llamo";
	if ($this->validaP($this->id_actor) == false){
		$sql = "INSERT INTO administrador.tbl_actor( id_actor, descripcion_actor, nombre_actor) VALUES ( '$this->id_actor', '$this->descripcion_actor', '$this->nombre_actor')";
		try {
			pg::query("begin");
			$row = pg::query($sql);
			pg::query("commit");
			echo "1";
		}
		catch (DependencyException $e) {
			echo "Error: " . $e;
			pg::query("rollback");
			echo "-1";
		}
	}
	else{
		$sql="UPDATE administrador.tbl_actor set descripcion_actor='" . $this->descripcion_actor . "', nombre_actor='" . $this-> nombre_actor . "' WHERE id_actor='" . $this->id_actor . "'";
		pg::query("begin");
		$row = pg::query($sql);
		pg::query("commit");		
		echo "2";
	}
}

function validaP ($id_actor){
      $sql =  "SELECT * FROM administrador.tbl_actor WHERE id_actor = '$id_actor'";
      try {
		$row = pg::query($sql);
		if(pg_num_rows($row) == 0){
		        return false;
	        }
		else{
			return true;
		 }
		}
		catch (DependencyException $e) {
			//pg::query("rollback");
			return false;
		}
}

function getTabla(){
	
	$sql="SELECT * FROM administrador.tbl_actor";
	try {
		echo "<div class='container' style='margin-top: 10px'>";
		echo "<table cellpadding='0' cellspacing='0' border='0' class='table table-striped table-bordered' id='example'>";
		echo "<thead>";
		echo "<tr>";
		echo "	<th>Codigo</th>";
		echo "	<th>Nombre</th>";
		echo "	<th>Descripcion</th>";
		echo "	<th>.</th>";
		echo "</tr>";
		echo "</thead>";
		echo "<tbody>";
		$result = pg::query($sql);
		while ($row= pg_fetch_array($result)){
			echo "<tr class='gradeA'>";
			echo "	<th>" . $row['id_actor'] . "</th>";
			echo "	<th>" . $row['descripcion_actor'] . "</th>";
			echo "	<th>" . $row['nombre_actor'] . "</th>";
		echo "	<th><a href='#' class='btn btn-danger' onclick='elimina(\"" . $row['id_actor'] . "\")'>X<i class='icon-white icon-trash'></i></a>.<a href='#' class='btn btn-primary' onclick='edit(\"" . $row['id_actor'] . "\", \"" . $row['descripcion_actor'] . "\", \"" . $row['nombre_actor'] . "\")'>E<i class='icon-white icon-refresh'></i></a></th>";
			echo "</tr>";
		}
		echo "</tbody>";
		echo "</table>";
		echo "</div>";
	}
	catch (DependencyException $e) {
		echo "Procedimiento sql invalido en el servidor";
	}
}

function getTablaInicianPorA(){
	
	$sql="select * from administrador.tbl_reparto where descripcion_reparto like 'A%'";
	try {
		echo "<div class='container' style='margin-top: 10px'>";
		echo "<table cellpadding='0' cellspacing='0' border='0' class='table table-striped table-bordered' id='example'>";
		echo "<thead>";
		echo "<tr>";
		echo "	<th>Codigo</th>";
		echo "	<th>Descripcion</th>";
		echo "	<th>Nombre</th>";

		echo "</tr>";
		echo "</thead>";
		echo "<tbody>";
		$result = pg::query($sql);
		while ($row= pg_fetch_array($result)){
			echo "<tr class='gradeA'>";
			echo "	<th>" . $row['id_actor'] . "</th>";
			echo "	<th>" . $row['descripcion_actor'] . "</th>";
			echo "	<th>" . $row['nombre_actor'] . "</th>";
			echo "</tr>";
		}
		echo "</tbody>";
		echo "</table>";
		echo "</div>";
	}
	catch (DependencyException $e) {
		echo "Procedimiento sql invalido en el servidor";
	}
}

function getTablaPDF(){
	
	$sql="select * from administrador.tbl_actor";	
	$tabla="";
	try {
		$tabla="<table>";
		$tabla=$tabla . "<tr>";
		$tabla=$tabla . "	<td>Codigo</td>";
		$tabla=$tabla . "	<td>Descripcion</td>";
		$tabla=$tabla . "	<td>Nombre</td>";

		$tabla=$tabla . "</tr>";

		$result = pg::query($sql);
		while ($row= pg_fetch_array($result)){
			$tabla=$tabla . "<tr>";
			$tabla=$tabla . "	<td>" . $row['id_actor'] . "</td>";
			$tabla=$tabla . "	<td>" . $row['descripcion_actor'] . "</td>";
			$tabla=$tabla . "	<td>" . $row['nombre_actor'] . "</td>";
			$tabla=$tabla . "</tr>";
		}
		$tabla=$tabla . "</table>";
	}
	catch (DependencyException $e) {
		echo "Procedimiento sql invalido en el servidor";
	}
	return $tabla;
}

function getLista(){
	
	$sql="SELECT * FROM administrador.tbl_actor";
	try {
		echo "<SELECT id_reparto='id_actor'>";
		$result = pg::query($sql);
		while ($row= pg_fetch_array($result)){
			echo "<OPTION value='".$row['id_actor']."'> ".$row['descripcion_actor']." ".$row['nombre_actor']." </OPTION>";
		}
		echo "</SELECT>";
	}
	catch (DependencyException $e) {
		pg::query("rollback");
	}
}

function getAutocomplete(){
	$res="";
	$sql="SELECT * FROM administrador.tbl_actor";
	try {
		$result = pg::query($sql);
		while ($row= pg_fetch_array($result)){
			$res .= '"' . $row['id_actor'] . ', ' . $row['descripcion_actor'] . ', ' . $row['nombre_actor'] . '"';
			$res .= ',';
		}
		$res = substr ($res, 0, -2); 
		$res = substr ($res, 1);
	}
	catch (DependencyException $e) {
	}
	return $res;
}
}
?>
