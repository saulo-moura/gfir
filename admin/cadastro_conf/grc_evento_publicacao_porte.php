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

$TabelaPrinc      = "grc_evento_publicacao_porte";
$AliasPric        = "grc_epp";
$Entidade         = "Porte do Evento";
$Entidade_p       = "Porte do Evento";
$CampoPricPai     = "idt_evento_publicacao";

$tabela = $TabelaPrinc;
// Fixa o item da tabela anterior (PAI)




if ($acao!="inc")
{
    $sql  = "select * from grc_evento_publicacao ";
    $sql .= " where idt = ".null($_GET['id']);
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

/*
$maxlength  = 2000;
$style      = "width:700px;";
$js         = "";
$vetCampo['detalhe'] = objTextArea('detalhe', 'Detalhe', false, $maxlength, $style, $js);
*/


$sql = '';
$sql .= ' select idt, descricao, desc_vl_cmb';
$sql .= ' from '.db_pir_gec.'gec_organizacao_porte';
$sql .= " where codigo in ('2', '3', '99')";
$sql .= ' order by descricao, desc_vl_cmb';
$js1 = " style='width:14em;'";
$vetCampo['idt_porte'] = objCmbBanco('idt_porte', 'Porte / Faixa Faturamento', true, $sql, ' ', '', $js1);

$vetCampo['percentual_desconto'] = objInteiro('percentual_desconto', '% Desconto', true);


$vetFrm = Array();
MesclarCol($vetCampo[$CampoPricPai], 3);
$vetFrm[] = Frame('', Array(
    Array($vetCampo[$CampoPricPai]),
    Array($vetCampo['idt_porte'],'',$vetCampo['percentual_desconto']),

),$class_frame,$class_titulo,$titulo_na_linha);


$vetCad[] = $vetFrm;
?>