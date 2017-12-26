<?php


if ($_GET['print'] != 's') {
    echo ' <div id="voltar_full_m">';
    echo ' <div class="voltar">';
    echo '         <img src="imagens/menos_full_pco.jpg" title="Voltar"   width="16" height="16"  style="padding:5px; " alt="Voltar" border="0" onclick="self.location = '."'".$url_volta."'".'" style="cursor: pointer;">';
    echo ' </div>';
    $nome_pr   = 'aditivo_orcamento';
    $nome_ex   = 'ADITIVO DO ORÇAMENTO - ';
    $titulo_rl = 'Aditivo do Orçamento';
    echo "<div id='area_imprime' >";
    echo '<a target="_blank" href="conteudo_print_list.php?prefixo=listar&menu=aditivo_orcamento&print=s&titulo_rel=Indices do Empreendimento" ><img style="padding:5px;" src="imagens/impressora.gif" width="16" height="16" title="Preparar para Impressão" alt="Preparar para Impressão"  border="0" /></a>';
    echo "</div>";
    
   // echo "<div id='area_excel' >";
   // $comp_excel_name="&comp_excel_name=".$nome_ex.mb_strtoupper($_SESSION[CS]['g_nm_obra']);
   // echo '<a target="_blank" href="conteudo_excel_list.php?prefixo=listar&menu='.$nome_pr.'&print=s&excel=s&titulo_rel='.$titulo_rl.$parww.$comp_excel_name.'" ><img style="padding:5px; " src="imagens/excel.gif" width="16" height="16" title="Migra para Excel" alt="Migra para Excel"  border="0" /></a>';
   // echo "</div>";
   
    echo ' </div>';
    echo '<br /><br />';
}
else
{
    echo "<div id='dados_imprime' >";
}



$idCampo = 'idt';
$bt_mais = false;
$bt_prefixo = 'det';
$reg_pagina = 50;
$ver_tabela = true;

$totaltabela=true;

$total_incc = 0;
$total_real = 0;
$texto_total = ' TOTAL: ';
$campo_total = ' ';

$sql  = 'select ';
$sql .= '  sum(valor_incc) as total_incc, ';
$sql .= '  sum(valor_real) as total_real,  ';
$sql .= '  sum(qtdias)     as total_dias  ';
$sql .= '  from empreendimento_aditivo ea ';
$sql .= '  where ';
$sql .= '   ea.idt_empreendimento = '.null($_SESSION[CS]['g_idt_obra']);
$rs   = execsql($sql);
ForEach ($rs->data as $row)
{
   $total_incc =$row['total_incc'];
   $total_real =$row['total_real'];
   $total_dias =$row['total_dias'];
}
//  Monta o vetor de Campo


$vetCampo['tp_descricao'] = CriaVetLista('TIPO ADITIVO', 'texto', 'tit14b', false,'','','',"Titulo_left");
//$vetCampo['descricao'] = CriaVetLista('DESCRIÇÃO' , 'texto', 'tit14b');
$vetCampo['data_inicio'] = CriaVetLista('DATA ADITIVO','data', 'tit14b', false,'','','',"Titulo_left");
$vetCampo['valor_incc'] = CriaVetLista('INCC','decimal', 'tit14b_right', false,'','','',"Titulo_right",2);
$vetCampo['valor_real'] = CriaVetLista('R$','decimal', 'tit14b_right', false,'','','',"Titulo_right",2);
//$vetCampo['valor_projetado'] = CriaVetLista('Projetado','decimal');
//$vetCampo['qtdias'] = CriaVetLista('DIAS ÚTEIS<br />PARADOS','decimal', 'tit14b_right', false,'','','',"Titulo_right",0);
$vetCampo['qtdias'] = CriaVetLista('DIAS PARADOS','decimal', 'tit14b_right', false,'','','',"Titulo_right",0);

$vetCampo['descricaow'] = CriaVetLista('' , 'texto', 'tit14b');

//$vetCampo['texto'] = CriaVetLista('MOTIVO PARALIZAÇÃO' , 'texto', 'tit14b');


$sql  = 'select ea.*, tp.descricao as tp_descricao from '.$pre_table.'empreendimento_aditivo ea ';
$sql .= ' inner join '.$pre_table.'tipo_empreendimento_aditivo tp on tp.idt = ea.idt_tipo_empreendimento_aditivo';
$sql .= ' where idt_empreendimento = '.null($_SESSION[CS]['g_idt_obra']);
$sql .= ' order by ea.data_inicio ';


?>
