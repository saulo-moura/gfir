<?php
$_SESSION[CS]['pendencia_listar'] = $_SERVER['REQUEST_URI'];

$idCampo = 'idt';
$Tela = "as Pendкncias do Atendimento";
//
$TabelaPai = "grc_atendimento";
$AliasPai = "grc_a";
$EntidadePai = "Atendimento";
$idPai = "idt";
//
$TabelaPrinc = "grc_atendimento_pendencia";
$AliasPric = "grc_ap";
$Entidade = "Pendкncia do Atendimento";
$Entidade_p = "Pendкncias do Atendimento";
$CampoPricPai = "idt_atendimento";
//
$barra_inc_h = "Incluir um Novo Registro de {$Entidade}";
$contlinfim = "Existem #qt {$Entidade_p}.";
//
$orderby = "";
//
$tipoidentificacao = 'N';
$tipofiltro = 'S';
$comfiltro = 'A';
$comidentificacao = 'F';
//
$barra_inc_ap = false;
$barra_alt_ap = true;
$barra_con_ap = true;
$barra_exc_ap = false;
$barra_fec_ap = false;


$veio = $_GET['veio'];
if ($veio == 'AT') {
    //
    // veio da tela de atendimento
    //
      // Criar retorno para conteudo_atendimento_pendencia.php
    //p($_GET);
    $cont_arq = "_atendimento_pendencia";
}



$Filtro = Array();
$Filtro['rs'] = $vetSimNao;
$Filtro['id'] = 'f_ativo';
$Filtro['nome'] = 'Ativo';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['ativo'] = $Filtro;

$Filtro = Array();
$sql = '';
$sql .= ' select distinct tipo as f_tipo, tipo';
$sql .= ' from grc_atendimento_pendencia';
$sql .= ' order by tipo';
$Filtro['rs'] = execsql($sql);
$Filtro['id'] = 'f_tipo';
$Filtro['LinhaUm'] = '-- Selecione um Tipo --- ';
$Filtro['nome'] = 'Tipo';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['tipo'] = $Filtro;
//


$vetModo = Array();
$vetModo['1'] = 'Responsбvel pela Soluзгo';
$vetModo['2'] = 'Gerador da Pendкncia';

$Filtro = Array();
$Filtro['rs'] = $vetModo;
$Filtro['id'] = 'f_modo';
$Filtro['nome'] = 'Modo';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['modo'] = $Filtro;

if ($vetFiltro['modo']['valor'] == 2) {
    $barra_inc_ap = true;
    $barra_alt_ap = false;
    $barra_con_ap = true;
    $barra_exc_ap = false;
}

//
$Filtro = Array();
$Filtro['rs'] = 'Texto';
$Filtro['id'] = 'texto';
$Filtro['js_tam'] = '0';
$Filtro['nome'] = 'Texto';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['texto'] = $Filtro;

//
//  Monta o vetor de Campo
//
$vetCampo['protocolo'] = CriaVetTabela('Cуdigo');
$vetCampo['data'] = CriaVetTabela('Data de Abertura', 'data');
$vetCampo['tipo'] = CriaVetTabela('Tipo');
$vetCampo['plu_u_nome_completo'] = CriaVetTabela('Consultor/Atendente');
$vetCampo['observacao'] = CriaVetTabela('Assunto');
$vetCampo['status'] = CriaVetTabela('Status');
$vetCampo['data_solucao'] = CriaVetTabela('Prazo de Resoluзгo', 'data');
$vetCampo['plu_us_nome_completo'] = CriaVetTabela('Responsбvel pela Soluзгo');


$sql = " select concat('GRC', grc_ap.idt) as idt, grc_ap.protocolo, grc_ap.data, grc_ap.tipo, grc_ap.observacao, grc_ap.status, grc_ap.data_solucao,";
$sql .= ' plu_u.nome_completo as plu_u_nome_completo, plu_us.nome_completo as plu_us_nome_completo';
$sql .= " from {$TabelaPrinc} grc_ap  ";
$sql .= " left join plu_usuario plu_u  on plu_u.id_usuario  = grc_ap.idt_usuario ";
$sql .= " left  join plu_usuario plu_us on plu_us.id_usuario = grc_ap.idt_responsavel_solucao ";

if ($vetFiltro['modo']['valor'] != '1') {
    $sql .= " where  (  grc_ap.idt_usuario             = ".null($_SESSION[CS]['g_id_usuario'])."   ) ";
} else {
    $sql .= "   where  ( grc_ap.idt_responsavel_solucao = ".null($_SESSION[CS]['g_id_usuario'])."  ) ";
}

if ($vetFiltro['ativo']['valor'] != '' and $vetFiltro['ativo']['valor'] != '0') {
    $sql .= "    and ( grc_ap.ativo = ".aspa($vetFiltro['ativo']['valor'])." )";
}

if ($vetFiltro['tipo']['valor'] != '' && $vetFiltro['tipo']['valor'] != '0' && $vetFiltro['tipo']['valor'] != '-1') {
    $sql .= "    and ( grc_ap.tipo = ".aspa($vetFiltro['tipo']['valor'])." ) ";
}

$sql .= ' and ( ';
$sql .= ' lower(grc_ap.data) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
$sql .= ' or lower(grc_ap.observacao) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
$sql .= ' or lower(plu_u.nome_completo) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
$sql .= ' ) ';

$sql .= whereAtendimentoPendencia();

$sql .= "  union all ";

$sql .= " select concat('GEC', grc_ap.idt) as idt, grc_ap.protocolo, grc_ap.dt_registro as data, grc_ap.tipo, grc_ap.observacao, grc_ap.status, null as data_solucao,";
$sql .= ' plu_u.nome_completo as plu_u_nome_completo, plu_us.nome_completo as plu_us_nome_completo';
$sql .= " from ".db_pir_gec."gec_pendencia grc_ap  ";
$sql .= " left outer join ".db_pir_gec."plu_usuario plu_u  on plu_u.id_usuario  = grc_ap.idt_usuario_registro ";
$sql .= " left outer join ".db_pir_gec."plu_usuario plu_us on plu_us.id_usuario = grc_ap.idt_usuario_solucao ";

if ($vetFiltro['modo']['valor'] != '1') {
    $sql .= " where  (  grc_ap.idt_usuario_registro = ".null(IdUsuarioPIR($_SESSION[CS]['g_id_usuario'], db_pir_grc, db_pir_gec))."   ) ";
} else {
    $sql .= "   where  ( grc_ap.idt_usuario_solucao = ".null(IdUsuarioPIR($_SESSION[CS]['g_id_usuario'], db_pir_grc, db_pir_gec))."  ) ";
}

if ($vetFiltro['ativo']['valor'] != '' and $vetFiltro['ativo']['valor'] != '0') {
    $sql .= "    and ( grc_ap.ativo = ".aspa($vetFiltro['ativo']['valor'])." )";
}

if ($vetFiltro['tipo']['valor'] != '' && $vetFiltro['tipo']['valor'] != '0' && $vetFiltro['tipo']['valor'] != '-1') {
    $sql .= "    and ( grc_ap.tipo = ".aspa($vetFiltro['tipo']['valor'])." ) ";
}

$sql .= ' and ( ';
$sql .= ' lower(grc_ap.dt_registro) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
$sql .= ' or lower(grc_ap.observacao) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
$sql .= ' ) ';

$orderby = "{$AliasPric}.data desc";

//$sql .= " order by {$orderby}";

if ($sqlOrderby == '') {
    $sqlOrderby = "data desc";
}