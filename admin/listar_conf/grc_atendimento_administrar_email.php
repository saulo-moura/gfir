<?php
$ordFiltro  = false;
$idCampo    = 'idt';
$mostrar    = true;
$cond_campo = '';
$cond_valor = '';
$prefixow   = 'listar';

$TabelaPrinc  = "grc_atendimento_administrar_email";
$AliasPric    = "grc_aae";
$Entidade     = "Administrar Email e SMS";
$Entidade_p   = "Administrar Email e SMS";

$barra_inc_h = "Incluir um Novo Registro de {$Entidade}";
$contlinfim  = "Existem #qt {$Entidade_p}.";

$Filtro = Array();
$Filtro['rs']       = 'Texto';
$Filtro['id']       = 'gec_ee_texto';
$Filtro['js_tam']   = '0';
$Filtro['nome']     = 'Texto';
$Filtro['valor']    = trata_id($Filtro);
$vetFiltro['texto'] = $Filtro;
//
// Monta o vetor de Campo
//
$vetCampo=Array();
$vetCampo['codigo']                 = CriaVetTabela('Código');
$vetCampo['descricao']              = CriaVetTabela('Descrição');
$vetCampo['ativo']                  = CriaVetTabela('Ativo?','descDominio',$vetSimNao);
$vetCampo['plu_usu_nome_completo']  = CriaVetTabela('Responsável');
$vetCampo['data_registro']          = CriaVetTabela('Data Registro');
//
$sql  = "select {$AliasPric}.*, ";
$sql .= "        plu_usu.nome_completo as plu_usu_nome_completo ";
$sql .= " from {$TabelaPrinc} {$AliasPric}  ";
$sql .= " left  join plu_usuario plu_usu on  plu_usu.id_usuario = {$AliasPric}.idt_responsavel";
$sql .= " where 1 = 1 ";
if ($vetFiltro['texto']['valor'] != '') {
    $sql .= ' and ( ';
    $sql .= ' lower('.$AliasPric.'.titulo) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' or lower(plu_usu.nome_completo) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' ) ';
}
?>
