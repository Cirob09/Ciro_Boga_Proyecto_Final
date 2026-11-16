<?php
require_once 'conexion.php';
$msg='';
if($_SERVER['REQUEST_METHOD']==='POST') {
    if(($_POST['clave']??'')!=='CAMBIAR-ESTA-CLAVE')$msg='Clave de instalación incorrecta.';
    elseif((int)$conexion->query("SELECT COUNT(*) FROM usuarios WHERE rol='admin'")->fetchColumn()>0)$msg='Ya hay un administrador. Eliminá este archivo.';
    else {
        $p=$_POST;
        $hash=password_hash($p['password'],PASSWORD_DEFAULT);
        $q=$conexion->prepare("INSERT INTO usuarios(nombre,apellido,dni,email,password_hash,rol) VALUES(?,?,?,?,?,'admin')");
        $q->execute([$p['nombre'],$p['apellido'],$p['dni'],$p['email'],$hash]);
        $msg='Administrador creado. Eliminá crear_admin.php ahora.';
        
    }
    
}
?><!DOCTYPE html>
<html lang="es">
<meta charset="UTF-8">
<link rel="stylesheet" href="css/estilos.css">
<body>
<main class="contenedor">
<section class="formulario">
<h1>Crear administrador</h1>
<p><?= htmlspecialchars($msg) ?></p>
<form method="POST">
<label>Clave de instalación</label>
<input type="password" name="clave" required><?php
foreach(['nombre'=>'Nombre','apellido'=>'Apellido','dni'=>'DNI','email'=>'Correo','password'=>'Contraseña'] as $k=>$v):
?><label><?= $v ?></label>
<input name="<?= $k ?>" <?= $k==='email'?'type="email"':($k==='password'?'type="password"':'') ?> required><?php
endforeach;
?><button class="boton">Crear</button>
</form>
</section>
</main>
</body>
</html>