<style>

</style>
<?php
    // 
    // Require_Once('configuracao.php');
    //
	$veio_at         = $_GET['veio_at'];
	$veio            = $_GET['veio'];
	$agenda_data     = $_GET['agenda_data'];
	$idt_atendimento = $_GET['idt_atendimento'];
	
	if ($agenda_data=='')
	{
	    $agenda_data = Date('d/m/Y');
	}
	else
	{
	    $agenda_data = $_SESSION[CS]['agenda_data'];
	}
	//p($_SESSION[CS]);
	echo "<script>";
	echo "var idt_atendimento    = '{$idt_atendimento}'; ";
	echo "var veio    = '{$veio}'; ";
	echo "var veio_at = '{$veio_at}'; ";
	echo "var agenda_data = '{$agenda_data}'; ";
	echo "</script>";
	
	$html='';
		$html .= "<style> "; 
		
		$html .= " .sem_agenda {"; 
		$html .= " background:transparente; "; 
		$html .= " font-size:1.0em; "; 
		$html .= " color:#FF0000; "; 
		$html .= " border-bottom:1px solid #FFFFFF; ";

		$html .= "}"; 
		
		
		$html .= " .tabela {"; 
		$html .= " background:transparente; "; 
		$html .= " font-size:12px; "; 
		$html .= "}"; 
		
		
		
		
		$html .= " .cab {"; 
		$html .= " background:transparente; "; 
		$html .= " color:#666666; "; 
		$html .= " border-top:1px solid #c0c0c0; ";
		$html .= " border-bottom:1px solid #c0c0c0; ";
        $html .= " border-right:1px solid #c0c0c0; "; 		
		$html .= " text-align:center; "; 		
		$html .= "}"; 
		
		
		$html .= " .cab_exe {"; 
		$html .= " background:transparente; "; 
		$html .= " color:#666666; "; 
		$html .= " border-top:1px solid #c0c0c0; ";
		$html .= " border-bottom:1px solid #c0c0c0; ";
        
		$html .= " text-align:center; "; 		
		$html .= "}"; 
		
		$html .= " .imagens_exe {"; 
		$html .= " background:#FFFFFF; "; 
		$html .= " color:#666666; "; 
		$html .= " border-bottom:1px solid #F4F4F4; "; 
		//$html .= " border-right:1px solid #F4F4F4; "; 
		$html .= "}"; 
		
		$html .= " .hora {"; 
		$html .= " background:#FFC6C6; "; 
		$html .= " color:#FFFFFF; "; 
		$html .= " font-weight: bold; ";
		$html .= " border-bottom:1px solid #F4F4F4; "; 
		//$html .= " border-right:1px solid #F4F4F4; "; 
		$html .= " text-align:center; "; 		
		$html .= "}"; 
		
		$html .= " .situacao {"; 
		$html .= " background:transparent; "; 
		$html .= " color:#666666; "; 
		$html .= " border-bottom:1px solid #F4F4F4; "; 
		//$html .= " border-right:1px solid #F4F4F4; "; 
		$html .= "}"; 
		
		$html .= " .ponto_atendimento {"; 
		$html .= " background:transparent; "; 
		$html .= " color:#666666; "; 
		$html .= " border-bottom:1px solid #F4F4F4; "; 
		//$html .= " border-right:1px solid #F4F4F4; "; 
		$html .= "}";
        $html .= " .especialidade {"; 
		$html .= " background:transparent; "; 
		$html .= " color:#666666; "; 
		$html .= " border-bottom:1px solid #F4F4F4; "; 
		$html .= " border-right:1px solid #F4F4F4; "; 
		$html .= "}";		
		
		$html .= " .cliente {"; 
		$html .= " background:transparent; "; 
		$html .= " color:#666666; "; 
		$html .= " border-bottom:1px solid #F4F4F4; "; 
		//$html .= " border-right:1px solid #F4F4F4; "; 
		$html .= "}";		
		
		
		$html .= " .imagens_exe {"; 
		$html .= " background:transparent; "; 
		$html .= "}";		
		
		
		$html .= "</style>";

	
    Require_Once('classes/gsw_calendario_class.php');
	//
    set_time_limit(0);
    $vetCalendario=Array();
	$vetCalendario['modelo']  = 1;
	$vetCalendario['flagDono']       = false;
	$vetCalendario['donoCalendario'] = "GUY";
	$vetCalendario['agenda_data']    = $agenda_data; 
	
	$vetCalendario['linha']  = 1;
	$vetCalendario['coluna'] = 1;
	//$vetCalendario['corMarcaDiaAtual'] = "#8080FF";
	
	$vetCalendario['corMarcaDiaAtual'] = "#2F65BB";
	
	
	$vetCalendario['width']          = "30%"; 
	$vetCalendario['padding']        = "0.5em"; 
	$vetCalendario['paddingLeft']    = "2em"; 
	
	$cordestaque =  "#F1F1F1";
	
		$html .= "<style type='text/css'>";


		$html .= "body  {";
	    $html .= "	background: #F1F1F1; ";
        $html .= "}";
		


		$html .= "#calendario_instrucao  {";
		$html .= "	background: transparente; ";
		$html .= "	color : #666666; ";
		$html .= "	width:100%; ";
		//$html .= "	margin-left:33%; ";
		$html .= "	float:left; ";
	    $html .= "}";
		
		$html .= "#minha_agenda  {";
		$html .= "	background: transparente; ";
		$html .= "	color : #666666; ";
		$html .= "	width:100%; ";
		//$html .= "	margin-left:33%; ";
		$html .= "	text_align:center; ";
		$html .= "	float:left; ";
	    $html .= "}";


		$html .= "#calendario_destaque  {";
		$html .= "	background: none; ";
	    $html .= "	background-color: {$cordestaque}; ";
		$html .= "	color : white; ";
        
		$html .= "	border:1px solid #C0C0C0; ";
		$html .= "	border-radius: 1em; ";
		$html .= "	width:33%; ";
		//$html .= "	height: 9.5em; ";
		$html .= "	height: 11em; ";
		$html .= "	margin-left:33%; ";
		
		
		
	    $html .= "}";
		
		
		
		$html .= "#calendario .ui-widget td.ui-datepicker-current-day a.ui-state-active {  ";
		$html .= "	background: none; ";
		$html .= "	background: {$vetCalendario['corMarcaDiaAtual']}; ";
        $html .= "	font-weight: bold; ";
		$html .= "	color: white; ";
		
		$html .= "} ";
		
		
		$html .= "#calendario .ui-datepicker{ ";
		//$html .= "	background: #F1F1F1; ";
		$html .= "	background: #FFFFFF; ";
		$html .= "	margin-top:1.0em; ";
		$html .= "	margin-bottom:1.0em; ";
		$html .= "	width: auto; ";
		$html .= "	border: 1px solid #C0C0C0; ";
		$html .= "}";
		
		$html .= "#calendario .ui-datepicker table{ ";
		$html .= "	border-collpse: separate; ";
		$html .= "}";
		
		
		$html .= "#calendario .ui-state-default{ ";
		$html .= "	background: #F1F1F1; ";
		$html .= "	color: #000000; ";
		$html .= "	border: 1px solid #C0C0C0; ";
		$html .= "	padding:0.1em; ";
		$html .= "}";
		
	
		$html .= "#filtro {  ";
		$html .= "	background: #F1F1F1; ";
		$html .= "	color:#000000; ";
		// $html .= "	width:100%; ";
		$html .= "	display:block; ";
		$html .= "	float:left; ";
		$html .= "	margin-top:1.0em; ";
		$html .= "	width:68%; ";
		
		$html .= "} ";
		$html .= "#horario {";
        $html .= "text-align: center;";
        $html .= "padding: 0px;";
        $html .= "font-size: 20px;";
        $html .= "color: #FFFFFF;";
        $html .= "background:#f1f1f1;";
		$html .= "width:100%; ";
		$html .= "display:block;";
		$html .= "}";
		$html .= "#horario_cab {";
        $html .= "text-align: center;";
        $html .= "padding: 0.3em;";
		$html .= "height: 0.8em;";
        $html .= "font-size: 2.0em;";
        $html .= "color: #FFFFFF;";
		$html .= "font-weight: bold;";
        $html .= "background: #F1F1F1;";
		$html .= "}";
		$html .= ".feriado {";
		$html .= "background: #FFBF40;";
		$html .= "}";
		$html .= ".domingo {";
		$html .= "background: #00FF00;";
		$html .= "}";
		$html .= ".sabado {";
		$html .= "background: #0000FF;";
		$html .= "}";


		$html .= ".disponivel  {";
		//$html .= "	background: #CAFFCA; ";
		$html .= "	background: #00FF00; ";
		$html .= "	color: #000000; ";
		$html .= "}";
		$html .= ".naodisponivel {";
		//$html .= "	background: #FFC4E1; ";
		$html .= "	background: #FF0000; ";
		$html .= "	color: #000000; ";
		$html .= "}";

		$html .= ".naodisponivelsem {";
		$html .= "	color: #000000; ";
		$html .= "}";


		$html .= "#dialog-processando {";
		$html .= "display: none;";
		$html .= "}";
		
	//	$html .= "li {";
	//	$html .= "line-height:1.0em;";
	//	$html .= "}";
		$html .= "</style>";
	
			echo $html;

	
	$GSWCALENDARIO = new TGSW_CALENDARIO($vetCalendario);
	
	
	$vetHtml=Array();
	////////////////// parâmetros
	//		Exemplo de texto
	/*
	$vetPar=Array();
	$nome_c                     = 'campo_nome';
	$vetPar['tipo']             = 'Texto';
	$vetPar['nome']             = $nome_c;
	$vetPar['titulo']           = 'campo_titulo';
	$vetPar['posicao_titulo']   = 'DL';
	$vetPar['obrigatorio']      = true;
	$vetPar['marcaobrigatorio'] = '*';
	$vetPar['tamanho']          = 45;
	$vetPar['tamanho-maximo']   = 90;
	$vetPar['js']               = " guy=bete ";
	$vetPar['hint']             = " teste de hint ";
	
	$vetEstilo                  = Array();
	// DIV do campo 	
	$estilo_nome = "{$nome_c}_D";
	$vetParaEstilo = Array();
	$vetParaEstilo['background'] = '#F1F1F1;';
	$vetParaEstilo['color']      = '#FFFFFF;';
	//$vetParaEstilo['text-align'] = 'center';
	//$vetParaEstilo['display']    = 'auto;';
	//$vetParaEstilo['width']      = '100%;';
	$vetEstilo[$estilo_nome]=$vetParaEstilo;
	
	
	// DIV do Label 	
	$estilo_nome = "{$nome_c}_DL";
	$vetParaEstilo = Array();
	$vetParaEstilo['xborder'] = "1px solid #000000;";
	//$vetParaEstilo['margin-left']='10em;';
	$vetParaEstilo['width']="33%;";
	$vetParaEstilo['text-align']="right;";
	$vetParaEstilo['float']="left;";
	$vetEstilo[$estilo_nome]=$vetParaEstilo;
	
	// Label 	
	$estilo_nome = "{$nome_c}_L";
	$vetParaEstilo = Array();
	$vetParaEstilo['xmargin-left']="10em;";
	
	$vetParaEstilo['color']="#000000;";
	
	$vetEstilo[$estilo_nome]=$vetParaEstilo;
	
	
	// DIV do Input 	
	$estilo_nome = "{$nome_c}_DI";
	$vetParaEstilo = Array();
	$vetParaEstilo['xborder'] = "1px solid #000000;";
	//$vetParaEstilo['margin-left']="10em;";
	$vetParaEstilo['width']="65%;";
	$vetParaEstilo['float']="left;";
	$vetEstilo[$estilo_nome]=$vetParaEstilo;
	
	// Input 	
	$estilo_nome = "{$nome_c}_I";
	$vetParaEstilo = Array();
	$vetParaEstilo['xmargin-left']='10em;';
	$vetEstilo[$estilo_nome]=$vetParaEstilo;
	//		
	$vetPar['estilo']           = $vetEstilo;
	////////////////// parâmetros
	
	$vetHtml[1]=$vetPar;
	
	*/
/*	
	$sql .= ' select idt, descricao';
$sql .= ' from '.db_pir.'sca_organizacao_secao';
$sql .= " where posto_atendimento <> 'S' ";
$sql .= ' order by classificacao';
$Filtro = Array();
$Filtro['rs'] = execsql($sql);
$Filtro['id'] = 'idt';
$Filtro['nome'] = 'Unidade';
$Filtro['LinhaUm'] = ' ';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['idt_unidade'] = $Filtro;

$sql = "select idt,  descricao from ".db_pir."sca_organizacao_secao ";
//$sql .= " where (posto_atendimento = 'UR' or posto_atendimento = 'S')";
$sql .= ' where SUBSTRING(classificacao, 1, 5) = ('; //and
$sql .= ' select SUBSTRING(classificacao, 1, 5) as cod';
$sql .= ' from '.db_pir.'sca_organizacao_secao';
$sql .= ' where idt = '.null($vetFiltro['idt_unidade']['valor']);
$sql .= ' )';
$sql .= ' and idt <> '.null($vetFiltro['idt_unidade']['valor']);
$sql .= ' order by classificacao ';
$Filtro = Array();
$Filtro['rs'] = execsql($sql);
$Filtro['id'] = 'idt';
$Filtro['nome'] = 'Ponto de Atendimento';
$Filtro['LinhaUm'] = ' ';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['idt_ponto_atendimento_tela'] = $Filtro;
*/
//////// 1
    $veio_at         = $_GET['veio_at'];
	$idt_atendimento = $_GET['idt_atendimento'];
	$_SESSION[CS]['veio_at']    = $veio_at;	
	$_SESSION[CS]['idt_atendimento']    = $idt_atendimento;	
	
    if ($veio_at=='AT')
	{
        // echo " Atendimento: {$idt_atendimento}";	
		$sql  = "select  ";
		$sql .= " grc_a.protocolo, grc_ap.cpf, grc_ap.nome, grc_ao.cnpj, grc_ao.razao_social   ";
		$sql .= " from grc_atendimento grc_a ";
		$sql .= " inner join grc_atendimento_pessoa grc_ap      on grc_ap.idt_atendimento = grc_a.idt ";
		$sql .= " left  join grc_atendimento_organizacao grc_ao on grc_ao.idt_atendimento = grc_a.idt";
		$sql .= ' where grc_a.idt = '.null($idt_atendimento);
		$rs   = execsqlNomeCol($sql);
		ForEach ($rs->data as $row) {
			$protocolo    = $row['protocolo'];
			$cpf          = $row['cpf'];
			$nome         = $row['nome'];
			$cnpj         = $row['cnpj'];
			$razao_social = $row['razao_social'];
		}
		echo "<div style='width:100%; background:#FFFFFF; padding:4px; height:20px;' >";
		
		echo "<div style='float:left; width:50%;' >";
		echo "CLIENTE: {$cpf} - {$nome}";
		echo "</div>";
		

		echo "<div style='float:left; width:50%;' >";
		echo "EMPRESA: {$cnpj} {$razao_social}";
		echo "</div>";
		
		echo "</div>";
	}


    // se é de um consultor
	
	if ($veio=='S')
	{
        // echo " Atendimento: {$idt_atendimento}";	
		$sql  = "select  ";
		$sql .= " grc_a.protocolo, grc_ap.cpf, grc_ap.nome, grc_ao.cnpj, grc_ao.razao_social   ";
		$sql .= " from grc_atendimento grc_a ";
		$sql .= " inner join grc_atendimento_pessoa grc_ap      on grc_ap.idt_atendimento = grc_a.idt ";
		$sql .= " left  join grc_atendimento_organizacao grc_ao on grc_ao.idt_atendimento = grc_a.idt";
		$sql .= ' where grc_a.idt = '.null($idt_atendimento);
		$rs   = execsqlNomeCol($sql);
		ForEach ($rs->data as $row) {
			$protocolo    = $row['protocolo'];
			$cpf          = $row['cpf'];
			$nome         = $row['nome'];
			$cnpj         = $row['cnpj'];
			$razao_social = $row['razao_social'];
		}
		echo "<div style='width:100%; background:#FFFFFF; padding:4px; height:20px;' >";
		
		echo "<div style='float:left; width:50%;' >";
		echo "CLIENTE: {$cpf} - {$nome}";
		echo "</div>";
		

		echo "<div style='float:left; width:50%;' >";
		echo "EMPRESA: {$cnpj} {$razao_social}";
		echo "</div>";
		
		echo "</div>";
	}


    $idt_servico           = $_GET['idt_servico'];
	$idt_unidade_regional  = $_GET['idt_unidade_regional'];
	$idt_ponto_atendimento = $_GET['idt_ponto_atendimento'];
	$idt_consultor         = $_GET['idt_consultor'];
	
    // Ponto atendimento
	
	
	$idt_atendente = "";
	$idt_pa        = "";
	if ($veio==3) // Veio de Criar Agenda
	{
	    // echo "--------- ".$veio;
	    //p($_GET);
	   
	    //p($_SESSION[CS]);
	    $idt_atendente = $_SESSION[CS]['g_id_usuario'];
	    $idt_pa        = $_SESSION[CS]['gat_idt_unidade_regional'];
		
		$idt_ponto_atendimento = $idt_pa;
		$idt_consultor         = $idt_atendente;
		
		//$_SESSION[CS]['agenda_idt_ponto_atendimento'] = $idt_ponto_atendimento;
	    //$_SESSION[CS]['agenda_idt_consultor']         = $idt_consultor;

		
		echo "<div style='border-bottom: 1px solid #000000; width:100%; background:#2F65BB; color:#FFFFFF; font-weight: bold; padding:4px; height:20px;' >";
		
		echo "<div style='float:left; width:50%;' >";
		
		$desc_pa        = $_SESSION[CS]['gatdesc_idt_unidade_regional'];
		$desc_atendente = $_SESSION[CS]['g_nome_completo'];
		
		
		
		
		echo "ATENDENTE/CONSULTOR: {$desc_atendente}";
		echo "</div>";
		

		echo "<div style='float:left; width:50%;' >";
		echo "PA: {$desc_pa}";
		echo "</div>";
		
		echo "</div>";
		//p($_SESSION[CS]);
	}


    $_SESSION[CS]['agenda_idt_unidade_regional']  = $idt_unidade_regional;
	$_SESSION[CS]['agenda_idt_ponto_atendimento'] = $idt_ponto_atendimento;
	$_SESSION[CS]['agenda_idt_consultor']         = $idt_consultor;
	$_SESSION[CS]['agenda_idt_servico']           = $idt_servico;
    $vetPar=Array();
	
	
	if ($veio!=3) // Veio de Criar Agenda
	{
	
	

		$nome_c                     = 'idt_unidade_regional';
		$vetPar['tipo']             = 'SelecaoTabela';
		$vetPar['value']            = $idt_unidade_regional;
		$vetPar['nome']             = $nome_c;
		$vetPar['titulo']           = 'Unidade Regional';
		$vetPar['posicao_titulo']   = 'DL';
		$vetPar['obrigatorio']      = false;
		$vetPar['marcaobrigatorio'] = '*';
		$vetPar['tamanho']          = 45;
		$vetPar['tamanho-maximo']   = 90;
		$vetPar['js']               = "";
		$vetPar['hint']             = "Possibilita filtrar pelo Consultores";
		$vetPar['vazio']            = 'S';
		
		
		$sql  ='';
		$sql .= ' select idt, descricao';
		$sql .= ' from '.db_pir.'sca_organizacao_secao';
		$sql .= " where posto_atendimento <> 'S' and (tipo_estrutura = 'UR' or tem_agendamento = 'S') ";
		
		$sql .= ' order by classificacao';
		$vetPar['sql']              = $sql;
		
		
		$vetEstilo                  = Array();
		// DIV do campo 	
		$estilo_nome   = "{$nome_c}_D";
		$vetParaEstilo = Array();
		$vetParaEstilo['background'] = '#F1F1F1;';
		$vetParaEstilo['color']      = '#FFFFFF;';
		
		//$vetParaEstilo['text-align'] = 'center';
		//$vetParaEstilo['display']    = 'auto;';
		//$vetParaEstilo['width']      = '100%;';
		$vetEstilo[$estilo_nome]=$vetParaEstilo;
		// DIV do Label 	
		$estilo_nome = "{$nome_c}_DL";
		$vetParaEstilo = Array();
		$vetParaEstilo['xborder'] = "1px solid #000000;";
		//$vetParaEstilo['margin-left']='10em;';
		$vetParaEstilo['width']="33%;";
		$vetParaEstilo['width']="27%;";
		
		
		
		$vetParaEstilo['text-align']="right;";
		$vetParaEstilo['float']="left;";
		$vetEstilo[$estilo_nome]=$vetParaEstilo;
		// Label 	
		$estilo_nome = "{$nome_c}_L";
		$vetParaEstilo = Array();
		$vetParaEstilo['xmargin-left']="10em;";
		$vetParaEstilo['color']="#000000;";
		$vetEstilo[$estilo_nome]=$vetParaEstilo;
		// DIV do Input 	
		$estilo_nome = "{$nome_c}_DI";
		$vetParaEstilo = Array();
		$vetParaEstilo['xborder'] = "1px solid #000000;";
		//$vetParaEstilo['margin-left']="10em;";
		$vetParaEstilo['width']="65%;";
		$vetParaEstilo['float']="left;";
		$vetParaEstilo['padding-top'] = '0.2em;';
		
		$vetEstilo[$estilo_nome]=$vetParaEstilo;
		// Input 	
		$estilo_nome = "{$nome_c}_I";
		$vetParaEstilo = Array();
		$vetParaEstilo['xmargin-left']='10em;';
		$vetParaEstilo['width']='29em;';
		$vetEstilo[$estilo_nome]=$vetParaEstilo;
		//		
		$vetPar['estilo']           = $vetEstilo;
		////////////////// parâmetros
		$vetHtml[]=$vetPar;
		
	//////// 2
		// Ponto atendimento
		$vetPar=Array();
		$nome_c                     = 'idt_ponto_atendimento';
		$vetPar['tipo']             = 'SelecaoTabela';
		$vetPar['value']            = $idt_ponto_atendimento;
		$vetPar['nome']             = $nome_c;
		$vetPar['titulo']           = 'Ponto de Atendimento';
		$vetPar['posicao_titulo']   = 'DL';
		$vetPar['obrigatorio']      = true;
		$vetPar['marcaobrigatorio'] = '*';
		$vetPar['tamanho']          = 45;
		$vetPar['tamanho-maximo']   = 90;
		$vetPar['js']               = "' ";
		$vetPar['hint']             = "Possibilita filtrar Pontos de Atendimento";
		$vetPar['vazio']            = 'S';
		$sql  ='';
		/*
		$sql = "select idt,  descricao from ".db_pir."sca_organizacao_secao ";
		$sql .= " where (posto_atendimento = 'UR' or posto_atendimento = 'S')";
		if ($idt_unidade_regional!="")
		{
		    $sql .= ' and  (idt = '.null($idt_unidade_regional);
		}
        */		
		if ($idt_unidade_regional!="")
		{
			$sql  = "select idt,  descricao from ".db_pir."sca_organizacao_secao ";
			$sql .= ' where SUBSTRING(classificacao, 1, 5) = ('; //and
			$sql .= ' select SUBSTRING(classificacao, 1, 5) as cod';
			$sql .= ' from '.db_pir.'sca_organizacao_secao';
			$sql .= ' where idt = '.null($idt_unidade_regional);
			$sql .= ' )';
			$sql .= ' and idt <> '.null($idt_unidade_regional);
		}
		else
		{
			$sql = "select idt,  descricao from ".db_pir."sca_organizacao_secao ";
			$sql .= " where (posto_atendimento = 'UR' or posto_atendimento = 'S')";
			if ($idt_unidade_regional!="")
			{
				$sql .= ' and  (idt = '.null($idt_unidade_regional);
			}
		}
		
		
		
		//$sql .= ' order by classificacao ';
		
		//$_SESSION[CS]['agenda_idt_unidade_regional']  = $idt_unidade_regional;
	//$_SESSION[CS]['agenda_idt_ponto_atendimento'] = $idt_ponto_atendimento;
	//$_SESSION[CS]['agenda_idt_consultor']         = $idt_consultor;
	//$_SESSION[CS]['agenda_idt_servico']           = $idt_servico;
		
		//$sql .= ' where SUBSTRING(classificacao, 1, 5) = ('; //and
		//$sql .= ' select SUBSTRING(classificacao, 1, 5) as cod';
		//$sql .= ' from '.db_pir.'sca_organizacao_secao';
		// $sql .= ' where idt = '.null($vetFiltro['idt_unidade']['valor']);
		// $sql .= ' )';
		//$sql .= ' and idt <> '.null($vetFiltro['idt_unidade']['valor']);
		
		
		/*
		$sql  = "select idt,  descricao from ".db_pir."sca_organizacao_secao ";
		$sql .= ' where SUBSTRING(classificacao, 1, 5) = ('; //and
		$sql .= ' select SUBSTRING(classificacao, 1, 5) as cod';
		$sql .= ' from '.db_pir.'sca_organizacao_secao';
		$sql .= ' where idt = '.null($vetFiltro['idt_unidade']['valor']);
		$sql .= ' )';
		$sql .= ' and idt <> '.null($vetFiltro['idt_unidade']['valor']);
		$sql .= ' order by classificacao ';
        */
		
		
		
		
		
		
		
		if ($veio==3) // Veio de Criar Agenda
		{
			$sql .= " and idt = ".null($idt_pa);
		}
		
		$sql .= ' order by classificacao ';
		$vetPar['sql']             = $sql;
		$vetEstilo                  = Array();
		// DIV do campo 	
		$estilo_nome = "{$nome_c}_D";
		$vetParaEstilo = Array();
		$vetParaEstilo['background'] = '#F1F1F1;';
		$vetParaEstilo['color']      = '#FFFFFF;';
		
		//$vetParaEstilo['text-align'] = 'center';
		//$vetParaEstilo['display']    = 'auto;';
		//$vetParaEstilo['width']      = '100%;';
		$vetEstilo[$estilo_nome]=$vetParaEstilo;
		// DIV do Label 	
		$estilo_nome = "{$nome_c}_DL";
		$vetParaEstilo = Array();
		$vetParaEstilo['xborder'] = "1px solid #000000;";
		//$vetParaEstilo['margin-left']='10em;';
		$vetParaEstilo['width']="33%;";
		$vetParaEstilo['width']="27%;";
		
		$vetParaEstilo['text-align']="right;";
		$vetParaEstilo['float']="left;";
		$vetEstilo[$estilo_nome]=$vetParaEstilo;
		// Label 	
		$estilo_nome = "{$nome_c}_L";
		$vetParaEstilo = Array();
		$vetParaEstilo['xmargin-left']="10em;";
		$vetParaEstilo['color']="#000000;";
		$vetEstilo[$estilo_nome]=$vetParaEstilo;
		// DIV do Input 	
		$estilo_nome = "{$nome_c}_DI";
		$vetParaEstilo = Array();
		$vetParaEstilo['xborder'] = "1px solid #000000;";
		//$vetParaEstilo['margin-left']="10em;";
		$vetParaEstilo['width']="65%;";
		$vetParaEstilo['float']="left;";
		$vetParaEstilo['padding-top'] = '0.2em;';
		$vetEstilo[$estilo_nome]=$vetParaEstilo;
		// Input 	
		$estilo_nome = "{$nome_c}_I";
		$vetParaEstilo = Array();
		$vetParaEstilo['xmargin-left']='10em;';
		$vetParaEstilo['width']='29em;';
		$vetEstilo[$estilo_nome]=$vetParaEstilo;
		//		
		$vetPar['estilo']           = $vetEstilo;
		////////////////// parâmetros
		$vetHtml[]=$vetPar;
		
		
	//////// 3
		// Consultores
		$vetPar=Array();
		$nome_c                     = 'idt_consultor';
		$vetPar['tipo']             = 'SelecaoTabela';
		$vetPar['nome']             = $nome_c;
		$vetPar['value']            = $idt_consultor;
		$vetPar['titulo']           = 'Consultores';
		$vetPar['posicao_titulo']   = 'DL';
		$vetPar['obrigatorio']      = false;
		$vetPar['marcaobrigatorio'] = '*';
		$vetPar['tamanho']          = 45;
		$vetPar['tamanho-maximo']   = 90;
		$vetPar['js']               = "";
		$vetPar['hint']             = "Possibilita filtrar pelo Consultores";
		$vetPar['vazio']            = 'S';
		$sql  ='';
		$sql .= "select plu_usu.id_usuario, plu_usu.nome_completo, sca_o.descricao from plu_usuario plu_usu";
		$sql .= " inner join grc_atendimento_pa_pessoa grc_pap on grc_pap.idt_usuario = plu_usu.id_usuario ";
		$sql .= " inner join ".db_pir."sca_organizacao_secao sca_o on sca_o.idt = grc_pap.idt_ponto_atendimento ";
		//  $sql .= " where grc_pap.idt_ponto_atendimento = ".null($vetFiltro['ponto_atendimento']['valor']);
		if ($veio==3) // Veio de Criar Agenda
		{
			$sql .= " and id_usuario = ".null($idt_atendente);
			$sql .= " and grc_pap.idt_ponto_atendimento = ".null($idt_pa);
		}
		$sql .= " order by plu_usu.nome_completo, sca_o.descricao";
		
		
		
		
		$sql  ='';
		$sql .= "select plu_usu.id_usuario, plu_usu.nome_completo, sca_o.descricao from plu_usuario plu_usu";
		$sql .= " inner join grc_atendimento_pa_pessoa grc_pap on grc_pap.idt_usuario = plu_usu.id_usuario ";
		$sql .= " inner join ".db_pir."sca_organizacao_secao sca_o on sca_o.idt = grc_pap.idt_ponto_atendimento ";
		$sql .= " where grc_pap.idt_ponto_atendimento = ".null($idt_ponto_atendimento);
		//$sql .= "   and grc_pap.duracao is not null ";
		if ($veio==3) // Veio de Criar Agenda
		{
			$sql .= " and id_usuario = ".null($idt_atendente);
			$sql .= " and grc_pap.idt_ponto_atendimento = ".null($idt_pa);
		}
		else
		{
		   // 
 		    $rs = execsql($sql);
			if ($rs->rows > 0)
			{
				
				$liga = "";
				$compl = "";
				foreach ($rs->data as $row) {
					$idt_consultor = $row['id_usuario'];
					$data=trata_data($_SESSION[CS]['agenda_data']);
					//p($data);
					$temagenda = VerificaConsultorData($idt_consultor,$idt_ponto_atendimento,$data);
					if ($temagenda==1)
					{
						$compl .= $liga." plu_usu.id_usuario = ".null($idt_consultor);
						$liga = " or ";
					}
				}
				if ($liga == " or ")
				{
					$sql .= " and ( ".$compl;
					$sql .= " ) ";
				}
				else
				{
				    $sql .= " and ( 2 = 1 ";
					$sql .= " ) ";
				
				}
			}
		}
		$sql .= " order by plu_usu.nome_completo, sca_o.descricao";

		
		
		
		
		
		
		$vetPar['sql']             = $sql;
		$vetEstilo                 = Array();
		// DIV do campo 	
		$estilo_nome = "{$nome_c}_D";
		$vetParaEstilo = Array();
		$vetParaEstilo['background'] = '#F1F1F1;';
		$vetParaEstilo['color']      = '#FFFFFF;';
		//$vetParaEstilo['text-align'] = 'center';
		//$vetParaEstilo['display']    = 'auto;';
		//$vetParaEstilo['width']      = '100%;';
		$vetEstilo[$estilo_nome]=$vetParaEstilo;
		// DIV do Label 	
		$estilo_nome = "{$nome_c}_DL";
		$vetParaEstilo = Array();
		$vetParaEstilo['xborder'] = "1px solid #000000;";
		//$vetParaEstilo['margin-left']='10em;';
		$vetParaEstilo['width']="33%;";
		$vetParaEstilo['width']="27%;";
		
		$vetParaEstilo['text-align']="right;";
		$vetParaEstilo['float']="left;";
		$vetEstilo[$estilo_nome]=$vetParaEstilo;
		// Label 	
		$estilo_nome = "{$nome_c}_L";
		$vetParaEstilo = Array();
		$vetParaEstilo['xmargin-left']="10em;";
		$vetParaEstilo['color']="#000000;";
		$vetEstilo[$estilo_nome]=$vetParaEstilo;
		// DIV do Input 	
		$estilo_nome = "{$nome_c}_DI";
		$vetParaEstilo = Array();
		$vetParaEstilo['xborder'] = "1px solid #000000;";
		//$vetParaEstilo['margin-left']="10em;";
		$vetParaEstilo['width']="65%;";
		$vetParaEstilo['float']="left;";
		$vetParaEstilo['padding-top'] = '0.2em;';
		$vetEstilo[$estilo_nome]=$vetParaEstilo;
		// Input 	
		$estilo_nome = "{$nome_c}_I";
		$vetParaEstilo = Array();
		$vetParaEstilo['xmargin-left']='10em;';
		$vetParaEstilo['width']='29em;';
		$vetEstilo[$estilo_nome]=$vetParaEstilo;
		//		
		$vetPar['estilo']           = $vetEstilo;
		////////////////// parâmetros
		$vetHtml[]=$vetPar;
	}	
//////// 4	
	// Serviços
	$vetPar=Array();
	$nome_c                     = 'idt_servico';
	$vetPar['tipo']             = 'SelecaoTabela';
	$vetPar['nome']             = $nome_c;
	$vetPar['value']            = $idt_servico;
	
	$vetPar['titulo']           = 'Serviços';
	$vetPar['posicao_titulo']   = 'DL';
	$vetPar['obrigatorio']      = false;
	$vetPar['marcaobrigatorio'] = '*';
	$vetPar['tamanho']          = 45;
	$vetPar['tamanho-maximo']   = 90;
	$vetPar['js']               = "";
	$vetPar['hint']             = "Possibilita filtrar por Serviços";
	$vetPar['vazio']            = 'S';
	$sql  ="";
	
	if ($veio==3) // Veio de Criar Agenda
	{
	
	    $sql  = "select grc_ae.idt, grc_ae.tipo_atendimento, grc_ae.descricao ";
	    $sql .= " from grc_atendimento_pa_pessoa_servico grc_paps ";
		$sql .= " inner join grc_atendimento_pa_pessoa grc_pap on grc_pap.idt = grc_paps.idt_pa_pessoa ";
		$sql .= " inner join grc_atendimento_especialidade grc_ae on grc_ae.idt = grc_paps.idt_servico ";
		//$sql .= " where grc_pap.idt_usuario = ".null($idt_atendente);
		$sql .= " where grc_pap.idt_usuario = ".null($idt_consultor);
        $sql .= " order by grc_ae.tipo_atendimento, grc_ae.codigo";
	}
	else
	{
	    if ($idt_consultor=="")
        {		
			$sql  = "select grc_ae.idt, grc_ae.tipo_atendimento, grc_ae.descricao from grc_atendimento_especialidade grc_ae ";
			$sql .= " order by grc_ae.tipo_atendimento, grc_ae.codigo";
		}
		else
		{
			$sql  = "select grc_ae.idt, grc_ae.tipo_atendimento, grc_ae.descricao ";
			$sql .= " from grc_atendimento_pa_pessoa_servico grc_paps ";
			$sql .= " inner join grc_atendimento_pa_pessoa grc_pap on grc_pap.idt = grc_paps.idt_pa_pessoa ";
			$sql .= " inner join grc_atendimento_especialidade grc_ae on grc_ae.idt = grc_paps.idt_servico ";
			$sql .= " where grc_pap.idt_usuario = ".null($idt_consultor);
			$sql .= " order by grc_ae.tipo_atendimento, grc_ae.codigo";		
		}
	}
	
	
	$vetPar['sql']              = $sql;
	
	$vetEstilo                  = Array();
	// DIV do campo 	
	$estilo_nome = "{$nome_c}_D";
	$vetParaEstilo = Array();
	$vetParaEstilo['background'] = '#F1F1F1;';
	$vetParaEstilo['color']      = '#FFFFFF;';
	//$vetParaEstilo['text-align'] = 'center';
	//$vetParaEstilo['display']    = 'auto;';
	//$vetParaEstilo['width']      = '100%;';
	$vetEstilo[$estilo_nome]=$vetParaEstilo;
	// DIV do Label 	
	$estilo_nome = "{$nome_c}_DL";
	$vetParaEstilo = Array();
	$vetParaEstilo['xborder'] = "1px solid #000000;";
	//$vetParaEstilo['margin-left']='10em;';
	$vetParaEstilo['width']="33%;";
	$vetParaEstilo['width']="27%;";
	
	$vetParaEstilo['text-align']="right;";
	$vetParaEstilo['float']="left;";
	$vetEstilo[$estilo_nome]=$vetParaEstilo;
	// Label 	
	$estilo_nome = "{$nome_c}_L";
	$vetParaEstilo = Array();
	$vetParaEstilo['xmargin-left']="10em;";
	$vetParaEstilo['color']="#000000;";
	$vetEstilo[$estilo_nome]=$vetParaEstilo;
	// DIV do Input 	
	$estilo_nome = "{$nome_c}_DI";
	$vetParaEstilo = Array();
	$vetParaEstilo['xborder'] = "1px solid #000000;";
	//$vetParaEstilo['margin-left']="10em;";
	$vetParaEstilo['width']="65%;";
	$vetParaEstilo['float']="left;";
	$vetParaEstilo['padding-top'] = '0.2em;';
	$vetEstilo[$estilo_nome]=$vetParaEstilo;
	// Input 	
	$estilo_nome = "{$nome_c}_I";
	$vetParaEstilo = Array();
	$vetParaEstilo['xmargin-left']='10em;';
	$vetParaEstilo['width']='29em;';
	$vetEstilo[$estilo_nome]=$vetParaEstilo;
	//		
	$vetPar['estilo']           = $vetEstilo;
	////////////////// parâmetros
	$vetHtml[]=$vetPar;	
	
	//////////////////// botões de Ação
	
	$vetPar=Array();
	$nome_c                     = 'campo_botao_envia';
	$vetPar['tipo']             = 'BotaoSelecao';
	$vetPar['nome']             = $nome_c;
	$vetPar['titulo']           = 'PESQUISAR';
	$vetPar['posicao_titulo']   = 'OL';
	$vetPar['obrigatorio']      = true;
	$vetPar['marcaobrigatorio'] = '*';
	$vetPar['tamanho']          = 15;
	$vetPar['tamanho-maximo']   = 90;
	$vetPar['js']               = " ";
	$vetPar['hint']             = " Botão de Enviar para Pesquisar";
	
	$vetEstilo                  = Array();
	// DIV do campo 	
	$estilo_nome = "{$nome_c}_D";
	$vetParaEstilo = Array();
	$vetParaEstilo['background'] = '#F1F1F1;';
	$vetParaEstilo['color']      = '#FFFFFF;';
	$vetParaEstilo['text-align'] = 'center';
	//$vetParaEstilo['display']    = 'block;';
	//$vetParaEstilo['width']      = '100%;';
	$vetEstilo[$estilo_nome]=$vetParaEstilo;
	
	
	// DIV do Label 	
	$estilo_nome = "{$nome_c}_DL";
	$vetParaEstilo = Array();
	$vetParaEstilo['xborder'] = "1px solid #000000;";
	//$vetParaEstilo['margin-left']='10em;';
	$vetParaEstilo['width']="33%;";
	$vetParaEstilo['text-align']="right;";
	//$vetParaEstilo['float']="left;";
	$vetEstilo[$estilo_nome]=$vetParaEstilo;
	
	// Label 	
	$estilo_nome = "{$nome_c}_L";
	$vetParaEstilo = Array();
	$vetParaEstilo['xmargin-left']="10em;";
	
	$vetParaEstilo['color']="#000000;";
	
	$vetEstilo[$estilo_nome]=$vetParaEstilo;
	
	
	// DIV do Input - Botão 	
	$estilo_nome = "{$nome_c}_DI";
	$vetParaEstilo = Array();
	$vetParaEstilo['xborder']  = "1px solid #FFFFFF;";
	$vetParaEstilo['cursor']  = "pointer;";
	$vetParaEstilo['padding'] = '0.4em;';
	
	//$vetParaEstilo['width']="65%;";
	//$vetParaEstilo['float']e="left;";
	$vetEstilo[$estilo_nome]=$vetParaEstilo;
	
	// Input 	
	$estilo_nome = "{$nome_c}_I";
	$vetParaEstilo = Array();
	//$vetParaEstilo['background'] = '#0000FF;';
	$vetParaEstilo['background'] = '#2F65BB;';
	
	$vetParaEstilo['color']      = '#FFFFFF;';
	$vetParaEstilo['width']      = '10em;';
	$vetParaEstilo['height']     = '2.5em;';
	$vetParaEstilo['font-weight']= 'bold;';
	$vetParaEstilo['border-radius']= '0.5em;';
	$vetParaEstilo['cursor']  = "pointer;";
	
	$vetEstilo[$estilo_nome]=$vetParaEstilo;
	//		
	$vetPar['estilo']           = $vetEstilo;
	////////////////// parâmetros
	
	$vetHtml[]=$vetPar;
	
	$veio_at=$_GET['$veio_at'];
	$idt_atendimento=$_GET['$idt_atendimento'];
	
	// passa para gerar tela
	
	$html          = $GSWCALENDARIO->MostraCalendario($vetHtml);
	


   
	
	
	
	$GSWCALENDARIO = null;
	//
	echo $html;
    set_time_limit(30);
	
	
	
?>
<script>

    var veio_at = '<?php echo $veio_at; ?>';

    $(document).ready(function () {
        $("#idt_unidade_regional_I, #idt_ponto_atendimento_I, #idt_consultor_I").change(function () { // campos que serão chamados quando alterar
		
		    idt_unidade_regional_I  = $("#idt_unidade_regional_I").val(); // Valor do campo destino
            idt_ponto_atendimento_I = $("#idt_ponto_atendimento_I").val(); // Valor do campo destino
			idt_consultor_I         = $("#idt_consultor_I").val(); // Valor do campo destino
			idt_servico_I           = $("#idt_servico_I").val(); // Valor do campo destino
			$.ajax({
			    dataType: 'json',
				type: 'POST',
				url: ajax_sistema + '?tipo=FiltroAgenda',
				data: {
					cas: conteudo_abrir_sistema,
					idt_unidade_regional_I: idt_unidade_regional_I,
					idt_ponto_atendimento_I: idt_ponto_atendimento_I,
					idt_consultor_I: idt_consultor_I,
					idt_servico_I: idt_servico_I
				},
				success: function (response) {
					if (response.erro == '') {
						//alert(url_decode(response.datasgeradas));
						if (response.idt_ponto_atendimento_DC!="") 
						{
						    $('#idt_ponto_atendimento_I').html(url_decode(response.idt_ponto_atendimento_DC));
						}	
						if (response.idt_consultor_DC!="") 
						{
		                    $('#idt_consultor_I').html(url_decode(response.idt_consultor_DC));
						}	
						if (response.idt_servico_DC!="") 
						{
		                    $('#idt_servico_I').html(url_decode(response.idt_servico_DC));
						}	
				
					} else {
						alert(url_decode(response.erro));
					}
				
				
		//			alert('voltei');
				},
				error: function (jqXHR, textStatus, errorThrown) {
					alert('Erro no ajax no: ' + textStatus + ' - ' + errorThrown);
				},
				async: false
			});
			
			/*
			if (idt_servico_D!='')
			{
			
			
			}
			
			
			
			valor = $("#idt_ponto_atendimento_D").val(); // Valor do campo destino

            if (valor != null) {
                $("#idt_aoe").empty(); // Limpa o conteúdo interno
				//
                var position = {'z-index': '6000', 'position': 'absolute', 'width': '16px'};
                $.extend(position, $("#idt_aoe").offset());
                position.top = position.top + 3;
                position.left = position.left + 3;
				
                $("<div class='cascade-loading'>&nbsp;</div>").appendTo("body").css(position);
                $("#idt_aoe").disabled = true;

                $.ajax({
                    type: 'POST',
                    url: ajax_sistema + '?tipo=nan_at_pf_pj',
                    data: {
                        cas: conteudo_abrir_sistema,
                        idt_nan_empresa: $('#idt_nan_empresa').val(),
                        idt_acao: $('#idt_acao').val()
                    },
                    success: function (str) {
                        $('#idt_aoe').html(url_decode(str));
                        $('#idt_aoe').change();
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        alert('Erro no ajax no: ' + textStatus + ' - ' + errorThrown);
                    },
                    async: false
                });

                $(".cascade-loading").remove();
            }
			*/
        });
	});
</script>