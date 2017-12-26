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

$TabelaPrinc      = "grc_evento_local";
$AliasPric        = "grc_el";
$Entidade         = "Local do Evento";
$Entidade_p       = "Locais do Evento";
$CampoPricPai     = "idt_evento";

$tabela = $TabelaPrinc;
// Fixa o item da tabela anterior (PAI)




if ($acao!="inc")
{
    $sql  = "select grc_eo.* from grc_evento_local grc_eo ";
    $sql .= " where grc_eo.idt = ".null($_GET['id']);
    $rs = execsql($sql);
    ForEach ($rs->data as $row) {
        $flag = $row['flag'];
    }


}

$id = 'idt';
$vetCampo[$CampoPricPai] = objFixoBanco($CampoPricPai, $EntidadePai, $TabelaPai, 'idt', 'descricao', 0);

$sql = "select idt, descricao from ".db_pir_gec."gec_endereco_tipo order by codigo";
$vetCampo['idt_evento_local_tipo'] = objCmbBanco('idt_evento_local_tipo', 'Tipo Endereço', true, $sql,'','width:180px;');

$vetCampo['ativo']     = objCmbVetor('ativo', 'Ativo?', True, $vetSimNao,'');


$vetCampo['idt_organizacao'] = objListarCmb('idt_organizacao', 'grc_organizacao_evento_cmb', 'Onde Será?', false);
$vetCampo['observacao']      = objTexto('observacao', 'Observação', false, 70, 255);


//

$vetParametros = Array(
    'consulta_cep' => true,
    'campo_uf' => 'logradouro_estado',
    'campo_cidade' => 'logradouro_municipio',
    'campo_bairro' => 'logradouro_bairro',
    'campo_logradouro' => 'logradouro',
    'tipo_uf' => 'cmb_texto',
);



$vetCampo['cep'] = objCEP('cep', 'CEP', true, $vetParametros);

//$vetCampo['cep']                    = objCEP('cep', 'CEP', True);


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


$class_frame_f = "class_frame_f";
$class_titulo_f = "class_titulo_f";

$class_frame_p = "class_frame_p";
$class_titulo_p = "class_titulo_p";


$class_frame = "class_frame";
$class_titulo = "class_titulo";
$titulo_na_linha = false;


$titulo_cadastro='ENDEREÇOS';

$vetParametros = Array(
    'situacao_padrao' => true,
);
$vetFrm[] = Frame("<span>$titulo_cadastro</span>", '', $class_frame_f, $class_titulo_f, $titulo_na_linha, $vetParametros);


$vetParametros = Array(
    'codigo_frm' => 'endereco01a',
    'controle_fecha' => 'A',
);


$vetFrm[] = Frame('<span>1 - IDENTIFICAÇÃO</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);


$vetParametros = Array(
    'codigo_pai' => 'endereco01a',
);

$vetFrm[] = Frame('<span>Entidade</span>', Array(
    Array($vetCampo[$CampoPricPai]),
),$class_frame,$class_titulo,$titulo_na_linha);




$vetFrm[] = Frame('<span>Local</span>', Array(
    Array($vetCampo['idt_organizacao'],'',$vetCampo['observacao']),
),$class_frame,$class_titulo,$titulo_na_linha);





MesclarCol($vetCampo['logradouro_pais'], 5);
$vetFrm[] = Frame('<span>Endereço</span>', Array(
    Array($vetCampo['idt_evento_local_tipo'],'',$vetCampo['cep'],'',$vetCampo['ativo']),

    Array($vetCampo['logradouro'],'',$vetCampo['logradouro_numero'],'',$vetCampo['logradouro_complemento']),
    Array($vetCampo['logradouro_bairro'],'',$vetCampo['logradouro_municipio'],'',$vetCampo['logradouro_estado']),
    Array($vetCampo['logradouro_pais']),
),$class_frame,$class_titulo,$titulo_na_linha);


$vetFrm[] = Frame('<span>Referência</span>', Array(
    Array($vetCampo['logradouro_referencia']),
),$class_frame,$class_titulo,$titulo_na_linha);



/*
$vetParametros = Array(
    'codigo_frm' => 'endereco_comunicacao',
    'controle_fecha' => 'F',
);
$vetFrm[] = Frame('<span>2 - COMUNICAÇÃO</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

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

$vetCampo['gec_entidade_comunicacao'] = objListarConf('gec_entidade_comunicacao', $idPai , $vetCampo, $sql, $titulo, false);

$vetParametros = Array(
    'codigo_pai' => 'endereco_comunicacao',
    'width' => '100%',
);

$vetFrm[] = Frame('<span>Comunicação</span>', Array(
    Array($vetCampo['gec_entidade_comunicacao']),
),$class_frame,$class_titulo,$titulo_na_linha, $vetParametros);


///////////////////////////// PARTE 03.............

$vetParametros = Array(
    'codigo_frm' => 'endereco_estrutura',
    'controle_fecha' => 'F',
);
$vetFrm[] = Frame('<span>3 - ESTRUTURA FÍSICA</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

//- comunicacao
$vetCampo = Array();
$vetCampo['codigo']    = CriaVetTabela('LOCAL');
$vetCampo['descricao'] = CriaVetTabela('Descrição');
$vetCampo['gec_eet_descricao']    = CriaVetTabela('TIPO');

$vetCampo['ativo']     = CriaVetTabela('Ativo?', 'descDominio', $vetSimNao );


$titulo = 'Estrutura Física (Locais)';


$TabelaPai   = "gec_entidade_endereco";
$AliasPai    = "gec_end";
$EntidadePai = "Dados do Endereço da Organização";
$idPai       = "idt";
//
$TabelaPrinc      = "gec_entidade_endereco_estrutura";
$AliasPric        = "gec_eee";
$Entidade         = "Estrutura do Endereço";
$Entidade_p       = "Estrutura do Endereço";
$CampoPricAvo     = "idt_entidade";
$CampoPricPai     = "idt_endereco";

$orderby = " {$AliasPric}.codigo ";

$sql  = "select {$AliasPric}.*, ";
$sql .= " gec_eet.descricao as gec_eet_descricao ";

$sql .= " from {$TabelaPrinc} {$AliasPric}  ";
$sql .= " inner join gec_entidade_estrutura_tipo gec_eet on  gec_eet.idt = {$AliasPric}.idt_tipo_estrutura";
$sql .= " where {$AliasPric}.{$CampoPricPai}".' = $vlID';
//$sql .= " where {$AliasPric}.{$CampoPricPai}".' = '.null($_GET['id']);
$sql .= " order by {$orderby}";
//p($sql);
//p($_GET);

$vetCampo['gec_entidade_endereco_estrutura'] = objListarConf('gec_entidade_endereco_estrutura', $idPai , $vetCampo, $sql, $titulo, false);

$vetParametros = Array(
    'codigo_pai' => 'endereco_estrutura',
    'width' => '100%',
);

$vetFrm[] = Frame('<span>Estrutura</span>', Array(
    Array($vetCampo['gec_entidade_endereco_estrutura']),
),$class_frame,$class_titulo,$titulo_na_linha, $vetParametros);
*/


$vetCad[] = $vetFrm;
?>
<script type="text/javascript">






</script>