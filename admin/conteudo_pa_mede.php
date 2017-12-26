<?php
Require_Once('configuracao.php');
if ($_REQUEST['menu'] == '')
 	$menu = 'vazio';
else
	$menu = $_REQUEST['menu'];

if ($_REQUEST['prefixo'] == '')
	$prefixo = 'inc';
else
	$prefixo = $_REQUEST['prefixo'];
	
if ($_REQUEST['acao'] == '')
	$acao = 'con';
else
	$acao = $_REQUEST['acao'];

if ($_REQUEST['titulo_rel'] == '')
    $nome_titulo='';
else
	$nome_titulo = $_REQUEST['titulo_rel'];
	
if ($externo=="S")
{

}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php echo $nome_titulo.' - '.$nome_site      ?></title>
<style type="text/css" media="all">
    Table.sMenu_print {
    	font-family: Arial, Helvetica, sans-serif;
    	font-style: normal;
        font-weight: bold;
    	color: Black;
    	word-spacing: 0px;
        width: 100%;
    	border: 1px solid Black;
    	display: inline;
    }
    Table.Menu_print_e {
        background:#FFFFFF;
        width: 100%;

        }




      div#barra_topo_m {
        background:#004080;
        width: 100%;
        height:35px;
        display:block;
        margin-bottom:4px;
        color:#FFFFFF;
        font-family: Calibri, Arial, Helvetica, sans-serif;
        font-size: 12px;
        font-style: normal;
        font-weight: bold;
        xdisplay:none;
    }
    div#retornar {
        float:left;
        padding-left:5px;
        padding-top:2px;
    }
    div#retornar a {
        font-family: Calibri, Arial, Helvetica, sans-serif;
        font-size: 14px;
        font-style: normal;
        font-weight: bold;
        color:#FFFFFF;
        text-decoration:none;

    }

    div#usuario_m {
        float:left;
        padding-left:30px;
        padding-top:5px;
    }
    div#resto_m {
        float:right;
        padding-right:30px;
        padding-top:5px;
    }
     div#titulo_modulo {
        xbackground:#2F2FFF;
        color:#FFFFFF;
        font-size:18px;
        width:100%;
        padding-top:3px;
        
        xbackground: -moz-linear-gradient(top, #2F2FFF 0%, #6FB7FF 50%, #DFDFFF 100%); /* FF3.6+ */
        xbackground: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#ff0000), color-stop(35%,#6FB7FF), color-stop(100%,#DFDFFF)); /* Chrome,Safari4+ */
        xbackground: -webkit-linear-gradient(top, #2F2FFF 0%,#6FB7FF 50%,#DFDFFF 100%); /* Chrome10+,Safari5.1+ */
        xbackground: -o-linear-gradient(top, #2F2FFF 0%,#6FB7FF 50%,#DFDFFF 100%); /* Opera 11.10+ */
        xbackground: -ms-linear-gradient(top, #2F2FFF 0%,#6FB7FF 50%,#DFDFFF 100%); /* IE10+ */
        xbackground: linear-gradient(to bottom, #2F2FFF 0%,#6FB7FF 50%,#DFDFFF 100%); /* W3C */
        xfilter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#2F2FFF', endColorstr='#6FB7FF',GradientType=0 ); /* IE6-9 */
        xborder: 1px solid thick #c00000;
        xborder-radius: 1em;
        border:1px solid  #0000A0;
    }
div#div_topo {
    padding:0px;
    margin:0px;
    width: 100%;
}
.ctopo {
    width: 100%;
    sbackground: url(imagens/div_topo_meio.png) no-repeat top;
    background: #808080;
    text-align: center;
    padding: 0px;
    padding-top: 8px;
    height: 24px;
}
.ctopo a {
    color: #d2d2d2;
    margin: 0px 5px;
    font-size:12px;
}
.ctopo a.intranet {
    color: white;
    font-weight: bold;
}

.barra_ferramentas {
    background: #FFFFFF;
    color: #000000;
    font-weight: bold;
    width:100%;
    display:block;
    float:left;
    border-bottom:2px solid #666666;
}

#errourl {
    background: #FFFFFF;
    color: #000000;
    width:100%;
    display:block;
	margin:0px;
    padding:0px;
}
#errourl_titulo {
    background: #FF0000;
    color: #FFFFFF;
    font-weight: bold;
    width:100%;
    display:block;
	text-align:center;
	font-size:16px;
}
#errourl_corpo {
    background: #FFFFFF;
    color: #000000;
    font-weight: bold;
    width:100%;
    display:block;
	text-align:lelft;
	margin:10px;
	font-size:14px;

}
#errourl_rodape {
    background: #FFFFFF;
    color: #000000;
    font-weight: bold;
    width:100%;
    display:block;
	text-align:lelft;
	margin:10px;
	margin-top:10px;
	font-size:14px;

}
</style>
<?php Require_Once('head.php');
//  echo "<script type='text/javascript'>var reduz_cron='N';</script>";



if ($externo=="S")
{  // Tratar segurança

}

if ($_SESSION[CS]['g_id_usuario'] == '') {
    echo 'Entrada indevida... ';
    // header("Location: ../");
    echo ' <script type="text/javascript" language="JavaScript1.2">';
    echo "    self.location = 'incentrada_indevida.php';";
    echo ' </script> ';
    exit();
}
?>
</head>
<body style="background:#ffffff; ">

<?php
	if ($externo=="S")
    {

    }
	else
	{

	    echo ' <div id="barra_topo_m"> ';
			$vetMes = Array(
				1 => 'Janeiro',
				2 => 'Fevereiro',
				3 => 'Março',
				4 => 'Abril',
				5 => 'Maio',
				6 => 'Junho',
				7 => 'Julho',
				8 => 'Agosto',
				9 => 'Setembro',
				10 => 'Outubro',
				11 => 'Novembro',
				12 => 'Dezembro'
			);
			echo ' <div id="retornar" style="xwidth:80px;"> ';
			echo '       <a href="javascript:top.close();" title="Clique aqui retornar"><img alt="" src="imagens/sair.png" width="32" height="32"></a>';
			echo ' </div>  ';
			echo "<div  style=''>";
		
			echo "<center>";
			$titulo_modulo="";
			echo "<div  id='titulo_modulo' style=''>";
			echo  $titulo_modulo;
			echo '</div>';
			echo '</div>';
		
        echo '</div>';
		
	}


echo '<div class="Meio" id="Meio">';
    //$menu    = 'grc_nan_devolutiva_rel';
	//$prefixo = 'cadastro';
	//$acao    = 'alt';
	
	
	$id      = 0;
    $acao    = 'inc';
		
    $_GET['id']         = $id;
    $_GET['acao']       = $acao;
    $_GET['deondeveio'] = 'Portal';
	
	// variáveis do GET
	
	$titulo_avaliacao         = $_GET['titulo_avaliacao'];
	$data_avaliacao           = $_GET['data_avaliacao'];
	$protocolo                = $_GET['protocolo'];
	$idt_avaliacao            = $_GET['idt_avaliacao'];
	$cpf                      = $_GET['cpf'];
	$idt_avaliado             = $_GET['idt_avaliado'];
	$cnpj                     = $_GET['cnpj'];
	$idt_organizacao_avaliado = $_GET['idt_organizacao_avaliado'];
	$observacao               = $_GET['observacao'];
	$codigo_formulario        = $_GET['codigo_formulario'];
	$idt_formulario           = $_GET['idt_formulario'];
	$usuario_responsavel      = $_GET['usuario_responsavel'];
	
	$_GET['manual']           = "S";
	$_GET['mede']             = "S";
	$mede                     = $_GET['mede'];
	$_GET['prefixo']          = 'cadastro';
    $_GET['menu']             = 'grc_avaliacao';
	
	
	$vetErro=Array();
	  
	// Verificar parâmetros
	
	// Acessar banco e validar parâmetros de Passagem N3
	
	if ($protocolo!='')
	{
		// Acessa grc_avaliacao
		$sql  = " select ";
		$sql .= '   grc_a.idt,';
		$sql .= '   grc_a.idt_atendimento,';
		$sql .= "   grc_a.idt_situacao  as grc_a_idt_situacao,  ";
		$sql .= "   grc_as.descricao    as grc_as_descricao  ";
		$sql .= " from grc_avaliacao grc_a ";
		$sql .= " inner join grc_avaliacao_situacao grc_as on grc_as.idt = grc_a.idt_situacao ";
		$sql .= " where ";
		$sql .= " grc_a.codigo = ".aspa($protocolo);
		$rs   = execsql($sql);
		ForEach ($rs->data as $row) {
		    $id                 = $row['idt'];
			$grc_a_idt_situacao = $row['grc_a_idt_situacao'];
			$grc_as_descricao   = $row['grc_as_descricao'];
			$idt_atendimento    = $row['idt_atendimento'];
			$_GET['id']         = $id;
			$acao               = 'alt';	
            $vetErro[]="Informado Protocolo Inexistente";			
		}
	}
	if ($cpf=='')
	{  // Erro Cliente PF não informado
       $vetErro[]="CPF é um Campo Obrigatório";			
	}
	else
	{
	    // Acessa gec_entidade
		$sql  = " select ";
		$sql .= '   gec_e.idt';
		$sql .= " from ".db_pir_gec."gec_entidade gec_e ";
		$sql .= " where ";
		$sql .= " gec_e.codigo = ".aspa($cpf);
		//p($sql);
		$rs   = execsql($sql);
		if ($rs->rows > 0)
		{
			ForEach ($rs->data as $row) {
				$idt_avaliado = $row['idt'];
				$_GET['idt_avaliado'] = $idt_avaliado;
			}
		}
		else
		{
		    $vetErro[]="CPF $cpf não esta cadastrado no PIR";			
		}
	  
	}

	
	
	
	if ($cnpj=='')
	{  // Erro Cliente CNPJ não informado
       $vetErro[]="CNPJ é um Campo Obrigatório";			
	}
	else
	{
	    // Acessa gec_entidade
		$sql  = " select ";
		$sql .= '   gec_e.idt';
		$sql .= " from ".db_pir_gec."gec_entidade gec_e ";
		$sql .= " where ";
		$sql .= " gec_e.codigo = ".aspa($cnpj);
		$rs   = execsql($sql);
		//p($sql);
		if ($rs->rows > 0)
		{

			ForEach ($rs->data as $row) {
				$idt_avaliado = $row['idt'];
				$_GET['idt_organizacao_avaliado'] = $idt_organizacao_avaliado;
			}
		}	
		else
		{
		    $vetErro[]="CNPJ $cnpj não esta cadastrado no PIR";			
		}
	}
    //	
	
	if ($codigo_formulario=='')
	{  // Erro Codigo do formulário não informado
       $vetErro[]="Código do formulário não informado";			
	}
	else
	{
	    // Acessa grc_formulario
		$sql  = " select ";
		$sql .= '   grc_f.idt';
		$sql .= " from ".db_pir_grc."grc_formulario grc_f ";
		$sql .= " where ";
		$sql .= " grc_f.codigo = ".aspa($codigo_formulario);
		$rs   = execsql($sql);
		//p($sql);
		if ($rs->rows > 0)
		{
			ForEach ($rs->data as $row) {
				$idt_formulario = $row['idt'];
				$_GET['idt_formulario'] = $idt_formulario;
			}
		}	
		else
		{
		    $vetErro[]="Código do Formulário $codigo_formulario não esta cadastrado no PIR";			
		}
	  
	}
	// Retornar mensagens de critica e consistencia
	
	// Estando ok acessar Formulário ou para Inclusão, Alteração, Consulta ou Exclusão (deve ser Lógica e não Física)
	
    // p($_GET);
    $qtdErro = count($vetErro);
	if ($qtdErro==0)
	{
	    
		// Aqui a Ação de Navegação para acesso ao MEDE
		//
		// Essa funcionalidade esta definida dentro de uma estrutura Cadastro_conf
		//
		// 
		// Essa é a interna do GRC padrão NAN
		// 	
		$prefixo = 'cadastro';
		$menu    = 'grc_avaliacao';
		//
		$Require_Once = "cadastro_p.php";
		//
		// Aqui vai o include para aparecer o Questionário 
		//
		// $Require_Once="cadastro_conf/grc_avaliacao_resposta.php";
		if (file_exists($Require_Once)) {
		
			//
			// Gravar registro de Avaliação e acho que tambel a do atendimento mas o de atendimento pode não ser agora
			//
			$datadia = trata_data(date('d/m/Y H:i:s'));
            $idt_responsavel_registro  = $_SESSION[CS]['g_id_usuario'];
            $data_registro             = aspa($datadia);
			
			$idt_situacao = 1;
			$idt_guia     = 1; 
	
			$tabela = 'grc_avaliacao';
			$Campo  = 'codigo';
			$tam = 7;
			$codigow = numerador_arquivo($tabela, $Campo, $tam);
			$codigo  = 'DS'.$codigow;
			
			$codigo     = aspa($codigo);
			$descricao  = aspa($titulo_avaliacao);
			$observacao = aspa($observacao);
			
			$data_avaliacao = aspa($datadia);
			
			$idt_organizacao_avaliado = null($idt_organizacao_avaliado);
			$idt_avaliado = null($idt_avaliado);
			
			
	/*         
	$data_avaliacao           = $_GET['data_avaliacao'];
	$protocolo                = $_GET['protocolo'];
	$idt_avaliacao            = $_GET['idt_avaliacao'];
	$cpf                      = $_GET['cpf'];
	$idt_avaliado             = $_GET['idt_avaliado'];
	$cnpj                     = $_GET['cnpj'];
	$idt_organizacao_avaliado = $_GET['idt_organizacao_avaliado'];
	$observacao               = $_GET['observacao'];
	$codigo_formulario        = $_GET['codigo_formulario'];
	$idt_formulario           = $_GET['idt_formulario'];
	$usuario_responsavel      = $_GET['usuario_responsavel'];
	*/		
            $sql_i = ' insert into grc_avaliacao ';
            $sql_i .= ' (  ';
			$sql_i .= " codigo, ";
			$sql_i .= " descricao, ";
			$sql_i .= " idt_situacao, ";
			$sql_i .= " idt_guia, ";
			$sql_i .= " idt_formulario, ";
			$sql_i .= " idt_organizacao_avaliado, ";
            $sql_i .= " idt_avaliado, ";
            $sql_i .= " data_avaliacao, ";
            $sql_i .= " idt_responsavel_registro, ";
            $sql_i .= " data_registro ";
            $sql_i .= '  ) values ( ';
			$sql_i .= " $codigo, ";
			$sql_i .= " $descricao, ";
			$sql_i .= " $idt_situacao, ";
			$sql_i .= " $idt_guia, ";
			$sql_i .= " $idt_formulario, ";
			$sql_i .= " $idt_organizacao_avaliado, ";
            $sql_i .= " $idt_avaliado, ";
            $sql_i .= " $data_avaliacao, ";
            $sql_i .= " $idt_responsavel_registro, ";
            $sql_i .= " $data_registro ";
            $sql_i .= ') ';
			// p($sql_i);
            execsql($sql_i);
			$idt_avaliacao=lastInsertId();
            // Buscar Novamente
            $sql = "select  ";
            $sql .= "   grc_av.*  ";
            $sql .= " from grc_avaliacao grc_av ";
            $sql .= " where grc_av.idt   =   " . null($idt_avaliacao);
            $rs = execsql($sql);
            if ($rs->rows == 0) {
                // Tem erro
                $vetErro[] = "PIR Não conseguiu Gravar Avaliação = {$idt_avaliacao} ";
            }
            else
			{ 			
				$id      = $idt_avaliacao;
				$acao    = 'alt';

				$_GET['id']         = $id;
				$_GET['acao']       = $acao;

				$Require_Once = "incmede_guia.php";
				Require_Once($Require_Once);
				
			}
		} else {
			$vetErro[] = "PROBLEMA NA CHAMADA DO PROGRAMA. CONTACTAR ADMINISTRADOR DO SISTEMA";
		}
	}
	$qtdErro = count($vetErro);
	if ($qtdErro==0)
	{ // Deu certo
	
    }
	else
	{  // Deu erro
	    echo "<div id='errourl' >";
		echo "<div id='errourl_titulo' >";
		echo " ERRO DE UTILIZAÇÃO DA URL DO MEDE";
		echo "</div>";
		echo "<div id='errourl_corpo' >";
        // Mostrar erros de alguma forma na URL
		ForEach ($vetErro as $Numero => $Valor)
		{
           echo " $Numero - $Valor <br />";
        }
		echo "</div>";
		echo "<div id='errourl_rodape' >";
		echo " Por favor, informar parâmetros para Utilização dessa URL de acordo com Documentação.";
		echo "</div>";
		
		echo "</div>";


	}
echo '</div>';
?>
</body>
</html>
