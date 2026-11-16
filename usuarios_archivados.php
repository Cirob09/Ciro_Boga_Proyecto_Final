<?php
require_once 'conexion.php';
require_once 'funciones.php';
pedirAdmin();
$usuarios=$conexion->query('SELECT id,nombre,apellido,dni,email,archivado_en FROM usuarios WHERE archivado_en IS NOT NULL ORDER BY archivado_en DESC')->fetchAll();
require_once 'header.php';
?><section class="seccion">
<h1>Usuarios archivados</h1>
<a class="boton" href="admin_usuarios.php">Volver</a>
<div class="tabla">
<table>
<tr>
<th>Nombre</th>
<th>Correo</th>
<th>Fecha</th>
<th>Acción</th>
</tr><?php
foreach($usuarios as $u):
?><tr>
<td><?= escapar($u['nombre'].' '.$u['apellido']) ?></td>
<td><?= escapar($u['email']) ?></td>
<td><?= escapar($u['archivado_en']) ?></td>
<td>
<form method="POST" action="reactivar_usuario.php">
<input type="hidden" name="csrf" value="<?= escapar(token()) ?>">
<input type="hidden" name="id" value="<?= $u['id'] ?>">
<button class="linkbtn">Reactivar</button>
</form>
</td>
</tr><?php
endforeach;
?></table>
</div><?php
if(!$usuarios):
?><p>No hay usuarios archivados.</p><?php
endif;
?></section><?php
require_once 'footer.php';
?>