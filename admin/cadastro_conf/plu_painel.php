<?php
$tabela = 'plu_painel';
$id = 'idt';

$vetCampo['descricao'] = objTexto('descricao', 'Descrição', True, 80, 100);
$vetCampo['codigo'] = objTexto('codigo', 'Código', True, 45);
$vetCampo['classificacao'] = objTexto('classificacao', 'Classificação', True, 45, 200);

MesclarCol($vetCampo['descricao'], 3);

$vetFrm[] = Frame('Dados do Painel', Array(
    Array($vetCampo['descricao']),
    Array($vetCampo['codigo'], '', $vetCampo['classificacao']),
        ), $class_frame, $class_titulo, $titulo_na_linha);

$vetCampoLC = Array();
$vetCampoLC['ordem'] = CriaVetTabela('Ordem');
$vetCampoLC['codigo'] = CriaVetTabela('Código');
$vetCampoLC['descricao'] = CriaVetTabela('Descrição');
$vetCampoLC['mostra_item'] = CriaVetTabela('Mostrar', 'descDominio', $vetIcoGrid);
$vetCampoLC['move_item'] = CriaVetTabela('Move o item?', 'descDominio', $vetSimNao);
$vetCampoLC['passo'] = CriaVetTabela('Passo a Passo?', 'descDominio', $vetSimNao);
$vetCampoLC['layout_grid'] = CriaVetTabela('Layout em grid?', 'descDominio', $vetSimNao);

$sql = '';
$sql .= ' select *';
$sql .= ' from plu_painel_grupo';
$sql .= ' where idt_painel = $vlID';
$sql .= ' order by ordem, descricao';

$titulo = 'Grupos do Painel';

$vetCampo['plu_painel_grupo'] = objListarConf('plu_painel_grupo', 'idt', $vetCampoLC, $sql, $titulo, false);

$vetParametros = Array(
    'width' => '100%',
);
$vetFrm[] = Frame('<span>Grupos do Painel</span>', Array(
    Array($vetCampo['plu_painel_grupo']),
        ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);

$vetCad[] = $vetFrm;
