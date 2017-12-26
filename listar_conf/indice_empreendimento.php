<?php

if ($_GET['print'] != 's') {
//    echo "<div id='area_imprime' >";
//    echo '<a target="_blank" href="conteudo_print_list.php?prefixo=listar&menu=indice_empreendimento&print=s&titulo_rel=Indices do Empreendimento" ><img style="padding:5px;" src="imagens/impressora.gif" width="16" height="16" title="Preparar para Impressão" alt="Preparar para Impressão"  border="0" /></a>';
//    echo "</div>";
    
    
    echo ' <div id="voltar_full_m">';
    
    echo ' <div class="voltar">';
    echo '         <img src="imagens/menos_full_pco.jpg" title="Voltar"   width="16" height="16"  style="padding:5px; " alt="Voltar" border="0" onclick="self.location = '."'".$url_volta."'".'" style="cursor: pointer;">';
    echo ' </div>';

    $nome_pr   = 'indice_empreendimento';
    $nome_ex   = 'INDICE DO EMPREENDIMENTO - ';
    $titulo_rl = 'Índice do Empreendimento';
    
    echo "<div id='area_imprime' >";
    echo '<a target="_blank" href="conteudo_print_list.php?prefixo=listar&menu=indice_empreendimento&print=s&titulo_rel=Indices do Empreendimento" ><img style="padding:5px;" src="imagens/impressora.gif" width="16" height="16" title="Preparar para Impressão" alt="Preparar para Impressão"  border="0" /></a>';
    echo "</div>";
    
  //  echo "<div id='area_excel' >";
  //  $comp_excel_name="&comp_excel_name=".$nome_ex.mb_strtoupper($_SESSION[CS]['g_nm_obra']);
  //  echo '<a target="_blank" href="conteudo_excel_list.php?prefixo=listar&menu='.$nome_pr.'&print=s&excel=s&titulo_rel='.$titulo_rl.$parww.$comp_excel_name.'" ><img style="padding:5px; " src="imagens/excel.gif" width="16" height="16" title="Migra para Excel" alt="Migra para Excel"  border="0" /></a>';
  //  echo "</div>";

    echo ' </div>';
    

    
    
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

    $vetMes = Array(
    '01' => 'Jan',
    '02' => 'Fev',
    '03' => 'Mar',
    '04' => 'Abr',
    '05' => 'Mai',
    '06' => 'Jun',
    '07' => 'Jul',
    '08' => 'Ago',
    '09' => 'Set',
    '10' => 'Out',
    '11' => 'Nov',
    '12' => 'Dez'
    );
    
    $obra_busca = null($_SESSION[CS]['g_idt_obra']);
    
    $idt_periodo_h = 0;

    
        $sqlg  = 'select ';
        $sqlg .= '  ffc.idt, ';
        $sqlg .= '  pe.idt as pe_idt, ';
        $sqlg .= '  pe.ano as pe_ano, ';
        $sqlg .= '  pe.mes as pe_mes';
        $sqlg .= '  from  fluxo_financeiro_controle ffc ';
        $sqlg .= '  inner join periodo pe on pe.idt = ffc.idt_periodo_h ';
        $sqlg .= '  where  publica='.aspa('S');
        $sqlg .= '    and  ffc.idt_empreendimento = '.null($obra_busca).'  ' ;
        $sqlg .= '  order by pe.ano desc, pe.mes desc';
        $rsg = execsql($sqlg);
        $ano_fin='';
        $mes_fin='';
        if ($rsg->rows != 0) {
            $rowg = $rsg->data[0];
            $idt_periodo_h = $rowg['pe_idt'];
            $pe_texto_anomes_posicao=$rowg['pe_mes'].' / '.$rowg['pe_ano'];
            $ano_fin=$rowg['pe_ano'];
            $mes_fin=$rowg['pe_mes'];

        }
        $sqlg  = 'select ';
        $sqlg .= '  pe.idt, ';
        $sqlg .= '  pe.idt as pe_idt, ';
        $sqlg .= '  pe.ano as pe_ano, ';
        $sqlg .= '  pe.mes as pe_mes';
        $sqlg .= '  from  periodo pe ';
        $sqlg .= '  where  flag_a='.aspa('S');
        $sqlg .= '  order by pe.ano desc, pe.mes desc';
        $rsg = execsql($sqlg);
        $ano_per='';
        $mes_per='';
        if ($rsg->rows != 0) {
            $rowg = $rsg->data[0];
            $idt_periodo_h = $rowg['pe_idt'];
            $pe_texto_anomes_posicao=$rowg['pe_mes'].' / '.$rowg['pe_ano'];
            $ano_per=$rowg['pe_ano'];
            $mes_per=$rowg['pe_mes'];
        }
        $tira_um=0;
        if ($ano_fin.$mes_fin!=$ano_per.$mes_per)
        {
            $tira_um=1;
        }
        else
        {  // pega o próximo idt_periodo_h //
           // se os dois em julho 2012 então pega o de Agosto
           // se o controle financeiro em Julho e Periodo em agosto
           // Esta começando AGOSto - utiliza a de agosto porém até JULHO
           // é o tal do tira um
           // então, estando igual pega do de agosto até JULHO
           // avancar o periodo em mais um e tirar um
           $tira_um=1;
           
           $ano_per_av=$ano_per;
           $mes_per_av=$mes_per;
           $mes_per_av=$mes_per_av+1;
           if ($mes_per_av==13)
           {
               $mes_per_av='01';
               $ano_per_av=$ano_per_av+1;
           }
           if ($mes_per_av<10)
           {
               $mes_per_av='0'.$mes_per_av;
           }
           // acessa novo periodo o que é mais um
            $sqlgd  = 'select ';
            $sqlgd .= '  pe.idt, ';
            $sqlgd .= '  pe.idt as pe_idt ';
            $sqlgd .= '  from  periodo pe ';
            $sqlgd .= '  where  ano='.aspa($ano_per_av);
            $sqlgd .= '    and  mes='.aspa($mes_per_av);
            $rsgd = execsql($sqlgd);
            $ano_per='';
            $mes_per='';
            if ($rsgd->rows != 0) {
                $rowgd = $rsgd->data[0];
                $idt_periodo_h = $rowgd['pe_idt'];
            }
        }
        //echo '  Data  '.$idt_periodo_h .' mm '.$pe_texto_anomes_posicao;

    // intervalo do empreendimento

    $vetint=Array();
    busca_intervalo($obra_busca,$vetint);
    $ano_inicio = $vetint['ano_inicio'];
    $ano_final  = $vetint['ano_final'];
    $mes_inicio = $vetint['mes_inicio'];
    $mes_final  = $vetint['mes_final'];
    
    // foi substituido por esse
    $mes_inicio = $_SESSION[CS]['data_incc_obra_mes'] ;
    $ano_inicio= $_SESSION[CS]['data_incc_obra_ano'];

    
    
    $vetflf=Array();
    busca_final_fluxo_financeiro($obra_busca,$idt_periodo_h,$vetflf);
    $ano_final_flf = $vetflf['ano_final'];
    $mes_final_flf = $vetflf['mes_final'];
    if ($ano_final_flf.$mes_final_flf>$ano_final.$mes_final)
    {
        $ano_final  = $ano_fin;
        $mes_final  = $mes_fin;
    }
    
    
    echo "<span class='titulo_indice'> Mês de ".$mes_inicio.' / '.$ano_inicio. ' até '.$mes_final.' / '.$ano_final.'</span>';
    //  Monta o vetor de Campo
    $vetCampo['pe_resumo'] = CriaVetLista('MÊS/ANO', 'texto', 'tit14b',false,'','','',"Titulo_left");
    
  //  $vetCampo['flag_projetado'] = CriaVetLista('Projetado?', 'texto', 'tit14b');
    
  //  $vetCampo['taxa_projetado'] = CriaVetLista('Taxa projetado', 'decimal', 'tit14b_right', false,'','','',"Titulo_right");
    $vet_incc_obra_aju=Array();
    calcula_incc_obra_aju($obra_busca,$idt_periodo_h,$vet_incc_obra_aju);
   // p($vet_incc_obra_aju);
    if ($tira_um==1)
    {
        $ultimo_incc = array_pop($vet_incc_obra_aju);
        $ano_final  = $ano_fin;
        $mes_final  = $mes_fin;


    }
   // p($vet_incc_obra_aju);

    //$vet[153]=' bete ';
   // $vetCampo['incc_obra_aju'] = CriaVetLista('% testar', 'descdominio', 'tit14b_right_b', false,$vet_incc_obra_aju,'','',"Titulo_right");

    $vetCampo['incc'] = CriaVetLista('INCC', 'decimal', 'tit14b_right', false,'','','',"Titulo_right",3);
    //$vetCampo['incc'] = CriaVetTabela('INCC','decimal','','','Titulo_right',3);
    $vetCampo['mensal'] = CriaVetLista('% MENSAL', 'decimal', 'tit14b_right', false,'','','',"Titulo_right",2);
  //  $vetCampo['anual'] = CriaVetLista('% ANUAL', 'decimal', 'tit14b_right', false,'','','',"Titulo_right");
    $vet_incc_obra=Array();
    calcula_incc_obra($obra_busca,$idt_periodo_h,$vet_incc_obra);
//    p($vet_incc_obra);
    //$vet[153]=' bete ';
    $vetCampo['incc_obra'] = CriaVetLista('% EMPREENDIMENTO', 'descdominio', 'tit14b_right_b', false,$vet_incc_obra,'','',"Titulo_right");

    $vetCampo['filler'] = CriaVetLista('      ', 'texto', 'tit14b');
    // $idt_periodo_h=tabela_indice_atual();
    //
    $sql   = 'select ';
    $sql  .= '  ind.*,  ';
    $sql  .= '  ind.idt as incc_obra,  ';
    $sql  .= '  ind.idt as incc_obra_aju,  ';
    $sql  .= '  pe.resumo as pe_resumo ';
    $sql  .= '  from indice ind ';
    $sql  .= '  inner join periodo pe on pe.idt=ind.idt_periodo';
    //
    $sql  .= ' where ';
    $sql  .= '   idt_periodo_h = '. null($idt_periodo_h).' and ';
    $sql  .= '  ( flag_projetado <> '. aspa('S') .' or flag_projetado is null ) and ';
    

    
    $sql  .= '  ( ';
    $sql  .= '    concat(pe.ano,pe.mes) >= '.aspa($ano_inicio.$mes_inicio);
    $sql  .= '  ) and  ( ';
    $sql  .= '    concat(pe.ano,pe.mes) <= '.aspa($ano_final.$mes_final);
    $sql  .= '  ) ';
    
    
    
    //
    $sql  .= ' order by pe.ano, pe.mes';


  //  p($sql);



?>