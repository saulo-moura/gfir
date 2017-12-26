<?php
$idCampo = 'idt';
$bt_mais = false;
$bt_prefixo = 'det';
$reg_pagina = 50;
$ver_tabela = true;
//  Monta o vetor de Campo
$vetCampo['peri_resumo'] = CriaVetLista('MÊS', 'texto', 'tit14b');
$vetCampo['valor'] = CriaVetLista('VALOR (R$)', 'decimal', 'tit14b_right', false,'','','',"Titulo_right");
$vetCampo['acumulado'] = CriaVetLista('ACUMULADO (R$)', 'decimal', 'tit14b_right', false,'','','',"Titulo_right");
$sql   = 'select ';
$sql  .= '    pj.*, ';
$sql  .= '    peri.resumo as peri_resumo ' ;
$sql  .= 'from pagamento_juro pj ';
$sql  .= 'left join periodo peri on peri.idt = pj.idt_periodo ';
$sql  .= 'where ';
$sql  .= '   pj.idt_empreendimento = '.null($_SESSION[CS]['g_idt_obra']);
$sql  .= '   order by peri.ano , peri.mes ';
?>