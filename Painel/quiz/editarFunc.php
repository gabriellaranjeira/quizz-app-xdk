<?php
	include_once("conn.php");
	$id = $_POST['id'];
	$consulta = $conn->prepare("SELECT * FROM pergunta WHERE id_quiz = :id");
	$consulta->bindParam(':id', $id);
	$consulta->execute();
	echo "<html>";
	echo '<form action="edtFnc.php" method="post">';
	echo '<input type="hidden" name="id" value="'.$id.'">';
	while($row = $consulta->fetch(PDO::FETCH_OBJ)){	
		echo 'Pergunta <input name="peg'.$row->id.'" value="'.utf8_encode($row->pergunta).'"><br>';
			$resposta = $conn->prepare("SELECT * FROM resposta WHERE id_pergunta = :peg");
			$resposta->bindParam(':peg', $row->id);
			$resposta->execute();
			while($res = $resposta->fetch(PDO::FETCH_OBJ)){
				echo '     Alternativa <input name="peg'.$row->id.'res'.$res->id.'" value="'.utf8_encode($res->resposta).'">';
				if($res->n == $row->certo){
					echo '<input type="radio" name="res'.$row->id.'"  value="'.$res->n.'" checked="checked" /><br> ';
				}else{
					echo '<input type="radio" name="res'.$row->id.'"  value="'.$res->n.'"/><br> ';
				}
			}

			echo '<br>---------------------------------------------------------- <br>';
	}
	echo '<input type="submit" value="Editar">';
	echo "</form>";
	echo "</html>";

	
?>