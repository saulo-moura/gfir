<?php
$idCampo = 'idt';
$Tela = "os Usuários do Grupo";


$TabelaPai   = "plu_link_util_grupo";
$AliasPai    = "plu_lug";
$EntidadePai = "Grupo";
$idPai       = "idt";

$mostrar    = true;
$cond_campo = '';
$cond_valor = '';
$prefixow    = 'listar';
$imagem     = 'imagens/endereco_16.png';

$upCad = vetCad('idt', 'Grupo', 'plu_link_util_grupo');
//$goCad[] = vetCad('idt,idt', 'Usuários do Grupo', 'plu_link_util_grupo_usuario', $prefixow, $mostrar, $imagem, $cond_campo, $cond_valor);


$TabelaPrinc      = "plu_link_util_grupo_usuario";
$AliasPric        = "plu_lugu";
$Entidade         = "Usuário do Grupo";
$Entidade_p       = "Usuários do Grupo";
$CampoPricPai     = "idt_grupo";

$barra_inc_h = "Incluir um Novo Registro de {$Entidade}";
$contlinfim  = "Existem #qt {$Entidade_p}.";

//$sql   = 'select ';
//$sql  .= '   id_usuario, nome_completo  ';
//$sql  .= ' from db_pir_grc.plu_usuario grc_pu ';
//$sql  .= ' where id_usuario = '.$_SESSION[CS]['g_id_usuario'];
//$rs = execsql($sql);

$Filtro = Array();
$Filtro['rs']       = $rs;
$Filtro['id']       = 'idt_grupo';
$Filtro['js_tam']   = '0';
$Filtro['nome']     = 'Usuário';
$Filtro['valor']    = trata_id($Filtro);
$vetFiltro['grupo'] = $Filtro;

$Filtro = Array();
$Filtro['rs']       = 'Texto';
$Filtro['id']       = 'texto';
$Filtro['js_tam']   = '0';
$Filtro['nome']     = 'Texto';
$Filtro['valor']    = trata_id($Filtro);
$vetFiltro['texto'] = $Filtro;


    $comfiltro = 'A';
    $comidentificacao = 'A';

$orderby = "pu_nome_completo";

$vetCampo['pu_nome_completo']    = CriaVetTabela('Usuário');


$sql   = "select ";
$sql  .= "   {$AliasPric}.*, pu.nome_completo as pu_nome_completo  ";
$sql  .= " from {$TabelaPrinc} as {$AliasPric} ";
$sql  .= " inner join plu_usuario as pu on pu.id_usuario = .{$AliasPric}.idt_usuario ";

$sql .= ' where ';
$sql .= " {$AliasPric}.idt_grupo =  ".null($vetFiltro['grupo']['valor']);


if ($vetFiltro['texto']['valor']!="")
{
    $sql .= ' and ';
    $sql .= ' ( ';
    $sql .= '    lower(gae.descricao)    like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' or lower(pu.nome_completo) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' ) ';
}
$sql  .= " order by {$orderby}";

?>
