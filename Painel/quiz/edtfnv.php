<?php
	include_once("conn.php");
	$id = $_POST['id'];
	$consulta = $conn->prepare("SELECT * FROM pergunta WHERE id_quiz = :id");
	$consulta->bindParam(':id', $id);
	$consulta->execute();
	while($row = $consulta->fetch(PDO::FETCH_OBJ)){	
		$tmpPeg = 'peg'.$row->id;
		$pergunta = $_POST[$tmpPeg];
		$tmpCer = 'res'.$row->id;
		$certo = $_POST[$tmpCer];
		$editPeg = $conn->prepare('UPDATE pergunta SET pergunta=:peg, certo=:c WHERE id = :id');
		$editPeg->bindParam(':peg', $pergunta);
		$editPeg->bindParam(':c', $certo);
		$editPeg->bindParam(':id', $row->id);
		if($editPeg->execute()){
			$resposta = $conn->prepare("SELECT * FROM resposta WHERE id_pergunta = :peg");
			$resposta->bindParam(':peg', $row->id);
			$resposta->execute();
			while($res = $resposta->fetch(PDO::FETCH_OBJ)){
				$tmpRes = 'peg'.$row->id.'res'.$res->id;
				$editRes = $conn->prepare('UPDATE resposta SET resposta=:res WHERE id = :id');
				$editRes->bindParam(':res', $_POST[$tmpRes]);
				$editRes->bindParam(':id', $res->id);
				$editRes->execute();
			}
		}

	}

	echo "Sucesso";

?>