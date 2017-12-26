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

    td#idt_competencia_obj div {
        color:#FF0000;
    }

    .Tit_Campo {
        font-size:12px;
    }

    td.Titulo {
        color:#666666;
    }


    #frm3 {
       width:100%;
    }


</style>










<?php
$tabela = 'grc_nan_devolutiva';
$id = 'idt';



$class_titulo_f  = "class_titulo_f";
$class_frame_p   = "class_frame_p";
$class_titulo_p  = "class_titulo_p";
$class_frame     = "class_frame";
$class_titulo    = "class_titulo";
$titulo_na_linha = false;




$vetCampo['codigo']    = objTexto('codigo', 'Código', True, 15, 45);
$vetCampo['descricao'] = objTexto('descricao', 'Descrição', True, 60, 120);
$vetCampo['ativo']     = objCmbVetor('ativo', 'Ativo?', True, $vetSimNao,'');


$vetCampo['versao']    = objInteiro('versao', 'Versão', True, 5);
$vetCampo['versao_txt'] = objTexto('versao_txt', 'Versão Texto', True, 20, 20);


//
$maxlength  = 1000;
$style      = "width:700px;";
$js         = "";
$vetCampo['detalhe'] = objTextArea('detalhe', 'Detalhe', false, $maxlength, $style, $js);
$vetCampo['detalhe'] = objHtml('detalhe', 'Título', false,200);
//$sql = "select idt, codigo, descricao from plu_estado order by descricao";
//$vetCampo['idt_estado'] = objCmbBanco('idt_estado', 'Estado', true, $sql,'','width:180px;');
$vetFrm = Array();
MesclarCol($vetCampo['detalhe'], 5);
MesclarCol($vetCampo['versao_texto'], 3);
$vetFrm[] = Frame('<span>Identificação</span>', Array(
    Array($vetCampo['codigo'],'',$vetCampo['descricao'],'',$vetCampo['ativo']),
	Array($vetCampo['versao'],'',$vetCampo['versao_txt']),
	Array($vetCampo['detalhe']),
),$class_frame,$class_titulo,$titulo_na_linha);






//
// ----------------------- ITENS DA DEVOLUTIVA
//
$vetParametros = Array(
    'codigo_frm' => 'devolutiva_item',
    'controle_fecha' => 'A',
);
$vetFrm[] = Frame('<span>ITENS DA DEVOLUTIVA</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

$vetCampo = Array();
$vetCampo['codigo']             = CriaVetTabela('Ordem');
$vetCampo['descricao']          = CriaVetTabela('Pergunta');
$vetTipoItem=Array();
$vetTipoItem['1']='Título e Texto Fixo';
$vetTipoItem['2']='Título e Include';
$vetTipoItem['3']='Título e Texto Fixo e Include';
$vetCampo['tipo']              = CriaVetTabela('Tipo','descDominio',$vetTipoItem );

$vetCampo['ativo']              = CriaVetTabela('Ativo?','descDominio',$vetSimNao );

$titulo = 'Itens da devolutiva';
$TabelaPrinc  = "grc_nan_devolutiva_item";
$AliasPric    = "grc_ndi";
$Entidade     = "Item da Devolutiva";
$Entidade_p   = "Itens da Devolutiva";
$CampoPricPai = "idt_devolutiva";
$orderby = " {$AliasPric}.codigo ";

$sql  = "select {$AliasPric}.* ";
$sql .= " from {$TabelaPrinc} {$AliasPric}  ";
$sql .= " where {$AliasPric}.{$CampoPricPai} = ".'$vlID';
$sql .= " order by {$orderby}";

$vetParametros = Array(
//    'func_trata_row' => bloqueia_row_formulario,
);
$vetCampo[$TabelaPrinc] = objListarConf($TabelaPrinc, 'idt', $vetCampo, $sql, $titulo, true, $vetParametros);

$vetParametros = Array(
    'codigo_pai' => 'devolutiva_item',
    'width' => '100%',
);
$vetFrm[] = Frame('', Array(
    Array($vetCampo[$TabelaPrinc]),
        ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);



$vetCampo['include'] = objInclude('include', 'cadastro_conf/grc_nan_devolutiva_rel_inc.php', $vetVariavel);
$vetParametros = Array(
    'width' => '100%',
);
$vetFrm[] = Frame('', Array(
    Array($vetCampo['include']),
),$class_frame,$class_titulo,$titulo_na_linha,$vetParametros);


$vetCad[] = $vetFrm;
?>