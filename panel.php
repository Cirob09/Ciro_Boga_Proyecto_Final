<?php
require_once 'conexion.php';
require_once 'funciones.php';
pedirLogin();
$q=$conexion->prepare('SELECT nombre,apellido,dni,email,creado_en FROM usuarios WHERE id=:id AND archivado_en IS NULL');
$q->execute(['id'=>$_SESSION['usuario_id']]);
$u=$q->fetch();
if(!$u) {
    session_destroy();
    header('Location: login.php');
    exit;
    
}
require_once 'header.php';
?><section class="formulario">
<h1>Hola, <?= escapar($u['nombre']) ?></h1>
<p>Este es tu panel personal.</p>
<p>
<b>Nombre:</b> <?= escapar($u['nombre']) ?></p>
<p>
<b>Apellido:</b> <?= escapar($u['apellido']) ?></p>
<p>
<b>DNI:</b> <?= escapar($u['dni']) ?></p>
<p>
<b>Correo:</b> <?= escapar($u['email']) ?></p>
<p>
<b>Registro:</b> <?= escapar($u['creado_en']) ?></p>
<a class="boton" href="catalogo.php">Explorar juegos</a>
</section><?php
require_once 'footer.php';
?>