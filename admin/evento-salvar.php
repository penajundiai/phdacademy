<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/auth.php';
exigir_login();
validar_csrf();

function gerar_slug(string $texto): string {
    $texto = iconv('UTF-8','ASCII//TRANSLIT//IGNORE',$texto);
    $texto = strtolower($texto);
    $texto = preg_replace('/[^a-z0-9]+/', '-', $texto);
    return trim($texto, '-');
}

$id = (int)($_POST['id'] ?? 0);
$titulo = trim($_POST['titulo'] ?? '');
$categoria = trim($_POST['categoria'] ?? 'Workshop');
$data_evento = $_POST['data_evento'] ?: null;
$horario = trim($_POST['horario'] ?? '');
$cidade = trim($_POST['cidade'] ?? '');
$endereco = trim($_POST['endereco'] ?? '');
$formato = trim($_POST['formato'] ?? 'Presencial');
$descricao = trim($_POST['descricao'] ?? '');
$descricao_completa = trim($_POST['descricao_completa'] ?? '');
$speaker_nome = trim($_POST['speaker_nome'] ?? '');
$speaker_cargo = trim($_POST['speaker_cargo'] ?? '');
$speaker_bio = trim($_POST['speaker_bio'] ?? '');
$programacao = trim($_POST['programacao'] ?? '');
$investimento = trim($_POST['investimento'] ?? '');
$link_compra = trim($_POST['link_compra'] ?? '');
$status = trim($_POST['status'] ?? 'Inscrições abertas');
$destaque = isset($_POST['destaque']) ? 1 : 0;
$ordem = (int)($_POST['ordem'] ?? 0);
$ativo = isset($_POST['ativo']) ? 1 : 0;
$imagem = basename($_POST['imagem_atual'] ?? '');

if ($titulo === '') exit('Título obrigatório.');

if (!empty($_FILES['imagem']['name']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
    $permitidos = ['image/jpeg'=>'jpg','image/png'=>'png','image/webp'=>'webp'];
    $mime = mime_content_type($_FILES['imagem']['tmp_name']);
    if (!isset($permitidos[$mime])) exit('Formato de imagem não permitido.');
    if ($_FILES['imagem']['size'] > 5 * 1024 * 1024) exit('Imagem muito grande. Máximo 5MB.');
    $nome = bin2hex(random_bytes(10)).'.'.$permitidos[$mime];
    $destino = __DIR__.'/../uploads/eventos/'.$nome;
    if (!move_uploaded_file($_FILES['imagem']['tmp_name'], $destino)) exit('Falha ao enviar imagem.');
    $imagem = $nome;
}

if ($id) {
    $q=$pdo->prepare("SELECT slug FROM eventos WHERE id=?"); $q->execute([$id]); $atual=$q->fetch();
    $slug = $atual['slug'] ?? gerar_slug($titulo);
} else {
    $slugBase = gerar_slug($titulo);
    $slug = $slugBase ?: 'evento';
    $n=2;
    while (true) {
        $q=$pdo->prepare("SELECT id FROM eventos WHERE slug=? LIMIT 1");
        $q->execute([$slug]);
        if(!$q->fetch()) break;
        $slug = $slugBase.'-'.$n++;
    }
}

if ($id) {
    $sql="UPDATE eventos SET titulo=?,slug=?,categoria=?,data_evento=?,horario=?,cidade=?,endereco=?,formato=?,descricao=?,descricao_completa=?,imagem=?,speaker_nome=?,speaker_cargo=?,speaker_bio=?,programacao=?,investimento=?,link_compra=?,status=?,destaque=?,ordem=?,ativo=?,atualizado_em=NOW() WHERE id=?";
    $pdo->prepare($sql)->execute([$titulo,$slug,$categoria,$data_evento,$horario,$cidade,$endereco,$formato,$descricao,$descricao_completa,$imagem,$speaker_nome,$speaker_cargo,$speaker_bio,$programacao,$investimento,$link_compra,$status,$destaque,$ordem,$ativo,$id]);
} else {
    $sql="INSERT INTO eventos (titulo,slug,categoria,data_evento,horario,cidade,endereco,formato,descricao,descricao_completa,imagem,speaker_nome,speaker_cargo,speaker_bio,programacao,investimento,link_compra,status,destaque,ordem,ativo,criado_em,atualizado_em) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,NOW(),NOW())";
    $pdo->prepare($sql)->execute([$titulo,$slug,$categoria,$data_evento,$horario,$cidade,$endereco,$formato,$descricao,$descricao_completa,$imagem,$speaker_nome,$speaker_cargo,$speaker_bio,$programacao,$investimento,$link_compra,$status,$destaque,$ordem,$ativo]);
}
header('Location: index.php');
?>