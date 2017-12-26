<style>
 #nm_funcao_desc label{
    }
    #nm_funcao_obj {
    }
    .Tit_Campo {
    }
    .Tit_Campo_Obr {
    }
    fieldset.class_frame {
        background:#ECF0F1;
        border:1px solid #14ADCC;
    }
    div.class_titulo {
        background: #ABBBBF;
        border    : 1px solid #14ADCC;
        color     : #FFFFFF;
        text-align: left;
    }
    div.class_titulo span {
        padding-left:10px;
    }


    fieldset.class_frame_f {
        background:#2F66B8;
        border:1px solid #FFFFFF;
        guyheight:30px;
    }
    div.class_titulo_f {
        background: #2F66B8;
        border    : 1px solid #2C3E50;
        color     : #FFFFFF;
        text-align: left;
        guyheight:30px;
        padding-top:10px;
    }
    div.class_titulo_f span {
        padding-left:20px;
        text-align: left;
    }

    fieldset.class_frame_p {
        xbackground:#ABBBBF;
        xborder:1px solid #FFFFFF;

        background:#FFFFFF;
        border:0px solid #FFFFFF;



    }
    div.class_titulo_p {
        xbackground: #ABBBBF;
        xborder    : 1px solid #2C3E50;
        xcolor     : #FFFFFF;
        text-align: left;
        xbackground: #F1F1F1;

        background: #ECF0F1;

        background: #C4C9CD;


        border    : 0px solid #2C3E50;
        color     : #FFFFFF;

    }
    div.class_titulo_p span {
        padding-left:20px;
        text-align: left;
    }

    div.class_titulo_p_barra {
        text-align: left;
        background: #C4C9CD;
        border    : 0px solid #2C3E50;
        color     : #FFFFFF;
        font-weight: bold;
        line-height: 12px;
        margin: 0;
        padding: 3px;
        padding-left: 10px;
    }


    fieldset.class_frame {
        xbackground:#ECF0F1;
        xborder:1px solid #2C3E50;
        background:#FFFFFF;
        border:0px solid #2C3E50;
    }
    div.class_titulo {
        xbackground: #C4C9CD;
        xborder    : 1px solid #2C3E50;
        xcolor     : #FFFFFF;
        text-align: left;

        background: #FFFFFF;
        color     : #FFFFFF;
        border    : 0px solid #2C3E50;


    }
    div.class_titulo span {
        padding-left:10px;
    }

    Select {
        border:0px;
        min-height: 25px;
        padding-left: 3px;
        padding-right: 3px;
        padding-top: 5px;
    }

    .TextoFixo {

        font-size:12px;
        guyheight:25px;
        text-align:left;
        border:0px;
        xbackground:#F1F1F1;
        background:#ECF0F1;


        font-weight:normal;

        font-family: Lato Regular, Calibri, Arial,  Helvetica, sans-serif;
        color:#5C6D7E;
        font-style: normal;
        word-spacing: 0px;
        padding-top:5px;



    }
    .Texto {

        font-size:12px;
        guyheight:25px;
        text-align:left;
        border:0px;
        xbackground:#F1F1F1;
        background:#ECF0F1;


        font-weight:normal;

        font-family: Lato Regular, Calibri, Arial,  Helvetica, sans-serif;
        color:#5C6D7E;
        font-style: normal;
        word-spacing: 0px;
        padding-top:5px;

    }

    td.Titulo {
        color:#666666;
    }


.botao_ag {
    text-align:center;
    width:180px;
    height:35px;
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

} 
.botao_ag:hover {
    background:#0000FF;
     

}
.botao_ag_bl {
    text-align:center;
    width:180px;
    height:35px;
    color:#FFFFFF;
    //background:#0000FF;
    background:#2F65BB;
    font-size:14px;
    cursor:pointer;
    float:left;
    margin-top:10px;
    margin-right:10px;
    xpadding-top:20px;
    xpadding-right:20px;
    font-weight:bold; 

} 
.botao_ag_bl:hover {
    background:#0000FF;
     

}

</style> 

<?php
$tabela = 'grc_atendimento_agenda';
$id = 'idt';
$veio_at    = $_GET['veio_at'];

//echo " pelo menos to aqui ------------------------------------------------------ <br/>";
// p($_GET);
$idt_atendimento = $_GET['idt_atendimento'];



$cpf_at                  = "";
$nome_at                 = "";
$telefone_residencial_at = "";
$telefone_celular_at     = "";
$email_at                = "";
$data_nascimento_at      = "";
$cnpj_at                 = "";
$nome_empresa_at         = "";

if ($veio_at=='AT')
{
   if ($idt_atendimento>0)
   {
     $sql  = "select  ";
     $sql .= " grc_ap.cpf,  ";
	 $sql .= " grc_ap.nome,  ";
	 $sql .= " grc_ap.telefone_residencial,  ";
	 $sql .= " grc_ap.telefone_celular,  ";
	 $sql .= " grc_ap.email,  ";
	 $sql .= " grc_ap.data_nascimento  ";
     $sql .= " from grc_atendimento grc_a ";
	 $sql .= " inner join grc_atendimento_pessoa grc_ap on grc_ap.idt_atendimento = grc_a.idt  ";
     $sql .= " where grc_a.idt = {$idt_atendimento} ";
	 $sql .= "   and grc_ap.tipo_relacao = ".aspa('L');
     $rs = execsql($sql);
     $wcodigo = '';
     ForEach($rs->data as $row)
     {
         $cpf_at                  = $row['cpf'];
		 $nome_at                 = $row['nome'];
		 $telefone_residencial_at = $row['telefone_residencial'];
		 $telefone_celular_at     = $row['telefone_celular'];
		 $email_at                = $row['email'];
		 $data_nascimento_at      = trata_data($row['data_nascimento']);
	 } 
   
   }
   else
   {
      // Erro - veio de uma atendimento sem ter o idt do atendimento
	  echo "ERRO VEIO DO ATENDIMENTO SEM IDT";
      die();   
   }



}


$vetParametrosw=Array();
DadosPARAGENDA($vetParametrosw);
$row_par=$vetParametrosw['row_ap'];

$idt_atendimento_agenda = $_GET['id'];
$idt_cliente            = 0;
$idt_ponto_atendimento  = $_GET['idt0'];

$bt_alterar_lbl = 'Registrar Marcação';
if ($_GET['acaoc']=='con')
{

}
else
{
    $bt_voltar_lbl  = 'Retorna sem Registrar Marcação';
}
$onSubmitDep    = 'grc_atendimento_agenda_marcacao_dep()';
$botao_volta    = "btAcaoVoltar();";

$botao_acao      = '<script type="text/javascript">';
$botao_acao     .= ' $(document).ready(function () { ';
$botao_acao     .= ' top.close();';
$botao_acao     .= '});';
$botao_acao     .= '</script>';


//echo " tirei botão ------------------------------------------------------ <br/>";

$callcenter  = $_SESSION[CS]['fu_callcenter'];
$balcao      = $_SESSION[CS]['fu_balcao'];
$recepcao    = $_SESSION[CS]['fu_recepcao'];
//p($_SESSION[CS]);

echo "<div class='cab_1' >";
if ($recepcao==1)
{
  //echo "  ATENDIMENTO DE RECEPÇÃO";
}

if ($balcao==1)
{
    //echo "  ATENDIMENTO DE BALCAO";
}
if ($callcenter==1)
{
   //echo "  ATENDIMENTO EM CALL CENTER";
}
echo "</div>";

//p($_GET);
//echo "$acao";

if ($acao!='inc')
{
     $sql  = "select  ";
     $sql .= " grc_aa.*  ";
     $sql .= " from grc_atendimento_agenda grc_aa ";
     $sql .= " where idt = {$idt_atendimento_agenda} ";
     $rs = execsql($sql);
     $wcodigo = '';
     ForEach($rs->data as $row)
     {
         $situacao     = $row['situacao'];
		 $semmarcacao  = $row['semmarcacao'];
		 $idt_marcador = $row['idt_marcador'];
		 $marcador     = $row['marcador'];
         $origem       = $row['origem'];
		 $data_banco   = $row['data'];
		 $hora         = $row['hora'];
         $idt_cliente            = $row['idt_cliente'];
         $idt_ponto_atendimento  = $row['idt_ponto_atendimento'];
         $idt_consultor          = $row['idt_consultor'];                      // incluído 07/08/2015 - gilmar
		 
		 //echo " {$situacao} cli= {$idt_cliente} pa =  {$idt_ponto_atendimento} Con =  {$idt_consultor}<br />";
		 if ($idt_cliente=="")
		 {
		     $idt_cliente=0;
		 }
		 // teste
		 /*
		 $idt_servico= $row['idt_especialidade'];
		 $vetRetorno = Array();
		 if ($idt_servico>0)
		 {
		     echo " $idt_atendimento_agenda -- $idt_servico -- $hora <br />";
			 FormarGrupoHorario($idt_atendimento_agenda,$idt_servico,$vetRetorno);
			 p($vetRetorno);
		 }
		 */
		 //
		 
     }
	 
	 
//	 $_GET['acaoc']='con';
if ($_GET['acaoc']=='con')
{
	alert('Visualizando Marcação');
	$acao='con';
}
else
{
	 if ($situacao!='Agendado')
     {
	     alert('Situação Não Permite Marcação');
         $acao='con';
     }
	 else
	 {
	 
		if ($_SESSION[CS]['g_id_usuario'] == 1 and $idt_marcador > 0)
		{
		    
			 alert("Esse Horário esta sendo Marcado agora por: {$marcador}<br />Como vc tem Direito, pode tomar essa Marcação dele<br /> ");
			 $semmarcacao='N';
		}
	 
		 if ($semmarcacao!='S')
		 {
			// Livre para Marcação 
			$data_hoje_banco = date('Y-m-d'); 
			$hora_hoje_banco = date('H:i'); 
			$aindavalida='N';
			$par_mesmodia=0;
			if ($row_par['mesmo_dia']=='S')
			{
			    $par_mesmodia=1;
			}
			if ($par_mesmodia==0)
			{
			    // não aceita no mesmo dia
				if ($data_banco > $data_hoje_banco)
				{
					if ($data_banco == $data_hoje_banco)
					{
						if ($hora > $hora_hoje_banco)
						{
							$aindavalida="S";
						}
						else
						{
							$aindavalida="N";
						}
					}	
					else
					{
						$aindavalida="S";
					}
				}
				else
				{
					$aindavalida="N";
				}
            }
            else
			{
			    // aceita no mesmo dia
			    if ($data_banco >= $data_hoje_banco)
				{
					if ($data_banco == $data_hoje_banco)
					{
						if ($hora > $hora_hoje_banco)
						{
							$aindavalida="S";
						}
						else
						{
							$aindavalida="N";
						}
					}	
					else
					{
						$aindavalida="S";
					}
				}
				else
				{
					$aindavalida="N";
				}


			}
			 
			if ($aindavalida=='S')
            {			
				$dataw         = date('d/m/Y H:i:s');
				$data_marcacao = trata_data($dataw);
				$protocolo     = "";
				$tabela        = 'grc_atendimento_agenda';
				$Campo         = 'protocolo';
				$tam           = 7;
				$codigow       = numerador_arquivo($tabela, $Campo, $tam);
				$codigo        = 'MA'.$codigow;
				$protocolo     = $codigo;
				$marcador      = $_SESSION[CS]['g_nome_completo'];
				$idt_marcador  = $_SESSION[CS]['g_id_usuario'];
				$sql = "update grc_atendimento_agenda ";
				$sql .= " set ";
				$sql .= " protocolo                  = ".aspa($protocolo).", ";
				$sql .= " semmarcacao                = ".aspa('S').", ";
				$sql .= " marcador                   = ".aspa($marcador).", ";
				$sql .= " idt_marcador               = ".null($idt_marcador).", ";
				$sql .= " data_hora_marcacao_inicial = ".aspa($data_marcacao)." ";
				$sql .= " where idt = ".null($idt_atendimento_agenda);
				execsql($sql);
				$vetPar=Array();
				$vetPar['tipo']                  ='INICIANDO MARCAÇÃO';
				$vetPar['idt_atendimento_agenda']=$idt_atendimento_agenda;
				$vetPar['neutro']="S";
				RegistrarLogAgendamento($vetPar);
			}
			else
			{
				if ($idt_marcador != $_SESSION[CS]['g_id_usuario'])
				{
					alert('Esse Horário não pode ser Marcado.');
					$acao='con';
				}	

			
			}
		 }
		 else
		 {
		 	if ($idt_marcador != $_SESSION[CS]['g_id_usuario'])
			{
				 alert("Esse Horário esta sendo Marcado agora por: {$marcador}<br />No momento não pode ser Utilizado. ");
				 $acao='con';
			}	 
		 }
		 
}		 
    }
	 
}
else
{




}


$deondeveio = $_GET['deondeveio'];

if ($_GET['acaoc']=='con')
{

}



//echo " ----- $deondeveio ====== $idt_cliente ";
if ($deondeveio=="")
{
    $deondeveio="";
}
//
// "MA" --- Marcação ;
//
if ($origem=="Hora Marcada")
{
    $js      = " readonly='true' style='background:#FFFF80; font-size:14px;' ";
    $js_hm   = " readonly='true' style='background:#FFFF80; font-size:14px;' ";
}
else
{
    $js    = " onclick='return DiaSemana_t(this);' style=' font-size:14px;' ";
    $js_hm   = "";
}
//$vetCampo['data'] = objData('data', 'Data Agenda', True,$js,'','S');
$vetCampo['data'] = objData('data', 'Data Agenda', True,$js,'');

$vetCampo['hora'] = objHora('hora', 'Hora', True,$js_hm);

// Indicar comprovante de Marcação para o dep
$vetCampo['acao_imprime_comprovante'] = objHidden('acao_imprime_comprovante', 'N','','',false);


//
// $vetCampo['hora'] = objCmbVetor('hora', 'Hora', false, $vetHora,' ',$js_hm);
//
$js    = " readonly='true' style='background:#FFFF80; font-size:14px;' ";
$vetCampo['observacao_chegada']     = objTexto('observacao_chegada', 'Observação Chegada', false, 30, 120,$js);
$vetCampo['observacao_atendimento'] = objTexto('observacao_atendimento', 'Observação Atendimento', false, 30, 120,$js);


$js    = " readonly='true' style='background:#FFFF80; font-size:14px;' ";
$vetCampo['data_confirmacao']   = objData('data_confirmacao', 'Data Confirmação', False, $js);

$vetCampo['hora_confirmacao'] = objTexto('hora_confirmacao', 'Hora Confirmação', False, 5, 5, $js);
$js    = " readonly='true' style='background:#FFFF80; font-size:14px;' ";
$vetCampo['hora_chegada'] = objTexto('hora_chegada', 'Hora Chegada', False, 5, 5,$js);
$vetCampo['hora_atendimento'] = objTexto('hora_atendimento', 'Hora Inicial Atendimento', False, 5, 5,$js);
$vetCampo['hora_final_atendimento'] = objTexto('hora_final_atendimento', 'Hora Final Atendimento', False, 5, 5,$js);
$vetCampo['hora_liberacao'] = objTexto('hora_liberacao', 'Hora Liberação', False, 5, 5,$js);

$js    = "   readonly='true' style='background:#FFFF80; font-size:14px;' ";
$vetCampo['dia_semana'] = objTexto('dia_semana', 'Dia Semana', false, 3, 3,$js);
//$vetCampo['telefone'] = objTexto('telefone', 'Telefone', False, 15, 15);
//$vetCampo['celular'] = objTexto('celular', 'Celular', False, 15, 15);
$vetCampo['origem'] = objTexto('origem', 'Origem', False,15,15,$js);



$js=" style='width:140px; ' ";
$js="  ";
$vetCampo['telefone']         = objTelefone('telefone', 'Telefone Fixo de Contato', false, $js);
$js=" onclick=' return TrataSMS();' ";
$vetCampo['celular']          = objTelefone('celular', 'Celular de Contato', false, $js);
$vetCampo['sms_1']            = objTelefone('sms_1', 'Celular para SMS', false, $js);
$js="  ";
$vetCampo['email']            = objEmail('email', 'Email de Contato', false, 35, 120,'S');

$js="";
$vetCampo['data_nascimento'] = objData('data_nascimento', 'Data Nascimento', True,$js,'','S');


//$sql  = "select idt, descricao from grc_atendimento_situacao_agenda ";
//$sql .= " order by descricao";
//$vetCampo['idt_situacao'] = objCmbBanco('idt_situacao', 'Situação', false, $sql,' ','width:100px;');

$js    = " readonly='true' style='background:#FFFF80; font-size:14px;' ";
$vetCampo['situacao'] = objTexto('situacao', 'Situação', false, 10, 20,$js);



if ($origem=="Hora Marcada")
{
    $js_hm   = " disabled  ";
    $style   = 'background:#FFFF80; font-size:14px; width:200px;';
    
}
else
{
    $js_hm   = "";
    $style   = ' width:700px;';
}

    $js_hm   = "";
//    $style   = ' width:300px;';
    $style   = ' width:200px;';


/*
$sql  = "select idt, descricao from grc_atendimento_especialidade ";
$sql .= " order by descricao";
*/

/*
$sql  = "select grc_ae.idt, grc_ae.tipo_atendimento, grc_ae.descricao ";
$sql .= " from grc_atendimento_pa_pessoa_servico grc_paps ";
$sql .= " inner join grc_atendimento_pa_pessoa grc_pap on grc_pap.idt = grc_paps.idt_pa_pessoa ";
$sql .= " inner join grc_atendimento_especialidade grc_ae on grc_ae.idt = grc_paps.idt_servico ";
*/

$sql  = "select grc_ae.idt, grc_ae.tipo_atendimento, grc_ae.descricao ";
$sql .= " from grc_atendimento_agenda_servico grc_aas ";
$sql .= " inner join grc_atendimento_especialidade grc_ae on grc_ae.idt = grc_aas.idt_servico ";
$sql .= " where grc_aas.idt = ".null($idt_atendimento_agenda);

//$sql .= " inner join grc_atendimento_agenda_servico grc_aas on grc_ae.idt = grc_paps.idt_servico ";


$js_hm   = " onchange = VefificaConsumoHorarios($idt_atendimento_agenda);";
//$sql .= " where grc_pap.idt_usuario = ".null($idt_consultor);
//$sql .= " order by grc_ae.tipo_atendimento, grc_ae.codigo";
$vetCampo['idt_especialidade'] = objCmbBanco('idt_especialidade', 'Serviço', true, $sql,' ',$style,$js_hm);
$js_hm   = "";

$fixaunidade=0;
$sql  = "select plu_usu.id_usuario, plu_usu.nome_completo from plu_usuario plu_usu";
$sql .= " inner join grc_atendimento_pa_pessoa grc_pap on grc_pap.idt_usuario = plu_usu.id_usuario ";
if ($idt_ponto_atendimento>0)
{
    $fixaunidade=1;
    $sql .= " where grc_pap.idt_ponto_atendimento = ".null($idt_ponto_atendimento);
}


if ($idt_consultor > 0)
{
    if ($fixaunidade == 1)
    {
       $sql .= " and plu_usu.id_usuario = ".null($idt_consultor);     // gilmar - 07/08/2015
    }
    else
    {
       $sql .= " where plu_usu.id_usuario = ".null($idt_consultor);     // gilmar - 07/08/2015
    }
}

$sql .= " order by plu_usu.nome_completo";

$js_hm   = "";
$style   = ' width:300px; background:#FFFF80; ';

$vetCampo['idt_consultor'] = objCmbBanco('idt_consultor', 'Consultor/Atendente', false, $sql,'',$style,$js_hm);

$maxlength  = 2000;
//$style      = "width:700px; ";
$style      = "height:50px; width:350px; ";
$js         = "";
$vetCampo['assunto'] = objTextArea('assunto', 'Resumo do Assunto', true, $maxlength, $style, $js);


//$sql  = "select idt, descricao from ".db_pir_gec."gec_entidade ";
//$sql .= " order by descricao";
//$vetCampo['idt_cliente'] = objCmbBanco('idt_cliente', 'Cliente', false, $sql,' ','width:400px;');

if ($veio_at=='AT')
{
	$jst    = " readonly='true' style='background:#FFFF70; font-size:14px;' ";
	$vetCampo['cpf']              = objCPF('cpf', 'CPF do Cliente', true,true,'','',$jst);

}
else
{
	if ($idt_cliente>0 and $acao!='alt')
	{
		$jst    = " readonly='true' style='background:#FFFF80; font-size:14px;' ";
		$vetCampo['cpf']              = objCPF('cpf', 'CPF do Cliente', true,true,'','',$jst);

	}
	else
	{
		$jst="  ChamaCPFEspecial(this)  ";
		$vetCampo['cpf']              = objCPF('cpf', 'CPF do Cliente', true,true,'',$jst);
	}

	if ($deondeveio=="Distancia")
	{
		 $jst="  ChamaCPFEspecial(this)  ";
		 $vetCampo['cpf']              = objCPF('cpf', 'CPF do Cliente', true,true,'',$jst);
	}
	

}
//echo " vvvvvvvvvvvvvvvv ".$veio_at;
$jse="style='width:350px;'";
$vetCampo['cliente_texto']    = objTexto('cliente_texto', 'Cliente', true, 40, 120,$jse);

if ($origem=="Hora Marcada")
{
    $vetCampo['idt_cliente']      = objListarCmb('idt_cliente', 'gec_entidade_agenda_cmb', 'Cliente', false,'350px');
}
else
{
    $vetCampo['idt_cliente']      = objListarCmb('idt_cliente', 'gec_entidade_agenda_cmb', 'Cliente', false,'450px');
}
// guy

$vetCampo['idt_cliente'] = objHidden('idt_cliente', '');
//$vetCampo['idt_cliente'] = objTexto('idt_cliente', 'idt cliente',10);

//$js1 = " style='width:30em;'";

//$vetCampo['nome'] = objTexto('nome', 'Nome Completo', true, 45, 120, $js1);
$vetCampo['confirmacao_cpf'] = objInclude('confirmacao_cpf', 'cadastro_conf/botao_atendimento_agenda_lupa_pf.php');

$vetCampo['grc_mostra_marcacao'] = objInclude('grc_mostra_marcacao', 'cadastro_conf/grc_mostra_marcacao.php');


$vetCampo['confirmacao_presenca'] = objInclude('confirmacao_presenca', 'cadastro_conf/botao_atendimento_agenda_presenca.php');

//


$jst="  ChamaCNPJEspecial(this)  ";
$vetCampo['cnpj']             = objCNPJ('cnpj', 'CNPJ da Empresa', false, true, 15,'',$jst);
$jse="style='width:350px;'";
$vetCampo['nome_empresa']     = objTexto('nome_empresa', 'Nome completo da Empresa', false, 40, 120,$jse);

$vetCampo['confirmacao_cnpj'] = objInclude('confirmacao_cnpj', 'cadastro_conf/botao_atendimento_agenda_lupa_pj.php');

$vetCampo['empresas_associadas_cpf'] = objInclude('empresas_associadas_cpf', 'cadastro_conf/grc_atendimento_agenda_marcacao_empresas_pessoa.php');

//$sql  = "select idt, descricao from ".db_pir."sca_organizacao_secao ";
//$sql .= " order by descricao";

if ($fixaunidade==0)
{   // Todos
    $sql   = 'select ';
    $sql  .= '   idt, descricao  ';
    $sql  .= ' from '.db_pir.'sca_organizacao_secao sac_os ';
    $sql  .= " where posto_atendimento = 'UR' or posto_atendimento = 'S' ";
    $sql  .= ' order by classificacao ';
    $js = " ";
    $vetCampo['idt_ponto_atendimento'] = objCmbBanco('idt_ponto_atendimento', 'Ponto Atendimento', true, $sql,' ','width:250px;',$js);

}
else
{
    $sql   = 'select ';
    $sql  .= '   idt, descricao  ';
    $sql  .= ' from '.db_pir.'sca_organizacao_secao sac_os ';
    $sql  .= " where (posto_atendimento = 'UR' or posto_atendimento = 'S' ) ";
    $sql  .= "   and idt = ".null($idt_ponto_atendimento);
    $sql  .= ' order by classificacao ';
    $js = " disabled ";
    $vetCampo['idt_ponto_atendimento'] = objCmbBanco('idt_ponto_atendimento', 'Ponto Atendimento', true, $sql,'','background:#FFFF80; width:250px;',$js);

}

$maxlength  = 10000;
//$style      = "width:700px;";
$style      = "height:50px;  width:100%;";
$js         = "";
$vetCampo['detalhe'] = objTextArea('detalhe', 'Observações para Recepção', false, $maxlength, $style, $js);
$vetCampo['confirmacao_chegada'] = objInclude('confirmacao_chegada', 'cadastro_conf/confirmacao_chegada.php');
$vetCampo['confirmacao_liberacao'] = objInclude('confirmacao_liberacao', 'cadastro_conf/confirmacao_liberacao.php');
$vetCampo['chama_atendimento'] = objInclude('chama_atendimento', 'cadastro_conf/chama_atendimento.php');
$vetCampo['confirmacao_atendimento'] = objInclude('confirmacao_atendimento', 'cadastro_conf/confirmacao_atendimento.php');
//$vetCampo['confirmacao_agendamento'] = objInclude('confirmacao_agendamento', 'cadastro_conf/confirmacao_agendamento.php');
$vetCampo['confirmacao_agendamento_desconfirma']  = objInclude('confirmacao_agendamento_desconfirma', 'cadastro_conf/confirmacao_agendamento_desconfirma.php');
$vetCampo['confirmacao_agendamento_bloqueio']     = objInclude('confirmacao_agendamento_bloqueio', 'cadastro_conf/confirmacao_agendamento_bloqueio.php');
$vetCampo['confirmacao_agendamento_cancelamento'] = objInclude('confirmacao_agendamento_cancelamento', 'cadastro_conf/confirmacao_agendamento_cancelamento.php');
//$sql = "select idt, codigo, descricao from plu_estado order by descricao";
//$vetCampo['idt_estado'] = objCmbBanco('idt_estado', 'Estado', true, $sql,'','width:180px;');
$js         = " visibility='hidden' ";
$js         = "";
$vetCampo['tipo_pessoa']      = objCmbVetor('tipo_pessoa', 'Prioridade?', false, $vetNaoSim,'',$js);
$maxlength  = 2000;
$style      = "width:600px;  background:#FFFF80; font-size:14px;";
$js         = " readonly='true' ";
$vetCampo['mensagem'] = objTextArea('mensagem', 'Forma de atendimento na Fila', false, $maxlength, $style, $js);
$vetCampo['botao_atendimento_agenda_prioridade_sim'] = objInclude('botao_atendimento_agenda_prioridade_sim', 'cadastro_conf/botao_atendimento_agenda_prioridade_sim.php');
$vetCampo['botao_atendimento_agenda_prioridade_nao'] = objInclude('botao_atendimento_agenda_prioridade_nao', 'cadastro_conf/botao_atendimento_agenda_prioridade_nao.php');
$vetCampo['botao_hora_marcada_agenda'] = objInclude('botao_hora_marcada_agenda', 'cadastro_conf/botao_hora_marcada_agenda.php');
$vetCampo['botao_hora_extra_agenda']   = objInclude('botao_hora_extra_agenda', 'cadastro_conf/botao_hora_extra_agenda.php');
$js         = " visibility='hidden' ";

$vetCampo['hora_marcada_extra']      = objCmbVetor('hora_marcada_extra', 'Hora Marcada?', false, $vetSimNao,' ',$js);




$vetCampo_w['botao_inicia_atendimento_agenda'] = objInclude('botao_inicia_atendimento_agenda', 'cadastro_conf/botao_inicia_atendimento_agenda.php');


$vetCampo['botao_atendimento_agenda_cadastro_pessoa'] = objInclude('botao_atendimento_agenda_cadastro_pessoa', 'cadastro_conf/botao_atendimento_agenda_cadastro_pessoa.php');

$vetCampo['botao_atendimento_agenda_imprime_comprovante'] = objInclude('botao_atendimento_agenda_imprime_comprovante', 'cadastro_conf/botao_atendimento_agenda_imprime_comprovante.php');


//$vetCampo['protocolo']        = objAutonum('protocolo', 'Senha',15,true);
$js    = " readonly='true'  style='background:#FFFF80; font-size:14px;' ";

$vetCampo['protocolo']        = objTexto('protocolo', 'Protocolo de Marcação',false,15,45,$js);
$js    = " readonly='true' style='background:#FFFF80; font-size:14px;' ";
$vetCampo['data_hora_marcacao'] = objDatahora('data_hora_marcacao', 'Data Marcação', False,$js);


$js2 = " onchange='return EscondeDeficiencia();' ";
$vetCampo['necessidade_especial'] = objCmbVetor('necessidade_especial', 'Portador de Necessidades Especiais?', false, $vetNaoSim, '', $js2);
$sql_lst_1 = 'select idt as idt_tipo_deficiencia, descricao from '.db_pir_gec.'gec_entidade_tipo_deficiencia order by descricao';

$sql_lst_2 = 'select ds.idt as idt_tipo_deficiencia, ds.descricao from '.db_pir_gec.'gec_entidade_tipo_deficiencia ds inner join
               grc_atendimento_agenda_tipo_deficiencia dr on ds.idt = dr.idt_tipo_deficiencia
               where dr.idt = $vlID order by ds.descricao';
$vetCampo['idt_tipo_deficiencia'] = objLista('idt_tipo_deficiencia', false, 'Deficiência do Sistema', 'idt_tipo_deficiencia1', $sql_lst_1, 'grc_atendimento_agenda_tipo_deficiencia', 200, 'Deficiência Selecionadas', 'idt_tipo_deficiencia2', $sql_lst_2);


$par = 'idt_tipo_deficiencia';
$vetDesativa['necessidade_especial'][0] = vetDesativa($par);
$vetAtivadoObr['necessidade_especial'][0] = vetAtivadoObr($par, 'S', true, '_lst_2');



$titulo_cadastro="AGENDAMENTO";

$class_frame_f = "class_frame_f";
$class_titulo_f = "class_titulo_f";
$class_frame_p = "class_frame_p";
$class_titulo_p = "class_titulo_p";
$class_frame = "class_frame";
$class_titulo = "class_titulo";
$titulo_na_linha = false;

 
//p($_GET);


//echo "Certo....{$deondeveio} ====<br />";

// $deondeveio = "Agenda";

if ($deondeveio != "Distancia" )
{

    //echo "Certo....<br />";

	$vetFrm = Array();
	$vetParametros = Array(
		'situacao_padrao' => true,
	);
	$vetFrm[] = Frame("<span>$titulo_cadastro</span>", '', $class_frame_f, $class_titulo_f, $titulo_na_linha, $vetParametros);

	// Definição de um frame ou seja de um quadro da tela para agrupar campos
	/*
	$vetParametros = Array(
		'codigo_frm' => 'parte01',
		'controle_fecha' => 'A',
	);

	$vetFrm[] = Frame('<span>01 - IDENTIFICAÇÃO</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

	$vetParametros = Array(
		'codigo_pai' => 'parte01',
	);
	*/
	$vetParametros = Array(
		'codigo_frm' => 'parte01_01',
		'controle_fecha' => 'A',
	);
	$vetFrm[] = Frame('<span>01 - Dados do Agendamento</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);
	$vetParametros = Array(
		'codigo_pai' => 'parte01_01',
	);

	//MesclarCol($vetCampo['confirmacao_agendamento_bloqueio'], 7);
	MesclarCol($vetCampo['confirmacao_agendamento_bloqueio'], 5);
	$vetFrm[] = Frame('<span></span>', Array(
		Array($vetCampo['data'],'',$vetCampo['hora'],'',$vetCampo['dia_semana'],' ',$vetCampo['idt_ponto_atendimento']),
		Array($vetCampo['origem'],'',$vetCampo['situacao'],'','','',$vetCampo['idt_consultor']),
		Array($vetCampo['confirmacao_agendamento_bloqueio'],'',$vetCampo['idt_especialidade']),
	),$class_frame,$class_titulo,$titulo_na_linha,$vetParametros);




	$vetParametros = Array(
		'codigo_frm' => 'parte01_02',
		'controle_fecha' => 'A',
	);
	$vetFrm[] = Frame('<span>02 - Pessoa e Cliente</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);
	$vetParametros = Array(
		'codigo_pai' => 'parte01_02',
	);

	//MesclarCol($vetCampo['idt_cliente'], 3);
	//MesclarCol($vetCampo['idt_especialidade'], 3);
	MesclarCol($vetCampo['assunto'], 5);
	
	MesclarCol($vetCampo['acao_imprime_comprovante'], 5);

	MesclarCol($vetCampo['idt_cliente'], 3);
	MesclarCol($vetCampo['nome_empresa'], 3);
	//MesclarCol($vetCampo['cliente_texto'], 3);
	//MesclarCol($vetCampo['celular'], 3);
	$vetFrm[] = Frame('<span></span>', Array(
		Array($vetCampo['cpf'],'', $vetCampo['idt_cliente']),
		Array('' ,'', $vetCampo['cliente_texto'],'', $vetCampo['data_nascimento']),
		Array($vetCampo['cnpj'],'', $vetCampo['nome_empresa']),
		Array($vetCampo['telefone'],'',$vetCampo['celular'],'',$vetCampo['email']),
		Array($vetCampo['assunto']),
		Array($vetCampo['acao_imprime_comprovante']),
		
		

	 ),$class_frame,$class_titulo,$titulo_na_linha,$vetParametros);



	$vetParametros = Array(
		'codigo_frm' => 'parte01_03',
		'controle_fecha' => 'F',
	);
	$vetFrm[] = Frame('<span>03 - Marcação</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);
	$vetParametros = Array(
		'codigo_pai' => 'parte01_03',
	);

	MesclarCol($vetCampo['assunto'], 3);
	MesclarCol($vetCampo['tipo_pessoa'], 3);

	MesclarCol($vetCampo['mensagem'], 3);


	$vetFrm[] = Frame("<span>{$titulo_cadastro}</span>", Array(
		Array($vetCampo['protocolo'],'',$vetCampo['data_hora_marcacao'],'',$vetCampo['confirmacao_agendamento_cancelamento']),
		Array($vetCampo['botao_hora_marcada_agenda'],'',$vetCampo['botao_hora_extra_agenda']),
		Array($vetCampo['botao_atendimento_agenda_prioridade_sim'],'',$vetCampo['botao_atendimento_agenda_prioridade_nao']),
		Array($vetCampo['hora_marcada_extra']),
		Array($vetCampo['mensagem']),
		Array($vetCampo['tipo_pessoa']),
	),$class_frame,$class_titulo,$titulo_na_linha,$vetParametros);







	$vetParametros = Array(
		'codigo_frm' => 'parte01_04',
		'controle_fecha' => 'F',
	);
	$vetFrm[] = Frame('<span>04 - Confirmação da Marcação</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);
	$vetParametros = Array(
		'codigo_pai' => 'parte01_04',
	);


	MesclarCol($vetCampo['confirmacao_agendamento'], 3);
	$vetFrm[] = Frame('<span></span>', Array(
		Array($vetCampo['data_confirmacao'],'',$vetCampo['hora_confirmacao'],'',$vetCampo['confirmacao_agendamento_desconfirma']),

	),$class_frame,$class_titulo,$titulo_na_linha,$vetParametros);


	$vetParametros = Array(
		'codigo_frm' => 'parte01_05',
		'controle_fecha' => 'F',
	);
	$vetFrm[] = Frame('<span>05 - Registro da Chegada</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);
	$vetParametros = Array(
		'codigo_pai' => 'parte01_05',
	);

	//MesclarCol($vetCampo['confirmacao_chegada'], 5);
	$vetFrm[] = Frame('<span></span>', Array(
		//Array($vetCampo['hora_chegada'],' ',$vetCampo['observacao_chegada'],'',$vetCampo['hora_liberacao']),
		//Array($vetCampo['confirmacao_chegada'],'','','',$vetCampo['confirmacao_liberacao']),
		//Array(),
		
		Array($vetCampo['confirmacao_chegada'],'',$vetCampo['hora_chegada'],' ',$vetCampo['observacao_chegada']),
		Array($vetCampo['confirmacao_liberacao'],'',$vetCampo['hora_liberacao'],'',''),
		
	),$class_frame,$class_titulo,$titulo_na_linha,$vetParametros);


	$vetParametros = Array(
		'codigo_frm' => 'parte01_06',
		'controle_fecha' => 'F',
	);
	$vetFrm[] = Frame('<span>06 - Chamar Cliente para Atendimento</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);
	$vetParametros = Array(
		'codigo_pai' => 'parte01_06',
	);

	$vetFrm[] = Frame('<span> </span>', Array(
		Array($vetCampo['chama_atendimento']),

	),$class_frame,$class_titulo,$titulo_na_linha,$vetParametros);






	$vetParametros = Array(
		'codigo_frm' => 'parte01_07',
		'controle_fecha' => 'F',
	);
	$vetFrm[] = Frame('<span>07 - Registro do Atendimento</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);
	$vetParametros = Array(
		'codigo_pai' => 'parte01_07',
	);

	//MesclarCol($vetCampo['confirmacao_atendimento'], 3);
	$vetFrm[] = Frame('<span></span>', Array(
		Array($vetCampo['hora_atendimento'],'',$vetCampo['hora_final_atendimento'],'',$vetCampo['observacao_atendimento']),
	  //  Array($vetCampo['botao_inicia_atendimento_agenda']),
	),$class_frame,$class_titulo,$titulo_na_linha,$vetParametros);

	/*

	$vetParametros = Array(
		'codigo_frm' => 'parte01_08',
		'controle_fecha' => 'F',
	);
	$vetFrm[] = Frame('<span>08 - Observações Gerais</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);
	$vetParametros = Array(
		'codigo_pai' => 'parte01_08',
	);
	$vetFrm[] = Frame('<span></span>', Array(
		Array($vetCampo['detalhe']),
	),$class_frame,$class_titulo,$titulo_na_linha,$vetParametros);

	*/

	// DEFINIÇÃO DE TELA FORMATO FULL SCREEN DENTRO DA FICHA DE ATENDIMENTO
	// PRODUTOS DE ATENDIMENTO
	//____________________________________________________________________________


	$vetParametros = Array(
		'codigo_frm' => 'grc_atendimento_08',
		'controle_fecha' => 'F',
	);
	$vetFrm[] = Frame('<span>08 - ATENDIMENTOS</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

	// Definição de campos formato full que serão editados na tela full

	$vetCampo = Array();
	//Monta o vetor de Campo
	$vetCampo['protocolo']                = CriaVetTabela('Protocolo');
	$vetCampo['primeiro']                 = CriaVetTabela('Primeiro?');
	$vetCampo['data_inicio_atendimento']  = CriaVetTabela('Data Inicio<br />Atendimento','data');
	$vetCampo['data_termino_atendimento']  = CriaVetTabela('Data Término<br />Atendimento','data');
	$vetCampo['assunto']                  = CriaVetTabela('Assunto');
	$vetCampo['plu_usu_nome_completo']    = CriaVetTabela('Consultor/Atendente');
	$vetCampo['grc_ent_descricao']        = CriaVetTabela('Cliente');
	$vetCampo['ativo']     = CriaVetTabela('Ativo?', 'descDominio', $vetSimNao );

	// Parametros da tela full conforme padrão

	$titulo = 'Atendimentos';

	$TabelaPrinc      = "grc_atendimento";
	$AliasPric        = "grc_atd";
	$Entidade         = "Atendimento";
	$Entidade_p       = "Atendimentos";


	// Select para obter campos da tabela que serão utilizados no full

	$orderby = "{$AliasPric}.protocolo desc";


	$sql   = "select ";
	$sql  .= "   {$AliasPric}.*,  ";
	$sql  .= "    plu_usu.nome_completo as plu_usu_nome_completo, ";
	$sql  .= "    gec_ent.descricao as grc_ent_descricao  ";
	$sql  .= " from {$TabelaPrinc} as {$AliasPric} ";
	$sql .= " left join plu_usuario plu_usu on plu_usu.id_usuario = {$AliasPric}.idt_consultor ";
	$sql .= " left join ".db_pir_gec."gec_entidade gec_ent on gec_ent.idt = {$AliasPric}.idt_cliente ";

	//
	$sql .= " where {$AliasPric}".'.idt_atendimento_agenda = $vlID';
	$sql .= " order by {$orderby}";

	// Carrega campos que serão editados na tela full




	$vetCampo['grc_atendimento'] = objListarConf('grc_atendimento', 'idt', $vetCampo, $sql, $titulo, false);

	// Fotmata lay_out de saida da tela full

	$vetParametros = Array(
		'codigo_pai' => 'grc_atendimento_08',
		'width' => '100%',
	);


	MesclarCol($vetCampo['botao_inicia_atendimento_agenda'], 5);

	$vetFrm[] = Frame('<span></span>', Array(
		Array('','','','','','',$vetCampo_w['botao_inicia_atendimento_agenda']),
	),$class_frame,$class_titulo,$titulo_na_linha,$vetParametros);

	$vetFrm[] = Frame('<span></span>', Array(
		Array($vetCampo['grc_atendimento']),
	),$class_frame,$class_titulo,$titulo_na_linha,$vetParametros);

	// FIM ____________________________________________________________________________






	// DEFINIÇÃO DE TELA FORMATO FULL SCREEN DENTRO DA FICHA DE ATENDIMENTO
	// PRODUTOS DE ATENDIMENTO
	//____________________________________________________________________________


	$vetParametros = Array(
		'codigo_frm' => 'grc_atendimento_agenda_ocorrencia',
		'controle_fecha' => 'A',
		

		
	);
	$vetFrm[] = Frame('<span>09 - Ocorrências</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

	// Definição de campos formato full que serão editados na tela full

	$vetCampo = Array();
	//Monta o vetor de Campo

	$vetCampo['data']    = CriaVetTabela('Data da Ocorrência');
	$vetCampo['plu_u_nome_completo']    = CriaVetTabela('Responsável');
	$vetCampo['observacao'] = CriaVetTabela('Observação');



	// Parametros da tela full conforme padrão

	$titulo = 'Ocorrências';

	$TabelaPrinc      = "grc_atendimento_agenda_ocorrencia";
	$AliasPric        = "grc_aac";
	$Entidade         = "Ocorrência da Agenda";
	$Entidade_p       = "Ocorrências da Agenda";


	// Select para obter campos da tabela que serão utilizados no full

	$orderby = "{$AliasPric}.data desc";

	$sql  = "select {$AliasPric}.*, ";
	$sql  .= "       plu_u.nome_completo as plu_u_nome_completo ";
	$sql .= " from {$TabelaPrinc} {$AliasPric}  ";
	$sql .= " inner join plu_usuario plu_u on plu_u.id_usuario = {$AliasPric}.idt_usuario ";
	//
	$sql .= " where {$AliasPric}".'.idt_atendimento_agenda = $vlID';
	$sql .= " order by {$orderby}";

	// Carrega campos que serão editados na tela full



	$vetCampo['grc_atendimento_agenda_ocorrencia'] = objListarConf('grc_atendimento_agenda_ocorrencia', 'idt', $vetCampo, $sql, $titulo, false);

	// Fotmata lay_out de saida da tela full

	$vetParametros = Array(
		'codigo_pai' => 'grc_atendimento_agenda_ocorrencia',
		'width' => '100%',
	);

	$vetFrm[] = Frame('<span></span>', Array(
		Array($vetCampo['grc_atendimento_agenda_ocorrencia']),
	),$class_frame,$class_titulo,$titulo_na_linha,$vetParametros);

	// FIM ____________________________________________________________________________
	$vetCad[] = $vetFrm;

	$idt_ponto_atendimento  = 999;
}
else
{
    //echo " ffffffffffffffffffffffffff ";
    $idt_ponto_atendimento  =$_GET['idt_ponto_atendimento'];
	
	$vetFrm = Array();
	//MesclarCol($vetCampo['idt_especialidade'], 3);
	//MesclarCol($vetCampo['assunto'], 5);
	MesclarCol($vetCampo['detalhe'], 5);
//	MesclarCol($vetCampo['idt_cliente'], 3);
	//MesclarCol($vetCampo['nome_empresa'], 3);
	MesclarCol($vetCampo['idt_tipo_deficiencia'], 5);
	
	//MesclarCol($vetCampo['cliente_texto'], 5);
	MesclarCol($vetCampo['tipo_pessoa'], 5);
	//MesclarCol($vetCampo['email'], 3);
	//MesclarCol($vetCampo['celular'], 3);
	
	$arquivo_html="";
	$arquivo_html.="<div style='margin-top:5px; background:#0000FF; height:2px; display:block; width:100%;'>";
	$arquivo_html.="";
	$arquivo_html.="</div'>";
	
	
	$vetCampo['linha_separa'] = objInclude('linha_separa', $arquivo_html);
	
	
	$arquivo_html="";
	$arquivo_html.="<div style='margin-top:10px; margin-bottom:10px; background:#0000FF; height:1px; display:block; width:100%;'>";
	$arquivo_html.="";
	$arquivo_html.="</div'>";
	
	
	$vetCampo['linha_separa1'] = objInclude('linha_separa1', $arquivo_html);
    
	
	//MesclarCol($vetCampo['cliente_texto'], 3);
	
	
	//MesclarCol($vetCampo['cliente_texto'], 3);
     //MesclarCol($vetCampo['botao_atendimento_agenda_cadastro_pessoa'], 3); 
	 //MesclarCol($vetCampo['botao_atendimento_agenda_imprime_comprovante'], 3);
	 
	 
	 MesclarCol($vetCampo['linha_separa'], 5);
	 MesclarCol($vetCampo['linha_separa1'], 5);
	 
	 //MesclarCol($vetCampo['protocolo'], 5);


	MesclarCol($vetCampo['empresas_associadas_cpf'], 5);
	MesclarCol($vetCampo['grc_mostra_marcacao'], 5);
	MesclarCol($vetCampo['acao_imprime_comprovante'], 5);
	
	$vetFrm[] = Frame('<span></span>', Array(
	Array($vetCampo['idt_cliente']),
	    //Array($vetCampo['cliente_texto']),
	    Array($vetCampo['situacao'] ,' ',$vetCampo['idt_ponto_atendimento'],'', $vetCampo['idt_consultor']),
	    Array($vetCampo['data'],'',$vetCampo['hora'],'',$vetCampo['dia_semana']),
		
		Array($vetCampo['linha_separa']),
		Array($vetCampo['protocolo'],'',$vetCampo['cpf'],'', $vetCampo['confirmacao_cpf']),
		//Array($vetCampo['cpf'],'', $vetCampo['idt_cliente'],'',$vetCampo['protocolo']),
		//Array($vetCampo['cpf'],'', $vetCampo['cliente_texto'],'', $vetCampo['confirmacao_cpf']),
		
		Array('','', $vetCampo['cliente_texto'],'', $vetCampo['confirmacao_presenca']),
		
		Array($vetCampo['data_nascimento'],'',$vetCampo['email'],'',$vetCampo['botao_atendimento_agenda_cadastro_pessoa']),
		Array($vetCampo['telefone'],'',$vetCampo['celular'],'',$vetCampo['botao_atendimento_agenda_imprime_comprovante']),
		
		Array($vetCampo['cnpj'],'', $vetCampo['nome_empresa'],'',$vetCampo['confirmacao_cnpj']),
		
        Array($vetCampo['empresas_associadas_cpf']),
		Array($vetCampo['linha_separa1']),
		
		Array($vetCampo['idt_especialidade'],'',$vetCampo['assunto'],'',$vetCampo['necessidade_especial']),
		
				Array($vetCampo['acao_imprime_comprovante']),

		
		Array($vetCampo['grc_mostra_marcacao']),
		
		
		
	//	Array($vetCampo['assunto']),
		//Array($vetCampo['necessidade_especial'],'',$vetCampo['idt_tipo_deficiencia']),
		Array($vetCampo['idt_tipo_deficiencia']),
		Array($vetCampo['linha_separa1']),
		Array($vetCampo['detalhe']),
		
	 ),$class_frame,$class_titulo,$titulo_na_linha,$vetParametros);
	 
        
	 
	 
	 
	 
	$vetCad[] = $vetFrm;
}
?>
<script>

var idt_atendimento_agenda  =  '<?php echo  $idt_atendimento_agenda; ?>' ;
var idt_ponto_atendimentow  =  '<?php echo  $idt_ponto_atendimento; ?>' ;

var acao                   =  '<?php echo  $acao; ?>' ;
   
var idt_cliente            =  '<?php echo  $idt_cliente; ?>' ;
var veio                   =  '<?php echo  $deondeveio; ?>' ;
var veio_at                =  '<?php echo  $veio_at; ?>' ;


var aindavalida             =  '<?php echo  $aindavalida; ?>' ;

var cpf_at                  =  '<?php echo  $cpf_at; ?>' ;
var nome_at                 =  '<?php echo  $nome_at; ?>' ;
var telefone_residencial_at =  '<?php echo  $telefone_residencial_at; ?>' ;
var telefone_celular_at     =  '<?php echo  $telefone_celular_at; ?>' ;
var email_at                =  '<?php echo  $email_at; ?>' ;
var data_nascimento_at      =  '<?php echo  $data_nascimento_at; ?>' ;
var cnpj_at                 =  '<?php echo  $cnpj_at; ?>' ;
var nome_empresa_at         =  '<?php echo  $nome_empresa_at; ?>' ;

var origem                 =  '<?php echo  $origem; ?>' ;

var recepcao               =  '<?php echo  $recepcao; ?>' ;
var balcao                 =  '<?php echo  $balcao; ?>' ;
var callcenter             =  '<?php echo  $callcenter; ?>' ;




$(document).ready(function () {

//  alert ('ttttt '+balcao);

    if (balcao==1222)
    {
           objd=document.getElementById('frm4');
           if (objd != null)
           {
               $(objd).css('display','none');
           }
           objd=document.getElementById('frm5');
           if (objd != null)
           {
               $(objd).css('display','none');
           }
           objd=document.getElementById('frm6');
           if (objd != null)
           {
               $(objd).css('display','none');
           }
           //  objd=document.getElementById('frm6');
           //  if (objd != null)
           //  {
           //      $(objd).css('display','none');
           //  }

    }
    if (veio=='MA22')
    {
           objd=document.getElementById('frm5');
           if (objd != null)
           {
               $(objd).css('display','none');
           }
           objd=document.getElementById('frm5');
           if (objd != null)
           {
               $(objd).css('display','none');
           }
           objd=document.getElementById('frm6');
           if (objd != null)
           {
               $(objd).css('display','none');
           }

           objd=document.getElementById('frm7');
           if (objd != null)
           {
               $(objd).css('display','none');
           }

           objd=document.getElementById('frm8');
           if (objd != null)
           {
               $(objd).css('display','none');
           }
    }
    if (idt_cliente>0)
    {
        var id='cpf';
        obj = document.getElementById(id);
        if (obj != null) {
            $(obj).css('background','#FFFF80');
            $(obj).css('fontSize','14px');
            $(obj).attr('readonly','true');
        }
    }
    
    if (origem=='Hora Marcadaxx')
    {
        var id='hora_marcada_extra';
        obj = document.getElementById(id);
        if (obj != null) {
            obj.value='S';
            ConfirmaPrioridade(idt_atendimento_agenda);
            
            /*
            alert(' hora marcada '+obj.value);
            
               var id='hora_marcada_extra';
               obj = document.getElementById(id);
               if (obj != null) {
                  var cpt = obj.value;
                  alert(' 22222 hora marcada '+cpt);
               }
            */
        }
        var id='botao_hora_marcada_agenda_desc';
        obj = document.getElementById(id);
        if (obj != null) {
             //$(obj).css('visibility','hidden');
             $(obj).css('display','none');
        }
        var id='botao_hora_extra_agenda_desc';
        obj = document.getElementById(id);
        if (obj != null) {
             //$(obj).css('visibility','hidden');
             $(obj).css('display','none');
        }

        var id='botao_atendimento_agenda_prioridade_sim_desc';
        obj = document.getElementById(id);
        if (obj != null) {
             $(obj).css('display','none');
        }
        var id='botao_atendimento_agenda_prioridade_nao_desc';
        obj = document.getElementById(id);
        if (obj != null) {
             $(obj).css('display','none');
        }
        var id='mensagem_desc';
        obj = document.getElementById(id);
        if (obj != null) {
             $(obj).css('display','none');
        }
        var id='mensagem';
        obj = document.getElementById(id);
        if (obj != null) {
             $(obj).css('display','none');
        }
        var id='hora_marcada_extra';
        obj = document.getElementById(id);
        if (obj != null) {
             $(obj).css('display','none');
        }
        var id='tipo_pessoa';
        obj = document.getElementById(id);
        if (obj != null) {
             $(obj).css('display','none');
        }
    }
    else
    {
      /*
        var id='botao_hora_marcada_agenda_desc';
        obj = document.getElementById(id);
        if (obj != null) {
             //$(obj).css('visibility','hidden');
             $(obj).css('display','none');
        }
        var id='botao_hora_extra_agenda_desc';
        obj = document.getElementById(id);
        if (obj != null) {
             //$(obj).css('visibility','hidden');
             $(obj).css('display','none');
        }

        var id='confirmacao_agendamento_bloqueio_desc';
        obj = document.getElementById(id);
        if (obj != null) {
             //$(obj).css('display','none');
             $(obj).css('visibility','hidden');
        }
        var id='confirmacao_agendamento_cancelamento_desc';
        obj = document.getElementById(id);
        if (obj != null) {
             $(obj).css('display','none');
        }
      */

    }
    //
    //if (idt_cliente
    var id='cliente_texto';
    obj = document.getElementById(id);
    if (obj != null) {
         //$(obj).hide();
    }
    var id='cliente_texto_desc';
    obj = document.getElementById(id);
    if (obj != null) {
         //$(obj).hide();
    }
	
	if (veio_at=="AT")
	{
	    if (aindavalida!='N')
		{
			//alert('ajustar vei de atendimento ');
			var id='cpf';
			obj = document.getElementById(id);
			if (obj != null) {
				obj.value=cpf_at;
				ChamaCPFEspecial(obj);
			}
		}
	}
	
    EscondeDeficiencia();
});


function EscondeDeficiencia()
{
    var id='#necessidade_especial';
	var de = $(id).val();
   

    var id='idt_tipo_deficiencia_desc';
    obj = document.getElementById(id);
    if (obj != null) {
		if (de=='N')
		{
			$(obj).hide();
		}
		else
		{
			$(obj).show();
		}
    }
}
function MostraDeficiencia()
{
var id='idt_tipo_deficiencia_desc';
    obj = document.getElementById(id);
    if (obj != null) {
         $(obj).hide();
    }
}
function DiaSemana_t(thisw)
{
    //alert('Data '+thisw.value);
    return false;
}
function ChamaCPFEspecial(thisw)
{
    var ret = Valida_CPF(thisw);
    // alert('xxx acessar pessoa '+thisw.value+ ' == '+ ret );
    //var cpf = thisw.value;
    if (ret && thisw.value!='')
    {
        ChamaPessoa();
    }
    return ret;
}

function ChamaCNPJEspecial(thisw)
{
    //alert('xxx acessar pessoa '+thisw.value+ ' == '+ ret );
	
	var id='cnpj';
    obj = document.getElementById(id);
    if (obj != null) {
        cnpj = obj.value;
    }
	
	if (cnpj=='')
	{
	    var id='nome_empresa';
		obj = document.getElementById(id);
		if (obj != null) {
			obj.value = "";
		}
		ChamaPessoaJuridica();
	    return true;
	}
	//alert('to aqui');
	var ret = Valida_CNPJ(thisw);
    //var cpf = thisw.value;
    if (ret && thisw.value!='')
    {
        ChamaPessoaJuridica();
    }
	else
	{
		var id='nome_empresa';
		obj = document.getElementById(id);
		if (obj != null) {
			obj.value = "";
		}

	
	}
	
    return ret;
}

function ChamaPessoa()
{
    var cpf                   = "";
    var idt_ponto_atendimento = 0;
    var $nome                 = "";
    var cnpj                  = "";
    var nome_empresa          = "";

    var telefone              = "";
    var celular               = "";
    var email                 = "";
    var idt_clientew          = 0;

    var id='cpf';
    obj = document.getElementById(id);
    if (obj != null) {
        cpf = obj.value;
    }
	if (idt_ponto_atendimentow == 999)
    {
		var id='idt_ponto_atendimento';
		obj = document.getElementById(id);
		if (obj != null) {
			idt_ponto_atendimento = obj.value;
		}
	}
	else
	{
		idt_ponto_atendimento = idt_ponto_atendimentow;

	}
	var id='protocolo_marcacao';
    obj = document.getElementById(id);
    if (obj != null) {
        protocolo_atendimento = obj.value;
    }
    var id='cnpj';
    obj = document.getElementById(id);
    if (obj != null) {
        cnpj = obj.value;
    }
    var id='nome_empresa';
    obj = document.getElementById(id);
    if (obj != null) {
        nome_empresa = obj.value;
    }
    var id='idt_cliente';
    obj = document.getElementById(id);
    if (obj != null) {
        idt_clientew = obj.value;
    }
    if (idt_cliente>0)
    {
        //return false;
    }
    var id='telefone';
    obj = document.getElementById(id);
    if (obj != null) {
        telefone = obj.value;
    }
    var id='celular';
    obj = document.getElementById(id);
    if (obj != null) {
        celular = obj.value;
    }
    var id='email';
    obj = document.getElementById(id);
    if (obj != null) {
        email = obj.value;
    }

    
    //alert(' teste de guy '+idt_clientew);
    
    var str = '';
    $.post('ajax_atendimento.php?tipo=BuscaPessoa', {
        async : false,
        idt_ponto_atendimento : idt_ponto_atendimento,
        cpf : cpf,
        cnpj : cnpj,
        nome_empresa : nome_empresa,
        telefone     : telefone,
        celular      : celular,
        idt_cliente  : idt_clientew,
        email        : email
		
    }
    , function (str) {
        if (str == '')
        {   // pessoa sem cadastro - erro estranhao
            alert('Erro Estranho - Comunicar ao Administrador de Sistema');
        }
        else
        {
            //str = "Geraçao não foi executada"+"\n"+str
            //alert(url_decode(str).replace(/<br>/gi, "\n"));
            var ret = str.split('###');
            var existe             = ret[0];
            var nome               = ret[1];
            var cpf                = ret[2];
            var telefone           = ret[3];
            var celular            = ret[4];
            var email              = ret[5];
            var protocolo_marcacao = ret[6];
            var cnpj               = ret[7];
            var nome_empresa       = ret[8];
            var idt_cliente        = ret[9];
			var data_nascimento    = ret[10];
			var sms_1              = ret[11];
			
			//alert(' data_nascimento = '+data_nascimento);
            var id='cpf';
            obj = document.getElementById(id);
            if (obj != null) {
                obj.value = cpf;
            }
            var id='telefone';
            obj = document.getElementById(id);
            if (obj != null) {
                obj.value = telefone;
             }
            var id='celular';
            obj = document.getElementById(id);
            if (obj != null) {
                obj.value = celular;
             }
            var id='email';
            obj = document.getElementById(id);
            if (obj != null) {
                obj.value = email;
            }
            var id='cnpj';
            obj = document.getElementById(id);
            if (obj != null) {
                obj.value = cnpj;
            }
            var id='nome_empresa';
            obj = document.getElementById(id);
            if (obj != null) {
                obj.value = nome_empresa;
             }
            var id='idt_cliente';
            obj = document.getElementById(id);
            if (obj != null) {
                obj.value = idt_cliente;
             }
            var id='idt_cliente_txt';
            obj = document.getElementById(id);
            if (obj != null) {
                //obj.innerHTML = cpf+' - '+nome;
                obj.innerHTML = nome;
             }
             
			 
			var id='data_nascimento';
            obj = document.getElementById(id);
            if (obj != null) {
                obj.value = data_nascimento;
             }
             
			var id='sms_1';
            obj = document.getElementById(id);
            if (obj != null) {
                obj.value = sms_1;
             }
             
			var id='cliente_texto';
            obj = document.getElementById(id);
            if (obj != null) {
                obj.value = nome;
             }
             
			 
             if (existe=='S')
             {
                 var id='cliente_texto';
                 obj = document.getElementById(id);
                 if (obj != null) {
                     //$(obj).hide();
					 //$(obj).css('bachground','#FF0000');
					 //$(obj).attr('readonly','true');
                 }
             }
             else
             {
                 var id='cliente_texto';
                 obj = document.getElementById(id);
                 if (obj != null)
                 {
                     $(obj).show();
                 }
             }
            

			if (veio_at=="AT")
			{
				var id='idt_cliente_txt';
				obj = document.getElementById(id);
				if (obj != null) {
					obj.innerHTML = nome_at;
				 }
				
				var id='cliente_texto';
				obj = document.getElementById(id);
				if (obj != null) {
					obj.value=nome_at;
				}
				var id='telefone';
				obj = document.getElementById(id);
				if (obj != null) {
					obj.value=telefone_residencial_at;
				}
				var id='celular';
				obj = document.getElementById(id);
				if (obj != null) {
					obj.value=telefone_celular_at;
				}
				var id='email';
				obj = document.getElementById(id);
				if (obj != null) {
					obj.value=email_at;
				}
				var id='data_nascimento';
				obj = document.getElementById(id);
				if (obj != null) {
					obj.value=data_nascimento_at;
				}
				var id='cnpj';
				obj = document.getElementById(id);
				if (obj != null) {
					obj.value=cnpj_at;
				}
				var id='nome_empresa';
				obj = document.getElementById(id);
				if (obj != null) {
					obj.value=nome_empresa_at;
				}
			
			}



         }
    });
    return false;
}







function ChamaPessoaJuridica()
{
    
    var cpf                   = "";
    var cnpj                  = "";
    var nome_empresa          = "";
    var id='cpf';
    obj = document.getElementById(id);
    if (obj != null) {
        cpf = obj.value;
    }
	if (cpf=='')
	{
	   alert('Por favor informe o CPF');
	   //obj.focus;
	   return false;
	}
	
	var id='protocolo_marcacao';
    obj = document.getElementById(id);
    if (obj != null) {
        protocolo_atendimento = obj.value;
    }
    var id='cnpj';
    obj = document.getElementById(id);
    if (obj != null) {
        cnpj = obj.value;
    }
	
	if (cnpj=='')
	{
	    var id='nome_empresa';
		obj = document.getElementById(id);
		if (obj != null) {
			obj.value = "";
		}
	    return false;
	}
	
	
    
    var str = '';
    $.post('ajax_atendimento.php?tipo=BuscaPessoaJuridica', {
        async : false,
		cpf  : cpf,
        cnpj : cnpj
    }
    , function (str) {
        if (str == '')
        {   // pessoa sem cadastro - erro estranhao
            alert('Erro Estranho - Comunicar ao Administrador de Sistema');
        }
        else
        {
			// str = "Geraçao não foi executada"+"\n"+str
			// alert(url_decode(str).replace(/<br>/gi, "\n"));
			var ret = str.split('###');
			var existe             = ret[0];
			var cnpj               = ret[1];
			var nome_empresa       = ret[2];
			var qtd_emp            = 0;
			//alert(' ---- > '+nome_empresa);
			var id='nome_empresa';
			obj = document.getElementById(id);
			if (obj != null) {
				obj.value = nome_empresa;
			}
			if (qtd_emp>0)
			{
				var id='empresas_pessoa';
				obj = document.getElementById(id);
				if (obj != null) {
					 $(obj).show();
				}
				var id='empresas_pessoa_det';
				obj = document.getElementById(id);
				if (obj != null) {
					 $(obj).show();
				}
			}
         }
    });
    return false;
}











function fncListarCmbMuda_idt_cliente(idt_cliente)
{
//   alert(idt_cliente);
   ChamaPessoa();
}
function grc_atendimento_agenda_marcacao_dep() {
        var ok = true;
		var cnpj = "";
		var id='cnpj';
		obj = document.getElementById(id);
		if (obj != null) {
			cnpj = obj.value;
		}		
		if (cnpj!="")
		{
			var ok = Valida_CNPJ(obj);
			if (ok==false)
			{   // limpa tb o nome
				var id='nome_empresa';
				obj = document.getElementById(id);
				if (obj != null) {
					obj.value = "";
				}
			}
		}
		
		var email    = "";
		var telefone = "";
		var celular  = "";
		
		var id='email';
		obj = document.getElementById(id);
		if (obj != null) {
			email = obj.value;
		}
		var id='telefone';
		obj = document.getElementById(id);
		if (obj != null) {
			telefone = obj.value;
		}
		var id='celular';
		obj = document.getElementById(id);
		if (obj != null) {
			celular = obj.value;
		}
		var comunica = "N";
		
		if (!email=="")
		{
		    comunica = "S";
			
		}
		if (!telefone=="")
		{
		    comunica = "S";
		}
		if (!celular=="")
		{
		    comunica = "S";
		}
		if (comunica=='N')
		{
		    alert('Para comunicações é necessário o preenchimento de um dos campos: Email, Telefone Fixo ou Celular');
			return false;
		}

        // para registrar é necessário estar cinza na base
		// semmarcacao==s 
		$.ajax({
			dataType: 'json',
			type: 'POST',
			url: 'ajax_atendimento.php?tipo=VerificaSePresoParaMarcacao',
			data: {
				cas: conteudo_abrir_sistema,
				idt_atendimento_agenda: idt_atendimento_agenda
			},
			success: function (response) {
				if (response.erro == '') {
				   // Tá preseo pode Marcar
				} else {
					alert(url_decode(response.erro));
					ok =  false;
				}
			},
			error: function (jqXHR, textStatus, errorThrown) {
				alert('Erro no ajax no: ' + textStatus + ' - ' + errorThrown);
				ok =  false;
			},
			async: false
		});



		return ok; 
}

function btAcaoVoltar() {
//alert (' ---- '+acao);
	if (acao == 'alt')
	{
	    
		$.ajax({
			dataType: 'json',
			type: 'POST',
			url: 'ajax_atendimento.php?tipo=desisteMarcacao',
			data: {
				cas: conteudo_abrir_sistema,
				idt_atendimento_agenda: idt_atendimento_agenda
			},
			success: function (response) {
				if (response.erro == '') {
					// self.location = $('#bt_volta_href').val();
					top.close();
				} else {
					alert(url_decode(response.erro));
				}
			},
			error: function (jqXHR, textStatus, errorThrown) {
				alert('Erro no ajax no: ' + textStatus + ' - ' + errorThrown);
			},
			async: false
		});
	}
	else
	{
		top.close();
	}
}
function TrataSMS()
{
    var sms_1   = "";
	var celular = "";
	var id='sms_1';
	objs = document.getElementById(id);
	if (objs != null) {
		sms_1 = objs.value;
    }
	var id='celular';
	objc = document.getElementById(id);
	if (objc != null) {
		celular = objc.value;
    }
	
	if (celular!="")
    {
		if (sms_1=="")
		{
			objs.value=objc.value;
		}    
    }
	else
	{
    	if (sms_1!="")
		{
			objc.value=objs.value;
		}
	}
	return false;


}
function VefificaConsumoHorarios(idt_atendimento_agenda)
{
    
    var idt_servico = "";
	var id='idt_especialidade';
	objs = document.getElementById(id);
	if (objs != null) {
		idt_servico = objs.value;
	}
	if (idt_servico=='')
	{
		alert('Por favor,Informe o Serviço');
		var id='detalhe_marcacao_serv';
		objs = document.getElementById(id);
		if (objs != null) {
			objs.innerHTML = '';
			$(objs).hide();
		}
		return false;
	}
	//alert(' agenda = '+idt_atendimento_agenda+ " servico = "+idt_servico);
	
	
	
	$.ajax({
		    dataType: 'json',
			type: 'POST',
			url: 'ajax_atendimento.php?tipo=VefificaConsumoHorarios',
			data: {
				cas: conteudo_abrir_sistema,
				idt_atendimento_agenda: idt_atendimento_agenda,
				idt_servico: idt_servico
			},
			success: function (response) {
				if (response.erro == '') {
					// tratar texto de retorno
					//alert(url_decode(response.texto));
					
					var id='detalhe_marcacao_serv';
					objs = document.getElementById(id);
					if (objs != null) {
						objs.innerHTML = url_decode(response.texto);
						$(objs).show();
					}
					
					
					
				} else { // deu erro
					var id='detalhe_marcacao_serv';
					objs = document.getElementById(id);
					if (objs != null) {
						objs.innerHTML = url_decode(response.texto);
						$(objs).show();
					}
				
				
					alert(url_decode(response.erro));
					
					var id='idt_especialidade';
					objs = document.getElementById(id);
					if (objs != null) {
						objs.value = "";
					}
					
					var id='detalhe_marcacao_serv';
					objs = document.getElementById(id);
					if (objs != null) {
						objs.innerHTML = "";
						$(objs).hide();
					}

					
					
				}
			},
			error: function (jqXHR, textStatus, errorThrown) {
				alert('Erro no ajax no: ' + textStatus + ' - ' + errorThrown);
			},
			async: false
		});
	
	
	
	
	
	
	
	
	
	
	
	
	
    return false;


}
</script>
