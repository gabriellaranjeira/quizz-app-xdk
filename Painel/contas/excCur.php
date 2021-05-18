<?php
	include_once("conn.php");


	$id = trim($_POST['id']);

	$records = $conn->prepare('SELECT * FROM usuarios WHERE id = :id');
	$records->bindParam(':id', $id);
	if($records->execute()){
		$usuario = $records->fetch(PDO::FETCH_ASSOC);
		$api_user = json_encode($usuario);
		$record = $conn->prepare('SELECT * FROM quiz ORDER BY id DESC');
		if($record->execute()){
			$quiz = $record->fetchAll();
			$api_quiz = json_encode($quiz);
			$recor = $conn->prepare('SELECT * FROM pergunta');
			if($recor->execute()){
				$peg = $recor->fetchAll();
				$api_peg = json_encode($peg);
				$reco = $conn->prepare('SELECT * FROM resposta');
				if($reco->execute()){
					$res = $reco->fetchAll();
					$api_res = json_encode($res);
					$rec = $conn->prepare('SELECT * FROM ranking ORDER BY pegs DESC');
					if($rec->execute()){
						$ran = $rec->fetchAll();
						$api_ran = json_encode($ran);
						$new = $conn->prepare('SELECT * FROM completo WHERE id_user = :id');
						$new->bindParam(':id', $id);
						if($new->execute()){
							$completo = $new->fetchAll();
							$api_completo = json_encode($completo);
							$usu = $conn->prepare('SELECT * FROM usuarios ORDER BY id ASC');
							if($usu->execute()){
								$usuCom = $usu->fetchAll();
								$api_usuarios = json_encode($usuCom);
								$nivel = $conn->prepare('SELECT * FROM nivel');
								if($nivel->execute()){
									$nivelCom = $nivel->fetchAll();
									$api_nivel = json_encode($nivelCom);
									$lib = $conn->prepare('SELECT * FROM liberacao WHERE id_user = :id');
									$lib->bindParam(':id', $id);
									if($lib->execute()){
										$libGet = $lib->fetchAll();
										$api_lib = json_encode($libGet);
										$materia = $conn->prepare('SELECT * FROM materia');
										if($materia->execute()){
											$materiaCom = $materia->fetchAll();
											$api_mat = $json_encode($materiaCom);
											$cursos = $conn->prepare('SELECT * FROM curso');
											if($cursos->execute(){
												$cursosCom = $cursos->fetchAll();
												$api_curso = json_encode($cursosCom);
												echo '{"usuario":'.$api_user.', "quiz":'.$api_quiz.', "peg":'.$api_peg.', "res":'.$api_res.', "ranking":'.$api_ran.', "completo":'.$api_completo.', "usuarios":'.$api_usuarios.', "nivel":'.$api_nivel.', "liberado":'.$api_lib.', "materia":'.$api_mat.', "curso":'.$api_curso.'}';
											}
										}
									}else{
									echo "erro";
									}
								}else{
									echo "erro";
								}
							}else{
							echo "erro";
							}
						}else{
							echo "erro";
						}
					}else{
						echo "erro";
					}
				}else{
					echo "erro";
				}
			}else{
				echo "erro";
			}
		}
		}else{
			echo "erro";
		}

?>