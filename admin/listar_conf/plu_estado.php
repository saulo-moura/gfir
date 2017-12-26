<?php
$idCampo = 'idt';
$Tela = "o Estado";

$upCad   = vetCad('', 'Paнs', 'plu_pais');
$goCad[] = vetCad('idt,idt', 'Municнpios', 'plu_cidade');

$TabelaPrinc      = "plu_estado";
$AliasPric        = "plu_es";
$Entidade         = "Estado";
$Entidade_p       = "Estados";

$barra_inc_h      = "Incluir um Novo Registro de {$Entidade}";
$contlinfim       = "Existem #qt {$Entidade_p}.";

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
    $Filtro['rs']       = 'Texto';
    $Filtro['id']       = 'texto';
    $Filtro['js_tam']   = '0';
    $Filtro['nome']     = 'Texto';
    $Filtro['valor']    = trata_id($Filtro);
    $vetFiltro['texto'] = $Filtro;
//Monta o vetor de Campo
$vetCampo['codigo'] = CriaVetTabela('Cуdigo');
$vetCampo['descricao'] = CriaVetTabela('Descriзгo');
$vetCampo['imagem'] = CriaVetTabela('Unidade Federaзгo', 'arquivo', '200', 'plu_estado');

$sql  = 'select * from '.$pre_table.'plu_estado plu_es  ';
$sql .= ' where plu_es.idt_pais = '.null($vetFiltro['idt_pais']['valor']);
$sql .= ' and ( ';
$sql .= ' lower(plu_es.codigo) like lower('.aspa($vetFiltro['texto']['valor'], '', '%').')';
$sql .= ' or lower(plu_es.descricao) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
$sql .= ' ) ';
$sql .= ' order by plu_es.descricao';
?>