<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/auth.php';
exigir_login();

function gerar_slug(string $texto): string {
    $texto = iconv('UTF-8','ASCII//TRANSLIT//IGNORE',$texto);
    $texto = strtolower($texto);
    $texto = preg_replace('/[^a-z0-9]+/', '-', $texto);
    return trim($texto, '-');
}

$id=(int)($_GET['id']??0);
$stmt=$pdo->prepare("SELECT * FROM eventos WHERE id=?");$stmt->execute([$id]);$e=$stmt->fetch();
if($e){
  $novoTitulo=$e['titulo'].' (cópia)';
  $base=gerar_slug($novoTitulo); $slug=$base; $n=2;
  while(true){$q=$pdo->prepare("SELECT id FROM eventos WHERE slug=? LIMIT 1");$q->execute([$slug]);if(!$q->fetch())break;$slug=$base.'-'.$n++;}
  $sql="INSERT INTO eventos (titulo,slug,categoria,data_evento,horario,cidade,endereco,formato,descricao,descricao_completa,imagem,speaker_nome,speaker_cargo,speaker_bio,programacao,investimento,link_compra,status,destaque,ordem,ativo,criado_em,atualizado_em) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,NOW(),NOW())";
  $pdo->prepare($sql)->execute([$novoTitulo,$slug,$e['categoria'],$e['data_evento'],$e['horario'],$e['cidade'],$e['endereco'],$e['formato'],$e['descricao'],$e['descricao_completa'],$e['imagem'],$e['speaker_nome'],$e['speaker_cargo'],$e['speaker_bio'],$e['programacao'],$e['investimento'],$e['link_compra'],$e['status'],0,$e['ordem'],$e['ativo']]);
}
header('Location:index.php');
?>