<style>


.chama {
    background:#006ca8;
    color:#FFFFFF;
    width:100%;
    display:block;
    text-align:center;
    font-size:2.4em;
}





.botao_ag {
    text-align:center;
    xwidth:300px;

    width:100%;

    xheight:50px;
    color:#FFFFFF;
    Xbackground:#0000FF;
    background:#2F65BB;
    font-size:14px;
    cursor:pointer;
    float:left;
    margin-top:10px;
    margin-right:10px;
    xpadding-top:20px;
    xpadding-right:20px;
    font-weight:bold;
    font-size:2.5em;
    padding:10px;

}
.botao_ag:hover {
    background:#0000FF;


}


.botao_ag_a {
    text-align:center;
    width:100%;
    color:#FFFFFF;
    background:#0000FF;
    font-size:14px;
    float:left;
    margin-top:10px;
    margin-right:10px;
    font-weight:bold;
    font-size:2.5em;
    padding:10px;
}


</style>

<?php

      $idt_atendimento_agenda=$_GET['id'];

      $sql1 = 'select ';
      $sql1 .= '  grc_aa.*   ';
      $sql1 .= '  from grc_atendimento_agenda grc_aa ';
      $sql1 .= ' where    grc_aa.idt    = '.null($idt_atendimento_agenda);
      $rs_aa = execsql($sql1);
      if ($rs_aa->rows == 0)
      {

      }


    $idt_consultor          = "";
    $data                   = "";
    $hora                   = "";

      ForEach ($rs_aa->data as $row_aa)
      {
          $protocolo                     = ($row_aa['protocolo']);
          $cpf                           = ($row_aa['cpf']);
          $cnpj                          = ($row_aa['cnpj']);
          $nome_pessoa                   = ($row_aa['nome_pessoa']);
          $cliente_texto                 = ($row_aa['cliente_texto']);
          $nome_empresa                  = ($row_aa['nome_empresa']);
          $idt_pessoa                    = ($row_aa['idt_pessoa']);
          $idt_consultor                 = ($row_aa['idt_consultor']);
          $idt_cliente                   = ($row_aa['idt_cliente']);
          $assunto                       = ($row_aa['assunto']);
          $data_inicio_atendimento       = ($data);
          $data_termino_atendimento      = ($data);
          $horas_atendimento             = ($horas_atendimentow);
          $idt_empresa                   = ($row_aa['idt_empresa']);
          $senha_totem                   = ($row_aa['senha_totem']);
          $data                          = $row_aa['data'];
          $hora                          = $row_aa['hora'];
      }

        $sql2  = 'select ';
        $sql2 .= '  grc_a.*   ';
        $sql2 .= '  from grc_atendimento grc_a ';
        $sql2 .= '  where grc_a.idt_atendimento_agenda = '.null($idt_atendimento_agenda);

        $rs_aap = execsql($sql2);

        $idt_atendimento  = 0;
        if ($rs_aap->rows == 0)
        {
        }
        else
        {
           ForEach ($rs_aap->data as $row)
           {
                $idt_atendimento  = $row['idt'];
           }
        }



        $sql2  = 'select ';
        $sql2 .= '  grc_aap.*   ';
        $sql2 .= '  from grc_atendimento_agenda_painel grc_aap ';
        $sql2 .= '  where grc_aap.idt_atendimento_agenda = '.null($idt_atendimento_agenda);

        $rs_aap = execsql($sql2);

        $status_painel  = "";
        if ($rs_aap->rows == 0)
        {
        }
        else
        {
           ForEach ($rs_aap->data as $row)
           {
                $status_painel  = $row['status_painel'];
           }
        }
//echo " chamar cliente ".$idt_atendimento_agenda;
echo "<div class='chama'>";
echo "<div class=''>";
echo " PAUSAR CHAMADA DO CLIENTE NO PAINEL";
echo "</div>";

echo "<div class=''>";
echo " SENHA: $senha_totem";
echo "</div>";


echo "<div class=''>";
echo " CPF:  $cpf    NOME: $cliente_texto          ";
echo "</div>";

if ($cnpj!="")
{
    echo "<div class=''>";
    echo " CNPJ: $cnpj EMPREENDIMENTO: $nome_empresa";

    echo "</div>";
}
echo "</div>";





if ($senha_totem=="")
{
    echo " <div class='botao_ag'  >";
            echo " <div style='margin:15px; '>Cliente sem SENHA Não pode ser PAUSADO NA CHAMADA .</div>";
    echo " </div>";
}
else
{
    if ($status_painel=='99')
    {
        echo " <div class='botao_ag'  >";
                echo " <div style='margin:15px; '>Cliente com Atendimento FECHADO.</div>";
        echo " </div>";
    }
    else
    {
        if ($status_painel=='20' || $status_painel=='01')
        {
            echo " <div id='inicia_atpd' class='botao_ag_a chama_clip'  >";
            echo " <div id='chama_clip' style='margin:15px; '>Cliente sendo chamado no Painel</div>";
            echo " </div>";
            //


            $tamdiv    = 80;
            $largura   = 32;
            $altura    = 32;


            $fsize     = '12px';
            $tampadimg = $tamdiv-$largura;
            $tamdiv    = $tamdiv.'px';
            $tamlabel  = $tamdiv + $tampadimg;
            $label     = $tamlabel.'px';
            $pad       = $tampadimg.'px';
            $padimg    = $tampadimg.'px';
            $tit_1="Possibilita o Cancelamento da Chamada do Cliente no Painel";
            $onclick2 = "onclick='return CancelarChamada({$idt_atendimento_agenda}); ' ";

            echo " <div  {$onclick2} id='atendimento_s2' style='cursor:pointer; width:$tamdiv; color:#000000; float:left; xborder-top:1px solid #ABBBBF; xborder-bottom:1px solid #ABBBBF; '>";


                   echo "<div style='float:left; padding:{$pad}; padding-top:5px; padding-bottom:5px; '   >";
                   echo " <img width='{$largura}'  height='{$altura}'  title='{$tit_1}' src='imagens/pausar_chamada.png' border='0'>";
                   echo "</div>";
                   echo "<div title='{$tit_1}' style='width:{$label};  overflow:auto; display:block; float:left; text-align:center; font-size:{$fsize};  '>";
                   echo " Pausar Chamada do Cliente ";
                   echo "</div>";




            echo " </div>";


           echo "<div id='mostra_mensagem_cancelada' title='' style=' width:100%; Xdisplay:none; float:left; text-align:center; font-size:{$fsize};  '>";
           echo "<div id='cancelachama_clid' style='background:#C00000; color:#FFFFFF; font-size:18px;'>";
           echo "";
           echo "</div>";
           echo "</div>";


            //
            echo " <div id='inicia_atp' style='xdisplay:none; '  class='botao_ag botao_ag' onclick='return IniciarAtendimento({$idt_atendimento_agenda},20);' >";
                    echo " <div style='margin:15px; '>Iniciar Atendimento </div>";
            echo " </div>";

        }
        if ($status_painel=='80')
        {
            echo " <div id='chama_clid' class='botao_ag'  >";
                    echo " <div id='chama_cli' style='margin:15px; '>Cliente já Chamado pelo Painel</div>";
            echo " </div>";
            echo " <div id='inicia_atd' style='xdisplay:none; '  class='botao_ag'  >";
                    echo " <div style='margin:15px; '>Já Iniciado o Atendimento </div>";
            echo " </div>";

            /*
            echo " <div id='termina_atd' style='xdisplay:none; '  class='botao_ag' onclick='return TerminarAtendimento({$idt_atendimento_agenda});' >";
                    echo " <div style='margin:15px; '>Terminar o Atendimento </div>";
            echo " </div>";
            */
        }
        if ($status_painel!='20' and $status_painel!='80' and $status_painel!='99' and $status_painel!='01' )
        {

            /*
            echo " <div id='chama_clid' class='botao_ag' onclick='return ChamaAtendimento({$idt_atendimento_agenda});' >";
                    echo " <div id='chama_cli' style='margin:15px; '>Chamar Cliente para atendimento</div>";
            echo " </div>";
            echo " <div id='inicia_atd' style='display:none; '  class='botao_ag' onclick='return IniciarAtendimento({$idt_atendimento_agenda},01);' >";
                    echo " <div style='margin:15px; '>Iniciar Atendimento </div>";
            echo " </div>";
            */
            echo " <div id='chama_clid' class='botao_ag'  >";
                    echo " <div id='chama_cli' style='margin:15px; '>STATUS NÃO PERMITE ESSA AÇÃO</div>";
            echo " </div>";
        }
     }
     //     Voltar
     echo " <div id='termina_atd' style='xdisplay:none; '  class='botao_ag' onclick='return VoltarAtendimento({$idt_atendimento_agenda});' >";
            echo " <div style='margin:15px; '>Voltar</div>";
     echo " </div>";
}









?>

<script type="text/javascript">

var status_painel = '<?php echo "{$status_painel}"; ?>';


var idt_atendimento = <?php echo $idt_atendimento; ?>;


var chamoucliente=0;
function ChamaAtendimento(idt_atendimento_agenda)
{
    if (chamoucliente==1)
    {
        alert('Cliente já foi chamado pelo Painel.');
        return false;
    }
    //alert(' Chama Atendimento = '+idt_atendimento_agenda);
    var idt_cliente = 0;
    //
    var id='idt_cliente';
    obj = document.getElementById(id);
    if (obj != null) {
       // obj.style.background = obj.value;
       //  obj.style.color = obj.value;
       idt_cliente=obj.value;
    }
//////////////////////////
    var str = '';
    $.post('ajax_atendimento.php?tipo=ChamaAtendimento', {
        async : false,
        idt_atendimento_agenda : idt_atendimento_agenda,
        idt_cliente            : idt_cliente
    }
    , function (str) {
        if (str == '') {
            //
            //  self.location = 'conteudo.php?prefixo=listar&texto0=&menu=gec_metodologia';
            //
            situacaochamado();
            //refresh();
            location.reload();
        } else {
            alert(url_decode(str).replace(/<br>/gi, "\n"));
        }
    });
///////////////////


    return false;
}

function situacaochamado()
{
        var id='chama_clid';
        obj = document.getElementById(id);
        if (obj != null) {
           obj.innerHTML="Cliente sendo chamado no Painel";
           $(obj).css('background','#0000FF');
        }
        var id='inicia_atd';
        obj = document.getElementById(id);
        if (obj != null) {
           $(obj).show();
        }
        TelaHeight();
}



function IniciarAtendimento(idt_atendimento_agenda,opc)
{
    //alert(' Iniciar Atendimento = '+idt_atendimento_agenda);
    var idt_cliente = 0;

    var id='idt_cliente';
    obj = document.getElementById(id);
    if (obj != null) {
       idt_cliente=obj.value;
    }
//////////////////////////
    var str = '';
    $.post('ajax_atendimento.php?tipo=ConfirmaAtendimento', {
        async : false,
        idt_atendimento_agenda : idt_atendimento_agenda,
        idt_cliente            : idt_cliente
    }
    , function (str) {
        if (str == '') {
        //    self.location = 'conteudo.php?prefixo=listar&texto0=&menu=gec_metodologia';
          iniciadoatendimento(opc);
         // chama tela de atendimento
         // self.location = 'conteudo.php?prefixo=cadastro&menu=grc_atendimento&instrumento=2&instrumento2=2&acao=alt&idt_atendimento_agenda='+idt_atendimento_agenda+'&id='+idt_atendimento;

         //self.location = 'conteudo.php?prefixo=inc&menu=grc_chama_cadastro_cliente&idt_atendimento_agenda='+idt_atendimento_agenda+'&id='+idt_atendimento_agenda;


          self.location = 'conteudo.php?prefixo=inc&menu=grc_atender_cliente&idt_atendimento_agenda='+idt_atendimento_agenda+'&id='+idt_atendimento_agenda;

          //refresh();
        } else {
            alert(url_decode(str).replace(/<br>/gi, "\n"));
        }
    });
///////////////////


    return false;
}
function iniciadoatendimento(opc)
{
    if (opc!=20)
    {
        var id='inicia_atd';
        obj = document.getElementById(id);
        if (obj != null) {
           obj.innerHTML="Iniciado Atendimento do Cliente";
           $(obj).css('background','#0000FF');
        }
        /*
        var id='termina_atd';
        obj = document.getElementById(id);
        if (obj != null) {
           $(obj).show();
        }
        */
    }
    else
    {
       // agora tem refresh ver se funciona
    }
    TelaHeight();
}


function TerminarAtendimento(idt_atendimento_agenda)
{
    //alert(' Iniciar Atendimento = '+idt_atendimento_agenda);
    var idt_cliente = 0;
    var id='idt_cliente';
    obj = document.getElementById(id);
    if (obj != null) {
       // obj.style.background = obj.value;
       //  obj.style.color = obj.value;
       idt_cliente=obj.value;
    }
//////////////////////////
    var str = '';
    $.post('ajax_atendimento.php?tipo=TerminarAtendimento', {
        async : false,
        idt_atendimento_agenda : idt_atendimento_agenda,
        idt_cliente            : idt_cliente
    }
    , function (str) {
        if (str == '') {
        //    self.location = 'conteudo.php?prefixo=listar&texto0=&menu=gec_metodologia';
          terminaratendimento();
          //refresh();
          location.reload();
        } else {
            alert(url_decode(str).replace(/<br>/gi, "\n"));
        }
    });
    return false;
}

function terminaratendimento()
{
    var id='termina_atd';
    obj = document.getElementById(id);
    if (obj != null) {
       obj.innerHTML="Finalizado o Atendimento ao Cliente";
       $(obj).css('background','#0000FF');
    }
    TelaHeight();
}

if (status_painel=='20')
{  // esta no painel
  // situacaochamado();
}

function VoltarAtendimento(idt_atendimento_agenda)
{
    history.back(1);
    return false;
}


function CancelarChamada(idt_atendimento_agenda)
{
    //alert(' Cancelar a chamada no Painel.... Qual critério para chamar novamente?')
//////////////////////////
    var str = '';
    $.post('ajax_atendimento.php?tipo=CancelarChamada', {
        async : false,
        idt_atendimento_agenda : idt_atendimento_agenda
    }
    , function (str) {
        if (str == '') {
            self.location = "<?php echo $_SESSION[CS]['grc_atendimento_totem']; ?>";
        } else {
            alert(url_decode(str).replace(/<br>/gi, "\n"));
        }
    });

    return false;

}

function situacaochamadocancelado()
{
        var id='cancelachama_clid';
        obj = document.getElementById(id);
        if (obj != null) {
           obj.innerHTML="Cliente retornado a FILA DE ATENDIMENTO.<br />Chamada Cancelada com Sucesso...";
           //$(obj).css('background','#0000FF');
        }
        var id='mostra_mensagem_cancelada';
        obj = document.getElementById(id);
        if (obj != null) {
           $(obj).show();
        }
        TelaHeight();
}


</script>