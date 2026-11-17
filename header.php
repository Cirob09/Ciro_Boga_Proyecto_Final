<?php
require_once __DIR__.'/funciones.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>NEXPLAY</title>
<link rel="stylesheet" href="estilos.css">
</head>
<body>
<header>
<div class="contenedor nav">
<a class="marca" href="index.php">
<!-- Reemplazá por tu logo de Canva -->
<img src="img/logo.jpeg" alt="Logo NEXPLAY">
<b>NEXPLAY</b>
</a>
<nav>
<a href="index.php">Inicio</a>
<a href="catalogo.php">Videojuegos</a><?php
if(conectado()):
?><a href="panel.php">Mi cuenta</a><?php
if(($_SESSION['usuario_rol']??'')==='admin'):
?><a href="admin_usuarios.php">Administración</a><?php
endif;
?><a href="cerrar_sesion.php">Salir</a><?php
else:
?><a href="login.php">Ingresar</a>
<a href="registro.php">Crear cuenta</a><?php
endif;
?></nav>
</div>
</header>
<main class="contenedor">