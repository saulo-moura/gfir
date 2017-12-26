<?php
$um_registro = Array(
    'where' => 'idt_entidade = '.null($_GET['idt0']),
    'get_pai' => 'idt0',
    'volta_menu' => 'gec_organizacao',
);

$TabelaPai = "gec_entidade";
$AliasPai = "gec_en";
$EntidadePai = "Entidade";
$idPai = "idt";

//
$TabelaPrinc = "gec_entidade_organizacao";
$AliasPric = "gec_eo";
$Entidade = "Dado da Organização";
$Entidade_p = "Dado da Organização";
$CampoPricPai = "idt_entidade";

$tabela = $TabelaPrinc;

$id = 'idt';
$vetCampo[$CampoPricPai] = objFixoBanco($CampoPricPai, $EntidadePai, $TabelaPai, 'idt', 'descricao', 0);


$vetCampo['ativo'] = objCmbVetor('ativo', 'Ativo?', True, $vetSimNao, '');
$vetCampo['inscricao_estadual'] = objTexto('inscricao_estadual', 'Inscrição Estadual', True, 30, 120);
$vetCampo['inscricao_municipal'] = objTexto('inscricao_municipal', 'Inscrição Municipal', True, 30, 120);
$vetCampo['registro_junta'] = objTexto('registro_junta', 'Registro Junta', True, 30, 120);
$vetCampo['data_registro'] = objData('data_registro', 'Data Registro Junta', False);

$vetCampo['data_inicio_atividade'] = objData('data_inicio_atividade', 'Data Inicio Atividade', False);



$sql = "select idt, codigo, descricao from gec_organizacao_porte order by codigo";
$vetCampo['idt_porte'] = objCmbBanco('idt_porte', 'Porte', true, $sql, ' ', 'width:180px;');

$sql = "select idt, codigo, descricao from gec_organizacao_tipo order by codigo";
$vetCampo['idt_tipo'] = objCmbBanco('idt_tipo', 'Tipo', true, $sql, ' ', 'width:180px;');

$sql = "select idt, codigo, descricao from gec_organizacao_natureza_juridica order by codigo";
$vetCampo['idt_natureza_juridica'] = objCmbBanco('idt_natureza_juridica', 'Natureza Jurídica', true, $sql, ' ', 'width:380px;');





$sql = "select idt, codigo, descricao from gec_organizacao_faturamento order by codigo";
$vetCampo['idt_faturamento'] = objCmbBanco('idt_faturamento', 'Faixa de Faturamento', false, $sql, ' ', 'width:380px;');

$vetCampo['qt_funcionarios'] = objDecimal('qt_funcionarios', 'Quantidade Funcionarios', false, 10, '', '',2);

$vetCampo['faturamento'] = objDecimal('faturamento', 'Faturamento', false, 10, '', '',2);




//
if (!$MesclarCadastro) {
    $vetFrm = Array();
    $vetFrm[] = Frame('<span>Entidade</span>', Array(
        Array($vetCampo[$CampoPricPai]),
            ), $class_frame, $class_titulo, $titulo_na_linha);
}

//MesclarCol($vetCampo['data_registro'], 3);

$vetFrm[] = Frame('<span>Dados</span>', Array(
    Array($vetCampo['ativo'], '', $vetCampo['inscricao_estadual'], '', $vetCampo['inscricao_municipal']),
    Array($vetCampo['registro_junta'], '', $vetCampo['data_registro'], '', $vetCampo['data_inicio_atividade']),
        ), $class_frame, $class_titulo, $titulo_na_linha);

$vetFrm[] = Frame('<span>Classificação</span>', Array(
    Array($vetCampo['idt_natureza_juridica'], '', $vetCampo['idt_tipo']),

    Array($vetCampo['qt_funcionarios'], '', $vetCampo['idt_porte']),
    Array($vetCampo['faturamento'], '', $vetCampo['idt_faturamento']),



        ), $class_frame, $class_titulo, $titulo_na_linha);





//- cnae
$vetCampo = Array();
$vetCampo['principal'] = CriaVetTabela('Principal?', 'descDominio', $vetSimNao);
$vetCampo['cn_descricao'] = CriaVetTabela('CNAE');


$titulo = 'CNAEs da Organização';

$TabelaPrinc = "gec_entidade_cnae";
$AliasPric = "gec_ecn";
$Entidade = "CNAE da Entidade";
$Entidade_p = "CNAEs da Entidade";
$CampoPricAvo = "idt_entidade";
$CampoPricPai = "idt_entidade_organizacao";
$orderby = " {$AliasPric}.principal desc, cn.codigo ";

$sql = "select {$AliasPric}.*, ";
$sql .= "        cn.descricao as cn_descricao ";
$sql .= " from {$TabelaPrinc} {$AliasPric}  ";
//
$sql .= " inner join cnae cn on  cn.subclasse = {$AliasPric}.cnae ";
//
$sql .= " where {$AliasPric}.{$CampoPricPai}".' = $vlID';
$sql .= " order by {$orderby}";


$vetCampo['gec_entidade_cnae'] = objListarConf('gec_entidade_cnae', 'idt', $vetCampo, $sql, $titulo, true);

$vetParametros = Array(
    'width' => '100%',
);
$vetFrm[] = Frame('<span>CNAE</span>', Array(
    Array($vetCampo['gec_entidade_cnae']),
        ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);

$vetCad[] = $vetFrm;
?>