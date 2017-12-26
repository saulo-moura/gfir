<?php
$idCampo = 'idt';
$bt_mais = false;
$bt_prefixo = 'det';
$reg_pagina = 20;
$ver_tabela = true;
///////////////////////////////////


$msg='';
$idt_obra  = null($_SESSION[CS]['g_idt_obra']);
$indicador = verificar_menu_obra($idt_obra, $msg);
if ($indicador=='N')
{
    echo "<div id='menu_existe_obra' > ";
    echo '<a >'.$msg.'</a>';
    echo "</div>";
    onLoadPag();
    FimTela();
    exit();
}
/////////////////////////////////////
//  Monta o vetor de Campo
$vetCampo['peri_resumo'] = CriaVetLista('MÊS', 'texto', 'tit14b');
$vetCampo['valor'] = CriaVetLista('VALOR (R$)', 'decimal', 'tit14b_right', false,'','','',"Titulo_right");
$vetCampo['acumulado'] = CriaVetLista('ACUMULADO (R$)', 'decimal', 'tit14b_right', false,'','','',"Titulo_right");
$sql   = 'select ';
$sql  .= '    oe.*, ';
$sql  .= '    peri.resumo as peri_resumo ' ;
$sql  .= 'from oas_exclusive oe ';
$sql  .= 'left join periodo peri on peri.idt = oe.idt_periodo ';
$sql  .= 'where ';
$sql  .= '   oe.idt_empreendimento = '.null($_SESSION[CS]['g_idt_obra']);
$sql  .= '   order by peri.ano, peri.mes ';

// verificar existencia

$sqlp   = 'select ';
$sqlp  .= '    count(*) as qtdsel ';
$sqlp  .= 'from oas_exclusive oe ';
$sqlp  .= 'where ';
$sqlp  .= '   oe.idt_empreendimento = '.null($_SESSION[CS]['g_idt_obra']);
$rs = execsql($sqlp);
ForEach ($rs->data as $row) {
   $qtdsel = $row['qtdsel'];
   if  ($qtdsel== 0)
   {   // msg sem registros
   //    $msg_sem_registro=' Sem informações cadastradas.';
   //    echo "<div id='msg_sem_registro' >";
   //    echo  $msg_sem_registro;
   //    echo "</div>";
   //    FimTela();
   //    exit();
   }
}



?>