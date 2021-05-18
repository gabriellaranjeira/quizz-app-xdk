<?php
	include_once("conn.php");
	$user = $_POST['user'];
	$quiz = $_POST['quiz'];
	$consulta_usu = $conn->prepare('SELECT id FROM usuarios WHERE usuario = :usu');
	$consulta_usu->bindParam(':usu', $user);
	if($consulta_usu->execute()){
		while($row = $consulta_usu->fetch(PDO::FETCH_OBJ)){
			$id_usu = $row->id;
		}

		$consulta_quiz = $conn->prepare('SELECT id FROM quiz WHERE nome = :nome');
		$consulta_quiz->bindParam(':nome', $quiz);
		if($consulta_quiz->execute()){
			while($row_quiz = $consulta_quiz->fetch(PDO::FETCH_OBJ)){
				$id_quiz = $row_quiz->id;
			}

			$insert = $conn->prepare('INSERT INTO liberacao(id_quiz,
													id_user) VALUES (:id_quiz,
																	:id_user)');
			$insert->bindParam(':id_quiz', $id_quiz);
			$insert->bindParam(':id_user', $id_usu);
			if($insert->execute()){
				header('location:home.php?msg=Quiz liberado ao usuario com sucesso!');
			}else{
				header('location:home.php?msg=Erro ao comunicar o banco de dados!');
			}

		}else{ header('location:home.php?msg=Erro ao comunicar o banco de dados!'); }
	}else{ header('location:home.php?msg=Erro ao comunicar o banco de dados!'); }
?>