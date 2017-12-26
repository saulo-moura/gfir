<?php
$idCampo = 'idt';
$Tela = "as Pendências do Atendimento";

$contlinfim = "Existem #qt Pendências.";

$tipoidentificacao = 'N';
$tipofiltro = 'S';
$comfiltro = 'A';
$comidentificacao = 'F';

$barra_inc_ap = false;
$barra_alt_ap = true;
$barra_con_ap = true;
$barra_exc_ap = false;
$barra_fec_ap = false;

$Filtro = Array();
$sql = "select distinct plu_u.id_usuario, plu_u.nome_completo ";
$sql .= " from grc_atendimento_pendencia grc_ap  ";
$sql .= " inner join plu_usuario plu_u on plu_u.id_usuario = grc_ap.idt_responsavel_solucao ";
$sql .= " where grc_ap.ativo = 'S'";
$sql .= ' order by plu_u.nome_completo';
$Filtro['rs'] = execsql($sql);
$Filtro['id'] = 'f_tutor';
$Filtro['id_select'] = 'id_usuario';
$Filtro['LinhaUm'] = ' ';
$Filtro['nome'] = 'Responsável pela Solução';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['f_tutor'] = $Filtro;

$vetCampo['plu_us_nome_completo'] = CriaVetTabela('Responsável pela Solução');
$vetCampo['protocolo'] = CriaVetTabela('Código');
$vetCampo['data'] = CriaVetTabela('Data de Abertura', 'data');
$vetCampo['plu_u_nome_completo'] = CriaVetTabela('Solicitante');
$vetCampo['observacao'] = CriaVetTabela('Assunto');

$sql = "select grc_ap.*, ";
$sql .= "       grc_a.protocolo as grc_a_protocolo, ";
$sql .= "       plu_u.nome_completo as plu_u_nome_completo, ";
$sql .= "       plu_us.nome_completo as plu_us_nome_completo ";
$sql .= " from grc_atendimento_pendencia grc_ap  ";
$sql .= " left outer join plu_usuario plu_u  on plu_u.id_usuario = grc_ap.idt_usuario ";
$sql .= " left outer join grc_atendimento grc_a  on grc_a.idt = grc_ap.idt_atendimento ";
$sql .= " left outer join plu_usuario plu_us on plu_us.id_usuario = grc_ap.idt_responsavel_solucao ";
$sql .= " where grc_ap.ativo = 'S'";

if ($vetFiltro['f_tutor']['valor'] > 0) {
    $sql .= " and grc_ap.idt_responsavel_solucao = ".null($vetFiltro['f_tutor']['valor']);
}