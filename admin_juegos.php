<?php
require_once 'conexion.php';
require_once 'funciones.php';
pedirAdmin();
$msg='';
$err='';
if($_SERVER['REQUEST_METHOD']==='POST') {
    if(!tokenValido())$err='Solicitud no válida.';
    else {
        $n=trim($_POST['nombre']??'');
        $c=trim($_POST['categoria']??'');
        $p=trim($_POST['plataforma']??'');
        $d=trim($_POST['descripcion']??'');
        $ruta=null;
        if(isset($_FILES['imagen'])&&$_FILES['imagen']['error']!==UPLOAD_ERR_NO_FILE) {
            if($_FILES['imagen']['error']!==UPLOAD_ERR_OK||$_FILES['imagen']['size']>2097152)$err='La imagen debe pesar menos de 2 MB.';
            else {
                $fi=new finfo(FILEINFO_MIME_TYPE);
                $tipo=$fi->file($_FILES['imagen']['tmp_name']);
                $permitidos=['image/jpeg'=>'jpg','image/png'=>'png','image/webp'=>'webp'];
                if(!isset($permitidos[$tipo]))$err='Formato no permitido. Usá JPG, PNG o WEBP.';
                else {
                    $nom=bin2hex(random_bytes(16)).'.'.$permitidos[$tipo];
                    if(move_uploaded_file($_FILES['imagen']['tmp_name'],__DIR__.'/uploads/juegos/'.$nom))$ruta='uploads/juegos/'.$nom;
                    else $err='No se pudo guardar la imagen.';
                    
                }
                
            }
            
        }
        if(!$err&&$n!==''&&$c!==''&&$p!=='') {
            $q=$conexion->prepare('INSERT INTO juegos(nombre,categoria,plataforma,descripcion,imagen) VALUES(?,?,?,?,?)');
            $q->execute([$n,$c,$p,$d,$ruta]);
            $msg='Videojuego agregado.';
            
        }
        elseif(!$err)$err='Completá nombre, categoría y plataforma.';
        
    }
    
}
$juegos=$conexion->query('SELECT * FROM juegos ORDER BY id DESC')->fetchAll();
require_once 'header.php';
?><section class="seccion">
<h1>Administrar videojuegos</h1><?php
if($msg):
?><p class="ok"><?= escapar($msg) ?></p><?php
endif;
?><?php
if($err):
?><p class="error"><?= escapar($err) ?></p><?php
endif;
?><section class="formulario">
<h2>Agregar videojuego</h2>
<form method="POST" enctype="multipart/form-data">
<input type="hidden" name="csrf" value="<?= escapar(token()) ?>">
<label>Nombre</label>
<input name="nombre" required>
<label>Categoría</label>
<input name="categoria" required>
<label>Plataforma</label>
<input name="plataforma" required>
<label>Descripción</label>
<textarea name="descripcion">
</textarea>
<label>Portada (JPG, PNG o WEBP, hasta 2 MB)</label>
<input type="file" name="imagen" accept="image/jpeg,image/png,image/webp">
<button class="boton">Agregar</button>
</form>
</section>
<h2>Videojuegos cargados</h2><?php
foreach($juegos as $j):
?><p><?= escapar($j['nombre']) ?> — <?= escapar($j['categoria']) ?></p><?php
endforeach;
?></section><?php
require_once 'footer.php';
?>