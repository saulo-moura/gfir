<?php
$idCampo = 'idt';
$bt_mais = false;
$bt_prefixo = 'det';
$reg_pagina = 30;
$ver_tabela = true;

$sql     = 'select  idt, estado, descricao from empreendimento ';
$sql    .= '    where idt = '.null($_SESSION[CS]['g_idt_obra']);
$sql    .= '    order by estado, descricao ';
$Filtro  = Array();
$Filtro['rs'] = execsql($sql);
$Filtro['vlPadrao'] = $_SESSION[CS]['g_idt_obra'];
$Filtro['id'] = 'idt';
$Filtro['nome'] = 'Empreendimento';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['empreendimento'] = $Filtro;



//  Monta o vetor de Campo
$vetCampo['item'] = CriaVetLista('อTEM', 'texto', 'tit14b');
$vetCampo['descricao'] = CriaVetLista('DESCRIวรO', 'texto', 'tit14b');
$vetCampo['data_inicio_cotacao'] = CriaVetLista('INอCIO DA COTAวรO', 'data', 'tit14b_mb10');
$vetCampo['data_prazo_maximo'] = CriaVetLista('PRAZO MมXIMO AQUISIวรO', 'data', 'tit14b_mb10');
$vetCampo['data_material_obra'] = CriaVetLista('MATERIAL NA OBRA', 'data', 'tit14b_mb10');
$vetCampo['sc_descricao'] = CriaVetLista('STATUS', 'texto', 'tit14b');



$sql   = 'select ';
$sql  .= '  cc.*, ';
$sql  .= '  sc.descricao as sc_descricao ';
$sql  .= '  from cronograma_contratacao cc ';
$sql  .= '  inner join status_contratacao sc on sc.idt = cc.idt_status ';
$sql  .= '  where cc.idt_empreendimento = '.null($vetFiltro['empreendimento']['valor']);
$sql  .= '  order by item ';


?>