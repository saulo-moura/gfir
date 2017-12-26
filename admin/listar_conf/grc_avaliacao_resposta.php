<?php
$idCampo = 'idt';
$Tela = "a Avaliaчуo";

$TabelaPrinc      = "grc_avaliacao";
$AliasPric        = "grc_a";
$Entidade         = "Avaliaчуo";
$Entidade_p       = "Avaliaчѕes";

$barra_inc_h = "Incluir um Novo Registro de {$Entidade}";
$contlinfim  = "Existem #qt {$Entidade_p}.";





$vetCampo['codigo']         = CriaVetTabela('Cѓdigo');
$vetCampo['descricao']      = CriaVetTabela('Descriчуo');
$vetCampo['org_avaliada']   = CriaVetTabela('Organizaчуo - Avaliada');
$vetCampo['avaliador']      = CriaVetTabela('Avaliador');
$vetCampo['org_avaliadora'] = CriaVetTabela('Organizaчуo - Avaliadora');

$sql   = "select {$AliasPric}.*,";
$sql  .= ' ent1.descricao as org_avaliada,';
$sql  .= ' ent2.descricao as avaliador,';
$sql  .= ' ent3.descricao as org_avaliadora';
$sql  .= " from {$TabelaPrinc} as {$AliasPric} ";
$sql .= " left outer join ".db_pir_gec."gec_entidade ent1 on ent1.idt = {$AliasPric}.idt_organizacao_avaliado";
$sql .= " left outer join ".db_pir_gec."gec_entidade ent2 on ent2.idt = {$AliasPric}.idt_avaliador";
$sql .= " left outer join ".db_pir_gec."gec_entidade ent3 on ent3.idt = {$AliasPric}.idt_organizacao_avaliador";
$sql .= " left outer join ".db_pir_gec."gec_entidade ent4 on ent4.idt = {$AliasPric}.idt_avaliado";
//$sql .= ' where ent4.codigo = '.aspa($_SESSION[CS]['g_login']);



