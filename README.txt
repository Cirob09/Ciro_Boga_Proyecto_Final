NEXPLAY - Proyecto final de Informática

INSTALACIÓN
1. Copiar la carpeta NEXPLAY dentro de C:\xampp\htdocs\
2. Iniciar Apache y MySQL desde XAMPP.
3. Entrar a http://localhost/phpmyadmin/ y ejecutar database.sql en la pestaña SQL.
4. Revisar conexion.php. En XAMPP local suele ser root con contraseña vacía.
5. Abrir http://localhost/NEXPLAY/

ADMINISTRADOR
Antes de usar crear_admin.php, cambiar CAMBIAR-ESTA-CLAVE por una clave propia. Abrir http://localhost/NEXPLAY/crear_admin.php, crear la cuenta y BORRAR crear_admin.php inmediatamente. Luego ingresar desde login.php.

IMÁGENES
No se incluyen imágenes. Colocá tu logo de Canva en assets/img/logo.png y una imagen principal en assets/img/portada.jpg. Las portadas de juegos se pueden cargar desde Administrar videojuegos (JPG, PNG o WEBP, hasta 2 MB).

FUNCIONES
Registro, login, hash de contraseñas, sesiones, panel personal, panel admin, búsqueda/edición/archivado/reactivación de usuarios, catálogo y búsqueda de juegos, detalle de juegos y carga de portadas.

SEGURIDAD
PDO preparado, validación PHP, htmlspecialchars, password_hash/password_verify, control de rol, token CSRF y archivado lógico por POST.

PRUEBAS
Probar registro válido y duplicado, login correcto e incorrecto, acceso admin, búsqueda y edición de usuarios, archivado/reactivación y carga/búsqueda de videojuegos. Realizar capturas después de ejecutar el sitio; no se incluyen capturas inventadas.

Archivos principales: conexion.php, funciones.php, registro.php, login.php, panel.php, cerrar_sesion.php, catalogo.php, juego.php, admin_usuarios.php, editar_usuario.php, archivar_usuario.php, usuarios_archivados.php, reactivar_usuario.php, admin_juegos.php, database.sql y css/estilos.css.
