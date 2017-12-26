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

</style>


<?php

//$tamdiv    = 57;
$tamdiv    = 65;
$tamdiv    = 85;

$largura   = 32;
$altura    = 32;

//$tamdiv    = 44;

//$tamdiv    = 48;

//$largura   = 32;
//$altura    = 32;


$fsize     = '11px';

$tampadimg = $tamdiv-$largura;
$tamdiv    = $tamdiv.'px';
$tamlabel  = $tamdiv + $tampadimg;
$label     = $tamlabel.'px';
$pad       = $tampadimg.'px';
$padimg    = $tampadimg.'px';

$tit_1 = "Permite chamar próximo da fila de acordo com funcionalidade definida.";
$tit_3 = "Visualiza Fila de Hora Extra - Convencional.";
$tit_4 = "Visualiza Fila de Hora Extra - Prioridade.";
$tit_5 = "Visualiza Fila de Hora Marcada.";

$tit_p = "Guichê de Chamada no Painel. Clique aqui para modificar Guichê de Atendimento.";
//
// estatística da fila de atendimentp
//
$veio = $_GET['veio'];


if ($veio==10 or $veio==13 or $veio==14)
{

    $HM = 0;
    $HE = 0;
    $HP = 0;
    $T  = 0;
    $rs = execsql($sql_w);


    ForEach ($rs->data as $row) {
       $senha_totem = $row['senha_totem'];
       if (substr($senha_totem,0,2)=='EX')
       {
           $HE = $HE + 1;
       }
       if (substr($senha_totem,0,2)=='EP')
       {
           $HP = $HP + 1;
       }
       if (substr($senha_totem,0,1)=='H')
       {
           $HM = $HM + 1;
       }
       $T  = $T  + 1;
    }



    $corativot ="#000000";
    $corativohe="#000000";
    $corativohp="#000000";
    $corativohm="#000000";
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

    echo " <div  style='width:100%; color:#000000; float:left; border-top:1px solid #ABBBBF; border-bottom:1px solid #ABBBBF; '>";

    if ($veio==10)
    {
        echo " <div onclick='return ChamarProximo();' style='width:{$tamdiv}; color:#004080; font-size:14px; cursor:pointer; float:left;  margin-right:15px;  '>";
               echo "<div style='float:left; padding:{$pad}; padding-top:5px; padding-bottom:5px; '   >";
               echo " <img width='{$largura}'  height='{$altura}'  title='{$tit_1}' src='imagens/chamar_proximo.png' border='0'>";
               echo "</div>";

               echo "<div title='{$tit_1}' style='width:{$label};  overflow:auto; display:block; float:left; text-align:center; font-size:{$fsize};  '>";
               echo " Chamar Próximo";
               echo "</div>";

        echo " </div>";
    }
//&nbsp;
    echo " <div onclick='return FilaTodas();' style='width:{$tamdiv}; color:#004080; font-size:14px; cursor:pointer; float:left;  margin-right:15px;  '>";
           echo "<div style='width:100px; float:left; padding:{$pad}; padding-top:5px; padding-bottom:5px; '   >";
           echo "<div style='width:35px; float:left;'><img width='{$largura}'  height='{$altura}'  title='{$tit_2}' src='imagens/fila.png' border='0'></div><div class='bola' style='color:#FFFFFF; float:left; text-align:center;'>{$T}</div>";
           echo "</div>";

           echo "<div  title='{$tit_2}' style='color:{$corativot}; width:{$label};  overflow:auto; display:block; float:left; text-align:center; font-size:{$fsize};  '>";
           echo " Fila Completa";
           echo "</div>";


    echo " </div>";



    echo " <div onclick='return FilaExtraConvencional();' style='width:{$tamdiv}; color:#004080; font-size:14px; cursor:pointer; float:left;  margin-right:15px;  '>";
           echo "<div style='width:100px; float:left; padding:{$pad}; padding-top:5px; padding-bottom:5px; '   >";
           echo " <div style='width:35px; float:left;'><img width='{$largura}'  height='{$altura}'  title='{$tit_2}' src='imagens/fila.png' border='0'></div><div class='bola' style='color:#FFFFFF; float:left; text-align:center;'>{$HE}</div>";
           echo "</div>";

           echo "<div  title='{$tit_3}' style='color:{$corativohe}; width:{$label};  overflow:auto; display:block; float:left; text-align:center; font-size:{$fsize};  '>";
           echo " Fila Extra<br />Convencional";
           echo "</div>";




    echo " </div>";



    echo " <div onclick='return FilaExtraPrioridade({$idt_atendimento});' style='width:{$tamdiv}; color:#004080; font-size:14px; cursor:pointer; float:left;  margin-right:15px;  '>";
           echo "<div style='width:100px; float:left; padding:{$pad}; padding-top:5px; padding-bottom:5px;   '   >";
           echo " <div style='width:35px; float:left;'><img width='{$largura}'  height='{$altura}'  title='{$tit_3}' src='imagens/fila.png' border='0'></div><div class='bola' style='color:#FFFFFF; float:left; text-align:center;'>{$HP}</div>";
           echo "</div>";

           echo "<div title='{$tit_4}' style='color:{$corativohp}; width:{$label};  overflow:auto; display:block; float:left; text-align:center; font-size:{$fsize};  '>";
           echo " Fila Extra<br />Prioridade";
           echo "</div>";

    echo " </div>";


    echo " <div onclick='return FilaHoraMarcada();' style='width:{$tamdiv}; color:#004080; font-size:14px; cursor:pointer; float:left;  margin-right:15px;  '>";
           echo "<div style='width:100px; float:left; padding:{$pad}; padding-top:5px; padding-bottom:5px;   '   >";
           echo " <div style='width:35px; float:left;'><img width='{$largura}'  height='{$altura}'  title='{$tit_3}' src='imagens/fila.png' border='0'></div><div class='bola' style='color:#FFFFFF; float:left; text-align:center;'>{$HM}</div>";
           echo "</div>";

           echo "<div title='{$tit_5}' style='color:{$corativohm}; width:{$label};  overflow:auto; display:block; float:left; text-align:center; font-size:{$fsize};  '>";
           echo " Fila Hora <br />Marcada";
           echo "</div>";

    echo " </div>";



    if ($_SESSION[CS]['grc_ab_descricao']=="")
    {
        $sql  = 'select ';
        $sql .= '  grc_ab.codigo as grc_ab_codigo,  ';
        $sql .= '  grc_ab.descricao as grc_ab_descricao  ';
        $sql .= '  from  grc_atendimento_pa_pessoa grc_app ';
        $sql .= '  inner join grc_atendimento_box grc_ab on grc_ab.idt = grc_app.idt_box ';
        $sql .= '  where grc_app.idt_usuario = '.null($_SESSION[CS]['g_id_usuario']);
        $sql .= '    and grc_app.idt_ponto_atendimento = '.null($_SESSION[CS]['g_idt_unidade_regional']);
        $rs   = execsql($sql);
        if ($rs->rows == 0)
        {
        }
        else
        {
            ForEach ($rs->data as $row)
            {
                $grc_ab_descricao = $row['grc_ab_descricao'];
                $_SESSION[CS]['grc_ab_descricao']=$grc_ab_descricao;
            }
        }
    }
    echo " <div onclick='return ChamaParametros();' style='width:{$tamdiv}; color:#004080; font-size:14px; cursor:pointer; float:left;  margin-right:15px;  '>";
           echo "<div style='width:100px; float:left; padding:{$pad}; padding-top:5px; padding-bottom:5px;   '   >";
           echo " <div style='width:35px; float:left;'><img width='{$largura}'  height='{$altura}'  title='{$tit_p}' src='imagens/parametro_presencial.png' border='0'></div>";
           echo "</div>";
           echo "<div title='{$tit_5}' style='color:{$corativohm}; width:{$label};  overflow:auto; display:block; float:left; text-align:center; font-size:{$fsize};  '>";
           echo " Guichê <br />".$_SESSION[CS]['grc_ab_descricao'];
           echo "</div>";
    echo " </div>";
    echo " </div> ";
}

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

function ChamarProximo()
{
    alert('Falta definição do processo.');
    return false;
}
function FilaExtraConvencional()
{
   // alert('Mostra fila extra convencional');
   var id='tipoFila6';
   objtp = document.getElementById(id);
   if (objtp != null) {
       objtp.value="HE";
    }
   // alert('Mostra fila extra convencional'+objtp.value);

    document.frm.submit();
    
    return false;
}

function FilaExtraPrioridade()
{
   // alert('Mostra fila extra convencional');
   var id='tipoFila6';
   objtp = document.getElementById(id);
   if (objtp != null) {
       objtp.value="HP";
   }
   document.frm.submit();
}

function FilaHoraMarcada()
{
  //  alert('Mostra fila hora extra marcada');
   var id='tipoFila6';
   objtp = document.getElementById(id);
   if (objtp != null) {
       objtp.value="HM";
   }
   else
   {
      alert('sem obj tipofila');
   }
   document.frm.submit();

    return false;
    
}
function FilaTodas()
{
  // alert('Mostra Todas as filas');
   var id='tipoFila6';
   objtp = document.getElementById(id);
   if (objtp != null) {
       objtp.value="T";
   }
   
   // alert('Mostra Todas as filas'+objtp.value);
   
   document.frm.submit();

    return false;

}


function ConfirmaAlterarInstrumento(idt_atendimento)
{
//   alert(' Alterar Instrumento '+idt_atendimento);
   var id='instrumento';
   objtp = document.getElementById(id);
   if (objtp != null) {
       $(objtp).show();
    }

}
function instrumento_fecha()
{
   var id='instrumento';
   objtp = document.getElementById(id);
   if (objtp != null) {
       $(objtp).hide();
   }
}
function instrumento_salvar()
{
  // alert(' Slavar Instrumento');

   //
   // pegar campos do formulário e enviar para gravação
   //

   var idt_troca_instrumento = '';
   var id='troca_instrumento';
   objtp = document.getElementById(id);
   if (objtp != null) {
       idt_troca_instrumento = objtp.value;
   }


   alert(' troca_instrumento '+ idt_troca_instrumento );

   if (idt_troca_instrumento=='')
   {
       alert('Favor informar o novo Instrumento para troca.');
       return false;
   }

   var str="";
   var titulo = "Processando Salvar Instrumento. Aguarde...";
   processando_grc(titulo,'#2F66B8');

   $.post('ajax_atendimento.php?tipo=SalvarInstrumento', {
      async: false,
      idt_atendimento       : idt_atendimento,
      idt_troca_instrumento : idt_troca_instrumento
   }
   , function (str) {
       if (str == '') {
           processando_acabou_grc();
       } else {
           alert(str);
           processando_acabou_grc();
       }
   });
   var id='instrumento';
   objtp = document.getElementById(id);
   if (objtp != null) {
       $(objtp).hide();
   }
   window.location.reload();
}




function ConfirmaMonitoramento(idt_atendimento)
{
   alert(' vivo estou Monitoramento '+idt_atendimento);
    /*
   var id='tipo_pessoa';
   objtp = document.getElementById(id);
   if (objtp != null) {
       objtp.value = 'S';
    }
*/
}

function ConfirmaPendencia(idt_atendimento)
{
 //  alert(' Pendencias '+idt_atendimento);
   var id='pendencia';
   objtp = document.getElementById(id);
   if (objtp != null) {
       $(objtp).show();
    }
}

function pendencia_fecha()
{
   var id='pendencia';
   objtp = document.getElementById(id);
   if (objtp != null) {
       $(objtp).hide();
   }
}
function pendencia_salvar()
{
   alert(' Slavar pendência');

   //
   // pegar campos do formulário e enviar para gravação
   //

   var data_solucao = '';
   var id='data_solucao';
   objtp = document.getElementById(id);
   if (objtp != null) {
       data_solucao = objtp.value;
   }

   var observacao = '';
   var id='observacao';
   objtp = document.getElementById(id);
   if (objtp != null) {
       observacao = objtp.value;
   }

//   alert(' data_solucao '+data_solucao + ' observacao '+observacao );

   $erros = "";
   if (data_solucao=='')
   {
       $erros = 'Favor informar a Data para Solução da pendência.'+"\n";
   }
   if (observacao=='')
   {
       $erros = 'Favor informar o texto da Pendência.'+"\n";
   }
   if ($erros!='')
   {
       alert($erros);
       return false;
   }
   var str="";
   var titulo = "Processando Salvar Pendência. Aguarde...";
   processando_grc(titulo,'#2F66B8');

   $.post('ajax_atendimento.php?tipo=SalvarPendencia', {
      async: false,
      idt_atendimento  : idt_atendimento,
      data_solucao     : data_solucao,
      observacao       : observacao
   }
   , function (str) {
       if (str == '') {
           processando_acabou_grc();
           btFechaCTC($('#grc_atendimento_pendencia').data('session_cod'));
       } else {
           alert(str);
           processando_acabou_grc();
       }
   });
   var id='pendencia';
   objtp = document.getElementById(id);
   if (objtp != null) {
       $(objtp).hide();
   }

}


function ConfirmaVincular_pj(idt_atendimento)
{
   alert(' Vincular PJ '+idt_atendimento);
   var sessao = $('#grc_atendimento_organizacao').data('session_cod');
   btClickCTC(idt_atendimento, 'inc', 0, 'cadastro', 'grc_atendimento_organizacao', sessao , 'EMPREENDIMENTO - PESSOA JURÍDICA');

}

function ConfirmaMaisPessoas(idt_atendimento)
{
  // alert(' + Pessoas '+idt_atendimento);
   var sessao = $('#grc_atendimento_pessoa').data('session_cod');
  // alert(' sessao '+sessao);
   btClickCTC(idt_atendimento, 'inc', 0, 'cadastro', 'grc_atendimento_pessoa', sessao , 'CLIENTE - PESSOA FÍSICA');

}

function ConfirmaLinks(idt_atendimento)
{
   // alert(' LINKs '+idt_atendimento);
    var  left   = 100;
    var  top    = 100;
    var  height = $(window).height()-100;
    var  width  = $(window).width() * 0.7;

    var link ='conteudo_atendimento_link_util.php?prefixo=inc&menu=atendimento_link_util&idt_atendimento='+idt_atendimento;
    linkutil =  window.open(link,"linkutil","left="+left+",top="+top+",width="+width+",height="+height+",location=no,resizable=yes,menubar=no,scrollbars=yes,toolbar=no,alwaysLowered=yes,alwaysRaised=no,dependent=yes,directories=no,hotkeys=no,menubar=no,personalbar=no,scrollbars=yes,status=no,titlebar=no,z-lock=yes,titlebar=no");
    linkutil.focus();



}

function ConfirmaPesquisas(idt_atendimento)
{
   alert(' Pesquisas '+idt_atendimento);
}

function ConfirmaPerguntasFrequentes(idt_atendimento)
{
   //alert(' Perguntas Frequentes '+idt_atendimento);




    var  left   = 100;
    var  top    = 100;
    var  height = $(window).height()-100;
    var  width  = $(window).width() * 0.8 ;

    var link ='conteudo_atendimento_perguntas_frequentes.php?prefixo=inc&menu=atendimento_perguntas_frequentes&idt_atendimento='+idt_atendimento;
    faq =  window.open(link,"PerguntasFrequentes","left="+left+",top="+top+",width="+width+",height="+height+",location=no,resizable=yes,menubar=no,scrollbars=yes,toolbar=no,alwaysLowered=yes,alwaysRaised=no,dependent=yes,directories=no,hotkeys=no,menubar=no,personalbar=no,scrollbars=yes,status=no,titlebar=no,z-lock=yes,titlebar=no");
    faq.focus();
















}

function ConfirmaProgramaFidelidade(idt_atendimento)
{
   alert(' Programa Fidelidade '+idt_atendimento);
}

function ConfirmaAnexarArquivo(idt_atendimento)
{
   alert(' Anexar Arquivos '+idt_atendimento);
}



function ConfirmaInscricao(idt_atendimento)
{
   alert(' Inscrição em Eventos '+idt_atendimento);
}



function ConfirmaHistorico(idt_atendimento)
{
   alert(' vivo estou 2 '+idt_atendimento);
}
function ConfirmaBaseInformacoes(idt_atendimento)
{
   alert(' vivo estou 9 '+idt_atendimento);
}

function ChamaParametros()
{
   alert(' chamar parametros ');
   
   
}

</script>