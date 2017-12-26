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
</style>
<?php


$vetInstrumentoAnalitico = Array();

$html = "";


/*
$html .= " <div  style='width:100%; color:#000000;background:#2F66B8; xfloat:left; text-align:left; font-size:18px; color:#FFFFFF; bmargin-top:10px;  xborder-top:1px solid #000000; xborder-bottom:1px solid #000000; '>";
$html .= " ANALÍTICO ";
$html .= " </div> ";
*/
//
// Consultar o Histórico do cliente
//
	$html .= " <div  style='padding:10px; border-top:1px solid #666666; border-bottom:1px solid #666666; width:100%; color:#000000;background:#2F66B8; padding:5px;  text-align:left; font-size:18px; color:#FFFFFF; bmargin-top:10px;  xborder-top:1px solid #000000; xborder-bottom:1px solid #000000; '>";
	$html .= "Cliente: {$cliente_texto}   CPF: {$cpf} ";
	$html .= " </div> ";
    $html .= "<table class='atende_tb' width='100%' border='0' cellspacing='0' cellpadding='0' vspace='0' hspace='0'> ";
	$TabelaPrinc = "grc_atendimento_agenda";
	$AliasPric   = "grc_aa";
	$campos = "{$AliasPric}.*, ";
	$campos .= "sca_oc.descricao as ponto_atendimento,  ";
	$campos .= "sca_oc.logradouro as logradouro,  ";
	$campos .= "sca_oc.logradouro_numero as numero,  ";
	$campos .= "sca_oc.logradouro_complemento as complemento,  ";
	$campos .= "sca_oc.cep as cep,  ";
	$campos .= "sca_oc.telefone   as telefone,  ";
	$campos .= "sca_oc.horario_funcionamento as horario_funcionamento,  ";
	$campos .= "sca_oc.imagem as imagem,  ";
	$campos .= "sca_oc.logradouro_codbairro as logradouro_codbairro,  ";
	$campos .= "sca_oc.logradouro_codcid as logradouro_codcid,  ";
	$campos .= "sca_oc.logradouro_codest as logradouro_codest,  ";
	$campos .= "sca_oc.logradouro_codpais as logradouro_codpais,  ";
	$campos .= "pu.email as consultor_email,  ";
	$campos .= "pu.nome_completo as consultor,  ";
	$campos .= "gae.descricao as servico  ";
	$sql  = "select  ";
	$sql .= " $campos  ";
	$sql .= " from {$TabelaPrinc}  {$AliasPric}";
	
	$sql  .= " left  join grc_atendimento as ga on ga.idt_atendimento_agenda = {$AliasPric}.idt ";
	$sql  .= " left  join grc_atendimento_especialidade as gae on gae.idt = {$AliasPric}.idt_especialidade ";
	$sql  .= " left  join ".db_pir_gec."gec_entidade as ge on ge.idt = {$AliasPric}.idt_cliente ";
	$sql  .= " left  join plu_usuario as pu on pu.id_usuario = {$AliasPric}.idt_consultor ";
	$sql  .= " left  join grc_atendimento_agenda_painel as pn on pn.idt_atendimento_agenda = {$AliasPric}.idt ";
	$sql  .= " left  join ".db_pir."sca_organizacao_secao as sca_oc on sca_oc.idt = {$AliasPric}.idt_ponto_atendimento ";
	$strWhere  = " {$AliasPric}.idt_cliente = ".null($idt_cliente);
	$korderbyw = " sca_oc.descricao, data, hora ";
	if ($strWhere!="")
	{
		$sql .= " where (";
		$sql .= $strWhere ;
		$sql .= " )";
	}
	if ($korderbyw!="")
	{
		$sql .= " order by ";
		$sql .= $korderbyw;
	}	
	$rs = execsql($sql);
	$qtd_sel = $rs->rows;
	if ($qtd_sel == 0 )
	{
		$html .= "<tr  id='{$idtr}' style='' >  ";
		$html .= "   <td id='{$idtd}' colspan='6' class='atende_gc_linha' title='Detalha o Histórico'   style='color:#2A5696; cursor:pointer' >";
		$html .= " Erro ao acessar Histórico do Cliente. ";
		$html .= "   </td> ";
		$html .= "</tr>";
		// Nada foi selecionado
		//echo "Erro Registro de Agendamento Não Encontrado";	
		$vetParametros['erro']="Erro Registro de Agendamento Não Encontrado";	
	}    
	else
	{ 
		$linha = 0;
		$ponto_atendimentow = "##";
		ForEach($rs->data as $row)
		{
			// detalhe dos campos na row
			$idt_ponto_atendimento = $row['idt_ponto_atendimento'];
			$codigo             = $row['codigo'];
			$data               = trata_data($row['data']);
			$hora               = $row['hora'];
			$dia_semana         = $row['dia_semana'];
			$cpf                = $row['cpf'];
			$cliente_texto      = $row['cliente_texto'];
			$email              = $row['email'];
			$celular            = $row['celular'];
			$protocolo          = $row['protocolo'];
			$cpf                = $row['cpf'];
			$cnpj               = $row['cnpj'];
			$nome_empresa       = $row['nome_empresa'];
			$unidade_regional   = $row['unidade_regional'];  
			$ponto_atendimento  = $row['ponto_atendimento'];  
			$servico            = $row['servico'];  
			$consultor          = $row['consultor'];  
			$logradouro         = $row['logradouro'];  
			$numero             = $row['numero'];  
			$complemento        = $row['complemento'];  
			$cep                = $row['cep'];  
			$telefone           = $row['telefone'];  
			$horario_funcionamento=$row['horario_funcionamento'];  
			
			if ($ponto_atendimentow != $ponto_atendimento)
			{
				$ponto_atendimentow = $ponto_atendimento;
				$html .= "<tr  id='' style='' >  ";
				$html .= "   <td colspan='6' class=''   style='border-top:1px solid #666666; border-bottom:1px solid #666666; padding:5px; background:#C0C0C0; color:#000000;' >{$ponto_atendimento}</td> ";
				$html .= "</tr>";
				$html .= "<tr  style='' >  ";
				$html .= "   <td class='atende_gc'   style='padding:10px; border-top:1px solid #FFFFFF; border-bottom:1px solid #FFFFFF;' >Situação</td> ";
				$html .= "   <td class='atende_gc'   style='padding:10px; border-top:1px solid #FFFFFF; border-bottom:1px solid #FFFFFF;' >Data</td> ";
				$html .= "   <td class='atende_gc'   style='padding:10px; border-top:1px solid #FFFFFF; border-bottom:1px solid #FFFFFF;' >Hora</td> ";
				$html .= "   <td class='atende_gc'   style='padding:10px; border-top:1px solid #FFFFFF; border-bottom:1px solid #FFFFFF;' >Serviço</td> ";
				$html .= "   <td class='atende_gc'   style='padding:10px; border-top:1px solid #FFFFFF; border-bottom:1px solid #FFFFFF;' >Empresa</td> ";
				$html .= "   <td class='atende_gc'   style='padding:10px; border-top:1px solid #FFFFFF; border-bottom:1px solid #FFFFFF;' >Consultor/Atendente</td> ";
				$html .= "</tr>";

	        }
			$linha = $linha + 1;
			//$onclick = "onclick = 'return DetalhaAtendimento($codparceiro, \"$CPFCliente\", \"{$DataHoraInicioRealizacao}\", $linha,0,\"{$CNPJW}\");'";
			//
			$html .= "<tr  id='{$idtr}' style='' >  ";
			$html .= "   <td class='atende_gc_linha'   style='' >Atual</td> ";
			$html .= "   <td class='atende_gc_linha'   style='' >{$data}</td> ";
			$html .= "   <td class='atende_gc_linha'   style='' >{$hora}</td> ";
			$html .= "   <td class='atende_gc_linha'   style='' >{$servico}</td> ";
			$html .= "   <td class='atende_gc_linha'   style='' >{$nome_empresa}</td> ";
			$html .= "   <td class='atende_gc_linha'   style='' >{$consultor}</td> ";
			$html .= "</tr>";
			//
			$html .= "<tr  id='{$idtr}' style='display:none;' >  ";
			$html .= "   <td id='{$idtd}' colspan='6' class='atende_gc_linha' title='Detalha o Histórico'   style='color:#2A5696; cursor:pointer' ></td> ";
			$html .= "</tr>";

		}
	}







//////////////////////////////////////
$html .= "</table>";

$html0  = ""; 
$html0 .= " <div  style='padding:10px; border-top:1px solid #666666; border-bottom:1px solid #666666; width:100%; color:#000000;background:#2F66B8; padding:5px;  text-align:left; font-size:18px; color:#FFFFFF; bmargin-top:10px;  xborder-top:1px solid #000000; xborder-bottom:1px solid #000000; '>";
$html0 .= "Cliente: {$cliente_texto}   CPF: {$cpf} ";
$html0 .= " </div> ";



	$html = ""; 
	$html .= " <div  style='padding:10px; border-top:1px solid #666666; border-bottom:1px solid #666666; width:100%;  background:#F5F5F5; padding:5px;  text-align:left; font-size:18px; color:#0000FF; bmargin-top:10px;  xborder-top:1px solid #000000; xborder-bottom:1px solid #000000; '>";
	$html .= " DETALHE DO AGENDAMENTO ";
	$html .= " </div> ";

	$html .= "<table class='atende_tb' width='100%' border='0' cellspacing='0' cellpadding='0' vspace='0' hspace='0'> ";
	$TabelaPrinc = "grc_atendimento_agenda";
	$AliasPric   = "grc_aa";
	$campos = "{$AliasPric}.*, ";
	$campos .= "sca_oc.descricao as ponto_atendimento,  ";
	$campos .= "sca_oc.logradouro as logradouro,  ";
	$campos .= "sca_oc.logradouro_numero as numero,  ";
	$campos .= "sca_oc.logradouro_complemento as complemento,  ";
	$campos .= "sca_oc.cep as cep,  ";
	$campos .= "sca_oc.telefone   as telefone,  ";
	$campos .= "sca_oc.horario_funcionamento as horario_funcionamento,  ";
	$campos .= "sca_oc.imagem as imagem,  ";
	$campos .= "sca_oc.logradouro_codbairro as logradouro_codbairro,  ";
	$campos .= "sca_oc.logradouro_codcid as logradouro_codcid,  ";
	$campos .= "sca_oc.logradouro_codest as logradouro_codest,  ";
	$campos .= "sca_oc.logradouro_codpais as logradouro_codpais,  ";
	$campos .= "pu.email as consultor_email,  ";
	$campos .= "pu.nome_completo as consultor,  ";
	$campos .= "gae.descricao as servico,  ";
	$campos .= "grc_aal.dataregistro as grc_aal_dataregistro,  ";
	$campos .= "grc_aal.tipo as grc_aal_tipo,  ";
	$campos .= "grc_aal.protocolo as grc_aal_protocolo,  ";
	$campos .= "grc_aal.marcador as grc_aal_marcador,  ";
	$campos .= "grc_aal.observacao as grc_aal_observacao,  ";
	$campos .= "grc_aal.situacao as grc_aal_situacao  ";
	
	$sql   = "select  ";
	$sql  .= " $campos  ";
	$sql  .= " from {$TabelaPrinc}  {$AliasPric}";
	$sql  .= " left  join grc_atendimento_agenda_log as grc_aal on grc_aal.idt_atendimento_agenda = {$AliasPric}.idt ";
	$sql  .= " left  join grc_atendimento as ga on ga.idt_atendimento_agenda = {$AliasPric}.idt ";
	$sql  .= " left  join grc_atendimento_especialidade as gae on gae.idt = grc_aal.idt_especialidade ";
	$sql  .= " left  join ".db_pir_gec."gec_entidade as ge on ge.idt = grc_aal.idt_cliente ";
	$sql  .= " left  join plu_usuario as pu on pu.id_usuario = grc_aal.idt_consultor ";
	$sql  .= " left  join grc_atendimento_agenda_painel as pn on pn.idt_atendimento_agenda = {$AliasPric}.idt ";
	$sql  .= " left  join ".db_pir."sca_organizacao_secao as sca_oc on sca_oc.idt = {$AliasPric}.idt_ponto_atendimento ";
	$strWhere  = " grc_aal.idt_cliente = ".null($idt_cliente);
	$strWhere .= " and grc_aal.neutro  <> ".aspa('S');
	$korderbyw = " sca_oc.descricao, dataregistro, data, hora ";
	if ($strWhere!="")
	{
		$sql .= " where (";
		$sql .= $strWhere ;
		$sql .= " )";
	}
	if ($korderbyw!="")
	{
		$sql .= " order by ";
		$sql .= $korderbyw;
	}	
	$rs = execsql($sql);
	$qtd_sel = $rs->rows;
	//
	$vetEstatisticaClienteQtd=Array();
	$vetEstatisticaClientePAQtd=Array();
	$vetEstatisticaClienteTipo=Array();
	$vetEstatisticaClienteTipo['MARCADO']   ="Marcação";
	$vetEstatisticaClienteTipo['DESMARCADO']="Desmarcação<br /> pelo Cliente";
	$vetEstatisticaClienteTipo['EXCLUIDO']  ="Desmarcação<br /> pelo Sebrae";
	$vetEstatisticaClienteTipo['TOTAL']     ="Total<br /> Agendado";
	$qtd_tipo = count($vetEstatisticaClienteTipo);
	foreach ($vetEstatisticaClienteTipo as $tipo => $descricao) {
        $vetEstatisticaClienteQtd[$tipo]=0;
	}		
	if ($qtd_sel == 0 )
	{
		$html .= "<tr  id='{$idtr}' style='' >  ";
		$html .= "   <td id='{$idtd}' colspan='9' class='atende_gc_linha' title='Detalha o Histórico'   style='font-size:20px; padding:20px; text-align:center; background:#F9F9F9; color:#2A5696; cursor:pointer' >";
		$html .= " Cliente sem Histórico. ";
		$html .= "   </td> ";
		$html .= "</tr>";
		// Nada foi selecionado
		//echo "Erro Registro de Agendamento Não Encontrado";	
		$vetParametros['erro']="Erro Registro de Agendamento Não Encontrado";	
	}    
	else
	{ 
		$linha = 0;
		$ponto_atendimentow = "##";
		ForEach($rs->data as $row)
		{
			// detalhe dos campos na row
			$idt_atendimento_agenda = $row['idt'];
			$idt_ponto_atendimento  = $row['idt_ponto_atendimento'];
			$codigo             = $row['codigo'];
			$data               = trata_data($row['data']);
			$hora               = $row['hora'];
			$dia_semana         = $row['dia_semana'];
			$cpf                = $row['cpf'];
			$cliente_texto      = $row['cliente_texto'];
			$marcador           = $row['grc_aal_marcador'];
			$email              = $row['email'];
			$celular            = $row['celular'];
			$protocolo          = $row['grc_aal_protocolo'];
			$cpf                = $row['cpf'];
			$cnpj               = $row['cnpj'];
			$nome_empresa       = $row['nome_empresa'];
			$unidade_regional   = $row['unidade_regional'];  
			$ponto_atendimento  = $row['ponto_atendimento'];  
			$servico            = $row['servico'];  
			$consultor          = $row['consultor'];  
			$logradouro         = $row['logradouro'];  
			$numero             = $row['numero'];  
			$complemento        = $row['complemento'];  
			$cep                = $row['cep'];  
			$telefone           = $row['telefone'];  
			$horario_funcionamento=$row['horario_funcionamento'];  
			
			$observacao         = $row['grc_aal_observacao'];  
			
			$grc_aal_situacao   = $row['grc_aal_situacao']; 
            $grc_aal_dataregistro = trata_data($row['grc_aal_dataregistro']); 			
			$grc_aal_tipo         = $row['grc_aal_tipo']; 
			$vetEstatisticaClienteQtd[$grc_aal_tipo]=$vetEstatisticaClienteQtd[$grc_aal_tipo]+1;
			if ($grc_aal_tipo=='EXCLUIDO' or $grc_aal_tipo=='DESMARCADO'  )
			{
			   $vetEstatisticaClienteQtd['TOTAL']=$vetEstatisticaClienteQtd['TOTAL']-1;
			}
			else
			{
				if ($grc_aal_tipo=='MARCADO')
			    {
					$vetEstatisticaClienteQtd['TOTAL']=$vetEstatisticaClienteQtd['TOTAL']+1; 
				}	
			}
			$vetEstatisticaClientePAQtd[$idt_ponto_atendimento][$grc_aal_tipo]=$vetEstatisticaClientePAQtd[$idt_ponto_atendimento][$grc_aal_tipo]+1;
			if ($ponto_atendimentow != $ponto_atendimento)
			{
				$ponto_atendimentow = $ponto_atendimento;
				$html .= "<tr  id='' style='' >  ";
				$html .= "   <td colspan='9' class=''   style='border-top:1px solid #666666; border-bottom:1px solid #666666; padding:5px; background:#C0C0C0; color:#000000;' >{$ponto_atendimento}</td> ";
				$html .= "</tr>";
				$html .= "<tr  style='' >  ";
				$html .= "   <td class='atende_gc'   style='width:80px; padding:10px; border-top:1px solid #FFFFFF; border-bottom:1px solid #FFFFFF;' >Data Registro</td> ";
				
				$html .= "   <td class='atende_gc'   style='padding:10px; border-top:1px solid #FFFFFF; border-bottom:1px solid #FFFFFF;' >Protocolo</td> ";
				$html .= "   <td class='atende_gc'   style='padding:10px; border-top:1px solid #FFFFFF; border-bottom:1px solid #FFFFFF;' >Tipo Evento</td> ";
				
				$html .= "   <td class='atende_gc'   style='padding:10px; border-top:1px solid #FFFFFF; border-bottom:1px solid #FFFFFF;' >Data<br >Agenda</td> ";
				$html .= "   <td class='atende_gc'   style='padding:10px; border-top:1px solid #FFFFFF; border-bottom:1px solid #FFFFFF;' >Hora<br >Agenda</td> ";
			
				
				$html .= "   <td class='atende_gc'   style='padding:10px; border-top:1px solid #FFFFFF; border-bottom:1px solid #FFFFFF;' >Consultor/Atendente</td> ";
				$html .= "   <td class='atende_gc'   style='padding:10px; border-top:1px solid #FFFFFF; border-bottom:1px solid #FFFFFF;' >Responsável</td> ";
				$html .= "   <td class='atende_gc'   style='padding:10px; border-top:1px solid #FFFFFF; border-bottom:1px solid #FFFFFF;' >Empresa</td> ";
					$html .= "   <td class='atende_gc'   style='padding:10px; border-top:1px solid #FFFFFF; border-bottom:1px solid #FFFFFF;' >Serviço</td> ";
				$html .= "</tr>";
	        }
			$linha = $linha + 1;
			$html .= "<tr  id='{$idtr}' style='' >  ";
			$html .= "   <td class='atende_gc_linha'   style='' >{$grc_aal_dataregistro}</td> ";
			
			$html .= "   <td class='atende_gc_linha'   style='' >{$protocolo}</td> ";
			$hint = $observacao;
			$html .= "   <td class='atende_gc_linha' title='{$hint}'   style='' >{$grc_aal_tipo}</td> ";
			
			$html .= "   <td class='atende_gc_linha'   style='' >{$data}</td> ";
			$html .= "   <td class='atende_gc_linha'   style='' >{$hora}</td> ";
			
			$html .= "   <td class='atende_gc_linha'   style='' >{$consultor}</td> ";
			$html .= "   <td class='atende_gc_linha'   style='' >{$marcador}</td> ";
			$html .= "   <td class='atende_gc_linha'   style='' >{$nome_empresa}</td> ";
			$html .= "   <td class='atende_gc_linha'   style='' >{$servico}</td> ";
			
			
			$html .= "</tr>";
			
			//$html .= "<tr  id='{$idtr}' style='display:none;' >  ";
			//$html .= "   <td id='{$idtd}' colspan='9' class='atende_gc_linha' title='Detalha o Histórico'   style='color:#2A5696; cursor:pointer' ></td> ";
			//$html .= "</tr>";
		}
	}
	
	
	
	
	
//////////////////////////////////////
$html .= "</table>";

// Montar Resumo
//p($vetEstatisticaClienteTipo);
//p($vetEstatisticaClienteQtd);
//p($vetEstatisticaClientePAQtd);
//	
$html1  = "";	
$html1 .= " <div  style='padding:10px; border-top:1px solid #666666; border-bottom:1px solid #666666; width:100%;  background:#F5F5F5; padding:5px;  text-align:left; font-size:18px; color:#0000FF; bmargin-top:10px;  xborder-top:1px solid #000000; xborder-bottom:1px solid #000000; '>";
$html1 .= " RESUMO DO AGENDAMENTO ";
$html1 .= " </div> ";
$html1 .= "<table class='' width='100%' border='0' cellspacing='0' cellpadding='0' vspace='0' hspace='0'> ";
// TIPOS
$html1 .= "<tr  style='' >  ";
foreach ($vetEstatisticaClienteTipo as $tipo => $descricao) {
    $html1 .= "   <td class=''   style='text-align:center; background:#FFFFFF; color:#000000; padding:10px; border-top:1px solid #FFFFFF; border-bottom:1px solid #FFFFFF;' >";
	$html1 .= $descricao;
	$html1 .= "</td> ";
}
$html1 .= "   <td class=''   style='text-align:center; background:#FFFFFF; color:#000000; padding:10px; border-top:1px solid #FFFFFF; border-bottom:1px solid #FFFFFF;' >";
$html1 .= "INDICE %<br />CLIENTE";
$html1 .= "</td> ";

$html1 .= "</tr>";
// QUANTITATIVOS
$html1 .= "<tr  style='' >  ";
$indicew = "";
$TOTALVALIDO = $vetEstatisticaClienteQtd['MARCADO']-$vetEstatisticaClienteQtd['EXCLUIDO'];
if ($TOTALVALIDO!=0)
{
	$indice  = 100-(($vetEstatisticaClienteQtd['DESMARCADO']/($TOTALVALIDO))*100);
	$indicew = format_decimal($indice,2)." %";
}	



foreach ($vetEstatisticaClienteTipo as $tipo => $descricao) {
    $html1 .= "   <td class=''   style='text-align:center; background:#FFFFFF; color:#000000; padding:10px; border-top:1px solid #FFFFFF; border-bottom:1px solid #FFFFFF;' >";
	$qtd = $vetEstatisticaClienteQtd[$tipo];
	$html1 .= $qtd;
	$html1 .= "</td> ";
}
$html1 .= "   <td class=''   style='text-align:center; background:#FFFFFF; color:#000000; padding:10px; border-top:1px solid #FFFFFF; border-bottom:1px solid #FFFFFF;' >";
$html1 .= $indicew;
$html1 .= "</td> ";
$html1 .= "</tr>";

$html1 .= "</table>";


echo $html0.$html1.$html;


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
	/*
    function DetalhaAtendimento(CodCliente, CPFCliente, DataHoraInicioRealizacao, linha, opcao, CNPJ)
    {
        // alert(' Detalha o atendimento '+CodCliente+" Hora "+DataHoraInicioRealizacao+" CNPJ "+CNPJ);
        //
        // CHAMAR O DETALHAMENTO DO ATENDIMENTO
        //
        var str = "";
        var titulo = "Detalhar Histórico de Atendimento. Aguarde...";
        processando_grc(titulo, '#2F66B8');

        $.post('ajax_atendimento.php?tipo=DetalharHistorico', {
            async: false,
            CodCliente: CodCliente,
            CPFCliente: CPFCliente,
            CNPJ: CNPJ,
            DataHoraInicioRealizacao: DataHoraInicioRealizacao,
            linha: linha,
            opcao: opcao
        }
        , function (str) {
            if (str == '') {
                alert('Erro detalhar historico ' + str);
                processando_acabou_grc();
            } else {
                var id = 'detalhehistr_' + linha;
                objtp = document.getElementById(id);
                if (objtp != null) {
                    $(objtp).show();
                }
                var id = 'detalhehistd_' + linha;
                objtp = document.getElementById(id);
                if (objtp != null) {
                    objtp.innerHTML = str;
                }
                processando_acabou_grc();
            }
        });



        return false;
    }

    function  FechaDetalhe(linha)
    {
        var id = 'detalhehistr_' + linha;
        objtp = document.getElementById(id);
        if (objtp != null) {
            $(objtp).hide();
        }
    }

    */





</script>
