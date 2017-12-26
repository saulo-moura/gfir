<?php
$idCampo = 'idt';
$bt_mais = false;
$bt_prefixo = 'det';

$reg_pagina = 20;
$ver_tabela = true;

/*
$sql     = 'select  idt, estado, descricao from empreendimento ';
$sql    .= '    order by estado, descricao ';
$Filtro  = Array();
$Filtro['rs'] = execsql($sql);
$Filtro['vlPadrao'] = $_SESSION[CS]['g_idt_obra'];
$Filtro['id'] = 'idt';
$Filtro['nome'] = 'Empreendimento';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['empreendimento'] = $Filtro;
*/

$sql     = 'select  idt, descricao from periodo ';
$sql    .= '    order by ano desc, mes desc';
$Filtro  = Array();
$Filtro['rs'] = execsql($sql);
$Filtro['id'] = 'idt';
$Filtro['nome'] = 'Período';
//$Filtro['LinhaUm'] = 'Todos os períodos';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['periodo'] = $Filtro;




//  Monta o vetor de Campo
$vetCampo['periodo_rotatividade'] = CriaVetLista('PERÍODO', 'texto', 'tit14b');
$vetCampo['quantidade_funcionarios'] = CriaVetLista('QUANTIDADE FUNCIONÁRIOS', 'texto', 'tit14b_right', false,'','','',"Titulo_right");
$vetCampo['percentual_encargos'] = CriaVetLista('% ENCARGOS', 'texto', 'tit14b_right', false,'','','',"Titulo_right");

$sql  = 'select ';
$sql .= '  ro.*, ';
$sql .= '  pero.codigo    as periodo_rotatividade,  ';
$sql .= '  peri.resumo    as peri_resumo  ';
$sql .= 'from rotatividade ro ';
$sql .= 'inner join periodo peri on peri.idt = ro.idt_periodo ';
$sql .= 'inner join periodo_rotatividade pero on pero.idt = ro.idt_periodo_rotatividade ';
$sql .= 'where ';
$sql .= '    ro.idt_empreendimento = '.null($_SESSION[CS]['g_idt_obra']);

if ($vetFiltro['periodo']['valor']!=-1)
{
    $sql .= ' and  ro.idt_periodo = '.null($vetFiltro['periodo']['valor']);
}


$sql .= ' order by peri.ano desc, peri.mes desc';




?>