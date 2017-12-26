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
        background: #FFFFFF;
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

    .Texto {
        border:0;
        background:#ECF0F1;
    }
    
    Select {
        border:0;
        background:#ECF0F1;
    }

    TextArea {
        border:0;
        background:#ECF0F1;
    }
    
    .TextArea {
        border:0;
        background:#ECF0F1;
    }

    div#xEditingArea {
        border:0;
        background:#ECF0F1;
    }

    .TextoFixo {
        background:#ECF0F1;
    }


    fieldset.class_frame {
        border:0;
    }

    .campo_disabled {
        background-color: #ffffd7;
    }    

    #parterepasse_tit {
        padding-left:0px;
    }

</style>
<?php
if ($_GET['idCad'] != '') {
    $_GET['idt0'] = $_GET['idCad'];
    $botao_volta = "parent.btFechaCTC('".$_GET['session_cod']."');";
    $botao_acao = '<script type="text/javascript">parent.btFechaCTC("'.$_GET['session_cod'].'");</script>';
}

$barra_bt_top_fixo = true;




$AliasPai     = "grc_pv";
$TabelaPai    = "grc_politica_vendas ";
$TabelaPaij   = "grc_politica_vendas ";
$TabelaPaij  .= " {$AliasPai} ";
$EntidadePai  = "Política de Vendas";
$idPai        = "idt";
//
$AliasPric    = "grc_pvt";
$TabelaPrinc  = "grc_politica_vendas_condicao";
$Entidade     = "Condição de Política de Vendas";
$Entidade_p   = "Condições de Política de Vendas";
$CampoPricPai = "idt_politica_vendas";
// Dados do pai
$sql2  = 'select ';
$sql2 .= "  {$AliasPai}.* ";
$sql2 .= "  from {$TabelaPai} {$AliasPai} ";
$sql2 .= "  where {$AliasPai}.idt = ".null($_GET['idt0']);
$rs_pai  = execsql($sql2);
$row_pai = $rs_pai->data[0];
// $desc_ponto_atendimento = $row_pai['sca_os_descricao'];
// $duracao="";





if ($acao!="inc")
{
	$sql2  = 'select ';
	$sql2 .= "  {$AliasPric}.* ";
	$sql2 .= "  from {$TabelaPrinc} {$AliasPric} ";
	$sql2 .= "  where {$AliasPric}.idt = ".null($_GET['id']);
	$rs_princ  = execsql($sql2);
	$row_princ = $rs_princ->data[0];
	// $duracao   = $row_princ['periodo'];
	
	
	
}
/*
$sql3  = 'select ';
$sql3 .= "  {$AliasPric}.* ";
$sql3 .= "  from {$TabelaPrinc} {$AliasPric} ";
$sql3 .= "  where {$AliasPric}.idt_politica_vendas = ".null($_GET['idt0']);
$rowt  = execsql($sql3);
$where = "";
echo "<table border='1' cellspacing='0' cellpadding='1' width='100%' style='width:100%; ' >";
foreach ($rst->data as $rowt) {
	$idt           = $rowt['idt'];
	$ordem         = $rowt['ordem'];
	$parentese_ant = $rowt['parentese_ant'];
	$codigo        = $rowt['codigo'];
	$condicao      = $rowt['condicao'];
	$valor         = $rowt['valor'];
	$parentese_dep = $rowt['parentese_dep'];
	$operador      = $rowt['operador'];
	$where .= $ordem." ".$parentese_ant." ".$codigo." ".$condicao." ".$valor." ".$parentese_dep." ".$operador."<br />";
	
}
$hint="";
echo "<tr>";
echo "<td title='{$hint}' id='where' class='' style='font-size:18px; background:#FFFFFF; color:#000000; text-align:left; font-weight: normal;  ' >";
echo $where;
echo "</td>"; 
echo "</tr>";
echo "</table>";
*/
//p($sql2);
//echo " -------------- $duracao ";
//p($_GET);

 $corbloq = "#FFFF70";


 $vetParametro=Array();
 $vetParametro['idt_politica_vendas']=$_GET['idt0'];
 $vetParametro['tipo']=$veio;
 $ret = MontaWherePoliticaVendas($vetParametro);
 $condicaoHtml = $vetParametro['condicaoHtml'];
 //echo $condicaoHtml;


$tabela = $TabelaPrinc;
$id     = 'idt';
$vetCampo[$CampoPricPai]    = objFixoBanco($CampoPricPai, $EntidadePai, $TabelaPaij, 'idt', 'descricao', 0);
$vetCampo['ordem']     = objInteiro('ordem', 'Ordem', True, 5);
//$vetCampo['codigo']    = objTexto('codigo', 'Expressão/Código', True, 40, 120);
$maxlength  = 5000;
$style      = " width:270px; background:{$corbloq}";
$js         = " readonly='true' ";
$vetCampo['codigo'] = objTextArea('codigo', 'Expressão/Campo', true, $maxlength, $style, $js);


$vetParenteseAnt=Array();
$vetParenteseAnt['(']='(';
$vetCampo['parentese_ant']     = objCmbVetor('parentese_ant', 'Abre', false, $vetParenteseAnt,' ');

$vetParenteseDep=Array();
$vetParenteseDep[')']=')';
$vetCampo['parentese_dep']     = objCmbVetor('parentese_dep', 'Fecha', false, $vetParenteseDep,' ');

$vetCondicao=Array();
$vetCondicao['=']='Igual a';
$vetCondicao['<>']='Diferende de';
$vetCondicao['>']='Maior do que';
$vetCondicao['<']='Menor do que';
$vetCondicao['>=']='Maior ou Idual a';
$vetCondicao['<=']='Menor ou Igual a';
$vetCondicao['like']='Contem';
$vetCampo['condicao']     = objCmbVetor('condicao', 'Condição', true, $vetCondicao,' ');

$maxlength  = 5000;
$style      = "width:200px;";
$js         = "";
$vetCampo['valor'] = objTextArea('valor', 'Valor', true, $maxlength, $style, $js);


$vetOperador=Array();
$vetOperador['e']=' e ';
$vetOperador['ou']=' ou ';
//$vetCampo['operador']     = objCmbVetor('operador', 'e/ou', false, $vetOperador,' ');
$js         = "readonly='true'  style=' background:{$corbloq}' ";
$vetCampo['operador'] = objTexto('operador', 'e/ou', false, 3, 45, $js);

//$vetCampo['operador']     = objHidden('operador', 'S');



$vetTipo=Array();
if ($veio!="M")
{
    $vetTipo['P'] = 'Aplicar na Seleção de Eventos';
}
else
{
    $vetTipo['M'] = 'Aplicar na Matrícula';
}
$js = " disabled style='background:#ffffd7;' ";
$vetCampo['tipo']     = objCmbVetor('tipo', 'Tipo', false, $vetTipo,'',$js);


$vetCampo['descricao'] = objTexto('descricao', 'Descrição', True, 40, 120);
$vetCampo['ativo']     = objCmbVetor('ativo', 'Ativo?', True, $vetSimNao,'');

$condicaoHtml="<br /><br /><div style='width:99%;'>$condicaoHtml</div>";
$vetCampo['expressao_condicao'] = objInclude('expressao_condicao', $condicaoHtml);

$vetCampo['obj_politica_vendas_escolhe_campos'] = objInclude('obj_politica_vendas_escolhe_campos', 'cadastro_conf/obj_politica_vendas_escolhe_campos.php');




$vetCampo['obj_politica_vendas_escolhe_eou'] = objInclude('obj_politica_vendas_escolhe_eou', 'cadastro_conf/obj_politica_vendas_escolhe_eou.php');

//
$maxlength  = 4000;
$style      = "width:700px;";
$js         = "";
$vetCampo['detalhe'] = objTextArea('detalhe', 'Detalhe', false, $maxlength, $style, $js);
//$sql = "select idt, codigo, descricao from plu_estado order by descricao";
//$vetCampo['idt_estado'] = objCmbBanco('idt_estado', 'Estado', true, $sql,'','width:180px;');
$vetFrm = Array();
MesclarCol($vetCampo[$CampoPricPai], 7);
MesclarCol($vetCampo['tipo'], 11);
MesclarCol($vetCampo['expressao_condicao'], 15);
MesclarCol($vetCampo['obj_politica_vendas_escolhe_campos'], 15);
$vetFrm[] = Frame('', Array(
    Array($vetCampo[$CampoPricPai],'',$vetCampo['tipo']),
	
	Array($vetCampo['ordem'],'',$vetCampo['parentese_ant'],'',$vetCampo['codigo'],'',$vetCampo['condicao'],'',$vetCampo['valor'],'',$vetCampo['parentese_dep'],'',$vetCampo['operador'],'',$vetCampo['obj_politica_vendas_escolhe_eou']),
    //Array($vetCampo['codigo'],'',$vetCampo['alias'],'',$vetCampo['descricao']),
    //Array($vetCampo['detalhe']),
	Array($vetCampo['expressao_condicao']),
	
	Array($vetCampo['obj_politica_vendas_escolhe_campos']),
	
),$class_frame,$class_titulo,$titulo_na_linha);


$vetCad[] = $vetFrm;
?>
