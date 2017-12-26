<?php
$idCampo = 'idt';
$Tela = "a Agenda";

$TabelaPrinc      = "grc_atendimento_agenda_painel";
$AliasPric        = "grc_aap";
$Entidade         = "Agenda do Painel";
$Entidade_p       = "Agendas do Painel";

$barra_inc_h = "Incluir um Novo Registro de {$Entidade}";
$contlinfim  = "Existem #qt {$Entidade_p}.";

$Filtro = Array();
$Filtro['rs']       = 'Texto';
$Filtro['id']       = 'texto';
$Filtro['js_tam']   = '0';
$Filtro['nome']     = 'Texto';
$Filtro['valor']    = trata_id($Filtro);
$vetFiltro['texto'] = $Filtro;

$orderby = "{$AliasPric}.data";

$vetCampo['data']    = CriaVetTabela('Data','data');
$vetCampo['dia_semana'] = CriaVetTabela('Dia');
$vetCampo['hora'] = CriaVetTabela('Hora');
$vetCampo['situacao'] = CriaVetTabela('Situação');

$vetCampo['pu_cliente_consultor'] = CriaVetTabela('Cliente <br />Consultor');

$vetCampo['telefone'] = CriaVetTabela('Telefone');
$vetCampo['hora_confirmacao'] = CriaVetTabela('Hora<br />Conf.');
$vetCampo['hora_chegada'] = CriaVetTabela('Hora<br />Che.');
$vetCampo['hora_liberacao'] = CriaVetTabela('Hora<br />Lib.');
$vetCampo['hora_atendimento'] = CriaVetTabela('Hora<br />Aten.');
$vetCampo['especialidade_ponto'] = CriaVetTabela('Especialidade <br />Ponto Atendimento');
$vetCampo['origem'] = CriaVetTabela('Origem');

$vetCampo['agenda_data_hora'] = CriaVetTabela('Data <br />Hora');
$vetCampo['box_painel'] = CriaVetTabela('Box <br />Painel');
$vetCampo['status_painel'] = CriaVetTabela('Status');
$vetCampo['protocolo'] = CriaVetTabela('Protocolo');


$sql   = "select ";
$sql  .= "   {$AliasPric}.*, gae.descricao as gae_descricao,  ";
$sql  .= "   ge.descricao as ge_descricao,  ";
$sql  .= "   pu.nome_completo as pu_nome_completo,  ";
$sql  .= "  concat_ws('<br />', ge.descricao, pu.nome_completo) as pu_cliente_consultor,  ";

$sql  .= "   sos.descricao as sos_descricao,  ";
$sql  .= "  concat_ws('<br />', gae.descricao, sos.descricao) as especialidade_ponto,  ";

$sql  .= "   gaa.data as gaa_data, gaa.data as gaa_hora,  ";
$sql  .= "  concat_ws('<br />', gaa.data, gaa.hora) as agenda_data_hora,  ";

$sql  .= "   gab.descricao as gab_descricao,  ";
$sql  .= "   gap.descricao as gap_descricao,  ";
$sql  .= "  concat_ws('<br />', gab.descricao, gap.descricao) as box_painel  ";


$sql  .= " from {$TabelaPrinc} as {$AliasPric} ";
$sql  .= " left  join grc_atendimento_especialidade as gae on gae.idt = .{$AliasPric}.idt_especialidade ";
$sql  .= " left  join ".db_pir_gec."gec_entidade as ge on ge.idt = .{$AliasPric}.idt_cliente ";
$sql  .= " left  join plu_usuario as pu on pu.id_usuario = .{$AliasPric}.idt_consultor ";
$sql  .= " left  join ".db_pir."sca_organizacao_secao as sos on sos.idt = .{$AliasPric}.idt_ponto_atendimento ";

$sql  .= " left  join grc_atendimento_agenda as gaa on gaa.idt = .{$AliasPric}.idt_atendimento_agenda ";
$sql  .= " left  join grc_atendimento_box as gab on gab.idt = .{$AliasPric}.idt_atendimento_box ";
$sql  .= " left  join grc_atendimento_painel as gap on gap.idt = .{$AliasPric}.idt_atendimento_painel ";




if ($vetFiltro['texto']['valor']!="")
{
    $sql .= ' where ';
    $sql .= ' ( ';
    $sql .= '  lower('.$AliasPric.'.data)      like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
//    $sql .= ' or lower('.$AliasPric.'.hora)    like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' ) ';
}
$sql  .= " order by {$orderby}";

?>
