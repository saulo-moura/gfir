<?php
$idCampo = 'idt';
$bt_mais = false;
$bt_prefixo = 'det';

$reg_pagina = 20;
$ver_tabela = true;

$totaltabela=true;

$valor_total_falta_mes       = 0;
$valor_total_atestado_mes    = 0;
$valor_total_dias_atestados  = 0;
$texto_total = ' TOTAL: ';
$campo_total = ' ';

$sql  = 'select ';
$sql .= '  sum(falta_mes) as total_falta_mes, sum(atestado_mes) as total_atestado_mes, sum(dias_atestados) as total_dias_atestados ';
$sql .= '  from dado_estatistico ';
$sql .= '  where ';
$sql .= '   idt_empreendimento = '.null($_SESSION[CS]['g_idt_obra']);
$rs   = execsql($sql);
ForEach ($rs->data as $row)
{
   $valor_total_falta_mes       = $row['total_falta_mes'];
   $valor_total_atestado_mes    = $row['total_atestado_mes'];
   $valor_total_dias_atestados  = $row['total_dias_atestados'];
}




//  Monta o vetor de Campo
$vetCampo['nom_resumo'] = CriaVetLista('MÊS', 'texto', 'tit14b');
$vetCampo['dias_uteis_mes'] = CriaVetLista('DIAS ÚTEIS<br> MÊS', 'decimal', 'tit14b_right', false,'','','',"Titulo_right" , 0);
$vetCampo['ativos'] = CriaVetLista('ATIVOS NO<br> MÊS', 'decimal', 'tit14b_right', false,'','','',"Titulo_right" , 0);
$vetCampo['falta_mes'] = CriaVetLista('FALTAS NO<br> MÊS', 'decimal', 'tit14b_right', false,'','','',"Titulo_right" , 0);
$vetCampo['percentual_faltas'] = CriaVetLista('% FALTAS', 'decimal', 'tit14b_right', false,'','',' %',"Titulo_right" , 2);
//$vetCampo['falta_acumulada'] = CriaVetLista('FALTAS<br> ACUMULADA', 'decimal', 'tit14b_right', false,'','','',"Titulo_right", 0);

$vetCampo['atestado_mes'] = CriaVetLista('ATESTADOS NO<br> MÊS', 'decimal', 'tit14b_right', false,'','','',"Titulo_right", 0);
$vetCampo['percentual_atestados'] = CriaVetLista('% ATESTADOS', 'decimal', 'tit14b_right', false,'','',' %',"Titulo_right", 2);
//$vetCampo['atestado_acumulado'] = CriaVetLista('ATESTADOS<br> ACUMULADO', 'decimal', 'tit14b_right', false,'','','',"Titulo_right", 0);

$vetCampo['dias_atestados'] = CriaVetLista('DIAS <br />DE ABONO', 'decimal', 'tit14b_right', false,'','','',"Titulo_right", 0);
$vetCampo['percentual_dias_atestados'] = CriaVetLista('% DIAS <br />DE ABONO', 'decimal', 'tit14b_right', false,'','',' %',"Titulo_right", 2);



$sql  = 'select dado.*, peri.resumo as nom_resumo ' ;
$sql .= 'from empreendimento em, dado_estatistico dado, periodo peri ';
$sql .= 'where em.idt = dado.idt_empreendimento ';
$sql .= 'and dado.idt_periodo = peri.idt ';
$sql .= 'and em.idt = '.null($_SESSION[CS]['g_idt_obra']);
$sql .= ' order by peri.ano , peri.mes ';
?>