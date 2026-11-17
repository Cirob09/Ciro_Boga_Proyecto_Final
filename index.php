<?php
require_once 'conexion.php';
 require_once 'funciones.php';
 $juegos=$conexion->query("SELECT * FROM juegos WHERE activo=1 ORDER BY creado_en DESC LIMIT 4")->fetchAll();
 require_once 'header.php';
?>
<section class="hero">
<div>
<small>EL UNIVERSO GAMER</small>
<h1>Descubrí tu próximo juego favorito.</h1>
<p>Explorá el catálogo, conocé nuevos títulos y encontrá tu próxima aventura.</p>
<a class="boton" href="catalogo.php">Ver videojuegos</a>
</div>
<div>
<!-- Colocá una imagen a elección en esta ruta -->
<img src="img/ip.jpeg" alt="Imagen principal de NEXPLAY">
</div>
</section>
<section class="seccion">
<h2>Juegos destacados</h2>
<div class="tarjetas"><?php
foreach($juegos as $j):
?><article class="tarjeta">
<img src="<?= escapar($j['imagen']?:'img/sin-imagen.jpg') ?>" alt="Portada de <?= escapar($j['nombre']) ?>">
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
?><p>Todavía no hay videojuegos cargados.</p><?php
endif;
?></div>
</section>
<?php
require_once 'footer.php';
?>