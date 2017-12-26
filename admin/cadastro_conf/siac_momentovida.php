<?php
$tabela = 'db_pir_siac.momentovida';
$id = 'idt';

$vetCampo['CodMomentoVida']          = objInteiro('CodMomentoVida', 'C�digo', True, 11, 11);
$vetCampo['DescMomentoVida']         = objTexto('DescMomentoVida', 'Descri��o', True, 40, 80);
$vetCampo['Situacao']                = objCmbVetor('Situacao', 'Situa��o', False, $vetSimNao);
$vetCampo['TipoPessoa']              = objCmbVetor('TipoPessoa', 'Tipo Pessoa', False, $vetFisicaJuridica);
$vetCampo['ClassificacaoPessoa']     = objInteiro('ClassificacaoPessoa', 'Classifica��o Pessoa', False, 6, 6);
$vetCampo['OperadorAnosAbertura']    = objTexto('OperadorAnosAbertura', 'Operador', False, 10, 10);
$vetCampo['QtdAnosAbertura']         = objInteiro('QtdAnosAbertura', 'Anos de Abertura', False, 6, 6);

$vetFrm = Array();
$vetFrm[] = Frame('<span>Identifica��o</span>', Array(
    Array($vetCampo['CodMomentoVida'],'',$vetCampo['DescMomentoVida']),
    Array($vetCampo['ClassificacaoPessoa'],'',$vetCampo['OperadorAnosAbertura'],'',$vetCampo['QtdAnosAbertura']),
    Array($vetCampo['TipoPessoa'],'',$vetCampo['Situacao']),
),$class_frame,$class_titulo,$titulo_na_linha);

$vetCad[] = $vetFrm;
?>
