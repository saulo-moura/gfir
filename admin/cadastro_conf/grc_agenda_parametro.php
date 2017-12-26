<?php
$tabela = 'grc_agenda_parametro';
$alias  = 'grc_ap';
$id     = 'idt';
 
$veiodiretocad = $_GET['veiodiretocad'];
if ($veiodiretocad=="S")
{
	$_GET['idt0'] = $_GET['idCad']; // seria o pai
	
	//grc_parametros_agendamento
	//$retorno = "self.location='".$_SESSION[CS]['painel_volta']['grc_agenda_parametro_servico']."'";
	
	$retorno = "self.location='"."conteudo.php?prefixo=inc&menu=grc_parametros_agendamento&origem_tela=painel&cod_volta=tabela_apoio_atendimento'";
	
	
	$botao_volta = "{$retorno};";
	$botao_acao = '<script type="text/javascript">'.$retorno.';</script>';
}



$sql2  = "select ";
$sql2 .= "  $alias.* ";
$sql2 .= "  from {$tabela} {$alias}";
$sql2 .= "  where {$alias}.idt = ".null($_GET['id']);
$rs_aap  = execsql($sql2);
$row_aap = $rs_aap->data[0];
//$origem  = $row_aap['origem'];



$vetCampo['codigo']    = objTexto('codigo', 'Código', True, 15, 45);
$vetCampo['descricao'] = objTexto('descricao', 'Descrição', True, 60, 120);
$vetCampo['ativo']     = objCmbVetor('ativo', 'Ativo?', True, $vetSimNao);


$vetCampo['mesmo_dia']     = objCmbVetor('mesmo_dia', 'Agendar para o mesmo dia?', True, $vetSimNao,'');
$vetCampo['envia_sms_confirmacao']     = objCmbVetor('envia_sms_confirmacao', 'Enviar SMS de Confirmação?', True, $vetSimNao,'');
$vetCampo['envia_sms_cancelamento']     = objCmbVetor('envia_sms_cancelamento', 'Enviar SMS de Cancelamento?', True, $vetSimNao,'');

$vetCampo['multiplos_agendamentos']     = objCmbVetor('multiplos_agendamentos', 'Permitir Múltiplos Agendamentos por Cliente?', True, $vetSimNao,'');


$vetAbs=Array();
$vetAbs[3]='3 Dias';
$vetAbs[5]='5 Dias';
$vetAbs[7]='7 Dias';
$vetAbs[9]='9 Dias';
$vetAbs[15]='15 Dias';
$vetAbs[30]='30 Dias';
//$vetCampo['abstencao_dias']     = objCmbVetor('abstencao_dias', 'Bloqueio por Abstenção', True, $vetAbs,'');



$sql  = "select idt, codigo, descricao from grc_prazo_sms grc_ps ";
$sql .= " where grc_ps.ativo = 'S' ";
$sql .= "    or grc_ps.idt   = ".null($row_aap['abstencao_dias']);
$sql .= " order by codigo";
//$row_aap['origem']
$vetCampo['abstencao_dias'] = objCmbBanco('abstencao_dias', 'Bloqueio por Abstenção', true, $sql,'','width:100px;');

$vetCampo['tolerancia_atraso'] = objInteiro('tolerancia_atraso', 'Tolerância a Atrasos (min.)', True, 10);


$vetSMS=Array();
$vetSMS[1]='1 Dia';
$vetSMS[3]='3 Dias';
$vetSMS[5]='5 Dias';
$vetSMS[7]='7 Dias';
/*
$vetCampo['prazo_sms_confirmacao'] = objCmbVetor('prazo_sms_confirmacao', 'Prazo de Envio SMS de Confirmação?', True, $vetSMS,'');
$vetCampo['prazo_sms_cancelamento'] = objCmbVetor('prazo_sms_cancelamento', 'Prazo de Envio SMS de Cancelamento?', True, $vetSMS,'');
*/




$sql  = "select idt, codigo, descricao from grc_prazo_sms grc_ps ";
$sql .= " where grc_ps.ativo = 'S' ";
$sql .= "    or grc_ps.idt   = ".null($row_aap['prazo_sms_confirmacao']);
$sql .= " order by codigo";
$vetCampo['prazo_sms_confirmacao'] = objCmbBanco('prazo_sms_confirmacao', 'Prazo de Envio SMS de Confirmação', true, $sql,'','width:100px;');




$sql  = "select idt, codigo, descricao from grc_prazo_sms grc_ps ";
$sql .= " where grc_ps.ativo = 'S' ";
$sql .= "    or grc_ps.idt   = ".null($row_aap['prazo_sms_cancelamento']);
$sql .= " order by codigo";
$vetCampo['prazo_sms_cancelamento'] = objCmbBanco('prazo_sms_cancelamento', 'Prazo de Envio SMS de Cancelamento', true, $sql,'','width:100px;');






$maxlength  = 255;
$style      = "width:350px; height:30px;";
$js         = " onkeyup='return ContaCaracteres(this);'; ";
$vetCampo['texto_sms_confirmacao'] = objTextArea('texto_sms_confirmacao', 'Texto SMS de Confirmação', false, $maxlength, $style, $js);
$maxlength  = 255;
$style      = "width:350px; height:30px;";
$js         = " onkeyup='return ContaCaracteres(this);'; ";
$vetCampo['texto_sms_cancelamento'] = objTextArea('texto_sms_cancelamento', 'Texto SMS de Cancelamento', false, $maxlength, $style, $js);


$maxlength  = 255;
$style      = "width:350px; height:30px;";
$js         = " onkeyup='return ContaCaracteres(this);'; ";
$vetCampo['texto_sms_vespera'] = objTextArea('texto_sms_vespera', 'Texto SMS de Véspera', false, $maxlength, $style, $js);
$maxlength  = 255;
$style      = "width:350px; height:30px;";
$js         = " onkeyup='return ContaCaracteres(this);'; ";
$vetCampo['texto_sms_agradecimento'] = objTextArea('texto_sms_agradecimento', 'Texto SMS de Agradecimento', false, $maxlength, $style, $js);
$maxlength  = 255;
$style      = "width:350px; height:30px;";
$js         = " onkeyup='return ContaCaracteres(this);'; ";
$vetCampo['texto_sms_cancelamento_sebrae'] = objTextArea('texto_sms_cancelamento_sebrae', 'Texto SMS de Cancelamento Sebrae', false, $maxlength, $style, $js);


$sql  = "select idt, codigo, descricao from grc_prazo_sms grc_ps ";
$sql .= " where grc_ps.ativo = 'S' ";
$sql .= "    or grc_ps.idt   = ".null($row_aap['prazo_sms_vespera']);
$sql .= " order by codigo";
$vetCampo['prazo_sms_vespera'] = objCmbBanco('prazo_sms_vespera', 'Prazo de Envio SMS de Véspera', true, $sql,'','width:100px;');
$sql  = "select idt, codigo, descricao from grc_prazo_sms grc_ps ";
$sql .= " where grc_ps.ativo = 'S' ";
$sql .= "    or grc_ps.idt   = ".null($row_aap['prazo_sms_agradecimento']);
$sql .= " order by codigo";
$vetCampo['prazo_sms_agradecimento'] = objCmbBanco('prazo_sms_agradecimento', 'Prazo de Envio SMS de Agradecimento', true, $sql,'','width:100px;');
$sql  = "select idt, codigo, descricao from grc_prazo_sms grc_ps ";
$sql .= " where grc_ps.ativo = 'S' ";
$sql .= "    or grc_ps.idt   = ".null($row_aap['prazo_sms_cancelamento_sebrae']);
$sql .= " order by codigo";
$vetCampo['prazo_sms_cancelamento_sebrae'] = objCmbBanco('prazo_sms_cancelamento_sebrae', 'Prazo de Envio SMS de Cancelamento Sebrae', true, $sql,'','width:100px;');


$vetCampo['envia_sms_vespera']             = objCmbVetor('envia_sms_vespera', 'Enviar SMS de Véspera?', True, $vetSimNao,'');
$vetCampo['envia_sms_agradecimento']       = objCmbVetor('envia_sms_agradecimento', 'Enviar SMS de Agradecimento?', True, $vetSimNao,'');
$vetCampo['envia_sms_cancelamento_sebrae'] = objCmbVetor('envia_sms_cancelamento_sebrae', 'Enviar SMS de Cancelamento Sebrae?', True, $vetSimNao,'');






$class_frame_f = "class_frame_f";
$class_titulo_f = "class_titulo_f";
$class_frame_p = "class_frame_p";
$class_titulo_p = "class_titulo_p";
$class_frame = "class_frame";
$class_titulo = "class_titulo";
$titulo_na_linha = false;


//
$maxlength  = 2000;
$style      = "width:700px;";
$js         = "";
$vetCampo['detalhe'] = objTextArea('detalhe', 'Detalhe', false, $maxlength, $style, $js);
//$sql = "select idt, codigo, descricao from plu_estado order by descricao";
//$vetCampo['idt_estado'] = objCmbBanco('idt_estado', 'Estado', true, $sql,'','width:180px;');
$vetFrm = Array();
if ($acao!='alt')
{
	$vetFrm[] = Frame('', Array(
		Array($vetCampo['codigo'],'',$vetCampo['descricao'],'',$vetCampo['ativo']),
	),$class_frame,$class_titulo,$titulo_na_linha);
}


MesclarCol($vetCampo['texto_sms_confirmacao'], 3);
MesclarCol($vetCampo['texto_sms_cancelamento'], 3);
MesclarCol($vetCampo['texto_sms_cancelamento_sebrae'], 3);
MesclarCol($vetCampo['texto_sms_vespera'], 3);
MesclarCol($vetCampo['texto_sms_agradecimento'], 3);
$vetFrm[] = Frame('', Array(
    Array($vetCampo['mesmo_dia'],'',$vetCampo['abstencao_dias'],'',$vetCampo['multiplos_agendamentos'],'',$vetCampo['tolerancia_atraso']),
	Array($vetCampo['envia_sms_confirmacao'],'',$vetCampo['prazo_sms_confirmacao'],'',$vetCampo['texto_sms_confirmacao']),
	Array($vetCampo['envia_sms_cancelamento'],'',$vetCampo['prazo_sms_cancelamento'],'',$vetCampo['texto_sms_cancelamento']),
	Array($vetCampo['envia_sms_vespera'],'',$vetCampo['prazo_sms_vespera'],'',$vetCampo['texto_sms_vespera']),
	Array($vetCampo['envia_sms_agradecimento'],'',$vetCampo['prazo_sms_agradecimento'],'',$vetCampo['texto_sms_agradecimento']),
	Array($vetCampo['envia_sms_cancelamento_sebrae'],'',$vetCampo['prazo_sms_cancelamento_sebrae'],'',$vetCampo['texto_sms_cancelamento_sebrae']),
	
),$class_frame,$class_titulo,$titulo_na_linha);



// Serviços
$vetParametros = Array(
		'codigo_frm' => 'grc_agenda_parametro_servico_w',
		'controle_fecha' => 'A',
		

	
);
$vetFrm[] = Frame('<span>CADASTRO DE SERVIÇOS DO PA</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

// Definição de campos formato full que serão editados na tela full

$vetCampo = Array();
$vetCampo['ponto_atendimento'] = CriaVetTabela('Ponto Atendimento');
$vetCampo['servico']           = CriaVetTabela('Serviço');
$vetCampo['periodo']           = CriaVetTabela('Duração do Atendimento<br />(Minutos)');
//$vetCampo['quantidade_periodo'] = CriaVetTabela('Quantidade de Períodos<br /> (Minutos)');

$titulo = 'Cadastro de Serviços PA';
$TabelaPrinc      = "grc_agenda_parametro_servico";
$AliasPric        = "grc_aps";
$Entidade         = "Serviço  do Parâmetro ";
$Entidade_p       = "Serviços do Parâmetro ";
// Select para obter campos da tabela que serão utilizados no full
$orderby = "sca_os.descricao, grc_ae.descricao  ";
$sql  = "select {$AliasPric}.*, ";
$sql .= "       grc_ae.descricao as servico, ";
$sql .= "       sca_os.descricao as ponto_atendimento ";
$sql .= " from {$TabelaPrinc} {$AliasPric}  ";
$sql .= " inner join grc_atendimento_especialidade grc_ae on  grc_ae.idt = {$AliasPric}.idt_servico ";
$sql .= " inner join ".db_pir."sca_organizacao_secao sca_os on  sca_os.idt = {$AliasPric}.idt_ponto_atendimento";
//
$sql .= " where {$AliasPric}".'.idt_parametro = $vlID';
$sql .= " order by {$orderby}";
$vetCampo['grc_agenda_parametro_servico'] = objListarConf('grc_agenda_parametro_servico', 'idt', $vetCampo, $sql, $titulo, false,$vetParametros);
$vetParametros = Array(
	'codigo_pai' => 'grc_agenda_parametro_servico_w',
	'width' => '100%',
);
$vetFrm[] = Frame('', Array(
	Array($vetCampo['grc_agenda_parametro_servico']),
),$class_frame,$class_titulo,$titulo_na_linha,$vetParametros);



/*

// Suspensão
$vetParametros = Array(
		'codigo_frm' => 'grc_agenda_parametro_suspensao_w',
		'controle_fecha' => 'A',
);
$vetFrm[] = Frame('<span>CADASTRO DE DATAS DE SUSPENSÃO EXPEDIENTE</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

// Definição de campos formato full que serão editados na tela full

$vetCampo = Array();
$vetCampo['ponto_atendimento'] = CriaVetTabela('Ponto Atendimento');
$vetCampo['data']              = CriaVetTabela('Data','data');
$vetCampo['observacao']        = CriaVetTabela('Observação');
$titulo = 'Cadastro de Datas de Suspensão Expediente';
$TabelaPrinc      = "grc_agenda_parametro_suspensao";
$AliasPric        = "grc_aps";
$Entidade         = "Serviço  do Parâmetro ";
$Entidade_p       = "Serviços do Parâmetro ";
// Select para obter campos da tabela que serão utilizados no full
$orderby = "sca_os.descricao, {$AliasPric}.data  ";
$sql  = "select {$AliasPric}.*, ";
$sql .= "       sca_os.descricao as ponto_atendimento ";
$sql .= " from {$TabelaPrinc} {$AliasPric}  ";
$sql .= " inner join ".db_pir."sca_organizacao_secao sca_os on  sca_os.idt = {$AliasPric}.idt_ponto_atendimento";
//
$sql .= " where {$AliasPric}".'.idt_parametro = $vlID';
$sql .= "   and tipo <> 'N' ";
$sql .= " order by {$orderby}";
$vetCampo['grc_agenda_parametro_suspensao'] = objListarConf('grc_agenda_parametro_suspensao', 'idt', $vetCampo, $sql, $titulo, false,$vetParametros);
$vetParametros = Array(
	'codigo_pai' => 'grc_agenda_parametro_suspensao_w',
	'width' => '100%',
);
$vetFrm[] = Frame('', Array(
	Array($vetCampo['grc_agenda_parametro_suspensao']),
),$class_frame,$class_titulo,$titulo_na_linha,$vetParametros);

*/

$vetCad[] = $vetFrm;
?>

<script>
$(document).ready(function () {
/*
   // Cancelamento
   var quantidade_texto="0 Caracteres";
   objd=document.getElementById('texto_sms_cancelamento');
   if (objd != null)
   {
       texto            = objd.value;
	   var tam          = texto.length;
	   quantidade_texto = tam+' caracteres';
    }
   objd=document.getElementById('texto_sms_cancelamento_desc');
   if (objd != null)
   {
	   var textohtml = "<div id='texto_sms_cancelamento_desc_qtd' >"+quantidade_texto+"</b>";
	   var para = document.createElement("div");               // Create a <p> node
	   para.id = 'texto_sms_cancelamento_desc_qtd';
	  
       var t = document.createTextNode(quantidade_texto);        // Create a text node
       para.appendChild(t);                                      // Append the text to <p>
	   objd.appendChild(para);
	   objd=document.getElementById('texto_sms_cancelamento_desc_qtd');
       if (objd != null)
       {
	      $(objd).css('float','right'); 
		  $(objd).css('padding-top','10px'); 
		  $(objd).css('padding-right','10px'); 
	   }
   }
*/   
   // Confirmação
   CriarElementoContador('texto_sms_confirmacao');
   // Cancelamento
   CriarElementoContador('texto_sms_cancelamento');
   // Vespera
   CriarElementoContador('texto_sms_vespera');
   // Agradecimento
   CriarElementoContador('texto_sms_agradecimento');
   // Cancelamento Sebrae
   CriarElementoContador('texto_sms_cancelamento_sebrae');
 
});
function CriarElementoContador(elemento)
{
   var quantidade_texto="0 Caracteres";
   objd=document.getElementById(elemento);
   if (objd != null)
   {
       texto            = objd.value;
	   var tam          = texto.length;
	   quantidade_texto = tam+' caracteres';
   }
   var elemento_desc = elemento+'_desc';
   objd=document.getElementById(elemento_desc);
   if (objd != null)
   {
	   var para = document.createElement("div");               // Create a <p> node
	   
	   var elemento_desc_qtd = elemento_desc+'_qtd';
	   para.id = elemento_desc_qtd;
	  
       var t = document.createTextNode(quantidade_texto);        // Create a text node
       para.appendChild(t);                                      // Append the text to <p>
	   objd.appendChild(para);
	   objd=document.getElementById(elemento_desc_qtd);
       if (objd != null)
       {
	      $(objd).css('float','right'); 
		  $(objd).css('padding-top','10px'); 
		  $(objd).css('padding-right','10px'); 
	   }
   }
}
function ContaCaracteres(thisw)
{
    var idt = thisw.id;
    var texto ="";
	var quantidade_texto="";
	objd=document.getElementById('texto');
	if (thisw != null)
	{
	   texto = thisw.value;
	   var tam = texto.length;
	   quantidade_texto=tam+' caracteres';
	   
	}
	var id = idt+'_desc_qtd';
	objd=document.getElementById(id);
	if (objd != null)
	{
	   objd.innerHTML = quantidade_texto;
	}
	
	return false;
}
</script>