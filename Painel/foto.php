<?php
	include_once("conn.php");
	$foto = trim($_POST['foto']);
	$id = trim($_POST['id']);
	$arquivo = md5(date("F j, Y, h:i a")).".png";
	$data2 = substr($foto, strpos($foto, ",") + 1);
	$decodedData = base64_decode($foto);
	$fp = fopen("img/$arquivo", 'wb');
	fwrite($fp, $decodedData);
	$sql = "UPDATE usuarios SET foto = :foto
				            WHERE id = :id";
	$up = $conn->prepare($sql);
	$up->bindParam(':foto', $arquivo, PDO::PARAM_STR); 
	$up->bindParam(':id', $id, PDO::PARAM_STR); 
	if($up->execute()){
		echo "sucesso";
	}else{ echo "Erro ao consultar banco de dados!"; }
?>