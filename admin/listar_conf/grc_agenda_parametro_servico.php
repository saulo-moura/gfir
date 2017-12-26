<?php
$idCampo = 'idt';
$Tela = "a Suspensão do Agendamento";
//
$TabelaPai   = "grc_agenda_parametro";
$AliasPai    = "grc_ap";
$EntidadePai = "Parâmetros do Agendamento";
$idPai       = "idt";
//
$TabelaPrinc      = "grc_agenda_parametro_servico";
$AliasPric        = "grc_aps";
$Entidade         = "Serviço do Agendamento";
$Entidade_p       = "Serviços do Agendamento";
$CampoPricPai     = "idt_parametro";


$barra_inc_h      = "Incluir um Novo Registro de {$Entidade}";
$contlinfim       = "Existem #qt {$Entidade_p}.";

$orderby = "";

//$sql_orderby=Array();

//
$Filtro = Array();
//$Filtro['campo']        = 'descricao';
//$Filtro['tabela']       = $TabelaPai;
$Filtro['id']             = 'idt';
$Filtro['nome']           = $EntidadePai;
//$Filtro['valor']        = trata_id($Filtro);
$Filtro['valor']          = 1;
$vetFiltro[$CampoPricPai] = $Filtro;
//
$Filtro = Array();
$Filtro['rs']       = 'Texto';
$Filtro['id']       = 'texto';
$Filtro['js_tam']   = '0';
$Filtro['nome']     = 'Texto';
$Filtro['valor']    = trata_id($Filtro);
$vetFiltro['texto'] = $Filtro;

$vetCampo = Array();
$vetCampo['ponto_atendimento'] = CriaVetTabela('Ponto Atendimento');
$vetCampo['servico']           = CriaVetTabela('Serviço');
$titulo = 'Ocorrências';
$TabelaPrinc      = "grc_agenda_parametro_servico";
$AliasPric        = "grc_aps";
$Entidade         = "Serviço  do Parâmetro ";
$Entidade_p       = "Serviços do Parâmetro ";
// Select para obter campos da tabela que serão utilizados no full
$orderby = "sca_os.descricao, grc_ae.descricao  ";
$sql  = "select {$AliasPric}.*, ";
$sql .= "       grc_ae.descricao as servico, ";
$sql .= "       sca_os.descricao as ponto_atendimento ";
$sql .= " from {$TabelaPrinc} {$AliasPric}  ";
$sql .= " inner join grc_atendimento_especialidade grc_ae on  grc_ae.idt = {$AliasPric}.idt_servico ";
$sql .= " inner join ".db_pir."sca_organizacao_secao sca_os on  sca_os.idt = {$AliasPric}.idt_ponto_atendimento";
//
$sql .= " where {$AliasPric}".'.idt_parametro = 1 ';


?>