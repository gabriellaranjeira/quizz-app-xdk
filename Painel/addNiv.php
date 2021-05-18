<?php
	include_once("conn.php");

	$patente = trim($_POST['patente']);
	$pegc = trim($_POST['pegc']);
	$sql = "INSERT INTO nivel(nivel,
						patente) VALUES (
		            	:nivel,
		            	:pat)";
		                                          
	$resp = $conn->prepare($sql);
	$resp->bindParam(':nivel', $pegc, PDO::PARAM_STR); 
	$resp->bindParam(':pat', $patente, PDO::PARAM_STR);
	if($resp->execute()){
		header('location: home.php?msg=Nivel cadastrado com sucesso!');
	}
?>