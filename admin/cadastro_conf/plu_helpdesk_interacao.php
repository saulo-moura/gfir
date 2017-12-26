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

// p($_GET);
if ($_GET['idCad'] != '') {
    $_GET['idt0'] = $_GET['idCad'];
    //$botao_volta = "parent.btFechaCTC('".$_GET['session_cod']."', null, parent.grc_atendimento_organizacao_fecha_ant);";
	
	
	//$botao_volta = "parent.btFechaCTC('".$_GET['session_cod']."', null);";
	
	$botao_volta = "parent.btFechaCTC('".$_GET['session_cod']."');";
    $botao_acao = '<script type="text/javascript">parent.btFechaCTC("'.$_GET['session_cod'].'");</script>';
}

$idt_helpdesk    = $_GET['idt0'];

echo "<video style='display:none;' autoplay></video>";
echo "<img  style='display:none;'  src=''>";
echo "<canvas style='display:none;'></canvas>";


echo "<div class='barratitulo_conf'>";
echo "INTERAÇÃO - SUPORTE TÉCNICO";
echo "</div>";


//$tabela = 'plu_helpdesk';
$id = 'idt';


$TabelaPai = "plu_helpdesk";
$AliasPai = "plu_h";
$EntidadePai = "HelpDesk";
$idPai = "idt";

$TabelaPrinc = "plu_helpdesk_interacao";
$AliasPric = "plu_hi";
$Entidade = "Interação do HelpDesk";
$Entidade_p = "Interações do HelpDesk";
$CampoPricPai = "idt_helpdesk";

$tabela = $TabelaPrinc;

$class_frame_f = "class_frame_f";
$class_titulo_f = "class_titulo_f";

$class_frame_p = "class_frame_p";
$class_titulo_p = "class_titulo_p";

$class_frame = "class_frame";
$class_titulo = "class_titulo";
$titulo_na_linha = false;






//P($_SESSION[CS]);
//p($_GET);

$_GET['direto']='S';
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


if ($acao=="inc")
{
    $vetParametros=Array();
	$vetParametros['titulo']   =' ';
	$vetParametros['descricao']=' ';
	$vetParametros['idt_helpdesk']=$idt_helpdesk;
    $idt_helpdesk_interacao=GravaHelpDeskInteracao($vetParametros);

	echo "<script>";
	echo " self.location='conteudo_cadastro.php?acao=alt&id={$idt_helpdesk_interacao}".getParametro('acao,id')."'";
	echo "</script>";
	
}
else
{
    $idt_helpdesk_interacao=$_GET['id'];
	$idt_helpdesk=0;
    $sql  = "select  ";
	$sql .= " plu_hdi.*  ";
    $sql .= " from plu_helpdesk_interacao plu_hdi ";
    $sql .= " where plu_hdi.idt = {$idt_helpdesk_interacao} ";
    $rs = execsql($sql);
    ForEach ($rs->data as $row) {
       $idt_helpdesk=$row['idt_helpdesk']; 
	}	
    $sql  = "select  ";
	$sql .= " plu_h.*  ";
    $sql .= " from plu_helpdesk plu_h ";
    $sql .= " where plu_h.idt = {$idt_helpdesk} ";
    $rs = execsql($sql);
    
    ForEach ($rs->data as $row) {
       $protocolo = $row['protocolo']; 
	   $titulo    = $row['titulo']; 
	}	

}


echo "<div class='barratitulo_conf'>";
echo "[{$protocolo}] - {$titulo}";
echo "</div>";




//p($_SESSION[CS]);



//$onSubmitDep = 'grc_avaliacao_dep()';

$class_titulo_f  = "class_titulo_f";
$class_frame_p   = "class_frame_p";
$class_titulo_p  = "class_titulo_p";
$class_frame     = "class_frame";
$class_titulo    = "class_titulo";
$titulo_na_linha = false;
$sistema_origem  = DecideSistema();
$idt_helpdesk_interacao    = $_GET['id'];

$vetCampo[$CampoPricPai] = objFixoBanco($CampoPricPai, $EntidadePai, $TabelaPai, 'idt', 'descricao', 0);



$vetFrm = Array();




//$vetParametros = Array(
//    'situacao_padrao' => true,
//);
//$vetFrm[] = Frame("<span>$titulo_cadastro</span>", '', $class_frame_f, $class_titulo_f, $titulo_na_linha, $vetParametros);

$vetParametros = Array(
    'codigo_frm' => 'parte01',
    'controle_fecha' => 'A',
);
$vetFrm[] = Frame('<span>INTERAÇÃO</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);


$vetParametros = Array(
    'codigo_pai' => 'parte01',
);












$js = " readonly='true' style='background:#FFFFE1;' ";
$vetCampo['protocolo'] = objTexto('protocolo', 'Protocolo', false, 15, 45,$js);


//$vetCampo['numero_id_helpdesk_usuario'] = objTexto('numero_id_helpdesk_usuario', 'Protocolo Sebrae', false, 45, 255,$js);

$js = " readonly='true' style='background:#FFFFE1;' ";
$vetCampo['numero_id_helpdesk_usuario'] = objTexto('numero_id_helpdesk_usuario', 'Protocolo Helpdesk Sebrae-ba', false, 35, 120,$js);
$vetCampo['status_helpdesk_usuario']    = objTexto('status_helpdesk_usuario', 'Status Helpdesk Sebrae', false, 20, 120,$js);


$vetCampo['login']           = objTexto('login', 'Responsável pela Interação', false, 20, 120,$js);

$vetCampo['nome']            = objTexto('nome', 'Nome Completo', false, 38, 120,$js);
$vetCampo['email']           = objEmail('email', 'Email Responsável pela Interação', false,38,'',$js);
$vetCampo['datahora']        = objDataHora('datahora', 'Data Registro da interação', false,$js);
$vetCampo['ip']              = objTexto('ip', 'IP', false, 10, 120,$js);
$vetCampo['latitude']        = objTexto('latitude', 'Latitude', false, 10, 120,$js);
$vetCampo['longitude']       = objTexto('longitude', 'Langitude', false, 10, 120,$js);
$vetCampo['macroprocesso']   = objEmail('macroprocesso', 'MacroProcesso', false, 15, 120,$js);
$js = " style=' width:100%;' ";
$vetCampo['titulo']          = objTexto('titulo', 'Título da Interação', true, 45, 120, $js);
$vetCampo['anonimo_nome']    = objTexto('anonimo_nome', 'usuário sem Login', false, 45, 120);
$vetCampo['anomimo_email']   = objEmail('anomimo_email', 'Email usuário sem Login', false, 45, 120);

$vetCampo['descricao']       = objHtml('descricao', 'Descrição', true,'250px','','',True);

$js = " readonly='true' disabled ";
$vetCampo['complemento']       = objHtml('complemento', 'Identificação do Usuário', true,'300px','',$js,false);


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

$vetTipoSolicitacaoHDI = Array();
$vetTipoSolicitacaoHDI['ES'] = 'Esclarecimentos'; 
$vetTipoSolicitacaoHDI['DU'] = 'Dúvida'; 
$vetTipoSolicitacaoHDI['FE'] = 'Encerramento'; 
$vetTipoSolicitacaoHDI['PA'] = 'Parado'; 
$vetTipoSolicitacaoHDI['AG'] = 'Aguardando'; 

$vetCampo['tipo_solicitacao'] = objCmbVetor('tipo_solicitacao', 'Tipo de Solicitação', true, $vetTipoSolicitacaoHDI,'');


$js = " readonly='true' style='background:#FFFFE1; ' ";

$vetCampo['navegador']          = objTexto('navegador', 'Navegador', false, 100, 255, $js);
$vetCampo['tipo_dispositivo']   = objTexto('tipo_dispositivo', 'Tipo Dispositivo', false, 20, 255, $js);
$vetCampo['modelo']             = objTexto('modelo', 'Modelo', false, 20, 255, $js);
$vetCampo['data_envio_email_helpdesk'] = objDataHora('data_envio_email_helpdesk', 'Data Envio Email', false,$js);

/*
 MesclarCol($vetCampo['email'], 3);
 MesclarCol($vetCampo['numero_id_helpdesk_usuario'], 3);
 MesclarCol($vetCampo['descricao'], 7);		
 $vetFrm[] = Frame('', Array(
    Array($vetCampo['protocolo'],'',$vetCampo['datahora'],'',$vetCampo['status'],'',$vetCampo['ip']),
	Array($vetCampo['login'],'',$vetCampo['nome'],'',$vetCampo['email']),
	Array($vetCampo['titulo'],'',$vetCampo['tipo_solicitacao'],'',$vetCampo['numero_id_helpdesk_usuario']),
	Array($vetCampo['descricao']),
        ), $class_frame_p, $class_titulo_p, $titulo_na_linha,$vetParametros);
*/
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
		MesclarCol($vetCampo['navegador'], 7);		
		MesclarCol($vetCampo['data_envio_email_helpdesk'], 3);		
		$vetFrm[] = Frame('', Array(
		    Array($vetCampo['complemento']),
			Array($vetCampo['latitude'],'',$vetCampo['longitude'],'',$vetCampo['status'],'',$vetCampo['macroprocesso']),
			Array($vetCampo['navegador']),
			Array($vetCampo['tipo_dispositivo'],'',$vetCampo['modelo'],'',$vetCampo['data_envio_email_helpdesk']),
			
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
 $vetParametros = Array(
        'codigo_frm' => 'plu_helpdesk_interacao_w',
        'controle_fecha' => 'A',
	//	'acao_alt_con_p' => 'S',
        'barra_inc_ap' => true,
        'barra_alt_ap' => true,
        'barra_con_ap' => false,
        'barra_exc_ap' => false,

        'barra_inc_ap_muda_vl' => false,
        'barra_alt_ap_muda_vl' => false,
        'barra_exc_ap_muda_vl' => false,
		'contlinfim' => '',
    );

$vetFrm[] = Frame('<span>VINCULAR ANEXOS A INTERAÇÂO</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p,$vetParametros);

$vetCampo = Array();
//Monta o vetor de Campo
$vetCampoFC['data_responsavel'] = CriaVetTabela('Data Registro','data');
$vetCampoFC['plu_ur_nome_completo']      = CriaVetTabela('Responsável');
$vetCampoFC['descricao']        = CriaVetTabela('Título do Anexo');
$vetCampoFC['arquivo']          = CriaVetTabela('Arquivo anexado', 'arquivo', '', 'plu_helpdesk_interacao_anexo');
// Parametros da tela full conforme padrão
$titulo = 'Anexos';

$TabelaPrinc = "plu_helpdesk_interacao_anexo";
$AliasPric   = "plu_hdia";
$Entidade    = "Anexo da Interação do HelpDesk";
$Entidade_p  = "Anexos da Interação do HelpDesk";
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
$sql .= " where {$AliasPric}".'.idt_helpdesk_interacao = $vlID';
$sql .= " order by {$orderby}";
//
// Carrega campos que serão editados na tela full
//
$vetCampo['plu_helpdesk_interacao_anexo'] = objListarConf('plu_helpdesk_interacao_anexo', 'idt', $vetCampoFC, $sql, $titulo, false, array_merge($vetPadraoLC, $vetParametros));
//
// Fotmata lay_out de saida da tela full
//
$vetParametros = Array(
    'codigo_pai' => 'plu_helpdesk_interacao_anexo_w',
    'width' => '100%',
);
//
$vetFrm[] = Frame('', Array(
    Array($vetCampo['plu_helpdesk_interacao_anexo']),
        ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);
//
// FIM ____________________________________________________________________________
// ____________________________________________________________________________
//

$vetCad[] = $vetFrm;
?>
<script type="text/javascript">
	
	
	AC_Midia();
	
	/*
	var onFailSoHard = function(e) {
		console.log('Reeeejected!', e);
	};
	
	// Not showing vendor prefixes.
	navigator.getUserMedia('video, audio', function(localMediaStream) {
		var video = document.querySelector('video');
		video.src = window.URL.createObjectURL(localMediaStream);
		// Note: onloadedmetadata doesn't fire in Chrome when using it with getUserMedia.
		// See crbug.com/110938.
		
		video.onloadedmetadata = function(e) {
			// Ready to go. Do some stuff.
		};
		
	    }, onFailSoHard);
		
		
		
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

*/

</script>
