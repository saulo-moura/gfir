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
	


$nome_cabecalho ='';
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
</style>
<?php Require_Once('head.php');
//  echo "<script type='text/javascript'>var reduz_cron='N';</script>";

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
    $titulo_modulo="HISTÓRICO DO AGENDAMENTO";
    echo "<div  id='titulo_modulo' style=''>";
    echo  $titulo_modulo;
    echo '</div>';
    echo '</div>';

echo '</div>';

echo '<div class="Meio" id="Meio">';
    // 
	$idt_atendimento_agenda=$_GET['idt_atendimento_agenda'];
	$TabelaPrinc = "grc_atendimento_agenda";
	$AliasPric   = "grc_aa";
    //
	$sql  = "select  ";
	$sql .= " $AliasPric.*  ";
	$sql .= " from {$TabelaPrinc}  {$AliasPric}";
	$sql  .= " left  join grc_atendimento as ga on ga.idt_atendimento_agenda = {$AliasPric}.idt ";
	$sql  .= " left  join grc_atendimento_especialidade as gae on gae.idt = {$AliasPric}.idt_especialidade ";
	$sql  .= " left  join ".db_pir_gec."gec_entidade as ge on ge.idt = {$AliasPric}.idt_cliente ";
	$sql  .= " left  join plu_usuario as pu on pu.id_usuario = {$AliasPric}.idt_consultor ";
	$sql  .= " left  join grc_atendimento_agenda_painel as pn on pn.idt_atendimento_agenda = {$AliasPric}.idt ";
	$sql  .= " left  join ".db_pir."sca_organizacao_secao as sca_oc on sca_oc.idt = {$AliasPric}.idt_ponto_atendimento ";
	$sql  .= " where {$AliasPric}.idt = ".null($idt_atendimento_agenda);
	$rs = execsql($sql);
	$qtd_sel = $rs->rows;
	if ($qtd_sel == 0 )
	{
	}    
	else
	{ 
		ForEach($rs->data as $row)
		{
			// detalhe dos campos na row
			$idt_ponto_atendimento = $row['idt_ponto_atendimento'];
			$idt_cliente        = $row['idt_cliente'];     
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
		}
	}
    
    $Require_Once="inchistorico_agendamento.php";
    if (file_exists($Require_Once)) {
    	Require_Once($Require_Once);
    } else {
        echo "PROBLEMA NA CHAMADA DO PROGRAMA. CONTACTAR ADMINISTRADOR DO SISTEMA";
    }
echo '</div>';
?>
</body>
</html>
