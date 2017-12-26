<?php
$idCampo = 'idt';
$Tela = "o Conteudo BIA";

$TabelaPrinc      = "bia_conteudobia";
$AliasPric        = "bia_cont";
$Entidade         = "Conteúdo BIA";
$Entidade_p       = "Conteúdos BIA";

$barra_inc_h = "Incluir um Novo Registro de {$Entidade}";
$contlinfim  = "Existem #qt {$Entidade_p}.";


$tipoidentificacao = 'N';
$tipofiltro = 'S';
$comfiltro = 'A';
$comidentificacao = 'F';

// Descida para o nivel 2

$prefixow    = 'listar';
$mostrar    = false;
$cond_campo = '';
$cond_valor = '';

//$imagem  = 'imagens/empresa_16.png';
//$goCad[] = vetCad('idt', 'Diagnóstico', 'grc_atendimento_diagnostico', $prefixow, $mostrar, $imagem, $cond_campo, $cond_valor);

//$imagem  = 'imagens/empresa_16.png';
//$goCad[] = vetCad('idt', 'Produtos', 'grc_atendimento_produto', $prefixow, $mostrar, $imagem, $cond_campo, $cond_valor);


$Filtro = Array();
$Filtro['rs']       = 'Texto';
$Filtro['id']       = 'texto';
$Filtro['js_tam']   = '0';
$Filtro['nome']     = 'Texto';
$Filtro['valor']    = trata_id($Filtro);
$vetFiltro['texto'] = $Filtro;



$Filtro = Array();
$Filtro['rs']       = 'Texto1';
$Filtro['id']       = 'texto1';
$Filtro['js_tam']   = '0';
$Filtro['nome']     = 'Texto 1';
$Filtro['valor']    = trata_id($Filtro);
$vetFiltro['texto1'] = $Filtro;


$orderby = "{$AliasPric}.CodConteudo";

$vetCampo['CodConteudo']    = CriaVetTabela('Código');
$vetCampo['TituloConteudo'] = CriaVetTabela('Título');
$vetCampo['SubTituloConteudo'] = CriaVetTabela('Sub Título');
$vetCampo['StatusPublicacao'] = CriaVetTabela('Status');
$vetCampo['Situacao'] = CriaVetTabela('Situacao');

$sql   = "select ";
$sql  .= "   {$AliasPric}.*  ";
//$sql  .= "    plu_usu.nome_completo as plu_usu_nome_completo, ";
//$sql  .= "    If (idt_entidade is null, entidade, gec_ent.descricao) as grc_ent_descricao  ";
$sql  .= " from {$TabelaPrinc} as {$AliasPric} ";

//$sql .= " inner join plu_usuario plu_usu on plu_usu.id_usuario = {$AliasPric}.idt_usuario ";
//$sql .= " left join gec_entidade gec_ent on gec_ent.idt = {$AliasPric}.idt_entidade ";

if ($vetFiltro['texto']['valor']!="")
{
    $sql .= ' where ';
    $sql .= ' ( ';
    $sql .= '  lower('.$AliasPric.'.CodConteudo)      like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' or lower('.$AliasPric.'.TituloConteudo) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' or lower('.$AliasPric.'.SubTituloConteudo) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' or lower('.$AliasPric.'.StatusPublicacao) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' or lower('.$AliasPric.'.Situacao) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' ) ';
}


if ($vetFiltro['texto1']['valor']!="")
{
    if ($vetFiltro['texto']['valor']!="")
    {
        $sql .= ' and ';
    }
    else
    {
        $sql .= ' where ';
    }
    $sql .= ' ( ';
    $sql .= '  lower('.$AliasPric.'.CodConteudo)      like lower('.aspa($vetFiltro['texto1']['valor'], '%', '%').')';
    $sql .= ' or lower('.$AliasPric.'.TituloConteudo) like lower('.aspa($vetFiltro['texto1']['valor'], '%', '%').')';
    $sql .= ' or lower('.$AliasPric.'.SubTituloConteudo) like lower('.aspa($vetFiltro['texto1']['valor'], '%', '%').')';
    $sql .= ' or lower('.$AliasPric.'.StatusPublicacao) like lower('.aspa($vetFiltro['texto1']['valor'], '%', '%').')';
    $sql .= ' or lower('.$AliasPric.'.Situacao) like lower('.aspa($vetFiltro['texto1']['valor'], '%', '%').')';
    $sql .= ' ) ';
}


//$sql  .= " order by {$orderby}";

if ($sqlOrderby == '') {
        $sqlOrderby = "CodConteudo asc";
}

?>
