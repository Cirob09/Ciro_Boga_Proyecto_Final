<?php
require_once 'conexion.php';
require_once 'funciones.php';
pedirAdmin();
if($_SERVER['REQUEST_METHOD']!=='POST'||!tokenValido())exit('Solicitud inválida.');
$id=filter_input(INPUT_POST,'id',FILTER_VALIDATE_INT);
if(!$id)exit('ID inválido.');
$q=$conexion->prepare('UPDATE usuarios SET archivado_en=NULL WHERE id=:id AND archivado_en IS NOT NULL');
$q->execute(['id'=>$id]);
header('Location: usuarios_archivados.php');
exit;
?>