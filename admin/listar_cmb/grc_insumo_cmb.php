<?php
$idCampo = 'idt';
$Tela = "o Insumo";

$TabelaPrinc = "grc_insumo";
$AliasPric = "grc_ins";
$Entidade = "Insumo";
$Entidade_p = "Insumos";

$barra_inc_h = "Incluir um Novo Registro de {$Entidade}";
$contlinfim = "Existem #qt {$Entidade_p}.";

$comfiltro = 'A';
$veio = $_GET['veio'];

$Filtro = Array();
$Filtro['rs'] = 'Texto';
$Filtro['id'] = 'texto';
$Filtro['js_tam'] = '0';
$Filtro['nome'] = 'Texto';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['texto'] = $Filtro;

$orderby = "{$AliasPric}.classificacao";

$vetCampo['classificacao'] = CriaVetTabela('Código');
$vetCampo['codigo'] = CriaVetTabela('Código Reduzido');
$vetCampo['descricao'] = CriaVetTabela('Descrição');
$vetCampo['nivel'] = CriaVetTabela('Analítico?', 'descDominio', $vetSimNao);

$vetListarCmbRegValido = Array(
    'nivel' => Array('S'),
);



$sql = "select ";
$sql .= "   {$AliasPric}.*,  ";
$sql .= " concat_ws(' - ', codigo, descricao) as {$campoDescListarCmb}";
$sql .= " from {$TabelaPrinc} as {$AliasPric} ";
$sql .= " where {$AliasPric}.ativo = 'S'";

if ($veio == '') {
    if ($includeListarCmb !== true) {
        $sql .= " and {$AliasPric}.sebprodcrm = 'T'";
    }
} else {
    if ($veio == 'R') {
        $sinal = 'N';
    } else {
        $sinal = 'S';
        $sql .= " and {$AliasPric}.sebprodcrm = 'T'";
    }

    $sql .= " and {$AliasPric}.sinal = ".aspa($sinal);
}


if ($vetFiltro['texto']['valor'] != "") {
    $sql .= ' and ';
    $sql .= ' ( ';
    $sql .= '  lower('.$AliasPric.'.codigo)      like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' or lower('.$AliasPric.'.descricao) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' or lower('.$AliasPric.'.classificacao) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' or lower('.$AliasPric.'.detalhe) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' ) ';
}
$sql .= " order by {$orderby}";
