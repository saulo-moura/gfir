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
$TabelaPrinc      = "gec_entidade_endereco";
$AliasPric        = "gec_ee";
$Entidade         = "Endereço da Entidade";
$Entidade_p       = "Endereços da Entidade";
$CampoPricPai     = "idt_entidade";

$tabela = $TabelaPrinc;

$id = 'idt';
$vetCampo[$CampoPricPai] = objFixoBanco($CampoPricPai, $EntidadePai, $TabelaPai, 'idt', 'descricao', 0);

$sql = "select idt, descricao from gec_endereco_tipo order by codigo";
$vetCampo['idt_entidade_endereco_tipo'] = objCmbBanco('idt_entidade_endereco_tipo', 'Tipo Endereço', true, $sql,'','width:180px;');

$vetCampo['ativo']     = objCmbVetor('ativo', 'Ativo?', True, $vetSimNao,'');




//
$vetCampo['cep']                    = objCEP('cep', 'CEP', True);


$vetCampo['logradouro']             = objTexto('logradouro', 'Logradouro', True, 30, 120);
$vetCampo['logradouro_numero']      = objTexto('logradouro_numero', 'Número', True, 30, 120);
$vetCampo['logradouro_complemento'] = objTexto('logradouro_complemento', 'Complemento', false, 30, 120);
$vetCampo['logradouro_bairro']      = objTexto('logradouro_bairro', 'Bairro', True, 30, 120);
$vetCampo['logradouro_municipio']   = objTexto('logradouro_municipio', 'Município', True, 30, 120);
$vetCampo['logradouro_estado']      = objTexto('logradouro_estado', 'Estado', True, 2, 2);
$vetCampo['logradouro_pais']        = objTexto('logradouro_pais', 'País', True, 30, 120);


$vetCampo['local']                  = objTexto('local', 'Local (departamento, Setor...) ', false, 50, 120);
$vetCampo['local_sigla']            = objTexto('local_sigla', 'Sigla do Local', false, 30, 120);

$vetCampo['telefone_01']            = objTexto('telefone_01', 'Telefone 1', false, 30, 120);
$vetCampo['telefone_02']            = objTexto('telefone_02', 'Telefone 2', false, 30, 120);

$vetCampo['email_01']               = objEmail('email_01', 'Email 1', false, 50, 120);
$vetCampo['email_02']               = objEmail('email_02', 'Email 2', false, 50, 120);


$maxlength  = 2000;
$style      = "width:700px;";
$js         = "";
$vetCampo['logradouro_referencia'] = objTextArea('logradouro_referencia', 'Referência', false, $maxlength, $style, $js);

//
$vetFrm = Array();
$vetFrm[] = Frame('<span>Entidade</span>', Array(
    Array($vetCampo[$CampoPricPai]),
),$class_frame,$class_titulo,$titulo_na_linha);


$vetFrm[] = Frame('<span>Local</span>', Array(
    Array($vetCampo['local_sigla'],'',$vetCampo['local']),
),$class_frame,$class_titulo,$titulo_na_linha);

MesclarCol($vetCampo['logradouro_pais'], 5);
$vetFrm[] = Frame('<span>Endereço</span>', Array(
    Array($vetCampo['idt_entidade_endereco_tipo'],'',$vetCampo['cep'],'',$vetCampo['ativo']),

    Array($vetCampo['logradouro'],'',$vetCampo['logradouro_numero'],'',$vetCampo['logradouro_complemento']),
    Array($vetCampo['logradouro_bairro'],'',$vetCampo['logradouro_municipio'],'',$vetCampo['logradouro_estado']),
    Array($vetCampo['logradouro_pais']),
),$class_frame,$class_titulo,$titulo_na_linha);

$vetFrm[] = Frame('<span>Referência</span>', Array(
    Array($vetCampo['logradouro_referencia']),
),$class_frame,$class_titulo,$titulo_na_linha);



//- comunicacao
$vetCampo = Array();
$vetCampo['origem']    = CriaVetTabela('LOCAL');
$vetCampo['telefone']  = CriaVetTabela('TELEFONE');
$vetCampo['sms']       = CriaVetTabela('SMS');
$vetCampo['email']     = CriaVetTabela('EMAIL');
$vetCampo['www']       = CriaVetTabela('WWW');


$titulo = 'Comunicação com a Organização';


$TabelaPai   = "gec_entidade_endereco";
$AliasPai    = "gec_end";
$EntidadePai = "Dados do Endereço da Organização";
$idPai       = "idt";
//
$TabelaPrinc      = "gec_entidade_comunicacao";
$AliasPric        = "gec_eco";
$Entidade         = "Comunicação da Entidade";
$Entidade_p       = "Comunicação da Entidade";
$CampoPricAvo     = "idt_entidade";
$CampoPricPai     = "idt_endereco";

$orderby = " {$AliasPric}.origem ";



$sql  = "select {$AliasPric}.*, ";
$sql .= " concat_ws('<br/>',telefone_1,telefone_2) as telefone, ";
$sql .= " concat_ws('<br/>',sms_1,sms_2) as sms, ";
$sql .= " concat_ws('<br/>',email_1,email_2) as email, ";
$sql .= " concat_ws('<br/>',www_1,www_2) as www ";
$sql .= " from {$TabelaPrinc} {$AliasPric}  ";


$sql .= " where {$AliasPric}.{$CampoPricPai}".' = $vlID';
//$sql .= " where {$AliasPric}.{$CampoPricPai}".' = '.null($_GET['id']);
$sql .= " order by {$orderby}";
//p($sql);
//p($_GET);

$vetCampo['gec_entidade_comunicacao'] = objListarConf('gec_entidade_comunicacao', $idPai , $vetCampo, $sql, $titulo, true);

$vetParametros = Array(
    'width' => '100%',
);
$vetFrm[] = Frame('<span>Comunicação</span>', Array(
    Array($vetCampo['gec_entidade_comunicacao']),
),$class_frame,$class_titulo,$titulo_na_linha, $vetParametros);

$vetCad[] = $vetFrm;
?>