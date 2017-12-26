<?php
$idCampo = 'idt';
$Tela = "o Documento";

$TabelaPrinc = db_pir_gec."gec_documento";
$AliasPric = "d";
$Entidade = "Documento";
$Entidade_p = "Documentos";

$contlinfim = "Existem #qt {$Entidade_p}.";

$Filtro = Array();
$Filtro['rs'] = 'Texto';
$Filtro['id'] = 'texto';
$Filtro['js_tam'] = '0';
$Filtro['nome'] = 'Texto';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['texto'] = $Filtro;

$vetCampo['codigo'] = CriaVetTabela('Cуdigo');
$vetCampo['sigla'] = CriaVetTabela('Sigla');
$tipo = '';
$vetDominio = '';
$tabela = '';
$classet_par = '';
$ndecimal = '2';
$classer_par = 'classer_par';
$vetCampo['descricao'] = CriaVetTabela('Descriзгo', $tipo, $vetDominio, $tabela, $classet_par, $ndecimal, $classer_par);
$vetCampo['nivel'] = CriaVetTabela('Analнtico?', 'descDominio', $vetSimNao);
$vetCampo['ativo'] = CriaVetTabela('Ativo?', 'descDominio', $vetSimNao);
$vetCampo['observacao'] = CriaVetTabela('Observaзгo');

$sql = '';
$sql .= " select {$AliasPric}.idt, {$AliasPric}.codigo, {$AliasPric}.sigla, {$AliasPric}.descricao, {$AliasPric}.observacao, {$AliasPric}.ativo,  {$AliasPric}.nivel,";
$sql .= " {$AliasPric}.descricao as {$campoDescListarCmb}";
$sql .= " from {$TabelaPrinc} {$AliasPric}";
$sql .= ' where 1 = 1';

if ($includeListarCmb !== true) {
    if ($vetFiltro['texto']['valor'] != '') {
        $sql .= ' and (lower('.$AliasPric.'.codigo) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
        $sql .= ' or lower('.$AliasPric.'.descricao) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
        $sql .= ' or lower('.$AliasPric.'.observacao) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
        $sql .= ' )';
    }

    if ($_GET['veio'] == 'SG') {
        $sql .= " and doc_sgtec = 'S'";
    }
    
    if ($_GET['veio'] == 'EV') {
        $sql .= " and tipo_documento = 'EV'";
    }
}

$sql .= " order by {$AliasPric}.codigo";
