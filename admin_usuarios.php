<?php
require_once 'conexion.php';
require_once 'funciones.php';
pedirAdmin();
$buscar=trim($_GET['buscar']??'');
if($buscar!=='') {
    $q=$conexion->prepare('SELECT id,nombre,apellido,dni,email,rol FROM usuarios WHERE archivado_en IS NULL AND (nombre LIKE :a OR apellido LIKE :b OR dni LIKE :c OR email LIKE :d) ORDER BY id DESC');
    $v='%'.$buscar.'%';
    $q->execute(['a'=>$v,'b'=>$v,'c'=>$v,'d'=>$v]);
    
}
else $q=$conexion->query('SELECT id,nombre,apellido,dni,email,rol FROM usuarios WHERE archivado_en IS NULL ORDER BY id DESC');
$usuarios=$q->fetchAll();
require_once 'header.php';
?><section class="seccion">
<h1>Administración de usuarios</h1>
<p>
<a class="boton" href="usuarios_archivados.php">Ver archivados</a>
<a class="boton" href="admin_juegos.php">Administrar juegos</a>
</p>
<form class="buscador">
<input name="buscar" placeholder="Nombre, apellido, DNI o correo" value="<?= escapar($buscar) ?>">
<button class="boton">Buscar</button>
</form>
<div class="tabla">
<table>
<tr>
<th>ID</th>
<th>Nombre</th>
<th>Apellido</th>
<th>DNI</th>
<th>Correo</th>
<th>Rol</th>
<th>Acciones</th>
</tr><?php
foreach($usuarios as $u):
?><tr>
<td><?= $u['id'] ?></td>
<td><?= escapar($u['nombre']) ?></td>
<td><?= escapar($u['apellido']) ?></td>
<td><?= escapar($u['dni']) ?></td>
<td><?= escapar($u['email']) ?></td>
<td><?= escapar($u['rol']) ?></td>
<td>
<a href="editar_usuario.php?id=<?= $u['id'] ?>">Editar</a>
<form class="inline" method="POST" action="archivar_usuario.php">
<input type="hidden" name="csrf" value="<?= escapar(token()) ?>">
<input type="hidden" name="id" value="<?= $u['id'] ?>">
<button class="linkbtn">Archivar</button>
</form>
</td>
</tr><?php
endforeach;
?></table>
</div><?php
if(!$usuarios):
?><p>No hay resultados.</p><?php
endif;
?></section><?php
require_once 'footer.php';
?>