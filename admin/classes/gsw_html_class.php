<?php
// <INICIO DO ARQUIVO>                                           //
//////////////////////////////////////////////////               //
//  GSW - V.1.0 - Julho 2016                                     //
//  Classe de Métodos - CALENDARIO                               //
//  Classe deve ser Instanciada apenas uma vez para o Sistema    //
////////////////////////////////////////////////////
// <INICIO CLASSE TGSW - Trata HTML>
class TGSW_HTML
{
	private $vetHTML          = Array();
    // 	
    public function __construct($vetHTML)
    {
	    $this->vetHTML  =  $vetHTML;
    }
    public function __destruct()
    {
		
    }
	public function SetHtml($vetHTML)
    {
		return 1;
	}
	public function Texto($vetPar)
    {
	    $html  = "";
		// Estilo
		$estilo = $vetPar['estilo'];
		//
		$html  .= "<style>";
		$nome             = $vetPar['nome'];
		$idlabel    = "{$nome}_L";
		$idinput    = "{$nome}_I";
		foreach ($estilo as $estilo_nome => $vetEstilo) {
		    $html  .= "#{$estilo_nome} {"; 
			foreach ($vetEstilo as $estilo_tipo => $valor) {
				$html  .= "$estilo_tipo:{$valor}; ";  
			}    
			$html  .= "} "; 
		}
		$html  .= "</style>";
		// HTML
		$posicao_titulo   = $vetPar['posicao_titulo'];
		$value            = $vetPar['value'];
		$titulo           = $vetPar['titulo'];
		$obrigatorio      = $vetPar['obrigatorio'];
		$marcaobrigatorio = $vetPar['marcaobrigatorio'];
		$tamanho          = $vetPar['tamanho'];
		$tamanho_maximo   = $vetPar['tamanho-maximo'];
		$js               = $vetPar['js'];
		$hint             = $vetPar['hint'];
		$leitura          = $vetPar['leitura'];
		$corconsulta      = $vetPar['corconsulta'];
		//
		$tamanhow         = " size='{$tamanho}' ";
		$tamanho_maximow  = " maxlength='{$tamanho_maximo}'  "; 
		//
		if ($tamanho=='')
		{
		    $tamanho=45; 
			$tamanhow = " size='{$tamanho}' ";
		}
		if ($tamanho_maximo=='')
		{
		    $tamanho_maximo=$tamanho;
		    $tamanho_maximow=" maxlength='{$tamanho_maximo}'  "; 
		}
		if ($obrigatorio==false)
		{
			$marcaobrigatorio="";
		}
		if ($hint!='')
		{
			$hintw = " title='{$hint}' ";
		}
		if ($posicao_titulo=='')
		{
		    $posicao_titulo="OL";
		}
		//
		if ($leitura=="")
		{
			$leitura=true;
		}
		$iddiv_D      = "{$nome}_D";
		$iddiv_DL     = "{$nome}_DL";
		$iddiv_DI     = "{$nome}_DI";
		
		$idlabel    = "{$nome}_L";
		$idinput    = "{$nome}_I";
		$idonchange = "{$nome}_change";
		$idonblur   = "{$nome}_blur";
		//
		$onchange   = "";
		$onblur     = "";
		if ($leitura)
		{
			$onchange   = " onchange = ' return {$nome}_change();'";
			$onblur     = " onblur   = ' return {$nome}_blur();'";
		}
		else
		{
		    if ($corconsulta=='')
			{
			    $corconsulta="#FFFFD2";
			}
			
			$style_L  = " style='' ";
			$style_LS = " style='background:{$corconsulta};' ";
			$style_I  = " readonly='true' style='background:{$corconsulta};' ";
		}
		if ($value=="")
		{
		
		
		}
		//
		$elementow  =  "";
		$elementow .=  "<div id='{$iddiv_D}' >";
		
		if ($posicao_titulo=='ML')
		{
			$elementow .= "<label id='{$idlabel}' {$style_L} for='{$nome}' >$titulo<span {$style_LS}>{$marcaobrigatorio}</span>:&nbsp;</label>";
			$elementow .= "<input id='{$idinput}' {$style_I}{$onchange} {$onblur} class='Texto' type='text' name='{$nome}' value='{$value}' {$hintw} {$tamanhow} {$tamanho_maximow} {$js} ><br>";
		}
		else
		{
			$elementow .=  "<div id='{$iddiv_DL}' >";
			$elementow .= "<label id='{$idlabel}' {$style_L} for='{$nome}' >$titulo<span {$style_LS}>{$marcaobrigatorio}</span>:&nbsp;</label>";
			$elementow .=  "</div>";
			$elementow .=  "<div id='{$iddiv_DI}' >";
			$elementow .= "<input id='{$idinput}' {$style_I}{$onchange} {$onblur} class='Texto' type='text' name='{$nome}' value='{$value}' {$hintw} {$tamanhow} {$tamanho_maximow} {$js} ><br>";
			$elementow .=  "</div>";
			
		}
		$elementow .=  "</div>";
		//
		$html .= $elementow;
		// Javascript
		$html .= "<script>";
		$html .= " var {$idinput} = '#{$nome}_I'; ";
		$html .= " var {$nome} = ''; ";
		$html .= "    $(document).ready(function () { ";
		$html .= " var jjjjj = ''; ";
		$html .= "    }); ";
		$html .= " function {$idonblur}() ";
		$html .= " { ";
		// $html .= " alert('idonblur'); ";
		$html .= " {$nome} = $({$idinput}).val();  ";
		// $html .= " alert('idonblur depois '+{$nome}); ";
		$html .= " } ";
		$html .= " function {$idonchange}() ";
		$html .= " { ";
		// $html .= " alert('idonchange'); ";
		$html .= " } ";
		$html .= "</script>";
        return $html;
    }
	public function SelecaoTabela($vetPar)
    {
	    $html  = "";
		// Estilo
		$estilo = $vetPar['estilo'];
		//
		$html  .= "<style>";
		$nome             = $vetPar['nome'];
		$idlabel    = "{$nome}_L";
		$idinput    = "{$nome}_I";
		foreach ($estilo as $estilo_nome => $vetEstilo) {
		    $html  .= "#{$estilo_nome} {"; 
			foreach ($vetEstilo as $estilo_tipo => $valor) {
				$html  .= "$estilo_tipo:{$valor}; ";  
			}    
			$html  .= "} "; 
		}
		$html  .= "</style>";
		// HTML
		$posicao_titulo   = $vetPar['posicao_titulo'];
		$value            = $vetPar['value'];
		$titulo           = $vetPar['titulo'];
		$obrigatorio      = $vetPar['obrigatorio'];
		$marcaobrigatorio = $vetPar['marcaobrigatorio'];
		$tamanho          = $vetPar['tamanho'];
		$tamanho_maximo   = $vetPar['tamanho-maximo'];
		$js               = $vetPar['js'];
		$hint             = $vetPar['hint'];
		$leitura          = $vetPar['leitura'];
		$corconsulta      = $vetPar['corconsulta'];
		$sql              = $vetPar['sql']; 
		$vazio            = $vetPar['vazio']; 
		$LinhaFixa        = $vetPar['LinhaFixa']; 
		//
		$tamanhow         = " size='{$tamanho}' ";
		$tamanho_maximow  = " maxlength='{$tamanho_maximo}'  "; 
		//
		
		//
		if ($tamanho=='')
		{
		    $tamanho=45; 
			$tamanhow = " size='{$tamanho}' ";
		}
		if ($tamanho_maximo=='')
		{
		    $tamanho_maximo=$tamanho;
		    $tamanho_maximow=" maxlength='{$tamanho_maximo}'  "; 
		}
		if ($obrigatorio==false)
		{
			$marcaobrigatorio="";
		}
		if ($hint!='')
		{
			$hintw = " title='{$hint}' ";
		}
		if ($posicao_titulo=='')
		{
		    $posicao_titulo="OL";
		}
		if ($sql=='')
		{
		    
		}
		else
		{
		   
		}
		if ($vazio=='S')
		{
		    $LinhaFixaw=' ';     
		}
		else
		{
		   $LinhaFixaw=$LinhaFixa;          
		}
		
		//
		if ($leitura=="")
		{
			$leitura=true;
		}
		$iddiv_D      = "{$nome}_D";
		$iddiv_DL     = "{$nome}_DL";
		$iddiv_DI     = "{$nome}_DI";
		$idlabel      = "{$nome}_L";
		$idinput      = "{$nome}_I";
		$idonchange   = "{$nome}_change";
		$idonblur     = "{$nome}_blur";
		//
		$onchange     = "";
		$onblur       = "";
		if ($leitura)
		{
			$onchange   = " onchange = ' return {$nome}_change();'";
			$onblur     = " onblur   = ' return {$nome}_blur();'";
		}
		else
		{
		    if ($corconsulta=='')
			{
			    $corconsulta="#FFFFD2";
			}
			$style_L  = " style='' ";
			$style_LS = " style='background:{$corconsulta};' ";
			$style_I  = " disabled style='background:{$corconsulta};' ";
		}
		//
		$elementow  =  "";
		$elementow .=  "<div id='{$iddiv_D}' >";
		
		if ($posicao_titulo=='ML')
		{
			$elementow .= "<label id='{$idlabel}' {$style_L} for='{$nome}' >$titulo<span {$style_LS}>{$marcaobrigatorio}</span>:&nbsp;</label>";
			// $elementow .= "<input id='{$idinput}' {$style_I}{$onchange} {$onblur} class='Texto' type='text' name='{$nome}' value='{$nome}' {$hintw} {$tamanhow} {$tamanho_maximow} {$js} ><br>";
			$rs         = execsql($sql);
//			function criar_combo_rs($rs, $NomeCombo, $PreSelect, $LinhaFixa, $JS, $style = '', $lang = '', $return = False, $id = '', $msg_sem_registro = 'Não existe informação no sistema') {

            $NomeCombo = $nome;
			$PreSelect = $value;
			$LinhaFixa = $LinhaFixaw;
			$JS        = "";
			$style     = "";
			$lang      = "";
            $return    = True;
			$id        = $idinput;
			$msg_sem_registro = 'Não existe informação no sistema';

			$elementow .= criar_combo_rs($rs, $NomeCombo, $PreSelect, $LinhaFixa, $JS, $style, $lang, $return, $id, $msg_sem_registro);
		}
		else
		{
			$elementow .=  "<div id='{$iddiv_DL}' >";
			$elementow .= "<label id='{$idlabel}' {$style_L} for='{$nome}' >$titulo<span {$style_LS}>{$marcaobrigatorio}</span>:&nbsp;</label>";
			$elementow .=  "</div>";
			
			$elementow .=  "<div id='{$iddiv_DI}' >";
			// $elementow .= "<input id='{$idinput}' {$style_I}{$onchange} {$onblur} class='Texto' type='text' name='{$nome}' value='{$nome}' {$hintw} {$tamanhow} {$tamanho_maximow} {$js} ><br>";
			$rs = execsql($sql);
			$NomeCombo = $nome;
			$PreSelect = $value;
			$LinhaFixa = $LinhaFixaw;
			$JS        = "";
			$style     = "";
			$lang      = "";
            $return    = True;
			$id        = $idinput;
			$msg_sem_registro = 'Não existe informação no sistema';

			$elementow .= criar_combo_rs($rs, $NomeCombo, $PreSelect, $LinhaFixa, $JS, $style, $lang, $return, $id, $msg_sem_registro);
			$elementow .=  "</div>";
			
		}
		$elementow .=  "</div>";
		//
		$html .= $elementow;
		// Javascript
		$html .= "<script>";
		$html .= " var {$idinput} = '#{$nome}_I'; ";
		$html .= " var {$nome} = ''; ";
		$html .= "    $(document).ready(function () { ";
		$html .= " var jjjjj = ''; ";
		$html .= "    }); ";
		$html .= " function {$idonblur}() ";
		$html .= " { ";
		// $html .= " alert('idonblur'); ";
		$html .= " {$nome} = $({$idinput}).val();  ";
		// $html .= " alert('idonblur depois '+{$nome}); ";
		$html .= " } ";
		$html .= " function {$idonchange}() ";
		$html .= " { ";
		// $html .= " alert('idonchange'); ";
		$html .= " } ";
		$html .= "</script>";
        return $html;
		
	}


	public function BotaoSelecao($vetPar)
    {
        $html  = "";
		// Estilo
		$estilo = $vetPar['estilo'];
		//
		$html  .= "<style>";
		$nome             = $vetPar['nome'];
		$idlabel    = "{$nome}_L";
		$idinput    = "{$nome}_I";
		foreach ($estilo as $estilo_nome => $vetEstilo) {
		    $html  .= "#{$estilo_nome} {"; 
			foreach ($vetEstilo as $estilo_tipo => $valor) {
				$html  .= "$estilo_tipo:{$valor}; ";  
			}    
			$html  .= "} "; 
		}
		foreach ($estilo as $estilo_nome => $vetEstilo) {
		    $html  .= "#{$estilo_nome}Limpa {"; 
			foreach ($vetEstilo as $estilo_tipo => $valor) {
				$html  .= "$estilo_tipo:{$valor}; ";  
			}    
			$html  .= "} "; 
		}
		$html  .= "</style>";
		// HTML
		$posicao_titulo   = $vetPar['posicao_titulo'];
		$titulo           = $vetPar['titulo'];
		$obrigatorio      = $vetPar['obrigatorio'];
		$marcaobrigatorio = $vetPar['marcaobrigatorio'];
		$tamanho          = $vetPar['tamanho'];
		$tamanho_maximo   = $vetPar['tamanho-maximo'];
		$js               = $vetPar['js'];
		$hint             = $vetPar['hint'];
		$leitura          = $vetPar['leitura'];
		$corconsulta      = $vetPar['corconsulta'];
		$temlabelbotao    = $vetPar['temlabelbotao'];
		if ($temlabelbotao=='')
		{
		    $temlabelbotao=False;
		}
		//
		$tamanhow         = " size='{$tamanho}' ";
		$tamanho_maximow  = " maxlength='{$tamanho_maximo}'  "; 
		//
		if ($tamanho=='')
		{
		    $tamanho=45; 
			$tamanhow = " size='{$tamanho}' ";
		}
		if ($tamanho_maximo=='')
		{
		    $tamanho_maximo=$tamanho;
		    $tamanho_maximow=" maxlength='{$tamanho_maximo}'  "; 
		}
		if ($obrigatorio==false)
		{
			$marcaobrigatorio="";
		}
		if ($hint!='')
		{
			$hintw = " title='{$hint}' ";
		}
		if ($posicao_titulo=='')
		{
		    $posicao_titulo="OL";
		}
		if ($obrigatorio==false)
		{
			$marcaobrigatorio="";
		}
		if ($temlabelbotao=='')
		{
			$temlabelbotao=false;
		}

		//
		if ($leitura=="")
		{
			$leitura  =true;
		}
		$iddiv_D      = "{$nome}_D";
		$iddiv_DL     = "{$nome}_DL";
		$iddiv_DI     = "{$nome}_DI";
		$idlabel      = "{$nome}_L";
		$idinput      = "{$nome}_I";
		$idonclick    = "{$nome}_click";
		//
		$$onclick   = "";
		if ($leitura)
		{
			$onclick   = " onclick = ' return {$idonclick}();'";
		}
		else
		{
		    if ($corconsulta=='')
			{
			    $corconsulta="#FFFFD2";
			}
			
			$style_L  = " style='' ";
			$style_LS = " style='background:{$corconsulta};' ";
			$style_I  = " disabled style='background:{$corconsulta};' ";
		}
		
		
		$idinput2  = $idinput."Limpa"; 
		$style_I2  = $style_I;
		$onclick2  = " onclick = ' return {$nome}_click_Limpa_Tudo();'";
		$idonclick2    = "{$nome}_click_Limpa_Tudo";
		$nome2  = "limpatudo";
		$titulo2="LIMPA TUDO";
		$hintw2="Limpa todos os Campos de Seleção";
	    $tamanhow2="";
		$tamanho_maximow2="";
		$js2="";
		
		
		//
		$elementow  =  "";
		
		$elementow .=  "<div id='{$iddiv_D}' style='padding-top:7em;' >";
		
		
		if ($posicao_titulo=='ML')
		{
		    if ($temlabelbotao)
			{
			    $elementow .=  "<div id='{$iddiv_DL}' >";
				$elementow .= "<label id='{$idlabel}' {$style_L} for='{$nome}' >$titulo<span {$style_LS}>{$marcaobrigatorio}</span>:&nbsp;</label>";
				$elementow .=  "</div>";
			}
			$elementow .=  "<div id='{$iddiv_DI}' >";
			$elementow .= "<input id='{$idinput}' {$style_I}{$onclick} class='button' type='button' name='{$nome}' value='{$nome}' {$hintw} {$tamanhow} {$tamanho_maximow} {$js} ><br>";
			$elementow .=  "</div>";
		}
		else
		{
		    if ($temlabelbotao)
			{
			    $elementow .=  "<div id='{$iddiv_DL}' >";
				$elementow .= "<label id='{$idlabel}' {$style_L} for='{$nome}' >$titulo<span {$style_LS}>{$marcaobrigatorio}</span>:&nbsp;</label>";
				$elementow .=  "</div>";
			}
			$elementow .=  "<div id='{$iddiv_DI}' >";
			$elementow .= "<input id='{$idinput}' {$style_I}  {$onclick} class='button' type='button' name='{$nome}' value='{$titulo}' {$hintw} {$tamanhow} {$tamanho_maximow} {$js} >";
			$elementow .= "<input id='{$idinput2}' {$style_I2}  {$onclick2} class='button' type='button' name='{$nome2}' value='{$titulo2}' {$hintw2} {$tamanhow2} {$tamanho_maximow2} {$js2} >";
			$elementow .=  "</div>";
			
		}
		
		$elementow .=  "</div>";
		//
		$html .= $elementow;
		// Javascript
		$html .= "<script>";
		$html .= " var {$idinput} = '#{$nome}_I'; ";
		$html .= " var {$nome} = ''; ";
		$html .= "    $(document).ready(function () { ";
		
		$html .= "    }); ";
		
		$html .= " function {$idonclick}() ";
		$html .= " { ";
		//$html .= " alert('idonclick _ faz pesquisa'); ";
		
		$html .= "  var id='idt_unidade_regional_I'; ";
		$html .= "  var idt_unidade_regional = ''; "; 
		$html .= "  objtp           = document.getElementById(id); ";
		$html .= "  if (objtp != null) { ";
		$html .= "      idt_unidade_regional = objtp.value; ";
		$html .= "  } ";
		
		$html .= "  var id='idt_ponto_atendimento_I'; ";
		$html .= "  var idt_ponto_atendimento = ''; "; 
		$html .= "  objtp           = document.getElementById(id); ";
		$html .= "  if (objtp != null) { ";
		$html .= "      idt_ponto_atendimento = objtp.value; ";
		$html .= "  } ";
		
		$html .= "  var id='idt_consultor_I'; ";
		$html .= "  var idt_consultor = ''; "; 
		$html .= "  objtp           = document.getElementById(id); ";
		$html .= "  if (objtp != null) { ";
		$html .= "      idt_consultor = objtp.value; ";
		$html .= "  } ";
		
		$html .= "  var id='idt_servico_I'; ";
		$html .= "  var idt_servico = ''; "; 
		$html .= "  objtp           = document.getElementById(id); ";
		$html .= "  if (objtp != null) { ";
		$html .= "      idt_servico = objtp.value; ";
		$html .= "  } ";
		
		$agenda_data = $_SESSION[CS]['agenda_data'];
		$veio_at     = $_SESSION[CS]['veio_at'];
		$idt_atendimento  = $_SESSION[CS]['idt_atendimento'];
		
        //$html .= " alert('idonclick _ xxxx === '+id+' xxxxx '+agenda_data); ";
		$html .= "   var agenda_data = '{$agenda_data}'; ";
		$html .= "   var veio_at = '{$veio_at}'; ";
		$html .= "   var idt_atendimento = '{$idt_atendimento}'; ";
		
		$html .= " self.location = 'conteudo_calendario.php?veio='+veio+'&veio_at='+veio_at+'&idt_atendimento='+idt_atendimento+'&agenda_data='+agenda_data+'&idt_servico='+idt_servico+'&idt_unidade_regional='+idt_unidade_regional+'&idt_ponto_atendimento='+idt_ponto_atendimento+'&idt_consultor='+idt_consultor+'&idt_atendimento='+idt_atendimento; ";
		
		$html .= " } ";
		
		$html .= " function {$idonclick2}() ";
		$html .= " { ";
		$html .= " $('#idt_unidade_regional_I').val(''); ";
		$html .= " $('#idt_ponto_atendimento_I').val(''); ";
		$html .= " $('#idt_consultor_I').val(''); ";
		$html .= " $('#idt_servico_I').val(''); ";
		$html .= " } ";
		
		$html .= "</script>";
        return $html;		
		
		
    }
}
////////////////////////////////////////////////////
// <FIM DO ARQUIVO>                               //
////////////////////////////////////////////////////
?>