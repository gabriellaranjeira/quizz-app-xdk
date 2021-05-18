<?php
try {

	$username = "u745487883_quiz";
	$password = "google123";

    $conn = new PDO('mysql:host=mysql.hostinger.com.br;dbname=u745487883_quiz', $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "<script>alert('ERROR: ". $e->getMessage() ."');<script>";
}


?>