<?php
$idCampo = 'idt';
$Tela = "a Pergunta e Resposta";

$TabelaPrinc      = "grc_pergunta_resposta";
$AliasPric        = "grc_pr";
$Entidade         = "Pergunta da Resposta";
$Entidade_p       = "Perguntas da Resposta";

$barra_inc_h      = "Incluir um Novo Registro de {$Entidade}";
$contlinfim       = "Existem #qt {$Entidade_p}.";


$tipoidentificacao = 'N';
$tipofiltro = 'S';
$comfiltro = 'A';
$comidentificacao = 'F';

$Filtro = Array();
$Filtro['rs']       = 'Texto';
$Filtro['id']       = 'texto';
$Filtro['js_tam']   = '0';
$Filtro['nome']     = 'Texto';
$Filtro['valor']    = trata_id($Filtro);
$vetFiltro['texto'] = $Filtro;

//Monta o vetor de Campo
$vetCampo['pergunta'] = CriaVetTabela('Pergunta');
$vetCampo['resposta'] = CriaVetTabela('Resposta');
$vetCampo['plu_usu_nome_completo'] = CriaVetTabela('Pessoa Responsável');
$vetCampo['sca_os_descricao'] = CriaVetTabela('Unidade Responsável');
$vetCampo['ativo'] = CriaVetTabela('Ativo?','descDominio');

$sql   = "select grc_pr.*, ";
$sql  .= "    plu_usu.nome_completo as plu_usu_nome_completo, ";
$sql  .= "    sca_os.descricao as sca_os_descricao  ";
$sql  .= "  from grc_pergunta_resposta grc_pr ";
$sql  .= " left join plu_usuario plu_usu on plu_usu.id_usuario = {$AliasPric}.idt_consultor ";
$sql  .= " left join ".db_pir."sca_organizacao_secao sca_os on sca_os.idt = {$AliasPric}.idt_unidade_responsavel ";
if ($vetFiltro['texto']['valor']!="")
{
    $sql .= ' and ';
    $sql .= ' ( ';
    $sql .= '  lower('.$AliasPric.'.pergunta)   like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' or lower('.$AliasPric.'.resposta) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' or lower(plu_usu.nome_completo) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' or lower(sca_os.descricao) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' ) ';
}
// $sql  .= " order by {$orderby}";

if ($sqlOrderby == '') {
        $sqlOrderby = " pergunta ";
}


?>