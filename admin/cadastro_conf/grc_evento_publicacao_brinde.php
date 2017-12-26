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
</style>



<?php

//p($_GET);

if ($_GET['idCad'] != '') {
    $_GET['idt0'] = $_GET['idCad'];
    $botao_volta = "parent.btFechaCTC('".$_GET['session_cod']."');";
    $botao_acao = '<script type="text/javascript">parent.btFechaCTC("'.$_GET['session_cod'].'");</script>';
}
//p($_GET);

// Dados da tabela Pai (Nivel 1)

$TabelaPai   = "grc_evento_publicacao";
$AliasPai    = "grc_ep";
$EntidadePai = "Política de Desconto do Evento";
$idPai       = "idt";

// Dados da tabelha filho nivel 2 (deste programa)

$TabelaPrinc      = "grc_evento_publicacao_brinde";
$AliasPric        = "grc_epb";
$Entidade         = "Brinde do Evento";
$Entidade_p       = "Brindes do Evento";
$CampoPricPai     = "idt_evento_publicacao";

$tabela = $TabelaPrinc;
// Fixa o item da tabela anterior (PAI)




if ($acao!="inc")
{
    $sql  = "select grc_ep.* from grc_evento_publicacao grc_ep ";
    $sql .= " where grc_ep.idt = ".null($_GET['id']);
    $rs = execsql($sql);
    ForEach ($rs->data as $row) {
        $flag = $row['flag'];
    }
/*
    if ($flag == 'S')
    {
        $acao='con';
        echo "<div style='text-align:center; font-size:14px; background:#FF0000; color:#FFFFFF; width:100%;'>";
        echo "OCORRÊNCIA REGISTRADA PELO SISTEMA. SÓ PODE SER CONSULTADA."; 
        echo "</div>"; 

    }
*/
}


$id = 'idt';
$vetCampo[$CampoPricPai] = objFixoBanco($CampoPricPai, $EntidadePai, $TabelaPai, 'idt', 'descricao', 0);


$maxlength  = 255;
$style      = "width:700px;";
$js         = "";
$vetCampo['link'] = objTextArea('link', 'Link', false, $maxlength, $style, $js);



$sql  = "select idt, descricao from grc_evento_brinde ";
$sql .= " order by codigo";
$vetCampo['idt_brinde'] = objCmbBanco('idt_brinde', 'Brinde', true, $sql,' ','width:180px;');

//$vetCampo['quantidade_inscrito'] = objInteiro('quantidade_inscrito', 'Quantidade Inscrições', true);


$vetFrm = Array();
MesclarCol($vetCampo[$CampoPricPai], 3);
$vetFrm[] = Frame('', Array(
    Array($vetCampo[$CampoPricPai]),
   // Array($vetCampo['idt_canal_inscricao'],'',$vetCampo['quantidade_inscrito']),
    Array($vetCampo['idt_brinde']),
	Array($vetCampo['link']),
),$class_frame,$class_titulo,$titulo_na_linha);


$vetCad[] = $vetFrm;
?>