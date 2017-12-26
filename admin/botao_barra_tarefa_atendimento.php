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

}
.table_pendencia_celula_value {
    color:#000000;
    text-align:left;
}



</style>
<?php

$tamdiv    = 57;
$largura   = 32;
$altura    = 32;

$tamdiv    = 44;

//$tamdiv    = 48;

$largura   = 23;
$altura    = 23;


$fsize     = '10px';

$tampadimg = $tamdiv-$largura;
$tamdiv    = $tamdiv.'px';
$tamlabel  = $tamdiv + $tampadimg;
$label     = $tamlabel.'px';
$pad       = $tampadimg.'px';
$padimg    = $tampadimg.'px';


$tit_1="Permite a alteração de um instrumento de atendimento com abordagem individual em outro sem a necessidade de retorno a tela principal do atendimento presencial. Nesses casos, a proposta é que seja apresentado ao usuário caixa de diálogo que permita a conversão";

$tit_2="Ferramenta de consulta do número de orientações técnicas planejadas no SGE para o projeto e ação selecionados. A exclamação vermelha indica que não há orientações técnicas previstas para esse projeto e ação. Nesses casos espera-se que seja exibido ao usuário uma caixa de diálogo que diga “Não existe previsão de orientação técnica no SGE para o projeto e ação selecionado. Você pode consultar essas informações clicando no ícone de planejamento. Caso deseje continuar, clique em OK.” Ao clicar no ícone de planejamento deve ser exibido a relação de instrumentos e seus respectivos quantitativos para o projeto e ação selecionados.";

$tit_3="Funcionalidade de cadastramento de pendência para o atendimento corrente. Nela ocorre a associação automática do protocolo ao chamado aberto. Deve permitir a associação de pendência a qualquer usuário ativo do sistema.";

$tit_4 = "Quando do atendimento de uma PF que se formaliza, esse botão remete o atendimento ao cadastro de PJ para vinculação posterior.";

$tit_5="Apresenta pop-up com LINKS úteis ao processo de atendimento definidos pela administração do sistema.";


$tit_6="Abre tela de cadastro de pessoa física para adicioná-la ao processo de atendimento em andamento.";


$tit_7="Abre pop-up para pesquisa ativa de cliente.";


$tit_8 = "Funcionalidade que permite a inclusão do cliente como participante de evento (instrumentos de abordagem grupal/coletiva) durante o atendimento de orientação técnica.";

$tit_9="Abre pop-up com informações do programa de fidelidade vinculado ao cliente em atendimento.";


$tit_10 = "Abre pop-up com perguntas e respostas mais comuns. Solução adicional à base de informações para o atendimento. ";

$tit_11 = "Ferramenta para inserção de arquivos relacionados ao atendimento.";


echo " <div  style='width:100%; color:#000000; float:left; border-top:1px solid #ABBBBF; border-bottom:1px solid #ABBBBF; '>";



echo " <div onclick='return ConfirmaAlterarInstrumento({$idt_atendimento});' style='width:{$tamdiv}; color:#004080; font-size:14px; cursor:pointer; float:left;  margin-right:15px;  '>";
       echo "<div style='float:left; padding:{$pad}; padding-top:5px; padding-bottom:5px; '   >";
       echo " <img width='{$largura}'  height='{$altura}'  title='{$tit_1}' src='imagens/at_alterarinstrumento.png' border='0'>";
       echo "</div>";

       echo "<div title='{$tit_1}' style='width:{$label};  overflow:auto; display:block; float:left; text-align:center; font-size:{$fsize};  '>";
       echo " Alterar Instrumento";
       echo "</div>";

echo " </div>";


echo " <div onclick='return ConfirmaMonitoramento({$idt_atendimento});' style='width:{$tamdiv}; color:#004080; font-size:14px; cursor:pointer; float:left;  margin-right:15px;  '>";
       echo "<div style='float:left; padding:{$pad}; padding-top:5px; padding-bottom:5px; '   >";
       echo " <img width='{$largura}'  height='{$altura}'  title='{$tit_2}' src='imagens/at_monitoramento.png' border='0'>";
       echo "</div>";

       echo "<div  title='{$tit_2}' style='width:{$label};  overflow:auto; display:block; float:left; text-align:center; font-size:{$fsize};  '>";
       echo " Monitoramento";
       echo "</div>";

echo " </div>";



echo " <div onclick='return ConfirmaPendencia({$idt_atendimento});' style='width:{$tamdiv}; color:#004080; font-size:14px; cursor:pointer; float:left;  margin-right:15px;  '>";
       echo "<div style='float:left; padding:{$pad}; padding-top:5px; padding-bottom:5px;   '   >";
       echo " <img width='{$largura}'  height='{$altura}'  title='{$tit_3}' src='imagens/at_pendencia.png' border='0'>";
       echo "</div>";

       echo "<div title='{$tit_3}' style='width:{$label};  overflow:auto; display:block; float:left; text-align:center; font-size:{$fsize};  '>";
       echo " Pendências";
       echo "</div>";

echo " </div>";



echo " <div onclick='return ConfirmaVincular_pj({$idt_atendimento});' style='width:{$tamdiv}; color:#004080; font-size:14px; cursor:pointer; float:left;  margin-right:15px;  '>";
       echo "<div style='float:left; padding:{$pad}; padding-top:5px; padding-bottom:5px;   '   >";
       echo " <img width='{$largura}'  height='{$altura}'  title='{$tit_4}' src='imagens/at_empresa.png' border='0'>";
       echo "</div>";
       
       echo "<div title='{$tit_4}' style='width:{$label};  overflow:auto; display:block; float:left; text-align:center; font-size:{$fsize};  '>";
       echo " Vincular PJ";
       echo "</div>";

echo " </div>";

echo " <div onclick='return ConfirmaLinks({$idt_atendimento});' style='width:{$tamdiv}; color:#004080; font-size:14px; cursor:pointer; float:left;  margin-right:15px;  '>";
       echo "<div style='float:left; padding:{$pad}; padding-top:5px; padding-bottom:5px;   '   >";
       echo " <img width='{$largura}'  height='{$altura}'  title='{$tit_5}' src='imagens/at_link_util.png' border='0'>";
       echo "</div>";

       echo "<div title='{$tit_5}' style='width:{$label};  overflow:auto; display:block; float:left; text-align:center; font-size:{$fsize};  '>";
       echo " Links";
       echo "</div>";

echo " </div>";

echo " <div onclick='return ConfirmaMaisPessoas({$idt_atendimento});' style='width:{$tamdiv}; color:#004080; font-size:14px; cursor:pointer; float:left;  margin-right:15px;  '>";
       echo "<div style='float:left; padding:{$pad}; padding-top:5px; padding-bottom:5px;   '   >";
       echo " <img width='{$largura}'  height='{$altura}'  title='{$tit_6}' src='imagens/at_maispessoas.png' border='0'>";
       echo "</div>";

       echo "<div title='{$tit_6}' style='width:{$label};  overflow:auto; display:block; float:left; text-align:center; font-size:{$fsize};  '>";
       echo " + Pessoas";
       echo "</div>";

echo " </div>";


echo " <div onclick='return ConfirmaPesquisas({$idt_atendimento});' style='width:{$tamdiv}; color:#004080; font-size:14px; cursor:pointer; float:left;  margin-right:15px;  '>";
       echo "<div style='float:left; padding:{$pad}; padding-top:5px; padding-bottom:5px;  '   >";
       echo " <img width='{$largura}'  height='{$altura}'  title='{$tit_7}'  src='imagens/at_pesquisar.png' border='0'>";
       echo "</div>";

       echo "<div title='{$tit_7}' style='width:{$label};  overflow:auto; display:block; float:left; text-align:center; font-size:{$fsize};  '>";
       echo " Pesquisas";
       echo "</div>";

echo " </div>";



echo " <div onclick='return ConfirmaInscricao({$idt_atendimento});' style='width:{$tamdiv}; color:#004080; font-size:14px; cursor:pointer; float:left;  margin-right:15px; xborder:1px solid red; '>";
       echo "<div style='float:left; padding:{$pad}; padding-top:5px; padding-bottom:5px;  xborder:1px solid blue; '   >";
       echo " <img width='{$largura}'  height='{$altura}'  title='{$tit_8}'  src='imagens/at_inscricao.png' border='0'>";
       echo "</div>";

       echo "<div title='{$tit_8}'  style='width:{$label};  overflow:auto; display:block; float:left; text-align:center; font-size:{$fsize};  xborder:1px solid black;'>";
       echo " Inscrição em Eventos";
       echo "</div>";

echo " </div>";








echo " <div onclick='return ConfirmaProgramaFidelidade({$idt_atendimento});' style='width:{$tamdiv}; color:#004080; font-size:14px; cursor:pointer; float:left;  margin-right:15px;  '>";
       echo "<div style='float:left; padding:{$pad}; padding-top:5px; padding-bottom:5px;   '   >";
       echo " <img width='{$largura}'  height='{$altura}'  title='{$tit_9}'  src='imagens/at_fidelidade.png' border='0'>";
       echo "</div>";

       echo "<div title='{$tit_9}'  style='width:{$label};  overflow:auto; display:block; float:left; text-align:center; font-size:{$fsize};  '>";
       echo " Programa de Fidelidade";
       echo "</div>";

echo " </div>";



echo " <div onclick='return ConfirmaPerguntasFrequentes({$idt_atendimento});' style='width:{$tamdiv}; color:#004080; font-size:14px; cursor:pointer; float:left;  margin-right:15px;  '>";
       echo "<div style='float:left; padding:{$pad}; padding-top:5px; padding-bottom:5px;   '   >";
       echo " <img width='{$largura}'  height='{$altura}'  title='{$tit_10}'  src='imagens/at_perguntas.png' border='0'>";
     //  echo " <img width='{$largura}'  height='{$altura}'  title='{$tit_10}'  src='imagens/duvidas.png' border='0'>";
       echo "</div>";

       echo "<div title='{$tit_10}' style='width:{$label};  overflow:auto; display:block; float:left; text-align:center; font-size:{$fsize};  '>";
       echo " Perguntas Frequentes";
       echo "</div>";

echo " </div>";



echo " <div onclick='return ConfirmaAnexarArquivo({$idt_atendimento});' style='width:{$tamdiv}; color:#004080; font-size:14px; cursor:pointer; float:left;  margin-right:15px;  '>";
       echo "<div style='float:left; padding:{$pad}; padding-top:5px; padding-bottom:5px;   '   >";
       echo " <img width='{$largura}'  height='{$altura}'  title='{$tit_11}' src='imagens/at_anexar.png' border='0'>";
       echo "</div>";

       echo "<div title='{$tit_11}' style='width:{$label};  overflow:auto; display:block; float:left; text-align:center; font-size:{$fsize};  '>";
       echo " Anexar Arquivos";
       echo "</div>";

echo " </div>";


echo " </div> ";


echo " <div id='pendencia' > ";


echo " <div id='pendencia_cab' > ";
echo "<div style='float:left; width:90%; xborder:1px solid red; '   >";
echo "PENDÊNCIA";
echo " </div> ";
$onclckfecha  = "onclick = 'return pendencia_fecha();'";
$onclcksalvar = "onclick = 'return pendencia_salvar();'";
echo "<div style='float:right;  width:4%;  padding:0; padding-right:5px; xborder:1px solid red; '   >";
echo " <img {$onclckfecha} width='21'  height='21'  title='Fechar Pandência' src='imagens/at_alterarinstrumento.png' border='0'>";
echo "</div>";
echo " </div> ";

echo " <div id='pendencia_det' > ";


/*

echo "<table class='table_contato' width='100%' border='0' cellspacing='4' cellpadding='4' vspace='0' hspace='0'> ";

//echo "<fieldset>";

echo "<tr class='table_contato_linha'> ";
$setorlabelw="<label for='telefone' >Setor para contato no <b>Sebrae</b><span>*</span>:&nbsp;</label>";
echo "   <td class='table_contato_celula_label'>{$setorlabelw}</td> ";
	$sql = "select
				idt,
				descricao
			from
				plu_contato
			order by
				descricao";
	$rs = execsql($sql);
	//criar_combo_rs($rs, 'fale', '', '', '');
echo "   <td class='table_contato_celula_value'>";
criar_combo_rs($rs, 'fale', '', '', '');
echo "</td> ";
echo "</tr>";

echo "<tr class='table_contato_linha'> ";
$nomelabelw="<label for='nome' >Seu Nome<span>*</span>:&nbsp;</label>";
echo "   <td class='table_contato_celula_label'>{$nomelabelw}</td> ";
$nomew="<input class='Texto' type='text' name='nome' value='{$nome}' size='45' maxlength='80'><br>";
echo "   <td class='table_contato_celula_value'>{$nomew}</td> ";
echo "</tr>";

echo "<tr class='table_contato_linha'> ";
$emaillabelw="<label for='email' >Seu e-mail<span>*</span>:&nbsp;</label>";
echo "   <td class='table_contato_celula_label'>{$emaillabelw}</td> ";
$emailw="<input class='Texto' type='text' name='email' value='{$email}' size='45' maxlength='80' onblur='Valida_Email(email)'><br>";
echo "   <td class='table_contato_celula_value'>{$emailw}</td> ";
echo "</tr>";

echo "<tr class='table_contato_linha'> ";
$telefonelabelw="<label for='telefone' >Seu Telefone<span>*</span>:&nbsp;</label>";
echo "   <td class='table_contato_celula_label'>{$telefonelabelw}</td> ";
$telefonew="<input class='Texto' type='text' name='telefone' value='{$telefone}' maxlength='13' size='13' onblur='return Valida_Telefone(this)' onkeyup='return Formata_Telefone(this,event)'><br>";
echo "   <td class='table_contato_celula_value'>{$telefonew}</td> ";
echo "</tr>";

echo "<tr class='table_contato_linha'> ";
$mensagemlabelw="<label for='telefone' >Sua Mensagem<span>*</span>:&nbsp;</label>";
echo "   <td class='table_contato_celula_label'>{$mensagemlabelw}</td> ";
$mensagemw="<textarea class='Texto' name='detalhe' style='height: 100px; width: 350px;'></textarea><br>";
echo "   <td class='table_contato_celula_value'>{$mensagemw}</td> ";
echo "</tr>";

echo "</table >";
*/


$mensagemw="";

echo "<table class='table_contato' width='100%' border='0' cellspacing='4' cellpadding='4' vspace='0' hspace='0'> ";


$data_solucao="";
echo "<tr class='table_pendencia_linha'> ";
$data_solucaolabelw="<label for='data_solucao' >Data para Solução<span>*</span>:&nbsp;</label>";
echo "   <td class='table_pendencia_celula_label'>{$data_solucaolabelw}</td> ";
$js = 'onblur="return checkdate(this)" onkeyup="return Formata_Data(this,event)"';
$data_solucaow="<input id='data_solucao' class='Texto' type='text' name='data_solucao' value='{$data_solucao}' maxlength='13' size='13' {$js} ><br>";
echo "   <td class='table_pendencia_celula_value'>{$data_solucaow}</td> ";
$vl='data_solucao';
echo '
    <script type="text/javascript">
        $(function() {
            $("#'.$vl.'").datepicker({
                showOn: \'button\',
                changeMonth: true,
                changeYear: true,
                buttonText: \'Selecionar a data\',
                buttonImage: \'imagens/calendar.gif\',
                buttonImageOnly: true,
                dateFormat: \'dd/mm/yy\'
            });
        });
    </script>
';






echo "</tr>";

$observacao="";
echo "<tr class='table_pendencia_linha'> ";
$observacaolabelw="<label for='observacao' >Pendência<span>*</span>:&nbsp;</label>";
echo "   <td class='table_pendencia_celula_label'>{$observacaolabelw}</td> ";
$observacaow="<textarea id='observacao' class='Texto' name='observacao' style='height: 100px; width: 400px;'></textarea><br>";
echo "   <td class='table_pendencia_celula_value'>{$observacaow}</td> ";
echo "</tr>";

echo "</table >";


echo "<table class='table_contato' width='100%' border='0' cellspacing='4' cellpadding='4' vspace='0' hspace='0'> ";
$btconfirma = "<input type='button' name='btnAcao' value='Salvar'  {$onclcksalvar} style='width:150px; height:25px; margin-left:10px; cursor: pointer;'/>";
//$btdesiste  = "<input type='button' value='Desistir' name='btdesiste' id='btdesiste' style='width:150px; height:25px; margin-left:10px; cursor: pointer;'  onclick='desiste_altera_faleconosco();'  />";
$btretorna  = "<input type='button' value='Retornar sem Salvar' name='btretornar' id='btretornar' style='width:150px; height:25px; margin-left:10px; cursor: pointer;'  {$onclckfecha}  />";


echo "<tr class='table_contato_linha'> ";
$msgrodapeobrigatoriow='( * ) campo obrigatório';
echo "   <td class='table_contato_celula_msgrodape' >{$msgrodapeobrigatoriow}</td> ";
echo "</tr>";

echo "<tr class='table_contato_linha'> ";
echo "   <td class='table_contato_celula_btconfirmar' >{$btconfirma}{$btretorna}</td> ";
//echo "   <td class='table_contato_celula_btdesistir'>{$btdesiste}</td> ";
echo "</tr>";
echo "</table >";








echo " </div> ";


echo " <div id='pendencia_com' > ";
echo " </div> ";


echo "</div>";

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


function ConfirmaAlterarInstrumento(idt_atendimento)
{
   alert(' Alterar Instrumento '+idt_atendimento);
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

   var id='pendencia';
   objtp = document.getElementById(id);
   if (objtp != null) {

 }
   //
   // pegar campos do formulário e enviar para gravação
   //


}


function ConfirmaVincular_pj(idt_atendimento)
{
   alert(' Vincular PJ '+idt_atendimento);
}

function ConfirmaMaisPessoas(idt_atendimento)
{
   alert(' + Pessoas '+idt_atendimento);
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


</script>
