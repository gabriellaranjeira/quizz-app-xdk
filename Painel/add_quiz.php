<?php
include_once("conn.php");

$nome = utf8_decode(trim($_POST['nome']));
$npeg = trim($_POST['npeg']);
$alt = trim($_POST['alt']);
$desc = utf8_decode(trim($_POST['desc']));
$mat = trim($_POST['mat']);
echo $mat."<br>";

$pegcurso = $conn->prepare('SELECT idcurso FROM materia WHERE id=:mat');
	$pegcurso->bindParam(':mat', $mat);
	$pegcurso->execute();
	$curso = $pegcurso->fetch(PDO::FETCH_ASSOC);
	$id_curso = $curso['idcurso'];
	echo "curso: ".$id_curso."<br>";

$consulta_id = $conn->prepare('SELECT id FROM quiz WHERE nome = :nome');
	$consulta_id->bindParam(':nome', $nome);
	$consulta_id->execute();
	$resultado = $consulta_id->fetch(PDO::FETCH_ASSOC);
	$id_quiz = $resultado['id'];


	$quiz = $conn->prepare("INSERT INTO quiz(nome,
										descricao,
										alt,
										idmat,
										idcurso) VALUES (:nome,
										:descricao,
										:alt,
										:idmat,
										:idcurso)");
$quiz->bindParam(':nome', $nome);
$quiz->bindParam(':descricao', $desc);
$quiz->bindParam(':alt', $alt);
$quiz->bindParam(':idmat', $mat);
$quiz->bindParam(':idcurso', $id_curso);
if($quiz->execute()){
	$consulta_id = $conn->prepare('SELECT id FROM quiz WHERE nome = :nome');
	$consulta_id->bindParam(':nome', $nome);
	$consulta_id->execute();
	$resultado = $consulta_id->fetch(PDO::FETCH_ASSOC);
	$id_quiz = $resultado['id'];

	for($i = 1; $i <= $npeg ; $i++){
		$peg = "peg".$i;
		$pergunta = $_POST[$peg];
		$pergunta = str_replace("é", "e", $pergunta);
		$pergunta = str_replace("ê", "e", $pergunta);
		$pergunta = str_replace("á", "a", $pergunta);
		$pergunta = str_replace("à", "a", $pergunta);
		$pergunta = str_replace("â", "a", $pergunta);
		$pergunta = str_replace("í", "i", $pergunta);
		$pergunta = str_replace("î", "i", $pergunta);
		$pergunta = str_replace("ì", "i", $pergunta);
		$pergunta = str_replace("è", "e", $pergunta);
		$pergunta = str_replace("ó", "o", $pergunta);
		$pergunta = str_replace("ô", "o", $pergunta);
		$pergunta = str_replace("ò", "o", $pergunta);
		$pergunta = str_replace("ç", "c", $pergunta);
		$pergunta = str_replace("ú", "u", $pergunta);
		$pergunta = str_replace("ù", "u", $pergunta);
		$pergunta = str_replace("û", "u", $pergunta);
		$pergunta = str_replace("ê", "e", $pergunta);
		$pergunta = str_replace("É", "E", $pergunta);
		$pergunta = str_replace("Ê", "E", $pergunta);
		$pergunta = str_replace("Á", "A", $pergunta);
		$pergunta = str_replace("À", "A", $pergunta);
		$pergunta = str_replace("Â", "A", $pergunta);
		$pergunta = str_replace("Ì", "I", $pergunta);
		$pergunta = str_replace("Î", "I", $pergunta);
		$pergunta = str_replace("Ì", "I", $pergunta);
		$pergunta = str_replace("È", "E", $pergunta);
		$pergunta = str_replace("Ó", "O", $pergunta);
		$pergunta = str_replace("Ô", "O", $pergunta);
		$pergunta = str_replace("Ò", "O", $pergunta);
		$pergunta = str_replace("Ç", "X", $pergunta);
		$pergunta = str_replace("Ú", "U", $pergunta);
		$pergunta = str_replace("Ù", "U", $pergunta);
		$pergunta = str_replace("Û", "U", $pergunta);
		$pergunta = str_replace("Ê", "E", $pergunta);
		$pergunta = str_replace("´", "", $pergunta);
		$pergunta = str_replace("`", "", $pergunta);
		$pergunta = str_replace("^", "", $pergunta);
		$pergunta = str_replace("~", "", $pergunta);
		echo $pergunta;
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
				$row = $consulta_peg->fetch(PDO::FETCH_ASSOC);
				$id_peg = $row['id'];
				
				for($x = 1;$x <= $alt ; $x++){
					$resposta = "peg".$i."alt".$x;
					$alternativa = $_POST[$resposta];
					$alternativa = str_replace("é", "e", $alternativa);
					$alternativa = str_replace("ê", "e", $alternativa);
					$alternativa = str_replace("á", "a", $alternativa);
					$alternativa = str_replace("à", "a", $alternativa);
					$alternativa = str_replace("â", "a", $alternativa);
					$alternativa = str_replace("í", "i", $alternativa);
					$alternativa = str_replace("î", "i", $alternativa);
					$alternativa = str_replace("ç", "c", $alternativa);
					$alternativa = str_replace("ì", "i", $alternativa);
					$alternativa = str_replace("è", "e", $alternativa);
					$alternativa = str_replace("ó", "o", $alternativa);
					$alternativa = str_replace("ô", "o", $alternativa);
					$alternativa = str_replace("ò", "o", $alternativa);
					$alternativa = str_replace("ú", "u", $alternativa);
					$alternativa = str_replace("ù", "u", $alternativa);
					$alternativa = str_replace("û", "u", $alternativa);
					$insert_alt = $conn->prepare('INSERT INTO resposta(id_pergunta,
																	id_quiz,
																	resposta,
																	n) VALUES (:id_peg,
																			:id_quiz,
																			:resposta,
																			:n)');
					$insert_alt->bindParam(':id_peg', $id_peg);
					$insert_alt->bindParam(':id_quiz', $id_quiz);
					$insert_alt->bindParam(':resposta', $alternativa);
					$insert_alt->bindParam(':n', $x);
					if($insert_alt->execute()){
						continue;
					}else{ header('location:home.php?msg=Não foi possivel cadastrar o quiz!');}
				}
			}else{ header('location:home.php?msg=Não foi possivel cadastrar o quiz!');}
		}else{ header('location:home.php?msg=Não foi possivel cadastrar o quiz!');}
	}

header('location:home.php?msg=Quiz cadastrado com sucesso!');

}else{ header('location:home.php?msg=Não foi possivel cadastrar o quiz!');}

?>