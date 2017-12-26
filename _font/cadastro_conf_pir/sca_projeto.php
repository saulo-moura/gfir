<?php
$tabela = 'sca_projeto';
$id = 'idt';


$sql = "select codigo, codigo, descricao from estado order by codigo";
$vetCampo['estado'] = objCmbBanco('estado', 'Unidade Federação', true, $sql,' ..Selecione.. ','width:180px;');
$vetCampo['descricao'] = objTexto('descricao', 'Projeto', True, 25, 120);
$vetCampo['imagem'] = objFile('imagem', 'Logomarca 218 x 218 px', True, 80, 'imagem', 218, 218);
$sql = "select idt, codigo, descricao from sca_projeto_situacao order by codigo";
$vetCampo['idt_situacao_projeto'] = objCmbBanco('idt_situacao_projeto', 'Status', true, $sql,' ..Selecione.. ','width:180px;');
$vetCampo['imagem_cabecalho'] = objFile('imagem_cabecalho', 'Imagem Cabeçalho Obra (560 x 150)', false, 80, 'imagem', 560, 150);
$vetCampo['imagem_home'] = objFile('imagem_home', 'Imagem da Home do Empreendimento (670 x 376)', false, 80, 'video', 700);


$vetCampo['ordem'] = objInteiroZero('ordem', 'Ordem', false, 3,3);

$vetCampo['dia_inicio_projeto'] = objCmbVetor('dia_inicio_projeto', 'Início do Projeto - Dia', true, $vetDia);
$vetCampo['mes_inicio_projeto'] = objCmbVetor('mes_inicio_projeto', 'Início do Projeto - Mês', true, $vetMes);
$vetCampo['ano_inicio_projeto'] = objCmbVetor('ano_inicio_projeto', 'Início do Projeto - Ano', true, $vetAno);


$vetCampo['dia_previsao'] = objCmbVetor('dia_previsao', 'Previsão Inicio Obra - Dia', false, $vetDia);
$vetCampo['mes_previsao'] = objCmbVetor('mes_previsao', 'Previsão Inicio Obra - Mês', false, $vetMes);
$vetCampo['ano_previsao'] = objCmbVetor('ano_previsao', 'Previsão Inicio Obra - Ano', false, $vetAno);

$vetCampo['ativo'] = objCmbVetor('ativo', 'Projeto Ativo?', True, $vetSimNao, '..Selecione..');




$vetCampo['endereco']    = objTexto('endereco', 'Endereço', false, 35, 120);
$vetCampo['complemento'] = objTexto('complemento', 'Complemento', false, 25, 45);
$vetCampo['numero']      = objTexto('numero', 'Número', false, 10, 45);

$vetCampo['bairro'] = objTexto('bairro', 'Bairro', false, 35, 120);
$vetCampo['cidade'] = objTexto('cidade', 'Cidade', false, 25, 120);
$vetCampo['cep'] = objCEP('cep', 'CEP', false, 10, 10);

$vetCampo['telefone'] = objTexto('telefone', 'telefones', false, 80, 120);
$vetCampo['fax'] = objTexto('fax', 'FAX', false, 80, 120);

$vetCampo['codigo_obra'] = objTexto('codigo_obra', 'Código Obra', false, 45, 120);


$vetFrm = Array();

$vetCampo['razao_social'] = objTexto('razao_social', 'Razão Social', false, 40, 120);
$vetCampo['cnpj'] = objCNPJ('cnpj', 'CNPJ', false, 18);
$vetCampo['inscricao_estadual'] = objTexto('inscricao_estadual', 'Inscrição Esatadual', false, 20, 45);
$vetCampo['inscricao_municipal'] = objTexto('inscricao_municipal', 'Inscrição Municipal', false, 20, 45);
$vetCampo['cei'] = objTexto('cei', 'CEI', false, 20, 45);

$vetCampo['codigo_dmm'] = objTexto('codigo_dmm', 'Código DMM Projeto', false, 5, 5);
$vetCampo['codigo_cta'] = objTexto('codigo_cta', 'Código Contábil Projeto', false, 5, 45);

//MesclarCol($vetCampo['idt_situacao_empreendimento'], 3);

$vetFrm[] = Frame(' Identificação ', Array(
    Array($vetCampo['descricao'],'',$vetCampo['codigo_dmm'],'',$vetCampo['codigo_cta']),
    Array($vetCampo['ativo'], ' ', $vetCampo['idt_situacao_projeto'], ' ', $vetCampo['estado']),

));

$vetFrm[] = Frame(' Datas ', Array(
    Array($vetCampo['dia_inicio_projeto'], '' ,$vetCampo['mes_inicio_projeto'], '' , $vetCampo['ano_inicio_projeto']),
    Array($vetCampo['dia_previsao'], '' , $vetCampo['mes_previsao'], '' , $vetCampo['ano_previsao']),
));

$vetFrm[] = Frame(' Logomarca ', Array(
    Array($vetCampo['imagem']),
));

MesclarCol($vetCampo['razao_social'], 3);

$vetFrm[] = Frame(' Identificação ', Array(
    Array($vetCampo['cnpj'],'',$vetCampo['razao_social']),
    Array($vetCampo['inscricao_estadual'],'',$vetCampo['inscricao_municipal'],'',$vetCampo['cei']),
));

MesclarCol($vetCampo['cep'], 5);
MesclarCol($vetCampo['telefone'], 5);
MesclarCol($vetCampo['fax'], 5);
//MesclarCol($vetCampo['idt_situacao_empreendimento'], 3);

$vetFrm[] = Frame(' Endereço ', Array(
    Array($vetCampo['endereco'], ' ', $vetCampo['complemento'], ' ', $vetCampo['numero']),
    Array($vetCampo['bairro'], ' ', $vetCampo['cidade'],'',$vetCampo['cep']),
    Array($vetCampo['telefone']),
    Array($vetCampo['fax']),

));

$vetCad[] = $vetFrm;
?>