<?php
$idCampo = 'idt';
$bt_mais = false;
$bt_prefixo = 'det';
$reg_pagina = 20;
$ver_tabela = true;
$sql     = 'select  idt, estado, descricao from empreendimento ';
$sql    .= '    order by estado, descricao ';
$Filtro  = Array();
$Filtro['rs'] = execsql($sql);
$Filtro['vlPadrao'] = $_SESSION[CS]['g_idt_obra'];
$Filtro['id'] = 'idt';
$Filtro['nome'] = 'Empreendimento';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['empreendimento'] = $Filtro;


$sql     = 'select  idt, descricao from periodo ';
$sql    .= '    order by ano desc, mes desc ';
$Filtro  = Array();
$Filtro['rs'] = execsql($sql);
//$Filtro['vlPadrao'] = $_SESSION[CS]['g_idt_obra'];
$Filtro['id'] = 'idt';
$Filtro['nome'] = 'Periodo';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['periodo'] = $Filtro;

    //  Monta o vetor de Campo
$vetCampo['pe_descricao'] = CriaVetLista('Periodo', 'texto', 'tit14b');
$vetCampo['emp_razao_social'] = CriaVetLista('Empresa', 'texto', 'tit14b');
$vetCampo['fp_ordem'] = CriaVetLista('Ordem', 'texto', 'tit14b_right', false,'','','',"Titulo_right");
$vetCampo['fp_descricao'] = CriaVetLista('Funчуo', 'texto', 'tit14b_right', false,'','','',"Titulo_right");
$vetCampo['quantidade'] = CriaVetLista('Quantidade', 'texto', 'tit14b_right', false,'','','',"Titulo_right");
$vet_incc_obra=Array();


$sql   = 'select ';
$sql  .= '    pe.*, ';
$sql  .= '    peri.descricao as peri_descricao, ' ;
$sql  .= '    emp.razao_social as emp_razao_social, ' ;
$sql  .= '    fp.ordem as fp_ordem, ' ;
$sql  .= '    fp.descricao  as fp_descricao ' ;
$sql  .= 'from pessoal_efetivo pe ';
$sql  .= 'inner join periodo peri on peri.idt = pe.idt_periodo ';
$sql  .= 'inner join empresa emp on  emp.idt = pe.idt_empresa ';
$sql  .= 'inner join funcao_pessoal fp on fp.idt = pe.idt_funcao_pessoal ';
$sql  .= 'where ';
$sql  .= '   pe.idt_empreendimento = '.null($vetFiltro['empreendimento']['valor']);

$sql  .= '    and pe.idt_periodo   = '.null($vetFiltro['periodo']['valor']);



?>