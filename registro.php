<?php
require_once 'conexion.php';
require_once 'funciones.php';
$errores=[];
$nombre=$apellido=$dni=$email='';

if($_SERVER['REQUEST_METHOD']==='POST') {
    $nombre=trim($_POST['nombre']??'');
    $apellido=trim($_POST['apellido']??'');
    $dni=trim($_POST['dni']??'');
    $email=trim($_POST['email']??'');
    $pass=$_POST['password']??'';
    $conf=$_POST['confirmar']??'';
    
    if(!tokenValido())$errores[]='Solicitud no válida.';
    if($nombre===''||mb_strlen($nombre)>80)$errores[]='Nombre inválido.';
    if($apellido===''||mb_strlen($apellido)>80)$errores[]='Apellido inválido.';
    if(!preg_match('/^[0-9]{7,8}$/',$dni))$errores[]='El DNI debe tener 7 u 8 números.';
    if(!filter_var($email,FILTER_VALIDATE_EMAIL))$errores[]='Correo inválido.';
    if(strlen($pass)<6)$errores[]='La contraseña debe tener al menos 6 caracteres.';
    if($pass!==$conf)$errores[]='Las contraseñas no coinciden.';
    
    if(!$errores) {
        $q=$conexion->prepare('SELECT id FROM usuarios WHERE dni=:dni OR email=:email');
        $q->execute(['dni'=>$dni,'email'=>$email]);
        if($q->fetch())$errores[]='Ese DNI o correo ya está registrado.';
        else {
            $hash=password_hash($pass,PASSWORD_DEFAULT);
            $q=$conexion->prepare("INSERT INTO usuarios(nombre,apellido,dni,email,password_hash,rol) VALUES(:n,:a,:d,:e,:p,'usuario')");
            $q->execute(['n'=>$nombre,'a'=>$apellido,'d'=>$dni,'e'=>$email,'p'=>$hash]);
            header('Location: login.php?registro=ok');
            exit;
            
        }
        
    }
    
}

require_once 'header.php';
?>
<section class="formulario">
<h1>Crear cuenta</h1><?php
if($errores):
?><div class="error"><?php
foreach($errores as $e):
?><p><?= escapar($e) ?></p><?php
endforeach;
?></div><?php
endif;
?><form method="POST">
<input type="hidden" name="csrf" value="<?= escapar(token()) ?>">
<label>Nombre</label>
<input name="nombre" maxlength="80" value="<?= escapar($nombre) ?>" required>
<label>Apellido</label>
<input name="apellido" maxlength="80" value="<?= escapar($apellido) ?>" required>
<label>DNI</label>
<input name="dni" pattern="[0-9]{7,8}" value="<?= escapar($dni) ?>" required>
<label>Correo</label>
<input type="email" name="email" value="<?= escapar($email) ?>" required>
<label>Contraseña</label>
<input type="password" name="password" minlength="6" required>
<label>Repetir contraseña</label>
<input type="password" name="confirmar" required>
<button class="boton">Registrarme</button>
</form>
<p>¿Ya tenés cuenta? <a href="login.php">Ingresá</a>.</p>
</section><?php
require_once 'footer.php';
?>