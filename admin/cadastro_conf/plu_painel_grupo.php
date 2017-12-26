<?php
$tabela = 'plu_painel_grupo';
$id = 'idt';

$_GET['idt0'] = $_GET['idCad'];
$botao_volta = "parent.btFechaCTC('".$_GET['session_cod']."');";
$botao_acao = '<script type="text/javascript">parent.btFechaCTC("'.$_GET['session_cod'].'");</script>';

$vetCampo['idt_painel'] = objFixoBanco('idt_painel', 'Painel', 'plu_painel', 'idt', 'descricao', 0);
$vetCampo['ordem'] = objInteiro('ordem', 'Ordem', true, 9);
$vetCampo['codigo'] = objTexto('codigo', 'Código', True, 50);
$vetCampo['descricao'] = objTexto('descricao', 'Descrição', true, 113, 255);
$vetCampo['mostra_item'] = objCmbVetor('mostra_item', 'Mostrar', True, $vetIcoGrid);
$vetCampo['move_item'] = objCmbVetor('move_item', 'Move o item?', True, $vetSimNao);
$vetCampo['passo'] = objCmbVetor('passo', 'Passo a Passo?', True, $vetSimNao);
$vetCampo['passo_tit'] = objCmbVetor('passo_tit', 'Titulo do Passo', True, $vetSimNao);
$vetCampo['layout_grid'] = objCmbVetor('layout_grid', 'Layout em grid?', True, $vetSimNao);
$vetCampo['texto_altura'] = objInteiro('texto_altura', 'Altura do Texto', True, 5);
$vetCampo['img_altura'] = objInteiro('img_altura', 'Altura da Imagem', True, 5);
$vetCampo['img_largura'] = objInteiro('img_largura', 'Largura da Imagem', True, 5);
$vetCampo['espaco_linha'] = objInteiro('espaco_linha', 'Espaçamento entre os itens (layout grid)', True, 5);
$vetCampo['img_margem_dir'] = objInteiro('img_margem_dir', 'Margem direita da imagem', True, 5);
$vetCampo['img_margem_esq'] = objInteiro('img_margem_esq', 'Margem esquerda da imagem', True, 5);

$vetCampo['tit_mostrar'] = objCmbVetor('tit_mostrar', 'Mostrar Titulo?', True, $vetSimNao);
$vetCampo['tit_bt_fecha'] = objCmbVetor('tit_bt_fecha', 'Botão Fecha', True, $vetBtFechaPainel);
$vetCampo['tit_font_tam'] = objInteiro('tit_font_tam', 'Tamanho da Fonte', false, 6);
$vetCampo['tit_font_cor'] = objTexto('tit_font_cor', 'Cor da Fonte', false, 6);
$vetCampo['tit_fundo'] = objTexto('tit_fundo', 'Cor do Fundo', false, 6);

$maxlength = 2000;
$style = "width:700px;";
$js = "";
$vetCampo['hint'] = objTextArea('hint', 'Hint', false, $maxlength, $style, $js);

$par = 'tit_bt_fecha,tit_font_tam,tit_font_cor,tit_fundo,hint';
$vetDesativa['tit_mostrar'][0] = vetDesativa($par);

$par = 'tit_bt_fecha';
$vetAtivadoObr['tit_mostrar'][0] = vetAtivadoObr($par);

$vetCampo['texto_font_tam'] = objInteiro('texto_font_tam', 'Tamanho da Fonte', false, 6);
$vetCampo['texto_ativ_font_cor'] = objTexto('texto_ativ_font_cor', 'Cor da Fonte Ativado', false, 6);
$vetCampo['texto_ativ_fundo'] = objTexto('texto_ativ_fundo', 'Cor do Fundo Ativado', false, 6);
$vetCampo['texto_desativ_font_cor'] = objTexto('texto_desativ_font_cor', 'Cor da Fonte Desativado', false, 6);
$vetCampo['texto_desativ_fundo'] = objTexto('texto_desativ_fundo', 'Cor do Fundo Desativado', false, 6);

MesclarCol($vetCampo['idt_painel'], 7);
MesclarCol($vetCampo['codigo'], 5);
MesclarCol($vetCampo['descricao'], 7);
MesclarCol($vetCampo['espaco_linha'], 5);

$vetFrm[] = Frame('Definição do Painel', Array(
    Array($vetCampo['idt_painel']),
    Array($vetCampo['ordem'], '', $vetCampo['codigo']),
    Array($vetCampo['descricao']),
    Array($vetCampo['mostra_item'], '', $vetCampo['move_item'], '', $vetCampo['passo'], '', $vetCampo['passo_tit']),
    Array($vetCampo['layout_grid'], '', $vetCampo['espaco_linha']),
        ));

$vetFrm[] = Frame('Definição da Imagem', Array(
    Array($vetCampo['img_altura'], '', $vetCampo['img_largura'], '', $vetCampo['img_margem_esq'], '', $vetCampo['img_margem_dir']),
        ));

$vetFrm[] = Frame('Definição do Texto', Array(
    Array($vetCampo['texto_altura'], '', $vetCampo['texto_font_tam'], '', $vetCampo['texto_ativ_font_cor'], '', $vetCampo['texto_ativ_fundo'], '', $vetCampo['texto_desativ_font_cor'], '', $vetCampo['texto_desativ_fundo']),
        ));

MesclarCol($vetCampo['hint'], 9);

$vetFrm[] = Frame('Definição do Titulo', Array(
    Array($vetCampo['tit_mostrar'], '', $vetCampo['tit_bt_fecha'], '', $vetCampo['tit_font_tam'], '', $vetCampo['tit_font_cor'], '', $vetCampo['tit_fundo']),
    Array($vetCampo['hint']),
        ));

$vetCampoLC = Array();
$vetCampoLC['cod_classificacao'] = CriaVetTabela('Classificação');
$vetCampoLC['nm_funcao'] = CriaVetTabela('Função');
$vetCampoLC['texto_cab'] = CriaVetTabela('Descrição');
$vetCampoLC['visivel'] = CriaVetTabela('Visível?', 'descDominio', $vetSimNao);

$sql = '';
$sql .= ' select pf.*, f.nm_funcao, f.cod_classificacao';
$sql .= ' from plu_painel_funcao pf';
$sql .= ' left outer join plu_funcao f on pf.id_funcao = f.id_funcao';
$sql .= ' where pf.idt_painel_grupo = $vlID';
$sql .= ' order by f.nm_funcao, pf.texto_cab';

$titulo = 'Funções do Painel';

$vetCampo['plu_painel_funcao'] = objListarConf('plu_painel_funcao', 'idt', $vetCampoLC, $sql, $titulo, true);

$vetParametros = Array(
    'width' => '100%',
);
$vetFrm[] = Frame('<span>Funções do Painel</span>', Array(
    Array($vetCampo['plu_painel_funcao']),
        ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);

$vetCad[] = $vetFrm;
