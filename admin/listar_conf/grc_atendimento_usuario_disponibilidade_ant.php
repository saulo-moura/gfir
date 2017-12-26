<style>
div#pendencia {
    background:#FFFFFF;
    color:#000000;
    width:100%;
    display:block;
    xheight:200px;
    display:none;
    xborder:1px solid #2F2FFF;
    float:left;
    border-bottom:2px solid #2F2FFF;
}

div#pendencia_cab {
    background:#004080;
    color:#FFFFFF;
    width:100%;
    xdisplay:block;
    height:25px;
    text-align:center;
    padding-top:5px;
}
div#pendencia_det {
    background:#FFFFFF;
    color:#FFFFFF;
    width:100%;
    text-align:center;
    padding-top:5px;
    border-bottom:2px solid #004080;

}
div#pendencia_com {
    background:#F1F1F1;
    color:#FFFFFF;
    width:100%;
    text-align:center;
    padding-top:5px;

}


.table_pendencia_linha {

}
.table_pendencia_celula_label {
    color:#000000;
    text-align:right;

}
.table_pendencia_celula_value {
    color:#000000;
    text-align:left;
}

div#instrumento {
    background:#FFFFFF;
    color:#000000;
    width:100%;
    display:block;
    xheight:200px;
    display:none;
    border-bottom:2px solid #2F2FFF;
    float:left;
}

div#instrumento_cab {
    background:#004080;
    color:#FFFFFF;
    width:100%;
    xdisplay:block;
    height:25px;
    text-align:center;
    padding-top:5px;
}
div#instrumento_det {
    background:#FFFFFF;
    color:#FFFFFF;
    width:100%;
    text-align:center;
    padding-top:5px;
    border-bottom:2px solid #004080;

}
div#instrumento_com {
    background:#F1F1F1;
    color:#FFFFFF;
    width:100%;
    text-align:center;
    padding-top:5px;

}


.table_instrumento_linha {

}
.table_instrumento_celula_label {
    color:#000000;
    text-align:right;

}
.table_instrumento_celula_value {
    color:#000000;
    text-align:left;
}

.bolax {
    border-radius: 50%;
    display: inline-block;
    height: 32px;
    width:  32px;
    border: 0px solid #000000;
    background-color: #FF0000;
}

.bola {
    xborder-radius: 50%;
    display: inline-block;
    height: 16px;
    width:  32px;
    border: 0px solid #000000;
    background-color: #FF0000;
}



.table_d {

}
.table_dc_linha {
    background:#2F66B8;
    color:#FFFFFF;
    text-align:center;
    border-bottom:1px solid #C0C0C0;
    border-right:1px solid #C0C0C0;
}

.table_dc_celula {
    background:#2F66B8;
    color:#FFFFFF;
    text-align:center;
    border-bottom:1px solid #C0C0C0;
    border-right:1px solid #C0C0C0;
	padding:5px;
}
.table_dc1_celula {
    background:#2F99B8;
    color:#FFFFFF;
    text-align:center;
    border-bottom:1px solid #C0C0C0;
    border-right:1px solid #C0C0C0;
	padding:5px;
}

.table_dl_linha {
    background:#FFFFFF;
    color:#000000;
    text-align:center;
    border-bottom:1px solid #C0C0C0;
    border-right:1px solid #C0C0C0;
}

.table_dl_celula {
    background:#FFFFFF;
    color:#000000;
    text-align:center;
    border-bottom:1px solid #C0C0C0;
    border-right:1px solid #C0C0C0;
	padding:5px;
}




.table_dr_linha {
    background:#2A5696;
    color:#FFFFFF;
    text-align:center;
    border-bottom:1px solid #C0C0C0;
    border-right:1px solid #C0C0C0;
}

.table_dr_celula {
    background:#2A5696;
    color:#FFFFFF;
    text-align:center;
    border-bottom:1px solid #C0C0C0;
    border-left:1px solid #C0C0C0;
	padding:5px;

}

.table_dr1_linha {
    background:#ABBBBF;
    color:#FFFFFF;
    text-align:center;
    border-bottom:1px solid #C0C0C0;
    border-right:1px solid #C0C0C0;
	padding:5px;

}

.table_dr1_celula {
    background:#ABBBBF;
    color:#FFFFFF;
    text-align:center;
    border-bottom:1px solid #C0C0C0;
    border-right:1px solid #C0C0C0;
	padding:5px;

}


</style>


<?php

//$tamdiv    = 57;
$tamdiv    = 65;
$tamdiv    = 100;

$largura   = 32;
$altura    = 32;


$largura   = 48;
$altura    = 48;


//$tamdiv    = 44;

//$tamdiv    = 48;

//$largura   = 32;
//$altura    = 32;


function DiferencaHoras($hora_inicial,$hora_final,$duracao,&$atendimentos)
{
    $difhora = 0;
    $vi = explode(':',$hora_inicial);
    $vf = explode(':',$hora_final);
    $im = ($vi[0] * 60) + $vi[1];
    $fm = ($vf[0] * 60) + $vf[1];
    
    $dm = $fm - $im;

    $dh = $dm / 60;
    
    $difhora = $dh;
    

    $atendimentos = ($dm / $duracao);

    return  $difhora;
}


$fsize     = '12px';

$tampadimg = $tamdiv-$largura;
$tamdiv    = $tamdiv.'px';
$tamlabel  = $tamdiv + $tampadimg;
$label     = $tamlabel.'px';
$pad       = $tampadimg.'px';
$padimg    = $tampadimg.'px';

$tit_1 = "A partir da disponibilidade do Consultor/atendende Gera Agenda para atendimento.\nPossibilita manter a agenda, Cancela Bloqueia e exclui. ";



$tit_2 = "Visualiza Disponibilidade.";
//
// estatística da fila de atendimentp
//
$veio = $_GET['veio'];


    $colorcab  ="#2C3E50";
    $colorh    ="#ABBBBF";

    $corativot ="#000000";
    $corativohe="#000000";
    $corativohp="#000000";
    $corativohm="#000000";
    /*
    if ($vetFiltro['tipofila']['valor']=='T')
    {
        $corativot="#FF0000";
    }

    if ($vetFiltro['tipofila']['valor']=='HE')
    {
        $corativohe="#FF0000";
    }
    if ($vetFiltro['tipofila']['valor']=='HP')
    {
        $corativohp="#FF0000";
    }
    if ($vetFiltro['tipofila']['valor']=='HM')
    {
        $corativohm="#FF0000";
    }
    */
    echo " <div  style='width:100%; color:#000000; float:left; border-top:1px solid #ABBBBF; border-bottom:1px solid #ABBBBF; '>";
	
	
    echo " <div onclick='return VisualizarDisponibilidade();' style='width:{$tamdiv}; color:#004080; font-size:14px; cursor:pointer; float:left;  margin-right:35px;  '>";
           echo "<div style='width:100px; float:left; padding:{$pad}; padding-top:5px; padding-bottom:5px; '   >";
           echo "<div style='width:35px; float:left;'><img width='{$largura}'  height='{$altura}'  title='{$tit_2}' src='imagens/disponibilidade.png' border='0'></div>";
           echo "</div>";
           echo "<div  title='{$tit_2}' style='color:{$corativot}; width:{$label};  overflow:auto; display:block; float:left; text-align:center; font-size:{$fsize};  '>";
           echo " Visualizar<br /> Disponibilidade";
           echo "</div>";
    echo " </div>";
	
	
    echo " <div onclick='return GeraAgenda();' style='width:{$tamdiv}; xcolor:#004080; font-size:14px; cursor:pointer; float:left;  margin-right:15px;  '>";
           echo "<div style='float:left; padding:{$pad}; padding-top:5px; padding-bottom:5px; '   >";
           echo " <img width='{$largura}'  height='{$altura}'  title='{$tit_1}' src='imagens/gerar_agenda.png' border='0'>";
           echo "</div>";

           echo "<div title='{$tit_1}' style='width:{$label};  overflow:auto; display:block; float:left; text-align:center; font-size:{$fsize};  '>";
           echo " Gerar e manter <br />Agenda para atendimento";
           echo "</div>";
    echo " </div>";
	
	
//&nbsp;
    echo " </div> ";
	
	
	
	

    echo " <div  id='disponibilidade_semanal' style='display:none; width:100%; color:#000000; float:left; border-top:1px solid #ABBBBF; border-bottom:1px solid #ABBBBF; '>";
    echo "<table class='table_d' width='100%' border='0' cellspacing='0' cellpadding='0' vspace='0' hspace='0'> ";
    
    echo "<tr class='table_dc_linha'> ";
    echo "   <td colspan='25' class='table_dc_celula' style='background:{$colorcab};'>DISPONIBILIDADE</td> ";
    echo "</tr>";

    
    
    
    echo "<tr class='table_dc_linha'> ";
    echo "   <td rowspan='2' class='table_dc_celula' >HORA<br />INICIO</td> ";
    echo "   <td colspan='3' class='table_dc_celula' >DOMINGO</td> ";
    echo "   <td colspan='3' class='table_dc_celula' >SEGUNDA</td> ";
    echo "   <td colspan='3' class='table_dc_celula' >TERÇA</td> ";
    echo "   <td colspan='3' class='table_dc_celula' >QUARTA</td> ";
    echo "   <td colspan='3' class='table_dc_celula' >QUINTA</td> ";
    echo "   <td colspan='3' class='table_dc_celula' >SEXTA</td> ";
    echo "   <td colspan='3' class='table_dc_celula' >SÁBADO</td> ";
    echo "   <td colspan='3' class='table_dc_celula' >TOTAL</td> ";
    echo "</tr>";
    
    echo "<tr class='table_dc_linha'> ";
    //echo "   <td rowspan='2' class='table_dc_celula' >HORA</td> ";
    // Domingo
    echo "   <td class='table_dc1_celula' >Horário</td> ";
    echo "   <td class='table_dc1_celula' >Hs</td> ";
    echo "   <td class='table_dc1_celula' >QtA</td> ";
    // Segunda
    echo "   <td class='table_dc1_celula' >Horário</td> ";
    echo "   <td class='table_dc1_celula' >Hs</td> ";
    echo "   <td class='table_dc1_celula' >QtA</td> ";
    // Terça
    echo "   <td class='table_dc1_celula' >Horário</td> ";
    echo "   <td class='table_dc1_celula' >Hs</td> ";
    echo "   <td class='table_dc1_celula' >QtA</td> ";
    // Quarta
    echo "   <td class='table_dc1_celula' >Horário</td> ";
    echo "   <td class='table_dc1_celula' >Hs</td> ";
    echo "   <td class='table_dc1_celula' >QtA</td> ";
    // Quinta
    echo "   <td class='table_dc1_celula' >Horário</td> ";
    echo "   <td class='table_dc1_celula' >Hs</td> ";
    echo "   <td class='table_dc1_celula' >QtA</td> ";
    // Sexta
    echo "   <td class='table_dc1_celula' >Horário</td> ";
    echo "   <td class='table_dc1_celula' >Hs</td> ";
    echo "   <td class='table_dc1_celula' >QtA</td> ";
    // Sábado
    echo "   <td class='table_dc1_celula' >Horário</td> ";
    echo "   <td class='table_dc1_celula' >Hs</td> ";
    echo "   <td class='table_dc1_celula' >QtA</td> ";
    
    // Total
    //echo "   <td class='table_dc_celula' >Horário</td> ";
    echo "   <td colspan='2' class='table_dc1_celula' >Hs</td> ";
    echo "   <td class='table_dc1_celula' >QtA</td> ";

    echo "</tr>";

    //
    // VETOR DA DISPONIBILIDADE DA PESSOA
    //
    $vetSemana=Array();
    /*
    $vetSemana[1]='';
    $vetSemana[2]='';
    $vetSemana[3]='';
    $vetSemana[4]='';
    $vetSemana[5]='';
    $vetSemana[6]='';
    $vetSemana[7]='';
    $vetSemana[8]='';
    */
    
    $vetSemanaTotal =Array();
    $vetSemanaTotalA=Array();
    $rs = execsql($sql_w);
    ForEach ($rs->data as $row) {
       $dia                 = $row['dia'];
       $num_dia             = $row['num_dia'];
       $hora_inicial        = $row['hora_inicial'];
       $hora_final          = $row['hora_final'];
       $duracao             = $row['duracao'];
       $ativo               = $row['ativo'];
       $difhora             = DiferencaHoras($hora_inicial,$hora_final,$duracao,$atendimentos);
       $row['difhora']      = $difhora;
       $row['atendimentos'] = $atendimentos;
       $hora_inicialw       = aspa($hora_inicial);
       $vetSemana[$hora_inicialw][$num_dia]=$row;
       $vetSemanaTotal[$num_dia]  = $vetSemanaTotal[$num_dia]  + $difhora;
       $vetSemanaTotalA[$num_dia] = $vetSemanaTotalA[$num_dia] + $atendimentos;
    }
    ksort($vetSemana);
    //
    // mostrar Horários
    //
    $HoraAnt='###';
    $VetLinhaP=Array();
    $VetLinhaP[0]="&nbsp;";
    $VetLinhaP[1]="&nbsp;";
    $VetLinhaP[2]="&nbsp;";
    $VetLinhaP[3]="&nbsp;";
    $VetLinhaP[4]="&nbsp;";
    $VetLinhaP[5]="&nbsp;";
    $VetLinhaP[6]="&nbsp;";
    $VetLinhaP[7]="&nbsp;";
    $VetLinhaP[8]="&nbsp;";
    $VetLinha   = $VetLinhaP;
    $VetLinhaH  = $VetLinhaP;
    $VetLinhaA  = $VetLinhaP;
    ForEach ($vetSemana as $Hora => $VetNumDia)
    {

       if ($HoraAnt!=$Hora and $HoraAnt!='###')
       {    // gera Linha
            $c1 = $VetLinha[1];
            $c2 = $VetLinha[2];
            $c3 = $VetLinha[3];
            $c4 = $VetLinha[4];
            $c5 = $VetLinha[5];
            $c6 = $VetLinha[6];
            $c7 = $VetLinha[7];
            $c8 = $VetLinha[8];
            
            $ch1 = $VetLinhaH[1];
            $ch2 = $VetLinhaH[2];
            $ch3 = $VetLinhaH[3];
            $ch4 = $VetLinhaH[4];
            $ch5 = $VetLinhaH[5];
            $ch6 = $VetLinhaH[6];
            $ch7 = $VetLinhaH[7];
            $ch8 = $ch1+$ch2+$ch3+$ch4+$ch5+$ch6+$ch7;

            $ca1 = $VetLinhaA[1];
            $ca2 = $VetLinhaA[2];
            $ca3 = $VetLinhaA[3];
            $ca4 = $VetLinhaA[4];
            $ca5 = $VetLinhaA[5];
            $ca6 = $VetLinhaA[6];
            $ca7 = $VetLinhaA[7];
            $ca8 = $ca1+$ca2+$ca3+$ca4+$ca5+$ca6+$ca7;


            $ca1t = format_decimal($ca1,2);
            $ca2t = format_decimal($ca2,2);
            $ca3t = format_decimal($ca3,2);
            $ca4t = format_decimal($ca4,2);
            $ca5t = format_decimal($ca5,2);
            $ca6t = format_decimal($ca6,2);
            $ca7t = format_decimal($ca7,2);
            $ca8t = format_decimal($ca8,2);



            $HoraAntw = str_replace("'"," ",$HoraAnt);
            echo "<tr class='table_dr_linha'> ";
            echo "   <td class='table_dl_celula' style='background:{$colorh}; color:#FFFFFF; ' >{$HoraAntw}</td> ";
            echo "   <td class='table_dl_celula' >{$c1}</td> ";
            echo "   <td class='table_dl_celula' >{$ch1}</td> ";
            echo "   <td class='table_dl_celula' >{$ca1t}</td> ";
            echo "   <td class='table_dl_celula' >{$c2}</td> ";
            echo "   <td class='table_dl_celula' >{$ch2}</td> ";
            echo "   <td class='table_dl_celula' >{$ca2t}</td> ";
            echo "   <td class='table_dl_celula' >{$c3}</td> ";
            echo "   <td class='table_dl_celula' >{$ch3}</td> ";
            echo "   <td class='table_dl_celula' >{$ca3t}</td> ";
            echo "   <td class='table_dl_celula' >{$c4}</td> ";
            echo "   <td class='table_dl_celula' >{$ch4}</td> ";
            echo "   <td class='table_dl_celula' >{$ca4t}</td> ";
            echo "   <td class='table_dl_celula' >{$c5}</td> ";
            echo "   <td class='table_dl_celula' >{$ch5}</td> ";
            echo "   <td class='table_dl_celula' >{$ca5t}</td> ";
            echo "   <td class='table_dl_celula' >{$c6}</td> ";
            echo "   <td class='table_dl_celula' >{$ch6}</td> ";
            echo "   <td class='table_dl_celula' >{$ca6t}</td> ";
            echo "   <td class='table_dl_celula' >{$c7}</td> ";
            echo "   <td class='table_dl_celula' >{$ch7}</td> ";
            echo "   <td class='table_dl_celula' >{$ca7t}</td> ";
           // echo "   <td class='table_dl_celula' >{$c8}</td> ";
            echo "   <td colspan='2' class='table_dl_celula' >{$ch8}</td> ";
            echo "   <td class='table_dl_celula' >{$ca8t}</td> ";
            echo "</tr>";
            $HoraAnt     = $Hora;
            $VetLinha    = $VetLinhaP;
            $VetLinhaH   = $VetLinhaP;
            $VetLinhaA   = $VetLinhaP;
       }
       if ($HoraAnt=='###')
       {
           $HoraAnt    = $Hora;
       }
       ForEach ($VetNumDia as $NumDia => $row)
       {
           $dia                 = $row['dia'];
           $num_dia             = $row['num_dia'];
           $hora_inicial        = $row['hora_inicial'];
           $hora_final          = $row['hora_final'];
           $duracao             = $row['duracao'];
           $ativo               = $row['ativo'];
           $difhora             = $row['difhora'];
           $atendimentos        = $row['atendimentos'];
           //$VetLinha[$NumDia]   = $hora_inicial.' - '.$hora_final.' - '.$difhora.' ['.$atendimentos.']';
           $VetLinha[$NumDia]   = $hora_inicial.' - '.$hora_final;
           $VetLinhaH[$NumDia]  = $difhora;
           $VetLinhaA[$NumDia]  = $atendimentos;
       }
    }
    
    
       if ($HoraAnt!='###')
       {    // gera Linha
            $c1 = $VetLinha[1];
            $c2 = $VetLinha[2];
            $c3 = $VetLinha[3];
            $c4 = $VetLinha[4];
            $c5 = $VetLinha[5];
            $c6 = $VetLinha[6];
            $c7 = $VetLinha[7];
            $c8 = $VetLinha[8];

            $ch1 = $VetLinhaH[1];
            $ch2 = $VetLinhaH[2];
            $ch3 = $VetLinhaH[3];
            $ch4 = $VetLinhaH[4];
            $ch5 = $VetLinhaH[5];
            $ch6 = $VetLinhaH[6];
            $ch7 = $VetLinhaH[7];
            $ch8 = $ch1+$ch2+$ch3+$ch4+$ch5+$ch6+$ch7;

            $ca1 = $VetLinhaA[1];
            $ca2 = $VetLinhaA[2];
            $ca3 = $VetLinhaA[3];
            $ca4 = $VetLinhaA[4];
            $ca5 = $VetLinhaA[5];
            $ca6 = $VetLinhaA[6];
            $ca7 = $VetLinhaA[7];
            $ca8 = $ca1+$ca2+$ca3+$ca4+$ca5+$ca6+$ca7;



            $ca1t = format_decimal($ca1,2);
            $ca2t = format_decimal($ca2,2);
            $ca3t = format_decimal($ca3,2);
            $ca4t = format_decimal($ca4,2);
            $ca5t = format_decimal($ca5,2);
            $ca6t = format_decimal($ca6,2);
            $ca7t = format_decimal($ca7,2);
            $ca8t = format_decimal($ca8,2);



            $HoraAntw = str_replace("'"," ",$HoraAnt);
            echo "<tr class='table_dr_linha'> ";
            echo "   <td class='table_dl_celula' style='background:{$colorh}; color:#FFFFFF;' >{$HoraAntw}</td> ";
            echo "   <td class='table_dl_celula' >{$c1}</td> ";
            echo "   <td class='table_dl_celula' >{$ch1}</td> ";
            echo "   <td class='table_dl_celula' >{$ca1t}</td> ";
            echo "   <td class='table_dl_celula' >{$c2}</td> ";
            echo "   <td class='table_dl_celula' >{$ch2}</td> ";
            echo "   <td class='table_dl_celula' >{$ca2t}</td> ";
            echo "   <td class='table_dl_celula' >{$c3}</td> ";
            echo "   <td class='table_dl_celula' >{$ch3}</td> ";
            echo "   <td class='table_dl_celula' >{$ca3t}</td> ";
            echo "   <td class='table_dl_celula' >{$c4}</td> ";
            echo "   <td class='table_dl_celula' >{$ch4}</td> ";
            echo "   <td class='table_dl_celula' >{$ca4t}</td> ";
            echo "   <td class='table_dl_celula' >{$c5}</td> ";
            echo "   <td class='table_dl_celula' >{$ch5t}</td> ";
            echo "   <td class='table_dl_celula' >{$ca5}</td> ";
            echo "   <td class='table_dl_celula' >{$c6}</td> ";
            echo "   <td class='table_dl_celula' >{$ch6}</td> ";
            echo "   <td class='table_dl_celula' >{$ca6t}</td> ";
            echo "   <td class='table_dl_celula' >{$c7}</td> ";
            echo "   <td class='table_dl_celula' >{$ch7}</td> ";
            echo "   <td class='table_dl_celula' >{$ca7t}</td> ";
            //echo "   <td class='table_dl_celula' >{$c8}</td> ";
            echo "   <td colspan='2' class='table_dl_celula' >{$ch8}</td> ";
            echo "   <td class='table_dl_celula' >{$ca8t}</td> ";
            echo "</tr>";
            $HoraAnt     = $Hora;
            $VetLinha    = $VetLinhaP;
            $VetLinhaH   = $VetLinhaP;
            $VetLinhaA   = $VetLinhaP;
       }

    
    
    
    $to1h = format_decimal($vetSemanaTotal[1],2);
    $to2h = format_decimal($vetSemanaTotal[2],2);
    $to3h = format_decimal($vetSemanaTotal[3],2);
    $to4h = format_decimal($vetSemanaTotal[4],2);
    $to5h = format_decimal($vetSemanaTotal[5],2);
    $to6h = format_decimal($vetSemanaTotal[6],2);
    $to7h = format_decimal($vetSemanaTotal[7],2);
    
    $TOTH = $vetSemanaTotal[1]+$vetSemanaTotal[2]+$vetSemanaTotal[3]+$vetSemanaTotal[4]+$vetSemanaTotal[5]+$vetSemanaTotal[6]+$vetSemanaTotal[7];

    $to8h = format_decimal($TOTH,2);

/*
    echo "<tr class='table_dr_linha'> ";
    echo "   <td class='table_dr_celula' >TOTAL HORAS</td> ";
    echo "   <td class='table_dr_celula' >{$to1}</td> ";
    echo "   <td class='table_dr_celula' >{$to2}</td> ";
    echo "   <td class='table_dr_celula' >{$to3}</td> ";
    echo "   <td class='table_dr_celula' >{$to4}</td> ";
    echo "   <td class='table_dr_celula' >{$to5}</td> ";
    echo "   <td class='table_dr_celula' >{$to6}</td> ";
    echo "   <td class='table_dr_celula' >{$to7}</td> ";
    echo "   <td class='table_dr_celula' >{$to8}</td> ";
    echo "</tr>";
*/

    $to1 = format_decimal($vetSemanaTotalA[1],2);
    $to2 = format_decimal($vetSemanaTotalA[2],2);
    $to3 = format_decimal($vetSemanaTotalA[3],2);
    $to4 = format_decimal($vetSemanaTotalA[4],2);
    $to5 = format_decimal($vetSemanaTotalA[5],2);
    $to6 = format_decimal($vetSemanaTotalA[6],2);
    $to7 = format_decimal($vetSemanaTotalA[7],2);
    
    $TOT = $vetSemanaTotalA[1]+$vetSemanaTotalA[2]+$vetSemanaTotalA[3]+$vetSemanaTotalA[4]+$vetSemanaTotalA[5]+$vetSemanaTotalA[6]+$vetSemanaTotalA[7];

    $to8 = format_decimal($TOT,2);


    echo "<tr class='table_dr_linha'> ";
    echo "   <td class='table_dr_celula' >TOTAL</td> ";
    echo "   <td class='table_dr_celula' >&nbsp;</td> ";
    echo "   <td class='table_dr_celula' >{$to1h}</td> ";
    echo "   <td class='table_dr_celula' >{$to1}</td> ";
    echo "   <td class='table_dr_celula' >&nbsp;</td> ";
    echo "   <td class='table_dr_celula' >{$to2h}</td> ";
    echo "   <td class='table_dr_celula' >{$to2}</td> ";
    echo "   <td class='table_dr_celula' >&nbsp;</td> ";
    echo "   <td class='table_dr_celula' >{$to3h}</td> ";
    echo "   <td class='table_dr_celula' >{$to3}</td> ";
    echo "   <td class='table_dr_celula' >&nbsp;</td> ";
    echo "   <td class='table_dr_celula' >{$to4h}</td> ";
    echo "   <td class='table_dr_celula' >{$to4}</td> ";
    echo "   <td class='table_dr_celula' >&nbsp;</td> ";
    echo "   <td class='table_dr_celula' >{$to5h}</td> ";
    echo "   <td class='table_dr_celula' >{$to5}</td> ";
    echo "   <td class='table_dr_celula' >&nbsp;</td> ";
    echo "   <td class='table_dr_celula' >{$to6h}</td> ";
    echo "   <td class='table_dr_celula' >{$to6}</td> ";
    echo "   <td class='table_dr_celula' >&nbsp;</td> ";
    echo "   <td class='table_dr_celula' >{$to7h}</td> ";
    echo "   <td class='table_dr_celula' >{$to7}</td> ";
    //echo "   <td class='table_dr_celula' >&nbsp;</td> ";
    echo "   <td colspan='2' class='table_dr_celula' >{$to8h}</td> ";
    echo "   <td class='table_dr_celula' >{$to8}</td> ";
    echo "</tr>";


    $tom1 = "";
    $tom2 = "";
    $tom3 = "";
    $tom4 = "";
    $tom5 = "";
    $tom6 = "";
    $tom7 = "";

    if ($vetSemanaTotalA[1]>0)
    {
        $tom1 = ($vetSemanaTotal[1] / $vetSemanaTotalA[1]);
    }
    if ($vetSemanaTotalA[2]>0)
    {
        $tom2 = ($vetSemanaTotal[2] / $vetSemanaTotalA[2]);
    }
    if ($vetSemanaTotalA[3]>0)
    {
        $tom3 = ($vetSemanaTotal[3] / $vetSemanaTotalA[3]);
    }
    if ($vetSemanaTotalA[4]>0)
    {
        $tom4 = ($vetSemanaTotal[4] / $vetSemanaTotalA[4]);
    }
    if ($vetSemanaTotalA[5]>0)
    {
        $tom5 = ($vetSemanaTotal[5] / $vetSemanaTotalA[5]);
    }
    if ($vetSemanaTotalA[6]>0)
    {
        $tom6 = ($vetSemanaTotal[6] / $vetSemanaTotalA[6]);
    }
    if ($vetSemanaTotalA[7]>0)
    {
        $tom7 = ($vetSemanaTotal[7] / $vetSemanaTotalA[7]);
    }
    $to1 = format_decimal($tom1,2);
    $to2 = format_decimal($tom2,2);
    $to3 = format_decimal($tom3,2);
    $to4 = format_decimal($tom4,2);
    $to5 = format_decimal($tom5,2);
    $to6 = format_decimal($tom6,2);
    $to7 = format_decimal($tom7,2);

    $TOTH = $vetSemanaTotal[1]+$vetSemanaTotal[2]+$vetSemanaTotal[3]+$vetSemanaTotal[4]+$vetSemanaTotal[5]+$vetSemanaTotal[6]+$vetSemanaTotal[7];
    $TOTA = $vetSemanaTotalA[1]+$vetSemanaTotalA[2]+$vetSemanaTotalA[3]+$vetSemanaTotalA[4]+$vetSemanaTotalA[5]+$vetSemanaTotalA[6]+$vetSemanaTotalA[7];

    $to8='';
    if ($TOTA>0)
    {
        $tom8 = ($TOTH / $TOTA);
    }

    $to8 = format_decimal($tom8,2);


    echo "<tr class='table_dr_linha'> ";
    echo "   <td class='table_dr1_celula' >TMA</td> ";
    echo "   <td colspan='3' class='table_dr1_celula' >{$to1}</td> ";
    echo "   <td colspan='3' class='table_dr1_celula' >{$to2}</td> ";
    echo "   <td colspan='3' class='table_dr1_celula' >{$to3}</td> ";
    echo "   <td colspan='3' class='table_dr1_celula' >{$to4}</td> ";
    echo "   <td colspan='3' class='table_dr1_celula' >{$to5}</td> ";
    echo "   <td colspan='3' class='table_dr1_celula' >{$to6}</td> ";
    echo "   <td colspan='3' class='table_dr1_celula' >{$to7}</td> ";
    echo "   <td colspan='3' class='table_dr1_celula' >{$to8}</td> ";
    echo "</tr>";






echo "</table >";

//p($vetSemana);






    echo " </div> ";

?>
<script>
$(document).ready(function () {

/*
           objd=document.getElementById('tipo_pessoa_desc');
           if (objd != null)
           {
               $(objd).css('visibility','hidden');
           }
           objd=document.getElementById('tipo_pessoa');
           if (objd != null)
           {
               objd.value = "";
               $(objd).css('visibility','hidden');
           }
*/
});

function GeraAgenda()
{
  // if (!confirm('ATENÇÃO...'+"\n"+'Se Confirmar a Agenda será Gerada de acordo com a disponibilidade.'+"\n"+'Confirma?'))
  // {
  //      return false;
  // }
   
   self.location = 'conteudo.php?prefixo=cadastro&id=0&acao=inc&menu=grc_atendimento_gera_agenda&disponibilidade=S';
   
   /*
   var str="";
   var titulo = "Processando Gerar Agenda. Aguarde...";
   processando_grc(titulo,'#2F66B8');

   $.post('ajax_atendimento.php?tipo=GerarAgendaDisponibilidade', {
      async: false,
      idt_atendimento  : idt_atendimento,
      data_solucao     : data_solucao,
      observacao       : observacao
   }
   , function (str) {
       if (str == '') {
           processando_acabou_grc();
           //btFechaCTC($('#grc_atendimento_pendencia').data('session_cod'));
       } else {
           alert(str);
           processando_acabou_grc();
       }
   });
   */
    
    return false;
}
function VisualizarDisponibilidade()
{
    //alert('VisualizarDisponibilidade');
    var id='disponibilidade_semanal';
    objd=document.getElementById(id);
    if (objd != null)
    {
       objd.value = "";
       $(objd).toggle();
    }

   
    return false;
}

</script>