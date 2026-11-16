<?php
require_once 'conexion.php';
require_once 'funciones.php';
pedirAdmin();
if($_SERVER['REQUEST_METHOD']!=='POST'||!tokenValido())exit('Solicitud inválida.');
$id=filter_input(INPUT_POST,'id',FILTER_VALIDATE_INT);
if(!$id||$id==$_SESSION['usuario_id'])exit('No se puede archivar esta cuenta.');
$q=$conexion->prepare('UPDATE usuarios SET archivado_en=CURRENT_TIMESTAMP WHERE id=:id AND archivado_en IS NULL');
$q->execute(['id'=>$id]);
header('Location: admin_usuarios.php');
exit;
?>