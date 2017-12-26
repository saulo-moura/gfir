<?php
$tabela = 'plu_converte_texto';

$acao = 'alt';
$_GET['id']=1;

$id = 'idt';
$vetCampo['codigo']              = objTexto('codigo', 'C�digo', True, 15, 45);

$vetCampo['arquivo_municipio']   = objFile('arquivo_municipio', 'Arquivo Munic�pio', False, 120, 'todos');

$vetCampo['arquivo_regional']   = objFile('arquivo_regional', 'Arquivo Regional', False, 120, 'todos');



$vetCampo['arquivo_produto']     = objFile('arquivo_produto', 'Arquivo Produto SEBRAE_TEC', False, 120, 'todos');



$vetCampo['arquivo_produto_siac']     = objFile('arquivo_produto_siac', 'Arquivo Produto SIAC', False, 120, 'todos');

$vetCampo['arquivo_produto_siac_insumo']     = objFile('arquivo_produto_siac_insumo', 'Arquivo Produto SIAC INSUMO', False, 120, 'todos');


$vetCampo['arquivo_credenciado'] = objFile('arquivo_credenciado', 'Arquivo Credenciado', False, 120, 'todos');




$vetCampo['arquivo_projeto'] = objFile('arquivo_projeto', 'Arquivo Projeto', False, 120, 'todos');
$vetCampo['arquivo_projeto_acao'] = objFile('arquivo_projeto_acao', 'Arquivo Projeto A��o', False, 120, 'todos');
$vetCampo['arquivo_projeto_etapa'] = objFile('arquivo_projeto_etapa', 'Arquivo Projeto Etapa', False, 120, 'todos');
$vetCampo['arquivo_projeto_acao_metrica_fisica_ano'] = objFile('arquivo_projeto_acao_metrica_fisica_ano', 'Arquivo Projeto A��o M�trica F�sica Ano', False, 120, 'todos');
$vetCampo['arquivo_projeto_acao_metrica_orcamento_ano'] = objFile('arquivo_projeto_acao_metrica_orcamento_ano', 'Arquivo Projeto A��o M�trica Orcament�ria Ano', False, 120, 'todos');


$vetConverte=Array();
$vetConverte['M']='Municipio';
$vetConverte['R']='Regional';
$vetConverte['P']='Produto SEBRAE_TEC';
$vetConverte['S']='Produto SIAC';
$vetConverte['I']='Produto SIAC INSUMO';
$vetConverte['C']='Credenciado';
//
$vetConverte['PR']='Projeto';
$vetConverte['PA']='Projeto A��o';
$vetConverte['PE']='Projeto Etapa';
$vetConverte['PF']='Projeto A��o M�trica F�sica';
$vetConverte['PO']='Projeto A��o M�trica Or�ament�ria';


$vetConverte['SI']='Compatibiliza SIACWEB Projetos com SGE';

//
$vetCampo['tipo']                = objCmbVetor('tipo', 'Tipo?', false, $vetConverte);


//
$vetFrm = Array();
$vetFrm[] = Frame('<span>Identifica��o</span>', Array(
    Array($vetCampo['codigo']),
),$class_frame,$class_titulo,$titulo_na_linha);


$vetFrm[] = Frame('<span>Arquivos a Converter</span>', Array(
    Array($vetCampo['tipo']),
),$class_frame,$class_titulo,$titulo_na_linha);


$vetFrm[] = Frame('<span>Arquivos a Converter</span>', Array(
    Array($vetCampo['arquivo_municipio']),
    Array($vetCampo['arquivo_regional']),
    Array($vetCampo['arquivo_produto']),
    Array($vetCampo['arquivo_produto_siac']),
    Array($vetCampo['arquivo_produto_siac_insumo']),
    Array($vetCampo['arquivo_credenciado']),
),$class_frame,$class_titulo,$titulo_na_linha);


$vetFrm[] = Frame('<span>Arquivos do SGE</span>', Array(
    Array($vetCampo['arquivo_projeto']),
    Array($vetCampo['arquivo_projeto_acao']),
    Array($vetCampo['arquivo_projeto_etapa']),
    Array($vetCampo['arquivo_projeto_acao_metrica_fisica_ano']),
    Array($vetCampo['arquivo_projeto_acao_metrica_orcamento_ano']),
),$class_frame,$class_titulo,$titulo_na_linha);

/*
$vetFrm[] = Frame('<span>Resumo</span>', Array(
    Array($vetCampo['detalhe']),
),$class_frame,$class_titulo,$titulo_na_linha);
*/


$vetCad[] = $vetFrm;
?>