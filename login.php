<?php
require_once 'conexion.php';
require_once 'funciones.php';
$error='';
if($_SERVER['REQUEST_METHOD']==='POST') {
    $email=trim($_POST['email']??'');
    $pass=$_POST['password']??'';
    if(!tokenValido())$error='Solicitud no válida.';
    else {
        $q=$conexion->prepare('SELECT id,nombre,password_hash,rol FROM usuarios WHERE email=:email AND archivado_en IS NULL LIMIT 1');
        $q->execute(['email'=>$email]);
        $u=$q->fetch();
        if($u&&password_verify($pass,$u['password_hash'])) {
            session_regenerate_id(true);
            $_SESSION['usuario_id']=$u['id'];
            $_SESSION['usuario_nombre']=$u['nombre'];
            $_SESSION['usuario_rol']=$u['rol'];
            header('Location: '.($u['rol']==='admin'?'admin_usuarios.php':'panel.php'));
            exit;
            
        }
        else $error='Correo o contraseña incorrectos.';
        
    }
    
}
require_once 'header.php';
?>
<section class="formulario">
<h1>Iniciar sesión</h1><?php
if(isset($_GET['registro'])):
?><p class="ok">Cuenta creada. Ya podés ingresar.</p><?php
endif;
?><?php
if($error):
?><p class="error"><?= escapar($error) ?></p><?php
endif;
?><form method="POST">
<input type="hidden" name="csrf" value="<?= escapar(token()) ?>">
<label>Correo</label>
<input type="email" name="email" required>
<label>Contraseña</label>
<input type="password" name="password" required>
<button class="boton">Ingresar</button>
</form>
<p>¿No tenés cuenta? <a href="registro.php">Registrate</a>.</p>
</section><?php
require_once 'footer.php';
?>