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

$TabelaPai   = "grc_evento";
$AliasPai    = "grc_e";
$EntidadePai = "Evento";
$idPai       = "idt";

// Dados da tabelha filho nivel 2 (deste programa)

$TabelaPrinc      = "grc_evento_ocorrencia";
$AliasPric        = "grc_eo";
$Entidade         = "Ocorrencia do Evento";
$Entidade_p       = "Ocorrencias do Evento";
$CampoPricPai     = "idt_evento";

$tabela = $TabelaPrinc;
// Fixa o item da tabela anterior (PAI)




if ($acao!="inc")
{
    $sql  = "select grc_eo.* from grc_evento_ocorrencia grc_eo ";
    $sql .= " where grc_eo.idt = ".null($_GET['id']);
    $rs = execsql($sql);
    ForEach ($rs->data as $row) {
        $flag = $row['flag'];
    }

    if ($flag == 'S')
    {
        $acao='con';
        echo "<div style='text-align:center; font-size:14px; background:#FF0000; color:#FFFFFF; width:100%;'>";
        echo "OCORRÊNCIA REGISTRADA PELO SISTEMA. SÓ PODE SER CONSULTADA."; 
        echo "</div>"; 

    }

}







$id = 'idt';
$vetCampo[$CampoPricPai] = objFixoBanco($CampoPricPai, $EntidadePai, $TabelaPai, 'idt', 'descricao', 0);

// descreve os campos do cadastro

$vetCampo['codigo']    = objTexto('codigo', 'Código', false, 15, 45);
$vetCampo['descricao'] = objTexto('descricao', 'Descrição', True, 60, 120);
$vetCampo['ativo']     = objCmbVetor('ativo', 'Ativo?', True, $vetSimNao);
//

/*
$maxlength  = 2000;
$style      = "width:700px;";
$js         = "";
$vetCampo['detalhe'] = objTextArea('detalhe', 'Detalhe', false, $maxlength, $style, $js);
*/

$vetCampo['data']     = objDatahora('data', 'Data', True);
$vetCampo['detalhe'] = objHTML('detalhe', 'Detalhe', false);

$sql  = "select id_usuario, nome_completo from plu_usuario ";
$sql .= " order by nome_completo";
$vetCampo['idt_responsavel'] = objCmbBanco('idt_responsavel', 'Responsável', true, $sql,' ','width:180px;');


//$sql  = "select idt, codigo, descricao from grc_produto_conteudo_programatico ";
//$sql .= " order by codigo";
//$vetCampo['idt'] = objCmbBanco('idt', 'Conteúdo Programático', true, $sql,' ','width:180px;');

// descreve o layput do cadastro

$vetFrm = Array();
$vetFrm[] = Frame('<span>Evento</span>', Array(
    Array($vetCampo[$CampoPricPai]),
),$class_frame,$class_titulo,$titulo_na_linha);

//MesclarCol($vetCampo['idt_situacao'], 3);

//$vetFrm[] = Frame('<span>Ocorrencias</span>', Array(
//    Array($vetCampo['idt']),
//),$class_frame,$class_titulo,$titulo_na_linha);



$vetFrm[] = Frame('<span>Identificação</span>', Array(
    Array($vetCampo['data'],'',$vetCampo['descricao']),


Array($vetCampo['idt_responsavel'],'',$vetCampo['ativo']),
),$class_frame,$class_titulo,$titulo_na_linha);


$vetFrm[] = Frame('<span>Resumo</span>', Array(
    Array($vetCampo['detalhe']),
),$class_frame,$class_titulo,$titulo_na_linha);


$vetCad[] = $vetFrm;
?>