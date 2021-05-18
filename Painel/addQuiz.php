<?php
include_once("conn.php");

$nome = trim($_POST['nome']);
$npeg = trim($_POST['npeg']);
$alt = trim($_POST['alt']);
$desc = trim($_POST['desc']);

$quiz = $conn->prepare("INSERT INTO quiz(nome,
										descricao,
										alt) VALUES (:nome,
										:descricao,
										:alt)");
$quiz->bindParam(':nome', $nome);
$quiz->bindParam(':descricao', $desc);
$quiz->bindParam(':alt', $alt);
if($quiz->execute()){
	$consulta_id = $conn->prepare('SELECT id FROM quiz WHERE nome = :nome');
	$consulta_id->bindParam(':nome', $nome);
	$consulta_id->execute();
	$resultado = $consulta_id->fetch(PDO::FETCH_ASSOC);
	$id_quiz = $resultado['id'];

	for($i = 1; $i <= $npeg ; $i++){
		$peg = "peg".$i;
		$pergunta = $_POST[$peg];
		$res = "res".$i;
		$certo = $_POST[$res];
		$insert_peg = $conn->prepare('INSERT INTO pergunta(id_quiz,
														pergunta,
														certo) VALUES (:id_quiz,
														:pergunta,
														:certo)');
		$insert_peg->bindParam(':id_quiz', $id_quiz);
		$insert_peg->bindParam(':pergunta', $pergunta);
		$insert_peg->bindParam(':certo', $certo);
		if($insert_peg->execute()){
			$consulta_peg = $conn->prepare('SELECT id FROM pergunta WHERE pergunta = :peg');
			$consulta_peg->bindParam(':peg', $pergunta);
			if($consulta_peg->execute()){
				$resultado_peg = $consulta_peg->fetch(PDO::FETCH_ASSOC);
				$id_peg = $resultado_peg['id'];
				for($x = 1;$x <= $alt ; $x++){
					$resposta = "peg".$i."alt".$x;
					$alternativa = $_POST[$resposta];
					$insert_alt = $conn->prepare('INSERT INTO resposta(id_pergunta,
																	resposta,
																	n) VALUES (:id_peg,
																			:resposta,
																			:n)');
					$insert_alt->bindParam(':id_peg', $id_peg);
					$insert_alt->bindParam(':resposta', $alternativa);
					$insert_alt->bindParam(':n', $x);
					if($insert_alt->execute()){
						continue;
					}else{ echo "erro alt"; }
				}
			}else{ echo "erro consulta"; }
		}else{ echo "erro peg"; }
	}

}else{ echo "erro quiz"; }


?>