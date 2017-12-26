<?php
$idCampo = 'idt';
$Tela = "a �rea de Conhecimento";

$TabelaPrinc = "gec_area_conhecimento";
$AliasPric = "gec_ac";
$Entidade = "�rea de Conhecimento";
$Entidade_p = "�reas de Conhecimento";

$contlinfim = "Existem #qt �reas de Conhecimento.";

$tipoidentificacao = 'N';

$sql = 'select idt, descricao from '.db_pir_gec.'gec_programa ';

if ($_GET['idt_programa_padrao'] != '') {
    $sql .= ' where idt = '.null($_GET['idt_programa_padrao']);
}

$sql .= ' order by codigo ';
$Filtro = Array();
$Filtro['rs'] = execsql($sql);
$Filtro['id'] = 'idt';
$Filtro['nome'] = 'Programa';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['idt_programa'] = $Filtro;

$idt_programa = $vetFiltro['idt_programa']['valor'];

if ($vetFiltro['idt_programa']['valor'] == -1) { // TODOS OS PROGRAMAS
    $n1 = "N�vel 1";
    $n2 = "N�vel 2";
    $n3 = "N�vel 3";
    $t1 = "Todos os N�veis";
}

if ($vetFiltro['idt_programa']['valor'] == 1) { // SGC
    $n1 = "�rea";
    $n2 = "Subarea";
    $n3 = "Especialidade";
    $t1 = "Todas as �reas";
    $contlinfim = "Existem #qt �reas - Sub�reas - Especialidades.";
}

if ($vetFiltro['idt_programa']['valor'] == 4) { // SEBRAETEC
    $n1 = "Tema";
    $n2 = "Subtema";
    $n3 = "Servi�o";
    $t1 = "Todos os Temas";
    $contlinfim = "Existem #qt Temas - Subtemas - Servi�os.";
}

$vetNivelw = Array();
$vetNivelw['T'] = '-- Todos --';
$vetNivelw['1'] = '�rea';
$vetNivelw['2'] = 'Subarea';
$vetNivelw['3'] = 'Especialidade';

$Filtro = Array();
$Filtro['rs'] = $vetNivelw;
$Filtro['id'] = 'nivel';
$Filtro['js_tam'] = '0';
$Filtro['nome'] = 'N�vel ';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['nivel'] = $Filtro;

$sql = 'select idt_area, descricao from '.db_pir_gec.'gec_area_conhecimento ';
$sql .= ' where nivel = 1';
$sql .= ' order by descricao ';
$Filtro = Array();
$Filtro['rs'] = execsql($sql);
$Filtro['id'] = 'idt_area';
$Filtro['nome'] = '�rea';
$Filtro['LinhaUm'] = '-- Todas as �reas --';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['idt_area'] = $Filtro;

$Filtro = Array();
$Filtro['rs'] = 'Texto';
$Filtro['id'] = 'texto';
$Filtro['js_tam'] = '0';
$Filtro['nome'] = 'Texto';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['texto'] = $Filtro;

$vetTpArea = Array();
$vetTpArea['S'] = 'Sint�tica';
$vetTpArea['A'] = 'Anal�tica';

$vetListarCmbRegValido = Array(
    'tipo' => Array('A'),
);

if ($vetFiltro['idt_programa']['valor'] == '' or $vetFiltro['idt_programa']['valor'] == -1) {
    $vetCampo['gec_p_descricao'] = CriaVetTabela('Programa');
}

$vetCampo['codigo'] = CriaVetTabela('C�digo');
$vetCampo['descricao_estruturada'] = CriaVetTabela($n1."<br />".$n2."<br />".$n3."<br />");
$vetCampo['nivel'] = CriaVetTabela('N�vel?', 'descDominio', $vetNivelw);
$vetCampo['tipo'] = CriaVetTabela('Tipo?', 'descDominio', $vetTpArea);
$vetCampo['ativo'] = CriaVetTabela('Ativo?', 'descDominio', $vetSimNao);
$vetCampo['publica'] = CriaVetTabela('Publica?', 'descDominio', $vetSimNao);

$sql = "select ";
$sql .= " gec_a.*, ";
$sql .= " gec_p.descricao as gec_p_descricao, ";
$sql .= " concat_ws(' - ',  gec_a.descricao_n1, gec_a.descricao_n2, gec_a.descricao_n3) as {$campoDescListarCmb}";
$sql .= " from ".db_pir_gec."gec_area_conhecimento gec_a ";
$sql .= " inner join ".db_pir_gec."gec_programa gec_p on gec_p.idt = gec_a.idt_programa ";
$sql .= ' where ';
$sql .= ' ( ';
$sql .= ' lower(gec_a.codigo) like lower('.aspa($vetFiltro['texto']['valor'], '', '%').')';
$sql .= ' or lower(gec_a.descricao) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
$sql .= ' ) ';

if ($vetFiltro['idt_programa']['valor'] != "" and $vetFiltro['idt_programa']['valor'] != 0) {
    $sql .= " and gec_a.idt_programa = ".$vetFiltro['idt_programa']['valor'];
}

if ($vetFiltro['nivel']['valor'] != "" and $vetFiltro['nivel']['valor'] != "T") {
    $sql .= ' and gec_a.nivel <= '.$vetFiltro['nivel']['valor'];
}

if ($vetFiltro['idt_area']['valor'] != "" and $vetFiltro['idt_area']['valor'] != -1 and $vetFiltro['idt_area']['valor'] != 0) {
    $sql .= ' and gec_a.idt_area = '.null($vetFiltro['idt_area']['valor']);
}

if ($sqlOrderby == '') {
    $sqlOrderby = 'gec_a.codigo asc';
}

$vetOrderby = Array(
    'gec_a.codigo' => 'C�digo',
    'gec_ac_a.descricao' => '�rea',
    'gec_ac_as.descricao' => 'Sub�rea',
    'gec_ac_ae.descricao' => 'Especialidade',
);
