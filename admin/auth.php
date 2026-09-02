<?php
session_start();
function admin_logado(): bool {
    return !empty($_SESSION['admin_id']);
}
function exigir_login(): void {
    if (!admin_logado()) {
        header('Location: login.php');
        exit;
    }
}
function csrf_token(): string {
    if (empty($_SESSION['csrf'])) {
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf'];
}
function validar_csrf(): void {
    if (!isset($_POST['csrf']) || !hash_equals($_SESSION['csrf'] ?? '', $_POST['csrf'])) {
        http_response_code(403);
        exit('Token de segurança inválido.');
    }
}
?>