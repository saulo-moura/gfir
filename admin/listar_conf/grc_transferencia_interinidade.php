<?php
$idCampo = 'idt';
$Tela = "a Transferência por Interinidade";

$TabelaPrinc = "grc_transferencia_responsabilidade";
$AliasPric = "grc_tr";
$Entidade = "Transferência por Interinidade";
$Entidade_p = "Transferências por Interinidade";

$barra_inc_h = "Incluir um Novo Registro de {$Entidade}";
$contlinfim = "Existem #qt {$Entidade_p}.";

$barra_alt_ap = false;
$barra_exc_ap = false;
$barra_fec_ap = false;
$barra_inc_ap = false;
$barra_con_ap = false;
$comcontrole = 0;

$comfiltro = 'A';

$Filtro = Array();
$Filtro['rs'] = 'Texto';
$Filtro['id'] = 'f_texto';
$Filtro['js_tam'] = '0';
$Filtro['nome'] = 'Texto';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['f_exto'] = $Filtro;

$vetCampo['descricao'] = CriaVetTabela('Descrição');
$vetCampo['uo_nome_completo'] = CriaVetTabela('Colaborador Origem');
$vetCampo['ud_nome_completo'] = CriaVetTabela('Colaborador Destino');
$vetCampo['dt_inicio'] = CriaVetTabela('Dt. Inicio', 'data');
$vetCampo['dt_validade'] = CriaVetTabela('Validade da Transferência', 'data');
$vetCampo['situacao'] = CriaVetTabela('Situação', 'descDominio', $vetSitTransRespInterinidade);

$sql = "select ";
$sql .= "   {$AliasPric}.*,  ";
$sql .= "   uo.nome_completo as uo_nome_completo,   ";
$sql .= "   ud.nome_completo as ud_nome_completo   ";
$sql .= " from {$TabelaPrinc} as {$AliasPric} ";
$sql .= " inner join plu_usuario uo on uo.id_usuario = {$AliasPric}.idt_colaborador_origem ";
$sql .= " inner join plu_usuario ud on ud.id_usuario = {$AliasPric}.idt_colaborador_destino ";
$sql .= " where tipo = 'I'";

if ($vetFiltro['f_texto']['valor'] != "") {
    $sql .= ' and ';
    $sql .= ' ( ';
    $sql .= '    lower('.$AliasPric.'.descricao) like lower('.aspa($vetFiltro['f_texto']['valor'], '%', '%').')';
    $sql .= ' or lower('.$AliasPric.'.justificativa) like lower('.aspa($vetFiltro['f_texto']['valor'], '%', '%').')';
    $sql .= ' ) ';
}