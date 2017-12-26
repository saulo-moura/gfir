<?php
$idCampo = 'idt';
$Tela = "a Contratar Credenciado";

$TabelaPrinc = db_pir_gec."gec_contratar_credenciado";
$AliasPric   = "gec_cc";
$Entidade    = "Contratar Credenciado";
$Entidade_p  = "contratos";

$barra_inc_h = "Incluir um Novo Registro de {$Entidade}";
$contlinfim  = "Existem #qt {$Entidade_p}.";

$Filtro = Array();
$Filtro['rs']       = 'Texto';
$Filtro['id']       = 'texto';
$Filtro['js_tam']   = '0';
$Filtro['nome']     = 'Texto';
$Filtro['valor']    = trata_id($Filtro);
$vetFiltro['texto'] = $Filtro;

$vetCampo['nan_contrato_ano']              = CriaVetTabela('Ano');
$vetCampo['gec_e_executora']               = CriaVetTabela('Empresa Executora');
$vetCampo['codigo']                        = CriaVetTabela('Número<br />Contrato');
//$vetCampo['nan_data_contrato']             = CriaVetTabela('Data<br /> do Contrato','data');
$vetCampo['sca_nan_ur'] = CriaVetTabela('Unidade Regional (UR)');

$vetCampo['nan_meta_atendimentos']         = CriaVetTabela('Meta Atendimentos(V1+V2)<br />(Quantidade)');
$vetCampo['nan_meta_atendimentos_aditivo'] = CriaVetTabela('Aditivo(V1+V2)<br />Meta Atendimentos<br />(Quantidade)');







$sql = '';
$sql .= " select {$AliasPric}.*, ";
$sql .= ' gec_e.descricao as gec_e_executora, ';
$sql .= ' sca_nan.descricao as sca_nan_ur ';

$sql .= " from {$TabelaPrinc} as {$AliasPric}";
$sql .= " left join ".db_pir_gec."gec_entidade gec_e on gec_e.idt = {$AliasPric}.idt_organizacao";
$sql .= " left join ".db_pir."sca_organizacao_secao sca_nan on sca_nan.idt = {$AliasPric}.nan_idt_unidade_regional";
$sql .= ' where gec_cc.nan_indicador = '.aspa('S');

if ($vetFiltro['texto']['valor'] != "") {
    $sql .= ' and ';
    $sql .= ' ( ';
    $sql .= '  lower('.$AliasPric.'.codigo)      like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' or lower('.$AliasPric.'.descricao) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' ) ';
}