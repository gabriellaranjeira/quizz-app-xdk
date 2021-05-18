<?php
include_once("conn.php");
$consulta = $conn->prepare("SELECT * FROM nivel");
$consulta->execute();
while($row = $consulta->fetch(PDO::FETCH_OBJ)){
  $id = $row->id;
  $nv = "nivel".$id;
  $pat = "patente".$id;
  $muda = $conn->prepare('UPDATE nivel SET nivel = :nv, patente = :pat WHERE id = :id'); 
  $muda->bindParam(':nv', $_POST[$nv]);
  $muda->bindParam(':pat', $_POST[$pat]);
  $muda->bindParam(':id', $_POST[$id]);
  $muda->execute();
}

header('location:home.php?msg=Quiz liberado ao usuario com sucesso!');
?>