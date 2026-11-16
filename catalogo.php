<?php
require_once 'conexion.php';
require_once 'funciones.php';
$buscar=trim($_GET['buscar']??'');
if($buscar!=='') {
    $q=$conexion->prepare('SELECT * FROM juegos WHERE activo=1 AND (nombre LIKE :n OR categoria LIKE :c OR plataforma LIKE :p) ORDER BY nombre');
    $v='%'.$buscar.'%';
    $q->execute(['n'=>$v,'c'=>$v,'p'=>$v]);
    
}
else $q=$conexion->query('SELECT * FROM juegos WHERE activo=1 ORDER BY nombre');
$juegos=$q->fetchAll();
require_once 'header.php';
?><section class="seccion">
<h1>Catálogo de videojuegos</h1>
<form class="buscador">
<input type="search" name="buscar" placeholder="Buscar nombre, género o plataforma" value="<?= escapar($buscar) ?>">
<button class="boton">Buscar</button>
</form>
<div class="tarjetas"><?php
foreach($juegos as $j):
?><article class="tarjeta">
<img src="<?= escapar($j['imagen']?:'assets/img/sin-imagen.jpg') ?>" alt="Portada">
<div>
<small><?= escapar($j['categoria']) ?></small>
<h3><?= escapar($j['nombre']) ?></h3>
<p><?= escapar($j['plataforma']) ?></p>
<a href="juego.php?id=<?= (int)$j['id'] ?>">Ver detalles</a>
</div>
</article><?php
endforeach;
?><?php
if(!$juegos):
?><p>No se encontraron videojuegos.</p><?php
endif;
?></div>
</section><?php
require_once 'footer.php';
?>