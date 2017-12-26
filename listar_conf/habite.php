<?php

if ($_GET['print'] != 's') {
    echo "<div id='area_imprime' >";
    echo '<a target="_blank" href="conteudo_print.php?prefixo=listar&menu=habite&print=s&titulo_rel=Habite-se" ><img style="padding:5px;" src="imagens/impressora.gif" width="16" height="16" title="Preparar para Impressão" alt="Preparar para Impressão"  border="0" /></a>';
    echo "</div>";
}
else
{
    echo "<div id='dados_imprime' >";
}

$idCampo = 'idt';
$bt_mais = false;
$bt_prefixo = 'det';
$reg_pagina = 30;
$ver_tabela = true;

//  Monta o vetor de Campo
$vetCampo['ordem'] = CriaVetLista('ORDEM', 'texto', 'tit14b');
$vetCampo['nom_pend'] = CriaVetLista('PENDÊNCIA', 'texto', 'tit14b');
$vetCampo['nom_resp'] = CriaVetLista('RESPONSÁVEL', 'texto', 'tit14b');
$vetCampo['data_prevista'] = CriaVetLista('DATA PREVISTA', 'data', 'tit14b_mb10');
$vetCampo['nom_stat'] = CriaVetLista('STATUS', 'texto', 'tit14b_mb10');
$vetCampo['sta_imagem']    = CriaVetTabela('', 'arquivo',' ' , 'status');
$sql  = 'select hab.*, em.descricao, pend.descricao as nom_pend,resp.descricao as nom_resp, sta.descricao as nom_stat , sta.imagem as sta_imagem ';
$sql .= 'from empreendimento em,habite hab,pendencia pend, status sta, responsavel resp ';
$sql .= 'where em.idt            = hab.idt_empreendimento ';
$sql .= 'and hab.idt_pendencia   = pend.idt ';
$sql .= 'and hab.idt_responsavel = resp.idt ';
$sql .= 'and hab.idt_status      = sta.idt ';
$sql .= 'and em.idt              = '.null($_SESSION[CS]['g_idt_obra']);
$sql .= ' order by hab.ordem';
?>