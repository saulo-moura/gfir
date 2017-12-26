<?php
//$goCad[] = vetCad('idt', 'Participaчуo', 'empreendimento_participacao');
//$goCad[] = vetCad('idt', 'Financiamento', 'empreendimento_financiamento');
//$goCad[] = vetCad('idt', 'Conjunto', 'empreendimento_conjunto');
//$goCad[] = vetCad('idt', 'Torre', 'empreendimento_torre');
//$goCad[] = vetCad('idt', 'Pavimento', 'qp_tipo_pavimento');
//$goCad[] = vetCad('idt', 'Paralizaчуo', 'empreendimento_greve');
$idCampo = 'idt';
$bt_mais = false;
$bt_prefixo = 'det';
$reg_pagina = 80;
$ver_tabela = true;
$tipofiltro='S';
/*
$Filtro = Array();
$Filtro['rs'] = 'Texto';
$Filtro['id'] = 'texto';
$Filtro['js_tam'] = '0';
$Filtro['nome'] = 'Texto';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['texto'] = $Filtro;
*/

    $upCad = vetCad('', 'Sistema', 'sca_sistema');

    $Filtro = Array();
    $Filtro['campo'] = 'descricao';
    $Filtro['tabela'] = 'sca_sistema';
    $Filtro['id'] = 'idt';
    $Filtro['nome'] = 'Sistema';
    $Filtro['valor'] = trata_id($Filtro);
    $vetFiltro['sca_sistema'] = $Filtro;





/*
$sql  = "select idt , descricao  from qp_padrao_empreendimento ";
$sql .= "  order by codigo";
//$sql    .= ' where idt = '.null($_SESSION[CS]['g_idt_obra']);
$Filtro             = Array();
$Filtro['rs']       = execsql($sql);
$Filtro['id']       = 'idt';
$Filtro['js_tam']   = '0';
$Filtro['nome']     = 'Padrуo';
$Filtro['LinhaUm']  = '-- Nуo Seleciona --';
$Filtro['valor']    = trata_id($Filtro);
$vetFiltro['qp_padrao_empreendimento'] = $Filtro;


$sql  = "select idt , descricao  from tipo_empreendimento ";
$sql .= "  order by descricao";
$Filtro             = Array();
$Filtro['rs']       = execsql($sql);
$Filtro['id']       = 'idt';
$Filtro['js_tam']   = '0';
$Filtro['nome']     = 'Tipo';
$Filtro['LinhaUm']  = '-- Nуo Seleciona --';
$Filtro['valor']    = trata_id($Filtro);
$vetFiltro['tipo_empreendimento'] = $Filtro;

*/




/*
$sql     = 'select  distinct es.codigo, es.descricao from estado es ';
$sql    .= '    inner join empreendimento em on em.estado = es.codigo ';
$sql    .= '    order by descricao ';
$Filtro  = Array();
$Filtro['rs']        = execsql($sql);
$Filtro['js_tam']    = '0';
$Filtro['id']        = 'codigo';
$Filtro['nome']      = 'Estado';
$Filtro['LinhaUm']   = '-- Seleciona Todos --';
$Filtro['valor']     = trata_id($Filtro);
$vetFiltro['estado'] = $Filtro;

$Filtro  = Array();
$Filtro['rs']        = $vetSimNao;
$Filtro['js_tam']    = '0';
$Filtro['id']        = 'ativo';
$Filtro['nome']      = 'Ativo?';
$Filtro['LinhaUm']   = '-- Seleciona Todos --';
$Filtro['valor']     = trata_id($Filtro);
$vetFiltro['ativo'] = $Filtro;


$classificarcp        = Array();
$classificarcp['01']  = 'em.descricao';
$classificarcp['02']  = 'em.estado, em.descricao';
$classificarcp['03']  = 're.codigo, em.descricao';
$classificarcp['04']  = 'pe.descricao, em.descricao';
$classificarcp['05']  = 'te.descricao, em.descricao';


$classificar        = Array();
$classificar['01']  = 'Empreendimento';
$classificar['02']  = 'Estado, Empreendimento';
$classificar['03']  = 'Regiao, Empreendimento';
$classificar['04']  = 'Padrуo, Empreendimento';
$classificar['05']  = 'Tipo, Empreendimento';

$Filtro             = Array();
$Filtro['rs']       = $classificar;
$Filtro['id']       = 'idt';
$Filtro['js_tam']   = '0';
$Filtro['tipo']     = 'C';
$Filtro['nome']     = 'Classificar por';
$Filtro['valor']    = trata_id($Filtro);
$vetFiltro['classificarpor'] = $Filtro;


$numcl          = $vetFiltro['classificarpor']['valor'];
$classificarpor = $classificarcp[$numcl];
*/

//Monta o vetor de Campo
$vetCampo['imagem']    = CriaVetTabela('Logomarca', 'arquivo', '25', 'empreendimento');

$vetCampo['em_ativo']     = CriaVetTabela('Ativo?','descDominio',$vetSimNao);
$vetCampo['em_descricao'] = CriaVetTabela('Ambiente');
$vetCampo['em_chama']     = CriaVetTabela('Link','link');

$vetCampo['em_producao']     = CriaVetTabela('Esta em Produчуo?','descDominio',$vetSimNao);


$sql  = '';
$sql .= ' select ';
$sql .= ' em.idt, em.imagem, em.descricao as em_descricao, em.chama as em_chama, em.ativo as em_ativo, em.producao as em_producao  ';
$sql .= ' from empreendimento em ';
$sql .= ' where idt_sistema = '.null($vetFiltro['sca_sistema']['valor']);

?>