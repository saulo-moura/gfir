<?php
$idCampo = 'idt';
$Tela = "a Gestão de Cupons";

$Filtro = Array();
$Filtro['rs'] = 'Texto';
$Filtro['id'] = 'texto';
$Filtro['js_tam'] = '0';
$Filtro['nome'] = 'Texto';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['texto'] = $Filtro;

$vetCampo['palavra_chave'] = CriaVetTabela('Palavra Chave');
$vetCampo['perc_desconto'] = CriaVetTabela('% Desconto', 'decimal');
$vetCampo['data_validade'] = CriaVetTabela('Data Validade', 'data');
$vetCampo['qtd_disponivel'] = CriaVetTabela('Qtd. Disponível');
$vetCampo['qtd_resevada'] = CriaVetTabela('Qtd. Reservada');
$vetCampo['qtd_utilizada'] = CriaVetTabela('Qtd. Utilizada');
$vetCampo['ativo'] = CriaVetTabela('Ativo?', 'descDominio', $vetSimNao);
$vetCampo['utilizacao_direta'] = CriaVetTabela('Aplicável a todos os eventos do Sebrae Bahia?', 'descDominio', $vetSimNao);

$sql = '';
$sql .= ' select *';
$sql .= ' from grc_evento_cupom';

if ($vetFiltro['texto']['valor'] != "") {
    $sql .= ' where ';
    $sql .= ' ( ';
    $sql .= '  lower(palavra_chave)      like lower(' . aspa($vetFiltro['texto']['valor'], '%', '%') . ')';
    $sql .= ' ) ';
}

$sql .= ' order by palavra_chave';
