<?php


if ($_GET['print'] != 's') {
//    echo "<div id='area_imprime' >";
//    echo '<a target="_blank" href="conteudo_print_list.php?prefixo=listar&menu=indice_empreendimento&print=s&titulo_rel=Indices do Empreendimento" ><img style="padding:5px;" src="imagens/impressora.gif" width="16" height="16" title="Preparar para Impressão" alt="Preparar para Impressão"  border="0" /></a>';
//    echo "</div>";


    echo ' <div id="voltar_full_m">';

    echo ' <div class="voltar">';
    echo '         <img src="imagens/menos_full_pco.jpg" title="Voltar"   width="16" height="16"  style="padding:5px; " alt="Voltar" border="0" onclick="self.location = '."'".$url_volta."'".'" style="cursor: pointer;">';
    echo ' </div>';

    $nome_pr   = 'quadro_funcionario';
    $nome_ex   = 'QUADRO FUNCIONARIO - ';
    $titulo_rl = 'Quadro Funcionário';

    echo "<div id='area_imprime' >";
    echo '<a target="_blank" href="conteudo_print_list.php?prefixo=listar&menu='.$nome_pr.'&print=s&titulo_rel='.$titulo_rl.'" ><img style="padding:5px;" src="imagens/impressora.gif" width="16" height="16" title="Preparar para Impressão" alt="Preparar para Impressão"  border="0" /></a>';
    echo "</div>";

  //  echo "<div id='area_excel' >";
  //  $comp_excel_name="&comp_excel_name=".$nome_ex.mb_strtoupper($_SESSION[CS]['g_nm_obra']);
  //  echo '<a target="_blank" href="conteudo_excel_list.php?prefixo=listar&menu='.$nome_pr.'&print=s&excel=s&titulo_rel='.$titulo_rl.$parww.$comp_excel_name.'" ><img style="padding:5px; " src="imagens/excel.gif" width="16" height="16" title="Migra para Excel" alt="Migra para Excel"  border="0" /></a>';
  //  echo "</div>";

    echo ' </div>';
    echo ' <br /><br />';




}
else
{
    echo "<div id='dados_imprime' >";
}





$idCampo = 'idt';
$bt_mais = false;
$bt_prefixo = 'det';

$reg_pagina = 100;
$ver_tabela = true;
//  Monta o vetor de Campo







$vetCampo['nom_resumo'] = CriaVetLista('MÊS', 'texto', 'tit14b',false,'','','',"Titulo_left");
$vetCampo['admitido'] = CriaVetLista('ADMITIDO', 'decimal', 'tit14b_right', false,'','','',"Titulo_right",0);
$vetCampo['demitido'] = CriaVetLista('DEMITIDO', 'decimal', 'tit14b_right', false,'','','',"Titulo_right",0);
$vetCampo['ativo'] = CriaVetLista('ATIVO', 'decimal', 'tit14b_right', false,'','','',"Titulo_right",0);


$vetCampo['NADA'] = CriaVetLista('', 'texto', 'tit14b_right', false,'','','',"Titulo_right");




$sql  = 'select qf.*, peri.resumo as nom_resumo ' ;
$sql .= 'from empreendimento em,quadro_funcionario qf, periodo peri ';
$sql .= 'where em.idt = qf.idt_empreendimento ';
$sql .= 'and qf.idt_periodo = peri.idt ';
$sql .= 'and em.idt = '.null($_SESSION[CS]['g_idt_obra']);
$sql .= ' order by peri.ano , peri.mes ';



?>