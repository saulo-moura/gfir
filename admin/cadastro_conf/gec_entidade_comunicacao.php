<?php

if ($_GET['idCad'] != '') {
   $_GET['idt0'] = $_GET['idCad'];
   $botao_volta = "parent.btFechaCTC('".$_GET['session_cod']."');";
   $botao_acao = '<script type="text/javascript">parent.btFechaCTC("'.$_GET['session_cod'].'");</script>';
}

$TabelaAvo   = "gec_entidade";
$AliasAvo    = "gec_en";
$EntidadeAvo = "Entidade";
$idAvo       = "idt";


$TabelaPai   = "gec_entidade_endereco";
$AliasPai    = "gec_end";
$EntidadePai = "Endereço da Organizacao";
$idPai       = "idt";


//
$TabelaPrinc      = "gec_entidade_comunicacao";
$AliasPric        = "gec_eco";
$Entidade         = "Comunicação da Entidade";
$Entidade_p       = "Comunicações da Entidade";

$CampoPricAvo     = "idt_entidade";
$CampoPricPai     = "idt_endereco";

$tabela = $TabelaPrinc;

$id = 'idt';

$vetCampo[$CampoPricAvo] = objFixoBanco($CampoPricAvo, $EntidadeAvo, $TabelaAvo, 'idt', 'descricao', 0);


$vetCampo[$CampoPricPai] = objFixoBanco($CampoPricPai, $EntidadePai, $TabelaPai, 'idt', 'logradouro', 1);

//$sql = "select subclasse, secao, divisao, grupo, classe, subclasse, descricao from cnae order by codigo";
//$vetCampo['cnae'] = objCmbBanco('cnae', 'CNAE', true, $sql,' -- ','width:480px;');

//$vetCampo['principal']     = objCmbVetor('principal', 'Principal', True, $vetSimNao,'');

$vetCampo['origem'] = objTexto('origem', 'Local da Comunicação', false, 70, 120);

$vetCampo['telefone_1'] = objTexto('telefone_1', 'Telefone 1', false, 30, 45);
$vetCampo['telefone_2'] = objTexto('telefone_2', 'Telefone 2', false, 30, 45);

$vetCampo['sms_1'] = objTexto('sms_1', 'SMS 1', false, 30, 45);
$vetCampo['sms_2'] = objTexto('sms_2', 'SMS 2', false, 30, 45);

//function objEmail($campo, $nome, $valida, $size, $maxlength = '', $mostraemail = '') {

$vetCampo['email_1'] = objEmail('email_1', 'EMAIL 1', false, 50, 120,'S');
$vetCampo['email_2'] = objEmail('email_2', 'EMAIL 2', false, 50, 120,'S');

$vetCampo['www_1'] = objURL('www_1', 'WWW 1', false, 50, 120);
$vetCampo['www_2'] = objURL('www_2', 'WWW 2', false, 50, 120);
//MesclarCol($vetCampo['logradouro_pais'], 5);

//
$vetFrm = Array();
$vetFrm[] = Frame('<span>Identificação</span>', Array(
    Array($vetCampo[$CampoPricAvo]),
    Array($vetCampo[$CampoPricPai]),
    Array($vetCampo['origem']),
),$class_frame,$class_titulo,$titulo_na_linha);


$vetFrm[] = Frame('<span>Telefones</span>', Array(
    Array($vetCampo['telefone_1'],'',$vetCampo['telefone_2']),
),$class_frame,$class_titulo,$titulo_na_linha);

$vetFrm[] = Frame('<span>SMS</span>', Array(
    Array($vetCampo['sms_1'],'',$vetCampo['sms_2']),
),$class_frame,$class_titulo,$titulo_na_linha);

$vetFrm[] = Frame('<span>EMAIL</span>', Array(
    Array($vetCampo['email_1'],'',$vetCampo['email_2']),
),$class_frame,$class_titulo,$titulo_na_linha);

$vetFrm[] = Frame('<span>WWW</span>', Array(
    Array($vetCampo['www_1'],'',$vetCampo['www_2']),
),$class_frame,$class_titulo,$titulo_na_linha);





$vetCad[] = $vetFrm;
?>