<?php
if(session_status()===PHP_SESSION_NONE) session_start();

function escapar($v) {
    return htmlspecialchars((string)$v,ENT_QUOTES,'UTF-8');
    
}

function conectado() {
    return isset($_SESSION['usuario_id']);
    
}

function pedirLogin() {
    if(!conectado()) {
        header('Location: login.php');
        exit;
        
    }
    
}

function pedirAdmin() {
    pedirLogin();
    if(($_SESSION['usuario_rol']??'')!=='admin') {
        http_response_code(403);
        exit('Acceso denegado.');
        
    }
    
}

function token() {
    if(empty($_SESSION['csrf']))$_SESSION['csrf']=bin2hex(random_bytes(32));
    return $_SESSION['csrf'];
    
}

function tokenValido() {
    return isset($_POST['csrf'],$_SESSION['csrf'])&&hash_equals($_SESSION['csrf'],$_POST['csrf']);
    
}
?>