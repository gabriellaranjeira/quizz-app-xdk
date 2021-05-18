<?php
include_once("conn.php");
		$user = $_POST['usuario'];
		$tmp = $user.date("dmYHis"); 
		$token = md5($tmp ,false);
		$consulta = $conn->prepare('SELECT email FROM usuarios WHERE usuario = :use');
		$consulta->bindParam(':use', $user);
		if($consulta->execute()){
			$url = base64_encode($token);
			$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
			$email = $resultado['email'];
			$link = "http://quizapp.pe.hu/recuperar.php?token=".$url;
			$corpo = "Para redefinir sua senha basta ir ao link: ".$link;
			$headers = "MIME-Version: 1.1\r\n";
			$headers .= "Content-type: text/plain; charset=UTF-8\r\n";
			$headers .= "From: QuizGame@brasil.com\r\n"; // remetente
			$headers .= "Return-Path: QuizGame@brasil.com\r\n"; // return-path
			$envio = mail($email, "Recuperação de senha Game", $corpo, $headers);
			if($envio){
				$insert = $conn->prepare("INSERT INTO esqueci(token, usuario) VALUES(:token, :usuario)");
				$insert->bindParam(':token', $token);
				$insert->bindParam(':usuario', $user);
				if($insert->execute()){
					echo "sucesso";
				}else{
					echo "Não foi possivel enviar a menssagem";
				}
			}else{
				echo "Não foi possivel enviar a menssagem";
			}
		}

?>