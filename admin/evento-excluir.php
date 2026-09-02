<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/auth.php';
exigir_login();
$id=(int)($_GET['id']??0);
if($id){$pdo->prepare("DELETE FROM eventos WHERE id=?")->execute([$id]);}
header('Location:index.php');
?>