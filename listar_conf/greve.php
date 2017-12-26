<?php
$idCampo = 'idt';
$bt_mais = false;
$bt_prefixo = 'det';
$reg_pagina = 50;
$ver_tabela = true;

$totaltabela=true;

$valor_total = 0;
$texto_total = ' TOTAL: ';
$campo_total = ' ';

$sql  = 'select ';
$sql .= '  sum(qtdias) as total_dias ';
$sql .= '  from empreendimento_greve eg ';
$sql .= '  where ';
$sql .= '   eg.idt_empreendimento = '.null($_SESSION[CS]['g_idt_obra']);
$rs   = execsql($sql);
ForEach ($rs->data as $row)
{
   $valor_total=$row['total_dias'];
}
//  Monta o vetor de Campo
//$vetCampo['fo_razao_social'] = CriaVetLista('Periodo', 'texto', 'tit14b');
//$vetCampo['numero_titulo'] = CriaVetLista('N�mero T�tulo', 'texto', 'tit14b');

$vetCampo['tp_descricao'] = CriaVetLista('TIPO PARALIZA��O', 'texto', 'tit14b');
$vetCampo['descricao'] = CriaVetLista('DESCRI��O', 'texto', 'tit14b');
$vetCampo['data_inicio'] = CriaVetLista('DATA IN�CIO','data', 'tit14b');
$vetCampo['data_termino'] = CriaVetLista('DATA T�RMINO','data', 'tit14b');
$vetCampo['qtdias'] = CriaVetLista('N�MERO DE DIAS', 'texto', 'tit14b');


$sql   = 'select ';
$sql  .= '  eg.*, ';
$sql  .= '  tp.descricao as tp_descricao ';
$sql  .= '  from empreendimento_greve eg ';
$sql  .= '  inner join tipo_paralizacao tp on tp.idt = eg.idt_tipo_paralizacao';
$sql .= '  where ';
$sql .= '   eg.idt_empreendimento = '.null($_SESSION[CS]['g_idt_obra']);
$sql .= ' order by data_inicio desc ';

?>