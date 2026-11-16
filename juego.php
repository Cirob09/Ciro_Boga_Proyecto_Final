<?php
require_once 'conexion.php';
require_once 'funciones.php';
$id=filter_input(INPUT_GET,'id',FILTER_VALIDATE_INT);
if(!$id||$id<1)exit('Identificador inválido.');
$q=$conexion->prepare('SELECT * FROM juegos WHERE id=:id AND activo=1');
$q->execute(['id'=>$id]);
$j=$q->fetch();
if(!$j)exit('Videojuego no encontrado.');
require_once 'header.php';
?><section class="detalle">
<img src="<?= escapar($j['imagen']?:'assets/img/sin-imagen.jpg') ?>" alt="Portada de <?= escapar($j['nombre']) ?>">
<div>
<small><?= escapar($j['categoria']) ?></small>
<h1><?= escapar($j['nombre']) ?></h1>
<p>
<b>Plataforma:</b> <?= escapar($j['plataforma']) ?></p>
<p><?= nl2br(escapar($j['descripcion'])) ?></p>
<a class="boton" href="catalogo.php">Volver</a>
</div>
</section><?php
require_once 'footer.php';
?>