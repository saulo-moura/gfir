<?php



 $vet_vai   = Array();
 $vet_volta = Array();

 $vet_vaiw        = explode(',',$grc_es_vai_para); 
 $vet_voltaw      = explode(',',$grc_es_volta_para); 


//p($grc_es_vai_para);
//p($grc_es_volta_para);

//p($vet_vaiw);
//p($vet_voltaw);


 ForEach ($vet_vaiw as $ind => $Valor) 
 {
    $vet_vai["$Valor"]="S";
 }
 ForEach ($vet_voltaw as $ind => $Valor) 
 {
    $vet_volta["$Valor"]="S";
 }

 $tam_vai   = count($vet_vai);
 $tam_volta = count($vet_volta);

//p($vet_vai);
//p($vet_volta);

 if ($acao=='alt')
 {
    if ($veio!="xxxxxxD")
    {
      if ( ($tam_vai>0 or $tam_volta>0  ) or $direito_geral==1) 
      {

            $retorno     = 'conteudo.php?acao=alt&texto0=&prefixo=cadastro&menu=grc_evento&id='.$idt_evento;
            $retornofull = 'conteudo.php?prefixo=listar&texto0=&menu=grc_evento&painel_btvoltar_rod=N';

            echo " <div style=' text-align:center; font-size:16px; background:#0000FF; color:#FFFFFF; border:1px solid #FFFFFF; height:25px; '>";
            echo " <div style='float:left; width:100%;'>";
            echo " Próximas Etapas ";
            echo " </div>";
            $sql  = "select * from grc_evento_situacao ";
            //$sql .= " where situacao_etapa='D' ";
            $sql .= " order by codigo";
            $rs = execsql($sql);
            ForEach ($rs->data as $row) {
                $idt               = $row['idt'];
                $codigo            = $row['codigo'];
                $descricao         = $row['descricao'];
                $codigow = $vet_vai[$codigo];    
//echo " $codigow == $codigo <br />";           
                if ($codigow!="" or $direito_geral==1 )
                {
                    echo " <div onclick='return AtivaSituacao({$idt});' style='color:#004080; font-size:14px; cursor:pointer; float:left; padding-top:20px; padding-right:20px;'>";
                    echo " <img  title='Ativa situação: {$descricao}.' src='imagens/alterar.png' border='0'>  $descricao";
                    echo " </div>";
                }
            }

            ForEach ($rs->data as $row) {
                $idt               = $row['idt'];
                $codigo            = $row['codigo'];
                $descricao         = $row['descricao'];
                $codigow = $vet_volta[$codigo];               
                if ($codigow!="" or $direito_geral==1 )
                {
                    echo " <div onclick='return AtivaSituacao({$idt});' style='color:#004080; font-size:14px; cursor:pointer; float:left; padding-top:20px; padding-right:20px;'>";
                    echo " <img  title='Ativa situação: {$descricao}.' src='imagens/alterar.png' border='0'>  $descricao";
                    echo " </div>";
                }
            }

            echo " </div>";
        }
        else
        {
            echo " <div style=' text-align:center; font-size:16px; background:#0000FF; color:#FFFFFF; border:1px solid #FFFFFF; height:25px; '>";
            echo " <div style='float:left; width:100%;'>";
            echo " EVENTO NÃO APROVADO PARA UTILIZAÇÃO ";
            echo " </div>";
            echo " </div>";
        
        
        }
    }
    else
    {
         echo "Execução ";
       
        $retorno     = 'conteudo.php?acao=alt&texto0=&prefixo=cadastro&menu=grc_evento&id='.$idt_evento;
        $retornofull = 'conteudo.php?prefixo=listar&texto0=&menu=grc_evento&painel_btvoltar_rod=N';
       
        $sql  = "select * from grc_evento_situacao ";
        $sql .= " where situacao_etapa='E' ";
        $sql .= " order by codigo";
        $rs = execsql($sql);
        ForEach ($rs->data as $row) {
            $idt               = $row['idt'];
            $codigo            = $row['codigo'];
            $descricao         = $row['descricao'];
            if ($codigo>$codigo_atual or $direito_geral==1)
            {
                echo " <div onclick='return AtivaSituacao({$idt});' style='color:#004080; font-size:14px; cursor:pointer; float:left; padding-top:20px; padding-right:20px;'>";
                echo " <img  title='Ativa situação: {$descricao}.' src='imagens/alterar.png' border='0'>  $descricao";
                echo " </div>";
            }
        }

    }

}
if ($acao=='con')
{

        if ($codigo_atual=="85" or $codigo_atual=="90")  // Não aprovado

        {
            echo " <div style=' width:100%; margin-top:10px; text-align:center; font-size:16px; background:#FF0000; color:#FFFFFF; border:1px solid #FFFFFF; height:25px; '>";
            echo " <div style='float:left; width:100%;'>";
            echo " EVENTO NÃO APROVADO PARA UTILIZAÇÃO ";
            echo " </div>";
            echo " </div>";
        }

        if ($codigo_atual=="45" or $codigo_atual=="50"  or $codigo_atual=="60")  // disparada compra e em execução

        {
            echo " <div style=' width:100%; margin-top:10px; text-align:center; font-size:16px; background:#FF0000; color:#FFFFFF; border:1px solid #FFFFFF; height:25px; '>";
            echo " <div style='float:left; width:100%;'>";
            echo " SITUAÇÃO DO EVENTO NÃO PODE SER MODIFICADA NESSA FUNCIONALIDADE.";
            echo " </div>";
            echo " </div>";
        }

}



if ($acao=='inc')
{
            echo " <div style=' width:100%; margin-top:10px; text-align:center; font-size:16px; background:#0000FF; color:#FFFFFF; border:1px solid #FFFFFF; height:25px; '>";
            echo " <div style='float:left; width:100%;'>";
            echo " EVENTO SENDO INCLUIDO - INÍCIO DO PLANEJAMENTO. ";
            echo " </div>";
            echo " </div>";

}



?>
<script type="text/javascript">

var retorno     = ' <?php echo $retorno; ?> ';
var retornofull = ' <?php echo $retornofull; ?> ';
var idt_evento  =   <?php echo $idt_evento; ?>  ;

function AtivaSituacao(idt_situacao)
{
  // alert(' --- '+idt_evento+' ---- sit '+idt_situacao);
   
   
   var str = '';
    $.post('ajax2.php?tipo=AtivaSituacaoEvento', {
        async: false,
        idt_evento   : idt_evento,
        idt_situacao : idt_situacao
    }
    , function (str) {
        if (str == '') {
            //alert(' retornei ');
            self.location = retorno;
        } else {
            str = "ERRO "+str;
            alert(url_decode(str).replace(/<br>/gi, "\n"));
        }
    });
   return false;
}


function AtivaSituacaoExecucao(idt_situacao)
{
    // alert(' --- '+idt_evento+' ---- sit '+idt_situacao);

    if (!confirm('A APROVAÇÃO fará com que o evento seja colocado em disponibilidade para Utilização ' + '\n\n' + 'Confirma?'))
    {
        return false;
    }

    var str = '';
    $.post('ajax2.php?tipo=AtivaSituacaoEvento', {
        async: false,
        idt_evento  : idt_evento,
        idt_situacao: idt_situacao
    }
    , function (str) {
        if (str == '') {
            alert('EVENTO APROVADO COM SUCESSO...');
            self.location = retornofull;
        } else {
            str = "ERRO "+str;
            alert(url_decode(str).replace(/<br>/gi, "\n"));
        }
    });
   return false;
}
</script>