<?php
$idCampo = 'idt';
$Tela = "o Produto";

$TabelaPrinc = "grc_produto";
$AliasPric = "grc_pro";
$Entidade = "Produto";
$Entidade_p = "Produtos";
$barra_inc_h = "Incluir um Novo Registro de {$Entidade}";
$contlinfim = "Existem #qt {$Entidade_p}.";

$tipofiltro = 'S';
$comfiltro = 'A';

$sql = "select idt,  descricao from ".db_pir_gec."gec_programa ";
$sql .= " order by codigo";
$rs = execsql($sql);
$Filtro = Array();
$Filtro['rs'] = $rs;
$Filtro['id'] = 'idt';
$Filtro['js_tam'] = '0';
$Filtro['LinhaUm'] = '-- Todos os Programas --';
$Filtro['nome'] = 'Programas';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['programa'] = $Filtro;

$sql = "select idt,  descricao from grc_foco_tematico ";
$sql .= " where ativo = 'S'";
$sql .= " order by codigo";
$rs = execsql($sql);
$Filtro = Array();
$Filtro['rs'] = $rs;
$Filtro['id'] = 'idt';
$Filtro['js_tam'] = '0';
$Filtro['LinhaUm'] = '-- Todas os Focos Temáticos --';
$Filtro['nome'] = 'Foco Temático';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['foco_tematico'] = $Filtro;

$sql = "select idt, codigo, descricao from grc_atendimento_instrumento ";
$sql .= " where nivel = 1";
$sql .= " order by codigo";
$rs = execsql($sql);
$Filtro = Array();
$Filtro['rs'] = $rs;
$Filtro['id'] = 'idt';
$Filtro['js_tam'] = '0';
$Filtro['LinhaUm'] = '-- Todos os Instrumentos --';
$Filtro['nome'] = 'Instrumentos';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['instrumentos'] = $Filtro;

$sql = "select distinct sca_os.idt,  sca_os.descricao from ".db_pir."sca_organizacao_secao sca_os ";
$sql .= " inner join grc_produto grc_p on grc_p.idt_secao_responsavel = sca_os.idt ";
$sql .= " order by classificacao";
$rs = execsql($sql);
$Filtro = Array();
$Filtro['rs'] = $rs;
$Filtro['id'] = 'idt';
$Filtro['js_tam'] = '0';
$Filtro['LinhaUm'] = '-- Todas as Unidades Responsáveis --';
$Filtro['nome'] = 'Unidade Responsável';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['idt_secao_responsavel'] = $Filtro;

$Filtro = Array();
$Filtro['rs'] = 'Texto';
$Filtro['id'] = 'texto';
$Filtro['js_tam'] = '0';
$Filtro['nome'] = 'Texto';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['texto'] = $Filtro;

// Vetor com campos da tela
$vetCampo['gec_prog_descricao'] = CriaVetTabela('Programa');
$vetCampo['grc_prft_descricao'] = CriaVetTabela('Foco Temático');
$vetCampo['grc_pri_descricao'] = CriaVetTabela('Instrumento');
$vetCampo['descricao'] = CriaVetTabela('Descrição do Produto');
$vetCampo['unidade'] = CriaVetTabela('Autora<br />Respo.');

$sql = "select ";
$sql .= "   {$AliasPric}.*,  ";
$sql .= "    CONCAT_WS('<br />',sca_os.sigla, sca_osr.sigla) as unidade,  ";
$sql .= "    grc_pri.descricao as grc_pri_descricao, ";
$sql .= "    grc_prft.descricao as grc_prft_descricao, ";
$sql .= "    gec_prog.descricao as gec_prog_descricao, ";
$sql .= "    {$AliasPric}.descricao as {$campoDescListarCmb}";

$sql .= " from {$TabelaPrinc} as {$AliasPric} ";

$sql .= " left join ".db_pir."sca_organizacao_secao sca_os on sca_os.idt = {$AliasPric}.idt_secao_autora ";
$sql .= " left join ".db_pir."sca_organizacao_secao sca_osr on sca_osr.idt = {$AliasPric}.idt_secao_responsavel ";
$sql .= " left join grc_atendimento_instrumento grc_pri on grc_pri.idt = {$AliasPric}.idt_instrumento ";
$sql .= " left join grc_foco_tematico grc_prft on grc_prft.idt = {$AliasPric}.idt_foco_tematico ";
$sql .= " left join ".db_pir_gec."gec_programa gec_prog on gec_prog.idt = {$AliasPric}.idt_programa ";

$sql .= " where {$AliasPric}.idt_produto_evento is null";
$sql .= " and {$AliasPric}.idt_produto_situacao = 5"; //Ativo no Sebrae/BA
$sql .= " and {$AliasPric}.ativo = 'S'";

if ($vetFiltro['programa']['valor'] != "" and $vetFiltro['programa']['valor'] != "-1") {
    $sql .= " and {$AliasPric}.idt_programa = ".null($vetFiltro['programa']['valor']);
}

if ($vetFiltro['idt_secao_responsavel']['valor'] != "" and $vetFiltro['idt_secao_responsavel']['valor'] != "-1") {
    $sql .= " and {$AliasPric}.idt_secao_responsavel = ".null($vetFiltro['idt_secao_responsavel']['valor']);
}

if ($vetFiltro['instrumentos']['valor'] != "" and $vetFiltro['instrumentos']['valor'] != "-1") {
    $sql .= " and {$AliasPric}.idt_instrumento = ".null($vetFiltro['instrumentos']['valor']);
}

if ($vetFiltro['foco_tematico']['valor'] != "" and $vetFiltro['foco_tematico']['valor'] != "-1") {
    $sql .= " and {$AliasPric}.idt_foco_tematico = ".null($vetFiltro['foco_tematico']['valor']);
}

if ($vetFiltro['texto']['valor'] != "") {
    $sql .= ' and ';
    $sql .= ' ( ';
    $sql .= '  lower('.$AliasPric.'.codigo)      like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' or lower('.$AliasPric.'.descricao) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' or lower('.$AliasPric.'.origem) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' or lower('.$AliasPric.'.detalhe) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' or lower('.$AliasPric.'.objetivo) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' or lower('.$AliasPric.'.complemento) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' or lower('.$AliasPric.'.palavra_chave) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' or lower('.$AliasPric.'.publico_alvo_texto) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' or lower('.$AliasPric.'.descricao_comercial) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' or lower('.$AliasPric.'.descricao_siac) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' or lower('.$AliasPric.'.codigo_siac) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' or lower('.$AliasPric.'.conteudo_programatico) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' or lower('.$AliasPric.'.codigo_classificacao_siac) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' ) ';
}