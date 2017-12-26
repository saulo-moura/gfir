<?php
$um_registro = Array(
    'where' => 'idt_entidade = '.null($_GET['idt0']),
    'get_pai' => 'idt0',
    'volta_menu' => 'gec_pessoa',
);

$TabelaPai   = "gec_entidade";
$AliasPai    = "gec_en";
$EntidadePai = "Entidade";
$idPai       = "idt";

//
$TabelaPrinc      = "gec_entidade_pessoa";
$AliasPric        = "gec_ep";
$Entidade         = "Dado da Pessoa";
$Entidade_p       = "Dado da Pessoa";
$CampoPricPai     = "idt_entidade";

$tabela = $TabelaPrinc;

$id = 'idt';
$vetCampo[$CampoPricPai] = objFixoBanco($CampoPricPai, $EntidadePai, $TabelaPai, 'idt', 'descricao', 0);


$vetCampo['ativo']        = objCmbVetor('ativo', 'Ativo?', True, $vetSimNao,'');
$vetCampo['rg_numero']              = objTexto('rg_numero', 'RG - Número', True, 20, 45);
$vetCampo['rg_data']          = objData('rg_data', 'RG - Data Expedição', False);
$vetCampo['rg_orgao']              = objTexto('rg_orgao', 'RG - Órgão Expedidor', True, 20, 45);
$vetCampo['rg_estado']              = objTexto('rg_estado', 'RG - Estado Expedidor', True, 20, 45);





//
$vetFrm = Array();

if (!$MesclarCadastro) {
$vetFrm[] = Frame('<span>Entidade</span>', Array(
    Array($vetCampo[$CampoPricPai]),
),$class_frame,$class_titulo,$titulo_na_linha);
}

MesclarCol($vetCampo['ativo'], 7);

$vetFrm[] = Frame('<span>Dados</span>', Array(
    Array($vetCampo['ativo']),
    Array($vetCampo['rg_numero'],'',$vetCampo['rg_data'],'',$vetCampo['rg_orgao'],'',$vetCampo['rg_estado']),
),$class_frame,$class_titulo,$titulo_na_linha);


$vetCad[] = $vetFrm;
?>