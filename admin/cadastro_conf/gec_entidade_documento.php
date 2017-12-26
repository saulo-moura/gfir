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
        background:#ECF0F1;
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
</style>

<?php
if ($_GET['idCad'] != '') {
   $_GET['idt0'] = $_GET['idCad'];
   $botao_volta = "parent.btFechaCTC('".$_GET['session_cod']."');";
   $botao_acao = '<script type="text/javascript">parent.btFechaCTC("'.$_GET['session_cod'].'");</script>';
}

$TabelaPai   = "gec_entidade";
$AliasPai    = "gec_en";
$EntidadePai = "Entidade";
$idPai       = "idt";

//
$TabelaPrinc      = "gec_entidade_documento";
$AliasPric        = "gec_ed";
$Entidade         = "Documento da Entidade";
$Entidade_p       = "Documentos da Entidade";
$CampoPricPai     = "idt_entidade";



$class_frame_f = "class_frame_f";
$class_titulo_f = "class_titulo_f";

$class_frame_p = "class_frame_p";
$class_titulo_p = "class_titulo_p";


$class_frame = "class_frame";
$class_titulo = "class_titulo";
$titulo_na_linha = false;



$tabela = $TabelaPrinc;

$id = 'idt';
$vetCampo[$CampoPricPai] = objFixoBanco($CampoPricPai, $EntidadePai, $TabelaPai, 'idt', 'descricao', 0);


$sql = "select idt, descricao from gec_documento order by codigo";
$vetCampo['idt_documento'] = objCmbBanco('idt_documento', 'Documento', true, $sql,' ','width:380px;');


$maxlength  = 2000;
$style      = "width:700px;";
$js         = "";
$vetCampo['observacao'] = objTextArea('observacao', 'Observação', false, $maxlength, $style, $js);




$veio = $_SESSION[CS][$TabelaPai]['veio'];
//
if ($veio=="O")
{
    $vetFrm = Array();
    $vetFrm[] = Frame('<span>Entidade</span>', Array(
        Array($vetCampo[$CampoPricPai]),
    ),$class_frame,$class_titulo,$titulo_na_linha);

  //  MesclarCol($vetCampo['logradouro_pais'], 5);

    $vetFrm[] = Frame('<span>Documento</span>', Array(
        Array($vetCampo['idt_documento']),
    ),$class_frame,$class_titulo,$titulo_na_linha);


    $vetFrm[] = Frame('<span>Observação</span>', Array(
        Array($vetCampo['observacao']),
    ),$class_frame,$class_titulo,$titulo_na_linha);
}
else
{
    if ($veio=="P")
    {
            $vetFrm = Array();
    $vetFrm[] = Frame('<span>Pessoa</span>', Array(
        Array($vetCampo[$CampoPricPai]),
    ),$class_frame,$class_titulo,$titulo_na_linha);

  //  MesclarCol($vetCampo['logradouro_pais'], 5);

    $vetFrm[] = Frame('<span>Documento</span>', Array(
        Array($vetCampo['idt_documento']),
    ),$class_frame,$class_titulo,$titulo_na_linha);


    $vetFrm[] = Frame('<span>Observação</span>', Array(
        Array($vetCampo['observacao']),
    ),$class_frame,$class_titulo,$titulo_na_linha);

    }
    else
    {

    }
}

////////////////////////

    $vetParametros = Array(
        'codigo_frm' => 'parte01',
        'controle_fecha' => 'A',
    );
    $vetFrm[] = Frame('<span>1 - ARQUIVOS ANEXADOS</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

    $vetCampo = Array();
    $vetCampo['plu_u_nome_completo'] = CriaVetTabela('Responsável');
    $vetCampo['data_cadastro']       = CriaVetTabela('Data Cadastro', 'data');
    $vetCampo['data_emissao']        = CriaVetTabela('Data Emissão', 'data');
    $vetCampo['data_vencimento']     = CriaVetTabela('Data Vencimento', 'data');
    $vetCampo['arquivo'] = CriaVetTabela('Arquivo','arquivo');
    $vetCampo['observacao'] = CriaVetTabela('Observações');
    $titulo = 'Arquivos Anexados';

    $TabelaPrinc      = "gec_entidade_documento_arquivo";
    $AliasPric        = "gec_eda";
    $Entidade         = "Arquivo do Documento da Entidade";
    $Entidade_p       = "Arquivos do Documento da Entidade";
    $CampoPricPai     = "idt_entidade_documento";

    $orderby = "{$AliasPric}.data_cadastro desc";

    $sql  = "select {$AliasPric}.*, ";
    $sql  .= "       plu_u.nome_completo as plu_u_nome_completo ";

    $sql .= " from {$TabelaPrinc} {$AliasPric}  ";
    $sql .= " inner join plu_usuario plu_u on plu_u.id_usuario = {$AliasPric}.idt_usuario ";

//
    $sql .= " where {$AliasPric}".'.idt_entidade_documento = $vlID';
    $sql .= " order by {$orderby}";


    $vetCampo['gec_entidade_documento_arquivo'] = objListarConf('gec_entidade_documento_arquivo', 'idt', $vetCampo, $sql, $titulo, true);


    $vetParametros = Array(
        'codigo_pai' => 'parte01',
        'width' => '100%',
    );
    $vetFrm[] = Frame('<span></span>', Array(
        Array($vetCampo['gec_entidade_documento_arquivo']),
    ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);

$vetCad[] = $vetFrm;
?>