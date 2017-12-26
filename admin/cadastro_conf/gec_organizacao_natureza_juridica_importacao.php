<?php
$tabela = 'gec_organizacao_natureza_juridica_importacao';
$id = 'idt';

$vetCampo['codigo'] = objTexto('codigo', 'C�digo', True, 20, 45);
$vetCampo['descricao'] = objTexto('descricao', 'Descri��o', True, 60, 120);



$vetCampo['arquivo']      = objFile('arquivo', 'Arquivo .csv com Naturezas Jur�dicas', false, 60, 'todos');


$vetExecuta=Array();
$vetExecuta['E']='Exclui';
$vetExecuta['S']='Executa';
$vetCampo['executa'] = objCmbVetor('executa', 'Executa Importa��o do CNAE?', false, $vetExecuta);


$vetFrm = Array();
$vetFrm[] = Frame('<span>Identifica��o</span>', Array(
    Array($vetCampo['codigo'],'',$vetCampo['descricao']),
),$class_frame,$class_titulo,$titulo_na_linha);

$vetFrm[] = Frame('<span>Arquivo .CSV para Importa��o</span>', Array(
    Array($vetCampo['arquivo']),
    Array($vetCampo['executa']),
),$class_frame,$class_titulo,$titulo_na_linha);


$vetCad[] = $vetFrm;
?>