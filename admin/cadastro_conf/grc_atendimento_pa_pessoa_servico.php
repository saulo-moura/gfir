<style>
    #nm_funcao_desc label{
    }
    #nm_funcao_obj {
    }
    .Tit_Campo {
    }
    .Tit_Campo_Obr {
    }
    fieldset.class_frame_f {
        background:#2F66B8;
        border:1px solid #FFFFFF;
        height:30px;
    }
    div.class_titulo_f {
        background: #2F66B8;
        border    : 1px solid #2C3E50;
        color     : #FFFFFF;
        text-align: left;
        height:30px;
        padding-top:10px;
    }
    div.class_titulo_f span {
        padding-left:20px;
        text-align: left;
    }
    fieldset.class_frame_p {
        background:#ABBBBF;
        border:1px solid #FFFFFF;
    }
    div.class_titulo_p {
        background: #ABBBBF;
        border    : 1px solid #2C3E50;
        color     : #FFFFFF;
        text-align: left;
    }
    div.class_titulo_p span {
        padding-left:20px;
        text-align: left;
    }
    fieldset.class_frame {
        background:#ECF0F1;
        border:1px solid #2C3E50;
    }
    div.class_titulo {
        background: #C4C9CD;
        border    : 1px solid #2C3E50;
        color     : #FFFFFF;
        text-align: left;
    }
    div.class_titulo span {
        padding-left:10px;
    }
</style>
<?php
if ($_GET['idCad'] != '') {
    $_GET['idt0'] = $_GET['idCad'];
    $botao_volta = "parent.btFechaCTC('".$_GET['session_cod']."');";
    $botao_acao = '<script type="text/javascript">parent.btFechaCTC("'.$_GET['session_cod'].'", parent.grc_atendimento_pa_pessoa_servico, null, returnVal);</script>';
}
$AliasPai     = "grc_app";
$TabelaPai    = "grc_atendimento_pa_pessoa ";
$TabelaPaij   = "grc_atendimento_pa_pessoa ";
$TabelaPaij  .= " {$AliasPai} left join plu_usuario plu_usu on plu_usu.id_usuario = {$AliasPai}.idt_usuario ";

$EntidadePai = "Atendente/Consultor";
$idPai       = "idt";
//
$AliasPric    = "grc_apps";
//$TabelaPrinc  = "grc_atendimento_pa_pessoa_servico {$AliasPric}";
$TabelaPrinc  = "grc_atendimento_pa_pessoa_servico ";
//$TabelaPrinc .= "  left join plu_usuario plu_usu on plu_usu.id_usuario = {$AliasPai}.idt_usuario ";

$Entidade     = "Serviços do Atendente/Consultor";
$Entidade_p   = "Serviços do Atendente/Consultor";
$CampoPricPai = "idt_pa_pessoa";
// p($_GET);
// Dados do pai

$sql2 = 'select ';
$sql2 .= "  {$AliasPai}.*, ";
$sql2 .= '  sca_os.descricao      as sca_os_descricao,  ';
$sql2 .= '  plu_usu.nome_completo as plu_usu_nome_completo  ';

$sql2 .= "  from {$TabelaPai} {$AliasPai} ";
$sql2 .= "  left join plu_usuario plu_usu on plu_usu.id_usuario = {$AliasPai}.idt_usuario ";
$sql2 .= "  left join ".db_pir."sca_organizacao_secao sca_os on sca_os.idt = {$AliasPai}.idt_ponto_atendimento ";
$sql2 .= "  where {$AliasPai}.idt = ".null($_GET['idt0']);
$rs_pai  = execsql($sql2);
$row_pai = $rs_pai->data[0];
$nome_atendente         = $row_pai['plu_usu_nome_completo'];
$desc_ponto_atendimento = $row_pai['sca_os_descricao'];

$idt_ponto_atendimento      = $row_pai['idt_ponto_atendimento'];
$duracao_ponto_atendimento  = $row_pai['duracao'];
//p($row_pai);
$duracao="";
if ($acao!="inc")
{
	$sql2  = 'select ';
	$sql2 .= "  {$AliasPric}.* ";
	$sql2 .= "  from {$TabelaPrinc} {$AliasPric} ";
	$sql2 .= "  where {$AliasPric}.idt = ".null($_GET['id']);
	$rs_princ  = execsql($sql2);
	$row_princ = $rs_princ->data[0];
	$duracao   = $row_princ['periodo'];
}
//p($sql2);
//echo " -------------- $duracao ";
//p($_GET);




$sql = 'select ';
$sql .= "   idt, descricao, opcoes_escolher  ";
$sql .= ' from grc_atendimento_especialidade grc_ae ';
//$sql .= " where ativo = 'S' ";
$sql .= ' order by descricao ';
$rs_servico = execsql($sql);
$rs_servico = execsql($sql);
$vetEscolherDuracaoServico    = Array();
$vetEscolherDuracaoServicoIdt = Array();
$vetEscolherDuracaoServicoDur = Array();
$ic = 0;
ForEach ($rs_servico->data as $row) {
	 $idt             = $row['idt'];
	 $descricao       = $row['descricao'];
	 $opcoes_escolher = $row['opcoes_escolher'];
	 $opcoes_escolher = str_replace('[','',$opcoes_escolher);
	 $opcoes_escolher = str_replace(']','',$opcoes_escolher);
	 $vet             = explode(';',$opcoes_escolher);
	 $tam             = count($vet);
	 
	 ForEach ($vet as $Indice => $Duracao) {
	    $ic = $ic + 1;
	    $vetEscolherDuracaoServico[$ic]    = $descricao." - ".$Duracao." min";  
		$vetEscolherDuracaoServicoIdt[$ic] = $idt;
		$vetEscolherDuracaoServicoDur[$ic] = $Duracao;
	 }
}
$arquivo_html ="";
$arquivo_html.="<div id='id_opcoes_escolha' style='font-size:14px; color:red; padding-top:15px;'>";
$arquivo_html.="PA: ".$desc_ponto_atendimento;
//$arquivo_html.="<br />Duração máxima: ".$duracao_ponto_atendimento;
$arquivo_html.="</div>";
$vetCampo['ponto_atendimento'] = objInclude('ponto_atendimento', $arquivo_html);

$tabela = $TabelaPrinc;

$id     = 'idt';
$vetCampo[$CampoPricPai]    = objFixoBanco($CampoPricPai, $EntidadePai, $TabelaPaij, 'idt', 'nome_completo', 0);

//
$sql = 'select ';
$sql .= "   grc_ae.idt, grc_ae.descricao, 'Duração', grc_ae.opcoes_escolher  ";
$sql .= ' from grc_atendimento_especialidade grc_ae ';
$sql .= ' inner join grc_agenda_parametro_servico grc_aps on grc_aps.idt_servico = grc_ae.idt  ';
$sql .= " where ativo = 'S' ";
$sql .= " and  grc_aps.idt_ponto_atendimento = ".null($idt_ponto_atendimento);
$sql .= ' order by codigo ';
$js = " onchange = MontaVetorDuracao(); ";
$vetCampo['idt_servico'] = objCmbBanco('idt_servico', 'Escolha um Serviço', true, $sql, ' ', ' width:99%; font-size:12px;', $js);



$vetDur = Array();
if ($acao!='inc')
{
    $vetDur[$duracao] = $duracao;
}
$js = " onchange='return DuracaoConsultor();'";
$vetCampo['periodo'] = objCmbVetor('periodo', 'Duração do Atendimento (Minutos)', True, $vetDur,'',$js);

//$vetCampo['periodo'] = objInteiro('periodo', 'Duração do Atendimento (Minutos)', true, 10);


$vetFrm = Array();
$vetFrm[] = Frame('', Array(
    Array($vetCampo['ponto_atendimento']),
    Array($vetCampo[$CampoPricPai]),
	

),$class_frame,$class_titulo,$titulo_na_linha,$vetParametros);

$vetFrm[] = Frame('<span>Definição do Padrão do Período de Atendimento</span>', Array(
    Array($vetCampo['idt_servico'],'',$vetCampo['periodo']),
),$class_frame,$class_titulo,$titulo_na_linha);

$vetCad[] = $vetFrm;
?>
<script type="text/javascript">
var acao     =  '<?php   echo $acao; ?>';
var duracaow =  '<?php   echo $duracao; ?>';

var idt_ponto_atendimento =  '<?php   echo $idt_ponto_atendimento; ?>';

var duracao_ponto_atendimentow =  '<?php   echo $duracao_ponto_atendimento; ?>';


$(document).ready(function () {
   MontaVetorDuracao();
   if (acao=='inc')
   {
       id='periodo';
	   objtp        = document.getElementById(id);
       if (objtp != null) {
	       //objtp.selectedIndex=0;
	   }
	
   
   }
});


function DuracaoConsultor()
{
    var idt_servico=0;
    id='idt_servico';
	objtp = document.getElementById(id);
	if (objtp != null) {
	   idt_servico=objtp.value;
	   //alert(' Servico '+idt_servico);
	}
    var duracao_informada=0; 
	id='periodo';
	objtp = document.getElementById(id);
	if (objtp != null) {
	   duracao_informada=objtp.value;
	  // alert(' Informada '+duracao_informada+' maxima '+duracao_ponto_atendimentow);
	}
	
	
	processando();
	$.ajax({
		dataType: 'json',
		type: 'POST',
		url: 'ajax_atendimento.php?tipo=DuracaoConsultor',
		data: {
			cas: conteudo_abrir_sistema,
			duracao_informada      : duracao_informada,
			idt_ponto_atendimento  : idt_ponto_atendimento,
			idt_servico            : idt_servico
			
		},
		success: function (response) {
			if (response.erro == '') {
			
			   // alert(' SMS de Confirmação de Presença enviado com SUCESSO!');
			} else {
				$("#dialog-processando").remove();
				
				alert(url_decode(response.erro));
				id='periodo';
				objtp = document.getElementById(id);
				if (objtp != null) {
				   objtp.value="";
				}
			}
		},
		error: function (jqXHR, textStatus, errorThrown) {
			$("#dialog-processando").remove();
			alert('Erro no ajax no: ' + textStatus + ' - ' + errorThrown);
		},
		async: false
	});
	$("#dialog-processando").remove();
    return false;
}



function MontaVetorDuracao()
{
   var id='idt_servico';
   var texto_servico = "";
   objtp           = document.getElementById(id);
   if (objtp != null) {
       var indicevet = 0;
       //texto_servico = objtp.value;
	   texto_servico = objtp.options[objtp.selectedIndex].text;
	   var vet = texto_servico.split('[');
	   var texto1=vet[0];
	   var texto2=vet[1];
	   
	   var vet2   = texto2.split(']');
	   var texto3 = vet2[0];
	   
	   var vet3     = texto3.split(';');
	   //var duracao1 = vet3[0];
	   var tam      = vet3.length;
	   if (tam==1)
		{
			duracaow=Number(vet3[0]);
		}
	   var vetarma  = "";
	   for (i = 0; i < tam; i++) { 
           duracao = Number(vet3[i]);
		//   alert('bbbbb '+indicevet+' d1 '+duracaow+ ' === '+duracao );
		   if (duracaow==Number(duracao))
		   {
		       indicevet = i;
		   }
		   vetarma      = vetarma +"<option value='"+duracao+"' >"+duracao+"</option>";
       }
	   id='periodo';
	   objtp        = document.getElementById(id);
       if (objtp != null) {
	       objtp.innerHTML=vetarma;
	   }
	   objtp.selectedIndex=indicevet;
	   
	  // alert('bbbbb '+indicevet+' d1 '+duracaow+ ' === '+duracao );
	   
	   
   }
//   alert('montavetorduracao '+texto_servico+' Texto 1 '+texto1+' Texto 2 '+texto2+' duração 1 '+duracao1);

}
</script>