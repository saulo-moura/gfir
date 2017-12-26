<?php
$idCampo = 'idt';
$Tela = "a Pergunta da Sondagem do Agendamento";


$TabelaPrinc      = "grc_agenda_parametro_sondagem";
$AliasPric        = "grc_aps";
$Entidade         = "Sondagem da Agenda";
$Entidade_p       = "Sondagem da Agenda";

$barra_inc_h = "Incluir um Novo Registro de {$Entidade}";
$contlinfim  = "Existem #qt {$Entidade_p}.";

$Filtro = Array();
$Filtro['rs']       = 'Texto';
$Filtro['id']       = 'texto';
$Filtro['js_tam']   = '0';
$Filtro['nome']     = 'Texto';
$Filtro['valor']    = trata_id($Filtro);
$vetFiltro['texto'] = $Filtro;

$vetCampo['grc_apsg_descricao']    = CriaVetTabela('Grupo');
$vetCampo['codigo']    = CriaVetTabela('Cуdigo da Pergunta');
$vetCampo['descricao'] = CriaVetTabela('Descriзгo');
$vetCampo['ativo']     = CriaVetTabela('Ativo?', 'descDominio', $vetSimNao );

$sql   = "select ";
$sql  .= "   {$AliasPric}.*,  ";
$sql  .= "   grc_apsg.descricao as grc_apsg_descricao  ";
$sql  .= " from {$TabelaPrinc} as {$AliasPric} ";
$sql  .= " inner join grc_agenda_parametro_sondagem_grupo grc_apsg on grc_apsg.idt = grc_aps.idt_grupo ";




if ($vetFiltro['texto']['valor']!="")
{
    $sql .= ' where ';
    $sql .= ' ( ';
    $sql .= '  lower('.$AliasPric.'.codigo)      like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' or lower('.$AliasPric.'.descricao) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' ) ';
}

?>