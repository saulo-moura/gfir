<style type="text/css">
    fieldset.class_frame_f {
        background:#2F66B8;
        border:1px solid #FFFFFF;
    }

    div.class_titulo_f {
        background: #2F66B8;
        border    : 1px solid #2C3E50;
        color     : #FFFFFF;
        text-align: left;
        padding-top:10px;
    }

    div.class_titulo_f span {
        padding-left:20px;
        text-align: left;
    }

    fieldset.class_frame_p {
        background:#FFFFFF;
        border:0px solid #FFFFFF;
    }

    div.class_titulo_p {
        background: #2F66B8;
        text-align: left;
        border    : 0px solid #2C3E50;
        color     : #FFFFFF;
        color     : #FFFFFF;
        text-align: left;
        height    : 20px;
        font-size : 12px;
        padding-top:5px;
    }

    div.class_titulo_p span {
        padding:10px;
        text-align: left;
    }

    div.class_titulo_p_barra {
        text-align: left;
        background: #c4c9cd;
        border    : none;
        color     : #FFFFFF;
        font-weight: bold;
        line-height: 12px;
        margin: 0;
        padding: 3px;
        padding-left: 20px;
    }

    fieldset.class_frame {
        background:#FFFFFF;
        border:0px solid #2C3E50;
    }

    div.class_titulo {
        text-align: left;
        background: #FFFFFF;
        color     : #FFFFFF;
        border    : 0px solid #2C3E50;
    }

    div.class_titulo span {
        padding-left:10px;
    }

    div.class_titulo_c {
        text-align: center;
        background: #FFFFFF;
        color     : #FFFFFF;
        border    : 0px solid #2C3E50;
    }

    div.class_titulo_c span {
        padding-left:10px;
    }

    Select {
        border:0px;
        height:28px;
    }

    .TextoFixo {
        font-size:12px;
        text-align:left;
        border:0px;
        background:#ECF0F1;
        font-weight:normal;
        font-family: Lato Regular, Calibri, Arial,  Helvetica, sans-serif;
        font-style: normal;
        word-spacing: 0px;
        padding-top:5px;
    }


    .Tit_Campo {
        font-size:12px;
    }

    td.Titulo {
        color:#666666;
    }

    .situacao {
        font-size:20px;
    }


    #descricao_obj {
        border:1px solid #C0C0C0;
    }

</style>



<?php
//
// gsw_email_class
//

#
# Decode UTF-8 and iso-8859-1 encoded text
#
function decode_imap_text($var){
if(ereg("=\?.{0,}\?[Bb]\?",$var)) {
$var = split("=\?.{0,}\?[Bb]\?",$var);
 
while(list($key,$value)=each($var)){
if(ereg("\?=",$value)){
$arrTemp=split("\?=",$value);
$arrTemp[0]=base64_decode($arrTemp[0]);
$var[$key]=join("",$arrTemp);
}
}
$var=join("",$var);
}
 
if(ereg("=\?.{0,}\?Q\?",$var)) {
$var = quoted_printable_decode($var);
$var = ereg_replace("=\?.{0,}\?[Qq]\?","",$var);
$var = ereg_replace("\?=","",$var);
}
return trim($var);
}

function DecodeBody($mbox,$id)
{
$struckture = imap_fetchstructure($mbox, $id); 
$message = imap_fetchbody($mbox,$id,$part);    
$name = $struckture->parts[$part]->dparameters[0]->value; 
$type = $struckture->parts[$part]->typee; 
############## type 
if ($type == 0) 
{ 
    $type = "text/"; 
} 
elseif ($type == 1) 
{ 
    $type = "multipart/"; 
} 
elseif ($type == 2) 
{ 
    $type = "message/"; 
} 
elseif ($type == 3) 
{ 
    $type = "application/"; 
} 
elseif ($type == 4) 
{ 
    $type = "audio/"; 
} 
elseif ($type == 5) 
{ 
    $type = "image/"; 
} 
elseif ($type == 6) 
{ 
    $type = "video"; 
} 
elseif($type == 7) 
{ 
    $type = "other/"; 
} 
$type .= $struckture->parts[$part]->subtypee; 
######## Type end 

header("Content-typee: ".$type); 
header("Content-Disposition: attachment; filename=".$name); 

######## coding 
$coding = $struckture->parts[$part]->encoding; 
if ($coding == 0) 
{ 
    $message = imap_7bit($message); 
} 
elseif ($coding == 1) 
{ 
    $wiadomsoc = imap_8bit($message); 
} 
elseif ($coding == 2) 
{ 
    $message = imap_binary($message); 
} 
elseif ($coding == 3) 
{ 
    $message = imap_base64($message); 
} 
elseif ($coding == 4) 
{ 
    $message = quoted_printable($message); 
} 
elseif ($coding == 5) 
{ 
    $message = $message; 
} 
//echo $message;
  return $message;
}

/*
		$host    = 'imap.gmail.com';
		$porta   = '993';
		$usuario = 'lupe.tecnologia.sebrae@gmail.com';
		$usuario = 'luizrehmpereira@gmail.com';
		$senha   = 'guybete52';
		$opcao   = '/imap/ssl/novalidate-cert';
		$box     = 'INBOX';
		//$box     = '';
		//$opcao   = '';
		$opcao   = '/imap/ssl';
		$str_conexao = "{{$host}:{$porta}{$opcao}}{$box}";
		$mbox  = imap_open($str_conexao, $usuario, $senha, NULL, 1 );
		
		
		//$mbox  = imap_open($str_conexao, $usuario, $senha, NULL, 1, array ('DISABLE_AUTHENTICATOR' => 'GSSAPI')     );
		
		// $this->mbox = imap_open("{".$this->host.":{$porta}/novalidate-cert}{$box}", $usuario, $senha , NULL, 1, array('DISABLE_AUTHENTICATOR' => 'GSSAPI'))
		if (!$mbox)
        {		
		//	die("Erro de Conexão: " . imap_last_error(). $str_conexao. " Usuario: {$usuario}  Senha: {$senha}" );
		
			echo "Erro de Conexão: " . imap_last_error(). $str_conexao. " Usuario: {$usuario}  Senha: {$senha}" ;
		}	 
        else
		{
		    $qtdmsg = imap_num_msg($mbox); 
			echo "Conexão OK: " . imap_last_error(). $str_conexao. " Usuario: {$usuario}  Senha: {$senha}<br />" ;
			echo "Quantidade msg: {$qtdmsg} <br />";
			echo '<br /><br />';
 			//for($m = 1; $m <= imap_num_msg($mbox); $m++){
			
			$numtotmsg = imap_num_msg($mbox);
			$numtotmsgl = $numtotmsg-100;
			//for($m = $numtotmsg; $m =5 ; $m = $m - 1){
			
			for($mx = 1; $mx <= imap_num_msg($mbox); $mx++){
			    $m = $numtotmsg - ($mx - 1);
				//ele vai repetir esse laço enquanto houver mensagens
				$header = imap_headerinfo($mbox, $m);
				//$header = imap_rfc822_parse_headers( $headerw);
						echo '<pre>';
					 print_r(imap_headerinfo($mbox, $m));
					 echo '</pre>';

				
				//$titulo = $header->subject; 
				//$titulow=imap_rfc822_parse_headers($titulo);
				//echo "{$m} - {$titulo} <br />";
				//print_r($titulow);
				
				
				// BODY
    $s = imap_fetchstructure($mbox,$m);
	echo '<pre>';
	print_r($s);
	echo '</pre>';
    		
				
				$body   = imap_fetchbody ($mbox, $m,"1.2");
				if ($body != "") {
				   echo "1.2 <br />";
				   $bodyw  =	 quoted_printable_decode($body);
                }
				if ($body == "") {
    $body = imap_fetchbody($imap, $i, "1");
	echo "1 <br />";
	$bodyw =	 quoted_printable_decode($body);
}
				
				if ($body == "") {
    $body = imap_fetchbody($imap, $i, "1.1");
	echo "1.1 <br />";
	$bodyw =	 ($body);
}
if ($body == "") {
    $body = imap_fetchbody($imap, $i, "2");
	$bodyw =	 ($body);
	echo "2 <br />";
}
if ($body == "") {
    $body = imap_fetchbody($imap, $i, "2.1");
	$bodyw =	 ($body);
	echo "2.1 <br />";
}
if ($body == "") {
    $body = imap_fetchbody($imap, $i, "2.2");
	$bodyw =	 ($body);
	echo "2.2 <br />";
}
if ($body == "") {
    $body = imap_fetchbody($imap, $i, "2.3");
	$bodyw =	 ($body);
	echo "2.3 <br />";
}
//$message = imap_fetchbody($inbox,$email_number,2);
				//	echo '<pre>';
				//	 print_r($body);
				//	 echo '</pre>';
					 
					 
				//$bodyw =	 imap_utf7_decode($body);
				
				$numero = $header->Msgno; 
				$id    = $numero;
				//$bodyw = DecodeBody($mbox,$id);
				
				//$bodyw = utf8_decode(imap_utf8($body));
				//$bodyw = (imap_utf8($body));
				//$bodyw = utf8_decode(($body));

				echo '<li>';
					echo '<h2>';
					$titulow=$header->subject;
					
					//$titulow = utf8_decode(imap_utf8($titulow));
					
					$titulow = decode_imap_text($titulow);
					
					//$titulow = quoted_printable_decode($titulow);
					//$titulow = (imap_utf8($titulow));

			//$titulo = quoted_printable_decode($titulow);
					echo $numero.' - '.$titulow 
						. ', '
						. date('d-m-Y H:i:s', strtotime($header->date));
				 echo '</h2>';
				 echo '<hr>';
				 
				 echo '<p>' . "-- {$numero} -- ".$bodyw . '</p>';
					echo '</li>';
					
					
					
					
					
					$overview = imap_fetch_overview($inbox,$email_number,0);
        $message = imap_fetchbody($inbox,$email_number,2);
        $struct = imap_fetchstructure($inbox, $email_number);

        $output.= '<div class="toggle'.($overview[0]->seen ? 'read' : 'unread').'">';
        $output.= '<span class="subject">'.$overview[0]->subject.'</span> ';
        $output.= '<span class="from">'.$overview[0]->from.'</span>';
        $output.= '<span class="date">on '.$overview[0]->date.'</span>';
        $output.= '</div>';

        // output the email body 
        $output.= '<div class="body">'.$message.'</div>';
					
					
					
					
					
					
					
					
					
					if ($mx>20)
					
					
					{
					    break;
					}
			}

			$MC = imap_check($mbox);

			// Fetch an overview for all messages in INBOX
			//$result = imap_fetch_overview($mbox,"1:{$MC->Nmsgs}",0);
			$inicio = $MC->Nmsgs-20;
			$result = imap_fetch_overview($mbox,"$inicio:{$MC->Nmsgs}",0);
			foreach ($result as $overview) {
			
			    $titulo = quoted_printable_decode($overview->subject);
				$from   = quoted_printable_decode($overview->from);
				
				echo "#{$overview->msgno} ({$overview->date}) - From: {$from}
				{$titulo}<br />";
				
				echo '<pre>';
					 print_r($overview);
					 echo '</pre>';
			}


						imap_close($mbox);
					}

*/

    


/*
    Require_Once('classes/gsw_email_class.php');
    $vetEmail=Array();
	$vetEmail['host']    = 'imap.gmail.com';
	$vetEmail['porta']   = '993';
	$vetEmail['usuario'] = 'lupe.tecnologia.sebrae@gmail.com';
	
	$vetEmail['usuario'] = 'luizrehmpereira@gmail.com';
	$vetEmail['senha']   = 'guybete52';
	$vetEmail['box']     = 'INBOX';
	$vetEmail['opcao']   = '/imap/ssl';
	
	
	$GSWEMAIL = new TGSW_EMAIL($vetEmail);
	$vetEmailLidos=Array();
	//$vetEmailLidos = $GSWEMAIL->LeEmail();
	$vetEmailErro        = Array();
	$vetEmailErro        = $GSWEMAIL->GravaEmail();
	
	$withbody=true;
	$id=6000;
	//$vetBody = $GSWEMAIL->formatMessage($id, $withbody);
	//p($vetBody); 
    //p($vetEmailLidos); 
*/

/*
	Require_Once('classes/gsw_email_helpdesk_class.php');
    $vetEmailHelpdesk=Array();
	$vetEmailHelpdesk['usuario'] = 'luizrehmpereira@gmail.com';
	$vetEmailHelpdesk['senha']   = 'guybete52';
	$vetEmail['opcao']           = '';
	$GSWEMAILHELPDESK = new TGSW_EMAILHELPDESK($vetEmailHelpdesk);
	$vetEmailErro        = Array();
	$vetEmailErro        = $GSWEMAILHELPDESK->GravaEmailHelpdesk();
*/
//p($_GET);


///////////////


if ($acao=='alt' or $acao=='inc')
{
    $botao_volta = ' plu_helpdesk_volta() ';
//	$botao_acao  = ' plu_helpdesk_acao() ';
}


echo "<video style='display:none;' autoplay></video>";
echo "<img  style='display:none;'  src=''>";
echo "<canvas style='display:none;'></canvas>";


echo "<div class='barratitulo_conf'>";
echo "SUPORTE TÉCNICO - SOLICITAÇÃO DE ATENDIMENTO";
echo "</div>";


$tabela = 'plu_helpdesk';
$id = 'idt';

//P($_SESSION[CS]);
//p($_GET);
$direto=$_GET['direto'];
if ($direto == 'S') {
   // $botao_volta  = "self.location = 'conteudo.php'; ";
   // $botao_acao   = '<script type="text/javascript">self.location = "conteudo.php";</script>';
}
else
{

}

$bt_alterar_lbl = 'Enviar';
$bt_voltar_lbl  = 'Desistir';

$bt_alterar_aviso=' ';


$acao_ant=$_GET['acao_ant'];
  
if ($acao=="inc")
{
    $vetParametros=Array();
	$vetParametros['titulo']   =' ';
	$vetParametros['descricao']=' ';
    $idt_helpdesk=GravaHelpDesk($vetParametros);

	echo "<script>";
	//echo " self.location='conteudo.php?acao=alt&acao_ant=inc&prefixo=cadastro&menu=plu_helpdesk&id={$idt_helpdesk}&direto=S'; ";
	echo " self.location='conteudo.php?acao=alt&prefixo=cadastro&menu=plu_helpdesk&id={$idt_helpdesk}&direto=S'; ";
	echo "</script>";
	
}
else
{
    $descricao_i = "";
    $idt_helpdesk=$_GET['id'];
    $sql  = "select  ";
	$sql .= " plu_hd.*  ";
    $sql .= " from plu_helpdesk plu_hd ";
    $sql .= " where plu_hd.idt = {$idt_helpdesk} ";
    $rs = execsql($sql);
    $wcodigo = '';
    ForEach ($rs->data as $row) {
        $descricao_i = $row['descricao'];
	}	
}


 //$acao_alt_con='S';

//p($_SESSION[CS]);



//$onSubmitDep = 'grc_avaliacao_dep()';

$class_titulo_f  = "class_titulo_f";
$class_frame_p   = "class_frame_p";
$class_titulo_p  = "class_titulo_p";
$class_frame     = "class_frame";
$class_titulo    = "class_titulo";
$titulo_na_linha = false;
$sistema_origem  = DecideSistema();
$idt_helpdesk    = $_GET['id'];
$vetFrm = Array();
$js = " readonly='true' style='background:#FFFFE1;' ";
$vetCampo['protocolo'] = objTexto('protocolo', 'Protocolo', false, 15, 45,$js);
 
$vetCampo['login']           = objTexto('login', 'Usuário', false, 20, 120,$js);

$vetCampo['nome']            = objTexto('nome', 'Nome Usuário', false, 35, 120,$js);
$vetCampo['email']           = objEmail('email', 'Email usuário', false,43,'',$js);
$vetCampo['datahora']        = objDataHora('datahora', 'Data Registro', false,$js);
$vetCampo['ip']              = objTexto('ip', 'IP', false, 10, 120,$js);
$vetCampo['latitude']        = objTexto('latitude', 'Latitude', false, 10, 120,$js);
$vetCampo['longitude']       = objTexto('longitude', 'Langitude', false, 10, 120,$js);
$vetCampo['macroprocesso']   = objEmail('macroprocesso', 'MacroProcesso', false, 15, 120,$js);
$js = " style=' width:100%;' ";
$vetCampo['titulo']          = objTexto('titulo', 'Título da Solicitação de Atendimento ', true, 45, 120, $js);
$vetCampo['anonimo_nome']    = objTexto('anonimo_nome', 'usuário sem Login', false, 45, 120);
$vetCampo['anomimo_email']   = objEmail('anomimo_email', 'Email usuário sem Login', false, 45, 120);

$vetCampo['descricao']       = objHtml('descricao', 'Descrição', true,'250px','','',True);


$js = " readonly='true' style='background:#FFFFE1;' ";
$vetCampo['numero_id_helpdesk_usuario'] = objTexto('numero_id_helpdesk_usuario', 'Protocolo Helpdesk Sebrae-ba', false, 35, 120,$js);
$vetCampo['status_helpdesk_usuario']    = objTexto('status_helpdesk_usuario', 'Status Helpdesk Sebrae', false, 20, 120,$js);

$js = " readonly='true' disabled ";
$vetCampo['complemento']       = objHtml('complemento', 'Identificação do Usuário', true,'250px','',$js,false);
$vetCampo['msg_erro']       = objHtml('msg_erro', 'Erro envio Email', false,'250px','','',True);


$vetStatusHD = Array();
$vetStatusHD['A'] ='Aberto'; 
$vetStatusHD['R'] ='Registrado'; 
$vetStatusHD['F'] ='Fechado'; 
$js = " disabled style='background:#FFFFE1; ' ";
$vetCampo['status'] = objCmbVetor('status', 'Status', True, $vetStatusHD,'',$js);

/*
$vetTipoSolicitacaoHD = Array();
$vetTipoSolicitacaoHD['PS'] ='Reportar Problema no Sistema'; 
$vetTipoSolicitacaoHD['RE'] ='Reclamação'; 
$vetTipoSolicitacaoHD['EL'] ='Elogio'; 
$vetTipoSolicitacaoHD['NA'] ='Não Informado'; 
*/

$vetTipoSolicitacaoHD = Array();
$vetTipoSolicitacaoHD['PS'] ='Problema no Sistema'; 
$vetTipoSolicitacaoHD['RE'] ='Dúvida do Sistema'; 

$vetCampo['tipo_solicitacao'] = objCmbVetor('tipo_solicitacao', 'Tipo de Solicitação', true, $vetTipoSolicitacaoHD,'');


$js = " readonly='true' style='background:#FFFFE1; ' ";

$vetCampo['navegador']          = objTexto('navegador', 'Navegador', false, 100, 255, $js);
$vetCampo['tipo_dispositivo']   = objTexto('tipo_dispositivo', 'Tipo Dispositivo', false, 20, 255, $js);
$vetCampo['modelo']             = objTexto('modelo', 'Modelo', false, 20, 255, $js);
$vetCampo['data_envio_email_helpdesk'] = objDataHora('data_envio_email_helpdesk', 'Data Envio Email', false,$js);


 MesclarCol($vetCampo['email'], 3);
 $vetFrm[] = Frame('', Array(
	Array($vetCampo['login'],'',$vetCampo['nome'],'',$vetCampo['email']),
	Array($vetCampo['protocolo'],'',$vetCampo['numero_id_helpdesk_usuario'],'',$vetCampo['datahora'],'',$vetCampo['status_helpdesk_usuario']),
        ), $class_frame_p, $class_titulo_p, $titulo_na_linha);
		
		
 MesclarCol($vetCampo['descricao'], 3);		
 $vetFrm[] = Frame('', Array(
	Array($vetCampo['titulo'],'',$vetCampo['tipo_solicitacao']),
	Array($vetCampo['descricao']),
	//Array($vetCampo['complemento']),
        ), $class_frame_p, $class_titulo_p, $titulo_na_linha);




	if ($direto != 'S') {
	
		
	    MesclarCol($vetCampo['complemento'], 7);		
		MesclarCol($vetCampo['msg_erro'], 7);		
		MesclarCol($vetCampo['navegador'], 7);		
		MesclarCol($vetCampo['data_envio_email_helpdesk'], 3);		
		$vetFrm[] = Frame('', Array(
		    Array($vetCampo['complemento']),
			Array($vetCampo['latitude'],'',$vetCampo['longitude'],'',$vetCampo['status'],'',$vetCampo['macroprocesso']),
			Array($vetCampo['navegador']),
			Array($vetCampo['tipo_dispositivo'],'',$vetCampo['modelo'],'',$vetCampo['data_envio_email_helpdesk']),
			Array($vetCampo['msg_erro']),
			
			
		), $class_frame_p, $class_titulo_p, $titulo_na_linha);
	}




if ($acao == 'con' || $acao == 'exc') {
    $vetParametros = Array(
        'codigo_frm' => 'plu_helpdesk_anexo_w',
        'controle_fecha' => 'A',
        'comcontrole' => 0,
        'barra_inc_ap' => false,
        'barra_alt_ap' => false,
        'barra_con_ap' => false,
        'barra_exc_ap' => false,
        'contlinfim' => '',
    );
} else {
    $vetParametros = Array(
        'codigo_frm' => 'plu_helpdesk_anexo_w',
        'controle_fecha' => 'A',
        'barra_inc_ap' => true,
        'barra_alt_ap' => true,
        'barra_con_ap' => false,
        'barra_exc_ap' => true,
        'contlinfim' => '',
    );
}



if ($acao=='con')
{
    $vetFrm[] = Frame('<span>ANEXOS DA SOLICITAÇÃO</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p);
}
else
{
    $vetFrm[] = Frame('<span>VINCULAR ANEXOS DA SOLICITAÇÃO</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p);
}
$vetCampoFC = Array();
//Monta o vetor de Campo
$vetCampoFC['data_responsavel'] = CriaVetTabela('Data Registro','data');
$vetCampoFC['plu_ur_nome_completo']      = CriaVetTabela('Responsável');
$vetCampoFC['descricao']        = CriaVetTabela('Título do Anexo');
$vetCampoFC['arquivo']          = CriaVetTabela('Arquivo anexado', 'arquivo', '', 'plu_helpdesk_anexo');
// Parametros da tela full conforme padrão
$titulo = 'Anexos';

$TabelaPrinc = "plu_helpdesk_anexo";
$AliasPric   = "plu_hda";
$Entidade    = "Anexo do Atendimento";
$Entidade_p  = "Anexos do Atendimento";
//
// Select para obter campos da tabela que serão utilizados no full
//
$orderby = "{$AliasPric}.data_responsavel desc ";
//
$sql = "select {$AliasPric}.*,  ";
$sql .= " plu_ur.nome_completo as plu_ur_nome_completo  ";
//
$sql .= " from {$TabelaPrinc} {$AliasPric}  ";
$sql .= " inner join plu_usuario plu_ur on plu_ur.id_usuario = {$AliasPric}.idt_responsavel  ";
//
$sql .= " where {$AliasPric}".'.idt_helpdesk = $vlID';
$sql .= " order by {$orderby}";
//
// Carrega campos que serão editados na tela full
//
//p($vetParametros);
$vetCampo['plu_helpdesk_anexo'] = objListarConf('plu_helpdesk_anexo', 'idt', $vetCampoFC, $sql, $titulo, false, $vetParametros);
//
// Fotmata lay_out de saida da tela full
//
$vetParametros = Array(
    'codigo_pai' => 'plu_helpdesk_anexo_w',
    'width' => '100%',
);
//
$vetFrm[] = Frame('', Array(
    Array($vetCampo['plu_helpdesk_anexo']),
        ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);
//
// FIM ____________________________________________________________________________
// ____________________________________________________________________________
//


///////////////// Interações
//if ($acao_ant!='inc')

if ($descricao_i !='')

{

	if ($acao == 'con' || $acao == 'exc') {
		$vetParametros = Array(
			'codigo_frm' => 'plu_helpdesk_interacao_w',
			'controle_fecha' => 'A',
			//'comcontrole' => 0,
			'barra_inc_ap' => true,
			'barra_alt_ap' => false,
			'barra_con_ap' => false,
			'barra_exc_ap' => false,
			'contlinfim' => '',
		);
	} else {
		$vetParametros = Array(
			'codigo_frm' => 'plu_helpdesk_interacao_w',
			'controle_fecha' => 'A',
			'barra_inc_ap' => true,
			'barra_alt_ap' => false,
			'barra_con_ap' => true,
			'barra_exc_ap' => false,
			'contlinfim' => '',
		);
	}

$vetParametros = Array(
        'codigo_frm' => 'plu_helpdesk_interacao_w',
        'controle_fecha' => 'A',
	//	'acao_alt_con_p' => 'S',
        'barra_inc_ap' => true,
        'barra_alt_ap' => false,
        'barra_con_ap' => true,
        'barra_exc_ap' => false,

        'barra_inc_ap_muda_vl' => false,
        'barra_alt_ap_muda_vl' => false,
        'barra_exc_ap_muda_vl' => false,
		'contlinfim' => '',
    );




	$vetFrm[] = Frame('<span>INTERAÇÕES</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p,$vetParametros);

	$vetCampoFC = Array();
	//Monta o vetor de Campo
	
	$vetTipoSolicitacaoHDI = Array();
	$vetTipoSolicitacaoHDI['ES'] = 'Esclarecimentos'; 
	$vetTipoSolicitacaoHDI['DU'] = 'Dúvida'; 
	$vetTipoSolicitacaoHDI['FE'] = 'Encerramento'; 
	$vetTipoSolicitacaoHDI['PA'] = 'Parado'; 
	$vetTipoSolicitacaoHDI['AG'] = 'Aguardando'; 
    // 
	
	
	$vetCampoFC['datahora'] = CriaVetTabela('Data / Hora','data');
	$vetCampoFC['protocolo'] = CriaVetTabela('Protocolo<br />CRM');
	$vetCampoFC['numero_id_helpdesk_usuario'] = CriaVetTabela('Protocolo<br />Sebrae-BA');
	$vetCampoFC['titulo'] = CriaVetTabela('Título');
	//$vetCampoFC['descricao'] = CriaVetTabela('Descrição');
	$vetCampoFC['plu_ur_nome_completo'] = CriaVetTabela('Responsável');
	$vetCampoFC['tipo_solicitacao'] = CriaVetTabela('Tipo Solicitação','descDominio',$vetTipoSolicitacaoHDI);
	//$vetCampoFC['arquivo']   = CriaVetTabela('Arquivo anexado', 'arquivo', '', 'plu_helpdesk_anexo');
	// Parametros da tela full conforme padrão
	$titulo = 'Interações';

	$TabelaPrinc = "plu_helpdesk_interacao";
	$AliasPric   = "plu_hi";
	$Entidade    = "Interação HelpDesk";
	$Entidade_p  = "Interações HelpDesk";
	//
	// Select para obter campos da tabela que serão utilizados no full
	//
	$orderby = "{$AliasPric}.datahora desc ";
	//
	$sql  = "select {$AliasPric}.*,  ";
	$sql .= " plu_ur.nome_completo as plu_ur_nome_completo  ";

	$sql .= " from {$TabelaPrinc} {$AliasPric}  ";
	$sql .= " left join plu_usuario plu_ur on plu_ur.login = {$AliasPric}.login  ";

	//
	$sql .= " where {$AliasPric}".'.idt_helpdesk = $vlID';
	$sql .= '   and ( flag_logico = '.aspa('A')." ) ";
	$sql .= " order by {$orderby}";
	//
	// Carrega campos que serão editados na tela full
	//
	//p($vetParametros);
	$vetCampo['plu_helpdesk_interacao'] = objListarConf('plu_helpdesk_interacao', 'idt', $vetCampoFC, $sql, $titulo, false,$vetParametros);
	//
	// Fotmata lay_out de saida da tela full
	//
	$vetParametros = Array(
		'codigo_pai' => 'plu_helpdesk_interacao_w',
		'width' => '100%',
	);
	//
	$vetFrm[] = Frame('', Array(
		Array($vetCampo['plu_helpdesk_interacao']),
			), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);
	//
	// FIM ____________________________________________________________________________
	// ____________________________________________________________________________
	//

}






$vetCad[] = $vetFrm;
?>
<script type="text/javascript">

	var acao = '<?php echo $acao;  ?>';
	
	$(document).ready(function () {
        $('#bt_voltar').click(function () {
            //alert('to vivo');
		});
	
	
	});
	
	AC_Midia();
	
	var onFailSoHard = function(e) {
		console.log('Reeeejected!', e);
	};
	
	// Not showing vendor prefixes.
	
	/*
	navigator.getUserMedia('video, audio', function(localMediaStream) {
		var video = document.querySelector('video');
		video.src = window.URL.createObjectURL(localMediaStream);
		// Note: onloadedmetadata doesn't fire in Chrome when using it with getUserMedia.
		// See crbug.com/110938.
		
		video.onloadedmetadata = function(e) {
			// Ready to go. Do some stuff.
		};
		
	    }, onFailSoHard);
		
	*/	
		
    //AC_MidiaSolicita();
	var video  = document.querySelector('video');
	var canvas = document.querySelector('canvas');
	var ctx    = canvas.getContext('2d');
	//var localMediaStream = null;
	function snapshot() {
	  //if (localMediaStream) {
		ctx.drawImage(video, 0, 0);
		// "image/webp" works in Chrome 18. In other browsers, this will fall back to image/png.
		document.querySelector('img').src = canvas.toDataURL('image/png');
	  //}
	}
	//video.addEventListener('click', snapshot, false);
	// Not showing vendor prefixes or code that works cross-browser.
	//navigator.getUserMedia({video: true}, function(stream) {
	//  video.src = window.URL.createObjectURL(stream);
	//  localMediaStream = stream;
	//}, onFailSoHard);


//snapshot();

function plu_helpdesk_volta()
{
    var msg = "Deseja desistir da abertura de chamado de suporte técnico?";
	//alert('acao = '+acao)
    if (acao=='alt')
	{
		if(confirm(msg)) {
		   self.location=$('#bt_volta_href').val();
		   //parent.hidePopWin(false);
		} else {
		   return false;
		}
	}
	else
	{
	   self.location=$('#bt_volta_href').val(msg);
	}
	

}
function plu_helpdesk_acao()
{
    var msg = "Sua solicitação foi cadastrada com sucesso! Por gentileza, aguardar retorno da equipe de suporte técnico para dar continuidade a este atendimento.";
	//alert('acao = '+acao)
    if (acao=='alt')
	{
		if(confirm(msg)) {
		   self.location=$('#bt_volta_href').val();
		   //parent.hidePopWin(false);
		} else {
		   return false;
		}
	}
	else
	{
	   self.location=$('#bt_volta_href').val(msg);
	}
	

}

</script>
