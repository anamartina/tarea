<?php
ini_set('display_errors', 'off');
include_once("resources/class.database.php");

class reparto{
	var $id_reparto;
  	var $descripcion_reparto;
	var $nombre_reparto;

function reparto(){
}

function select($id_reparto){
	$sql =  "SELECT * FROM administrador.tbl_actividad WHERE id_reparto = '$id_reparto'";
	try {
		$row = pg::query($sql);
		$row=pg_fetch_array($row);
		$this->id_reparto = $row['id_reparto'];
		$this->descripcion_reparto = $row['descripcion_reparto'];
		$this->nombre_reparto = $row['nombre_reparto'];
		return true;
	}
	catch (DependencyException $e) {
	}
}

function delete($id_reparto){
	$sql = "DELETE FROM administrador.tbl_reparto WHERE id_reparto = '$id_reparto'";
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
	if ($this->validaP($this->id_reparto) == false){
		$sql = "INSERT INTO administrador.tbl_reparto( id_reparto, descripcion_reparto, nombre_reparto) VALUES ( '$this->id_reparto', '$this->descripcion_reparto', '$this->nombre_reparto')";
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
		$sql="UPDATE administrador.tbl_actividad set descripcion_reparto='" . $this->descripcion_reparto . "', nombre_reparto='" . $this-> nombre_reparto . "' WHERE id_reparto='" . $this->id_reparto . "'";
		pg::query("begin");
		$row = pg::query($sql);
		pg::query("commit");		
		echo "2";
	}
}

function validaP ($id_reparto){
      $sql =  "SELECT * FROM administrador.tbl_reparto WHERE id_reparto = '$id_reparto'";
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
	
	$sql="SELECT * FROM administrador.tbl_reparto";
	try {
		echo "<div class='container' style='margin-top: 10px'>";
		echo "<table cellpadding='0' cellspacing='0' border='0' class='table table-striped table-bordered' id='example'>";
		echo "<thead>";
		echo "<tr>";
		echo "	<th>Codigo</th>";
		echo "	<th>Descripcion</th>";
		echo "	<th>Nombre</th>";
		echo "	<th>.</th>";
		echo "</tr>";
		echo "</thead>";
		echo "<tbody>";
		$result = pg::query($sql);
		while ($row= pg_fetch_array($result)){
			echo "<tr class='gradeA'>";
			echo "	<th>" . $row['id_reparto'] . "</th>";
			echo "	<th>" . $row['descripcion_reparto'] . "</th>";
			echo "	<th>" . $row['nombre_reparto'] . "</th>";
		echo "	<th><a href='#' class='btn btn-danger' onclick='elimina(\"" . $row['id_reparto'] . "\")'>X<i class='icon-white icon-trash'></i></a>.<a href='#' class='btn btn-primary' onclick='edit(\"" . $row['id_reparto'] . "\", \"" . $row['descripcion_reparto'] . "\", \"" . $row['nombre_reparto'] . "\")'>E<i class='icon-white icon-refresh'></i></a></th>";
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
			echo "	<th>" . $row['id_reparto'] . "</th>";
			echo "	<th>" . $row['descripcion_reparto'] . "</th>";
			echo "	<th>" . $row['nombre_reparto'] . "</th>";
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
	
	$sql="select * from administrador.tbl_reparto";	
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
			$tabla=$tabla . "	<td>" . $row['id_reparto'] . "</td>";
			$tabla=$tabla . "	<td>" . $row['descripcion_reparto'] . "</td>";
			$tabla=$tabla . "	<td>" . $row['nombre_reparto'] . "</td>";
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
	
	$sql="SELECT * FROM administrador.tbl_reparto";
	try {
		echo "<SELECT id_reparto='id_reparto'>";
		$result = pg::query($sql);
		while ($row= pg_fetch_array($result)){
			echo "<OPTION value='".$row['id_reparto']."'> ".$row['descripcion_reparto']." ".$row['nombre_reparto']." </OPTION>";
		}
		echo "</SELECT>";
	}
	catch (DependencyException $e) {
		pg::query("rollback");
	}
}

function getAutocomplete(){
	$res="";
	$sql="SELECT * FROM administrador.tbl_reparto";
	try {
		$result = pg::query($sql);
		while ($row= pg_fetch_array($result)){
			$res .= '"' . $row['id_reparto'] . ', ' . $row['descripcion_reparto'] . ', ' . $row['nombre_reparto'] . '"';
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
