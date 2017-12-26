<?php
$idCampo = 'idt';
$Tela = "o Municipio";

$TabelaPrinc      = "plu_cidade";
$AliasPric        = "plu_ci";
$Entidade         = "Cidade";
$Entidade_p       = "Cidades";

$barra_inc_h      = "Incluir um Novo Registro de {$Entidade}";
$contlinfim       = "Existem #qt {$Entidade_p}.";
    //$upCad = vetCad('', 'Paнs', 'plu_estado');
    //$goCad[] = vetCad('idt,idt', 'Pavimentos', 'empreendimento_torre_andar');
    //
    $upCad = vetCad('idt,idt', 'Estado', 'plu_estado');
    //
    $Filtro = Array();
    $Filtro['campo']  = 'descricao';
    $Filtro['tabela'] = 'plu_pais';
    $Filtro['id']     = 'idt';
    $Filtro['nome']   = 'Paнs';
    $Filtro['valor']  = trata_id($Filtro);
    $vetFiltro['idt_pais'] = $Filtro;
    //
    $Filtro = Array();
    $Filtro['campo']  = 'descricao';
    $Filtro['tabela'] = 'plu_estado';
    $Filtro['id']     = 'idt';
    $Filtro['nome']   = 'Municнpio';
    $Filtro['valor']  = trata_id($Filtro);
    $vetFiltro['idt_estado'] = $Filtro;
//
//Monta o vetor de Campo
//
$vetCampo['sigla']            = CriaVetTabela('Sigla');
$vetCampo['descricao']        = CriaVetTabela('Descriзгo');
$vetCampo['plu_es_descricao'] = CriaVetTabela('Estado');

$sql   = 'select ';
$sql  .= ' plu_ci.idt, plu_ci.sigla, ';
$sql  .= ' plu_ci.descricao, ';
$sql  .= ' plu_es.codigo as plu_es_codigo, ';
$sql  .= ' plu_es.descricao as plu_es_descricao ';
$sql  .= ' from plu_cidade plu_ci ';
$sql  .= ' inner join plu_estado plu_es on plu_es.idt = plu_ci.idt_estado ';
$sql  .= ' where  plu_ci.idt_estado = '.null($vetFiltro['idt_estado']['valor']);
$sql  .= ' order by plu_es.codigo, plu_ci.descricao'
?>