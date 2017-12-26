<?php
$idCampo = 'idt';
$bt_mais = false;
$bt_prefixo = 'det';
$reg_pagina = 50;
$ver_tabela = true;
//  Monta o vetor de Campo
/*
$vetCampo['fo_razao_social'] = CriaVetLista('FORNECEDOR', 'texto', 'tit14b');
$vetCampo['numero_titulo'] = CriaVetLista('NÚMERO TÍTULO', 'texto', 'tit14b');
$vetCampo['data_protesto'] = CriaVetLista('DATA PROTESTO','data', 'tit14b');
$vetSit=Array();
$vetSit['AB']='Em Aberto';
$vetSit['IM']='Pago';
//CriaVetLista($nome, $tipo, $style, $mostra_nome = false, $par = '', $antes = '', $depois = '', $classcab='', $ndecimal='') {
$vetCampo['situacao'] = CriaVetLista('SITUAÇÃO', 'descdominio', '' ,false, $vetSit);
$vetCampo['valor'] = CriaVetLista('VALOR (R$)', 'decimal', 'tit14b_right', false,'','','',"Titulo_right");
$vetCampo['acumulado'] = CriaVetLista('ACUMULADO (R$)', 'decimal', 'tit14b_right', false,'','','',"Titulo_right");
//$vetCampo['valor'] = CriaVetTabela('VALOR (R$)','decimal');
//$vetCampo['acumulado'] = CriaVetTabela('ACUMULADO (R$)','decimal');
$sql   = 'select ';
$sql  .= '  tp.*, ';
$sql  .= '  fo.razao_social as fo_razao_social ';
$sql  .= '  from titulo_protestado tp ';
$sql  .= '  inner join fornecedor fo     on fo.idt = tp.idt_fornecedor ';
$sql .= 'where ';
$sql .= '   tp.idt_empreendimento = '.null($_SESSION[CS]['g_idt_obra']);
$sql .= ' order by fo_razao_social, numero_titulo ';

*/

$ver_tabela = true;

$totaltabela=true;

$valor_total = 0;
$texto_total = ' TOTAL: ';
$campo_total = ' ';

$sql  = 'select ';
$sql .= '  sum(valor) as total_valor ';
$sql .= '  from titulo_protestado ';
$sql .= '  where ';
$sql .= '   idt_empreendimento = '.null($_SESSION[CS]['g_idt_obra']);
$rs   = execsql($sql);
ForEach ($rs->data as $row)
{
   $valor_total=$row['total_valor'];
}



$vetCampo['ano_mes_w'] = CriaVetLista('MÊS', 'texto', 'tit14b');
$vetCampo['qtdt'] = CriaVetLista('<span>QUANTIDADE DE TÍTULOS</span>', 'texto', 'tit14b_right_tpqt', false,'','','',"Titulo_right_tpqt");

$vetCampo['valormest'] = CriaVetLista('<span>VALOR (R$)</span>', 'decimal', 'tit14b_right_tp', false,'','','',"Titulo_right_tp");
//$vetCampo['valormest'] = CriaVetLista('VALOR (R$)','decimal', 'tit14b_right');

$sql   = 'select ';
$sql  .= '  ano, ';
$sql  .= '  mes, ';
$sql  .= '  ano_mes as ano_mes_w, ';
$sql  .= '  count(*) as qtdt, ';
$sql  .= '  sum(valor) as valormest ';
$sql  .= '  from titulo_protestado ';
$sql  .= 'where ';
$sql  .= '   idt_empreendimento = '.null($_SESSION[CS]['g_idt_obra']);
$sql  .= '  and ( indicador_ausencia_mes <> '.aspa('S').' or indicador_ausencia_mes is null )';
$sql  .= '  group by ano , mes, ano_mes ';
//$sql  .= ' order by ano desc , mes desc ';
$sql  .= ' union all ';
$sql  .= 'select ';
$sql  .= '  ano, ';
$sql  .= '  mes, ';
$sql  .= "  concat(ano_mes, ' - ', '<span style=".'"color:#0000A0;"'."> não tem protesto<span> ')  as ano_mes_w , ";
//$sql  .= "  '<span style=".'"color:#0000A0;"'.">sem protesto<span> ' as qtdt, ";
$sql  .= "  '' as qtdt, ";
$sql  .= "  '' as valormest ";
$sql  .= '  from titulo_protestado ';
$sql  .= 'where ';
$sql  .= '   idt_empreendimento = '.null($_SESSION[CS]['g_idt_obra']);
$sql  .= '  and ( indicador_ausencia_mes = '.aspa('S'). ' ) ';
$sql  .= '  group by ano , mes, ano_mes ';
$sql  .= ' order by ano desc , mes desc ';
//p($sql);

?>