<style>
.atende_tb{

}
.atende_gc{
   background:#ECF0F1;
   color:#000000;
   xborder-bottom:1px solid #000000;
   padding:5px;
}
.atende_gc_linha{
   background:#FFFFFF;
   color:#000000;
   xborder-bottom:1px solid #000000;
   padding:5px;
}


.atende_gc_s{

   background:#FFFFFF;
   color:#000000;
   border-bottom:1px solid #000000;
   padding:5px;
   text-align:center;
}
.atende_gc_linha_s1{
   background:#ECF0F1;
   color:#000000;
   padding:5px;
   text-align:center;
}

.atende_gc_linha_s{
   background:#FFFFFF;
   color:#000000;
   padding:5px;
   text-align:center;
}


div#topo {
   xxwidth:900px;
}
div#geral {
   xxwidth:900px;
}
table {
   width:100%;
}


.atende_gc_ti {
   xbackground:#ABBBBF;
   
   background:#C4C9CD;
   text-align:left;
   width:5%;

   color:#000000;
}
.atende_gc_li {
   background:#C4C9CD;
   text-align:left;
   width:45%;
   color:#FFFFFF;
}


</style>
<?php


if ($_REQUEST['idt_atendimento'] == '')
 	$idt_atendimento = 'vazio';
else
	$idt_atendimento = $_REQUEST['idt_atendimento'];

if ($_REQUEST['idt_projeto'] == '')
 	$idt_projeto = 'vazio';
else
	$idt_projeto = $_REQUEST['idt_projeto'];
	
if ($_REQUEST['idt_acao'] == '')
 	$idt_acao = 'vazio';
else
	$idt_acao = $_REQUEST['idt_acao'];
	
	
	
    $idt_instrumento_atual=0;
	//
    $sql = 'select ';
    $sql .= '  grc_a.idt_instrumento  ';
    $sql .= '  from  grc_atendimento grc_a';
    $sql .= '  where grc_a.idt = '.null($idt_atendimento);
    $rs = execsql($sql);
    if ($rs->rows == 0)
    {
    }
    else
    {
        ForEach ($rs->data as $row)
        {
            $idt_instrumento_atual = $row['idt_instrumento'];
        }
	}
	
	
	
	
	
	
	
    $sql = 'select ';
    $sql .= '  grc_p.descricao as grc_p_descricao,  ';
    $sql .= '  grc_p.gestor    as gestor,  ';
    $sql .= '  grc_ps.descricao as etapa,  ';
    $sql .= '  grc_pa.descricao as grc_pa_descricao  ';
    $sql .= '  from  grc_projeto grc_p';
    $sql .= "  left join grc_projeto_situacao grc_ps on grc_ps.idt = grc_p.idt_projeto_situacao ";
    $sql .= '  left join grc_projeto_acao grc_pa on grc_pa.idt_projeto = grc_p.idt';
    $sql .= '  where grc_pa.idt = '.null($idt_acao);
    $rs = execsql($sql);
    if ($rs->rows == 0)
    {
        // erro de achar projeto
        echo "ERRO achar projeto ação  ";
        echo "  idt_projeto = $idt_projeto ----   idt_acao = $idt_acao  ";

    }
    else
    {
        $grc_p_descricao='';
        ForEach ($rs->data as $row)
        {
            $grc_p_descricao   = $row['grc_p_descricao'];
            $gestor            = $row['gestor'];
            $etapa             = $row['etapa'];
            $grc_pa_descricao  = $row['grc_pa_descricao'];
        }
    }
    $html  = "";
    $html .=  "<table class='atende_tb' width='100%' border='0' cellspacing='0' cellpadding='0' vspace='0' hspace='0'> ";
    $html .=  "<tr  style='' >  ";
    $html .=  "   <td class='atende_gc_ti'   style='' >PROJETO:</td> ";
    $html .=  "   <td class='atende_gc_li'   style='' >$grc_p_descricao</td> ";
    $html .=  "   <td class='atende_gc_ti'   style='' >GESTOR:</td> ";
    $html .=  "   <td class='atende_gc_li'   style='' >$gestor</td> ";
    $html .=  "</tr>";
    $html .=  "<tr  style='' >  ";
    $html .=  "   <td class='atende_gc_ti'   style='' >AÇÃO:</td> ";
    $html .=  "   <td class='atende_gc_li'   style='' >{$grc_pa_descricao}</td> ";
    $html .=  "   <td class='atende_gc_ti'   style='' >FASE:</td> ";
    $html .=  "   <td class='atende_gc_li'   style='' >{$etapa}</td> ";
    $html .=  "</tr>";
    $html .=  "</table> ";
    //
    echo $html;
//
$vetInstrumento     = Array();
$vetInstrumento[1]  = 'Informação';
$vetInstrumento[2]  = 'Orientação Técnica';
$vetInstrumento[3]  = 'Consultoria';
$vetInstrumento[4]  = 'Cursor';
$vetInstrumento[5]  = 'Palestra';
$vetInstrumento[6]  = 'Oficina';
$vetInstrumento[7]  = 'Seminário';
$vetInstrumento[8]  = 'Missão/Caravana';
$vetInstrumento[9]  = 'Feira';
$vetInstrumento[10] = 'Rodada de Negócio';
//
$vetInstrumentoConv     = Array();
$vetInstrumentoConv[1]  = 4;  // CURSO
$vetInstrumentoConv[2]  = 3;  // CONSULTORIA
$vetInstrumentoConv[5]  = 1;  // INFORMAÇÃO
$vetInstrumentoConv[24] = 2;  // ORIENTAÇÃO TÉCNICA
$vetInstrumentoConv[30] = 8;  // Missão e Caravana
$vetInstrumentoConv[31] = 9;  // Feiras
$vetInstrumentoConv[32] = 10; // Rodada
$vetInstrumentoConv[33] = 5;  // Palestra
$vetInstrumentoConv[34] = 7;  // Seminário
$vetInstrumentoConv[35] = 6;  // Oficina


$vetInstrumentoConvrea=Array();
$vetInstrumentoConvrea[7]  = 4;  // CURSO  -
$vetInstrumentoConvrea[2]  = 3;  // CONSULTORIA -
$vetInstrumentoConvrea[8]  = 1;  // INFORMAÇÃO  -
$vetInstrumentoConvrea[13] = 2;  // ORIENTAÇÃO TÉCNICA -
$vetInstrumentoConvrea[3]  = 8;  // Missão e Caravana -
$vetInstrumentoConvrea[5]  = 9;  // Feiras -
$vetInstrumentoConvrea[6]  = 10; // Rodada -
$vetInstrumentoConvrea[4]  = 5;  // Palestra -
$vetInstrumentoConvrea[14] = 7;  // Seminário -
$vetInstrumentoConvrea[1]  = 6;  // Oficina   -



//
$vetInstrumento_abord = Array();
$vetInstrumento_abord[1]  = 'Individual';
$vetInstrumento_abord[2]  = 'Individual';
$vetInstrumento_abord[3]  = 'Individual';
$vetInstrumento_abord[4]  = 'Grupal';
$vetInstrumento_abord[5]  = 'Grupal';
$vetInstrumento_abord[6]  = 'Grupal';
$vetInstrumento_abord[7]  = 'Grupal';
$vetInstrumento_abord[8]  = 'Grupal';
$vetInstrumento_abord[9]  = 'Grupal';
$vetInstrumento_abord[10] = 'Grupal';

$vetInstrumento_atend=Array();
$vetInstrumento_atend[1]  = "";
$vetInstrumento_atend[2]  = "";
$vetInstrumento_atend[3]  = "";
$vetInstrumento_atend[4]  = "";
$vetInstrumento_atend[5]  = "";
$vetInstrumento_atend[6]  = "";
$vetInstrumento_atend[7]  = "";
$vetInstrumento_atend[8]  = "";
$vetInstrumento_atend[9]  = "";
$vetInstrumento_atend[10] = "";


$vetInstrumento_prev = Array();
$vetInstrumento_prev[1]  = 0;
$vetInstrumento_prev[2]  = 0;
$vetInstrumento_prev[3]  = 0;
$vetInstrumento_prev[4]  = 0;
$vetInstrumento_prev[5]  = 0;
$vetInstrumento_prev[6]  = 0;
$vetInstrumento_prev[7]  = 0;
$vetInstrumento_prev[8]  = 0;
$vetInstrumento_prev[9]  = 0;
$vetInstrumento_prev[10] = 0;

$vetInstrumento_rea     = Array();
$vetInstrumento_rea[1]  = 0;
$vetInstrumento_rea[2]  = 0;
$vetInstrumento_rea[3]  = 0;
$vetInstrumento_rea[4]  = 0;
$vetInstrumento_rea[5]  = 0;
$vetInstrumento_rea[6]  = 0;
$vetInstrumento_rea[7]  = 0;
$vetInstrumento_rea[8]  = 0;
$vetInstrumento_rea[9]  = 0;
$vetInstrumento_rea[10] = 0;

$vetInstrumentoAnalitico=Array();


$html   = "";





        if ($_SESSION[CS]['competencia']['erro']!= "Sem Competência Aberta")
        {
            $rowp = $_SESSION[CS]['competencia']['row'];
            $idt          = $rowp['idt'];
            $data_inicial = $rowp['data_inicial'];
            $data_final   = $rowp['data_final'];
            $ano          = $rowp['ano'];
            $mes          = $rowp['mes'];
            $texto        = $rowp['texto'];
            $fechado      = $rowp['fechado'];
            //
            $dt_iniw      = trata_data("01/01/{$ano}");
            $dt_fimw      = trata_data("21/12/{$ano}");
            //
        }

    //
    
    //$idt_acao=12788;
    
    //$idt_acao=30000;
    
    $vetMonitoraTab  = Array();
    $vetMonitoraTabRelacao  = Array();
    $vetMonitoraPrev = Array();
    $sql = 'select ';
    $sql .= '  siac_pam.*  ';
    $sql .= '  from  grc_projeto_acao_meta siac_pam';
    $sql .= '  where siac_pam.idt_projeto_acao = '.null($idt_acao);
    $sql .= '    and siac_pam.ano              = '.aspa($ano);

    $rs = execsql($sql);
    if ($rs->rows == 0)
    {
    }
    else
    {
        ForEach ($rs->data as $row)
        {
            $mes                       = $row['mes'];
            $ano                       = $row['ano'];
            $idt_instrumento           = $row['idt_instrumento'];
            $codigo_instrumento        = $row['codigo_instrumento'];
            
            if ($codigo_instrumento==23 or $codigo_instrumento==25 or $codigo_instrumento==27)
            {
                continue;
            }
            
            $instrumento               = $row['instrumento'];
            $codigo_metrica            = $row['codigo_metrica'];
            $metrica                   = $row['metrica'];
            $quantitativo              = $row['quantitativo'];
            $vetMonitoraTab[$codigo_instrumento] = $instrumento;
            $vetMonitoraPrev[$codigo_instrumento]= $vetMonitoraPrev[$codigo_instrumento]+$quantitativo;
            
            $vetInstrumento_prev[$vetInstrumentoConv[$codigo_instrumento]]=$vetInstrumento_prev[$vetInstrumentoConv[$codigo_instrumento]]+$quantitativo;
            
        }
    }





$sql   = "select ";
$sql  .= "    grc_atd.*,  ";
$sql  .= "    plu_usu.nome_completo as plu_usu_nome_completo, ";
$sql  .= "    gec_ent.descricao as grc_ent_descricao,  ";
$sql  .= "    grc_ai.descricao as grc_ai_descricao  ";
$sql  .= " from grc_atendimento as grc_atd ";
$sql  .= " left join plu_usuario plu_usu on plu_usu.id_usuario        = grc_atd.idt_consultor ";
$sql  .= " left join ".db_pir_gec."gec_entidade gec_ent on gec_ent.idt   = grc_atd.idt_cliente ";
$sql  .= " left join grc_atendimento_instrumento grc_ai on grc_ai.idt = grc_atd.idt_instrumento ";
$sql  .= ' where ';
$sql  .= " data >= ".aspa($dt_iniw)." and data <=  ".aspa($dt_fimw)." " ;
$sql  .= " and situacao = ".aspa('Finalizado');
$rs    = execsql($sql);
if ($rs->rows == 0)
{
}
else
{
    ForEach ($rs->data as $row)
    {
        $idt_instrumento = $row['idt_instrumento'];
        $vetInstrumento_rea[$vetInstrumentoConvrea[$idt_instrumento]]=$vetInstrumento_rea[$vetInstrumentoConvrea[$idt_instrumento]]+1;

    }
}




 
 
  $idt_instrumento_convatual = $vetInstrumentoConvrea[$idt_instrumento_atual];

 
 
 
 
 
 
 

$html1  = "";


$html1  .= " <div  style='width:100%; color:#000000;background:#2F66B8; xfloat:left; text-align:center; font-size:18px; color:#FFFFFF; bmargin-top:10px;  xborder-top:1px solid #000000; xborder-bottom:1px solid #000000; '>";
$html1  .= " MÉTRICAS ";
$html1  .= " </div> ";

$html1 .=  "<table class='atende_tb' width='100%' border='0' cellspacing='0' cellpadding='0' vspace='0' hspace='0'> ";

$html1 .=  "<tr  style='' >  ";
$html1 .=  "   <td class='atende_gc_s'   style='border-right:1px solid #000000; ' >Instrumentos</td> ";
$html1 .=  "   <td class='atende_gc_s'   style='' >Previsto(SGE)</td> ";
$html1 .=  "   <td class='atende_gc_s'   style='' >Realizado(GRC)</td> ";
$html1 .=  "   <td class='atende_gc_s'   style='' >%</td> ";
$html1 .=  "   <td class='atende_gc_s'   style=' border-left:1px solid #000000;  border-right:1px solid #000000;  ' >Instrumentos</td> ";
$html1 .=  "   <td class='atende_gc_s'   style='' >Previsto(SGE)</td> ";
$html1 .=  "   <td class='atende_gc_s'   style='' >Realizado(GRC)</td> ";
$html1 .=  "   <td class='atende_gc_s'   style='' >%</td> ";
$html1 .=  "</tr>";
//
$html1 .=  "<tr  style='' >  ";
// linha 1

for ($c = 0; $c < 5; $c++)
{
    $linha= $c+1;
    
    if ($linha==1 or $linha==3 or $linha==5)
    {
        $classw ='atende_gc_linha_s1';
    }
    else
    {
        $classw ='atende_gc_linha_s';
    }
    
    
    
    //
    $Instrumento   = $vetInstrumento[$linha];
    $Previsto      = format_decimal($vetInstrumento_prev[$linha],0);
    $Realizado     = format_decimal($vetInstrumento_rea[$linha],0);
    $Percentual    = "";
    if ($Previsto>0)
    {
        $Percentual = ($Realizado/$Previsto)*100;
        $Percentual = format_decimal($Percentual);
    }
    $simbolo = "";
    if ($idt_instrumento_convatual==$linha)
    {
        $simbolo = "<span style='color:#FF0000;'>!</span>";

    }
    //
    $html1 .=  "   <td class='{$classw}'   style='border-right:1px solid #000000;  ' >{$Instrumento}{$simbolo}</td> ";
    $html1 .=  "   <td class='{$classw}'   style='' >{$Previsto}</td> ";
    $html1 .=  "   <td class='{$classw}'   style='' >{$Realizado}</td> ";
    $html1 .=  "   <td class='{$classw}'   style='' >{$Percentual}</td> ";
    //
    $Instrumento   = $vetInstrumento[$linha+5];
    $Previsto      = format_decimal($vetInstrumento_prev[$linha+5],0);
    $Realizado     = format_decimal($vetInstrumento_rea[$linha+5],0);
    $Percentual    = "";
    if ($Previsto>0)
    {
        $Percentual = ($Realizado/$Previsto)*100;
        $Percentual = format_decimal($Percentual);
    }//
    $simbolo = "";
    if ($idt_instrumento_convatual==$linha)
    {
        $simbolo = "<span style='color:#FF0000;'>!</span>";

    }
    $html1 .=  "   <td class='{$classw}'   style='border-left:1px solid #000000; border-right:1px solid #000000;' >{$Instrumento}$simbolo</td> ";
    $html1 .=  "   <td class='{$classw}'   style='' >{$Previsto}</td> ";
    $html1 .=  "   <td class='{$classw}'   style='' >{$Realizado}</td> ";
    $html1 .=  "   <td class='{$classw}'   style='' >{$Percentual}</td> ";
    $html1 .=  "</tr>";
}








$html1 .=  "<tr  style='' >  ";
$html1 .=  "   <td colspan='8' class='atende_gc_sx'   style='border-top:1px solid #000000; ' ></td> ";
$html1 .=  "</tr>";




$html1 .=  "</table> ";







    
    
    
    echo $html1.$html;


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
function DetalhaAtendimento(CodCliente,DataHoraInicioRealizacao,linha)
{
   //alert(' Detalha o atendimento '+CodCliente+" Hora "+DataHoraInicioRealizacao);
   //
   // CHAMAR O DETALHAMENTO DO ATENDIMENTO
   //
   var str="";
   var titulo = "Detalhar Histórico de Atendimento. Aguarde...";
   processando_grc(titulo,'#2F66B8');

   $.post('ajax_atendimento.php?tipo=DetalharHistorico', {
      async: false,
      CodCliente                : CodCliente,
      DataHoraInicioRealizacao  : DataHoraInicioRealizacao,
      linha                     : linha
   }
   , function (str) {
       if  (str == '') {
            alert('Erro detalhar historico '+str);
            processando_acabou_grc();
       } else {
            var id='detalhehistr_'+linha;
            objtp = document.getElementById(id);
            if (objtp != null) {
                $(objtp).show();
            }
            var id='detalhehistd_'+linha;
            objtp = document.getElementById(id);
            if (objtp != null) {
                objtp.innerHTML=str;
            }
            processando_acabou_grc();
       }
   });



    return false;
}

function  FechaDetalhe(linha)
{
    var id='detalhehistr_'+linha;
    objtp = document.getElementById(id);
    if (objtp != null) {
        $(objtp).hide();
    }
}







</script>
