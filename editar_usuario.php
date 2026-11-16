<?php
require_once 'conexion.php';
require_once 'funciones.php';
pedirAdmin();
$id=filter_input(INPUT_GET,'id',FILTER_VALIDATE_INT);
if(!$id)exit('ID inválido.');
$q=$conexion->prepare('SELECT id,nombre,apellido,dni,email FROM usuarios WHERE id=:id AND archivado_en IS NULL');
$q->execute(['id'=>$id]);
$u=$q->fetch();
if(!$u)exit('Usuario no encontrado.');
$errores=[];
if($_SERVER['REQUEST_METHOD']==='POST') {
    $n=trim($_POST['nombre']??'');
    $a=trim($_POST['apellido']??'');
    $d=trim($_POST['dni']??'');
    $e=trim($_POST['email']??'');
    if(!tokenValido())$errores[]='Solicitud no válida.';
    if($n===''||$a==='')$errores[]='Nombre y apellido son obligatorios.';
    if(!preg_match('/^[0-9]{7,8}$/',$d))$errores[]='DNI inválido.';
    if(!filter_var($e,FILTER_VALIDATE_EMAIL))$errores[]='Correo inválido.';
    $dup=$conexion->prepare('SELECT id FROM usuarios WHERE (dni=:d OR email=:e) AND id<>:id');
    $dup->execute(['d'=>$d,'e'=>$e,'id'=>$id]);
    if($dup->fetch())$errores[]='DNI o correo ya utilizado.';
    if(!$errores) {
        $up=$conexion->prepare('UPDATE usuarios SET nombre=:n,apellido=:a,dni=:d,email=:e WHERE id=:id AND archivado_en IS NULL');
        $up->execute(['n'=>$n,'a'=>$a,'d'=>$d,'e'=>$e,'id'=>$id]);
        header('Location: admin_usuarios.php');
        exit;
        
    }
    $u=['id'=>$id,'nombre'=>$n,'apellido'=>$a,'dni'=>$d,'email'=>$e];
    
}
require_once 'header.php';
?><section class="formulario">
<h1>Editar usuario</h1><?php
foreach($errores as $e):
?><p class="error"><?= escapar($e) ?></p><?php
endforeach;
?><form method="POST">
<input type="hidden" name="csrf" value="<?= escapar(token()) ?>">
<label>Nombre</label>
<input name="nombre" value="<?= escapar($u['nombre']) ?>" required>
<label>Apellido</label>
<input name="apellido" value="<?= escapar($u['apellido']) ?>" required>
<label>DNI</label>
<input name="dni" value="<?= escapar($u['dni']) ?>" required>
<label>Correo</label>
<input type="email" name="email" value="<?= escapar($u['email']) ?>" required>
<button class="boton">Guardar</button>
</form>
</section><?php
require_once 'footer.php';
?>