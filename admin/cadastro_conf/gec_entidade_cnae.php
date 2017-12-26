<?php
if ($_GET['idCad'] != '') {
    //$_GET['idt0'] = $_GET['idCad'];
    $_GET['idt1'] = $_GET['idCad'];
    $botao_volta = "parent.btFechaCTC('".$_GET['session_cod']."');";
    $botao_acao = '<script type="text/javascript">parent.btFechaCTC("'.$_GET['session_cod'].'");</script>';
}
p($_GET);
$TabelaAvo = "gec_entidade";
$AliasAvo = "gec_en";
$EntidadeAvo = "Entidade";
$idAvo = "idt";


$TabelaPai = "gec_entidade_organizacao";
$AliasPai = "gec_eno";
$EntidadePai = "Entidade Organizacao";
$idPai = "idt";


//
$TabelaPrinc = "gec_entidade_cnae";
$AliasPric = "gec_ec";
$Entidade = "CNAE da Entidade";
$Entidade_p = "CNAEs da Entidade";

$CampoPricAvo = "idt_entidade";
$CampoPricPai = "idt_entidade_organizacao";

$tabela = $TabelaPrinc;

$id = 'idt';

if ($_GET['idt0'] == '') {
    $sql = '';
    $sql .= ' select '.$CampoPricAvo;
    $sql .= ' from '.$TabelaPai;
    $sql .= ' where '.$idPai.' = '.null($_GET['idt1']);
    $rs = execsql($sql);
    $_GET['idt0'] = $rs->data[0][0];
}

$vetCampo[$CampoPricAvo] = objFixoBanco($CampoPricAvo, $EntidadeAvo, $TabelaAvo, 'idt', 'descricao', 0);


$vetCampo[$CampoPricPai] = objFixoBanco($CampoPricPai, $EntidadePai, $TabelaPai, 'idt', 'inscricao_estadual', 1);

$sql = "select subclasse, secao, divisao, grupo, classe, subclasse, descricao from cnae order by codigo";
$vetCampo['cnae'] = objCmbBanco('cnae', 'CNAE', true, $sql, ' -- ', 'width:480px;');

$vetCampo['principal'] = objCmbVetor('principal', 'Principal', True, $vetSimNao, '');

//
$vetFrm = Array();
$vetFrm[] = Frame('<span>Entidade</span>', Array(
    Array($vetCampo[$CampoPricAvo]),
    Array($vetCampo[$CampoPricPai]),
        ), $class_frame, $class_titulo, $titulo_na_linha);


$vetFrm[] = Frame('<span>Local</span>', Array(
    Array($vetCampo['cnae']),
    Array($vetCampo['principal']),
        ), $class_frame, $class_titulo, $titulo_na_linha);

//MesclarCol($vetCampo['logradouro_pais'], 5);

$vetCad[] = $vetFrm;
?>