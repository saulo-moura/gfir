<?php
$ordFiltro  = false;
$idCampo    = 'idt';
$idCampoPar = 'gec_epe_idt';

$Tela        = "o  Tema Interesse";
$TabelaPai   = "grc_atendimento_pessoa";
$AliasPai    = "grc_atp";
$EntidadePai = "Atendimento Pessoa";
$idPai       = "idt";

$veio = $_SESSION[CS][$TabelaPai]['veio'];

$upCad = vetCad('', 'Pessoa', 'grc_atendimento_pessoa');

$mostrar    = true;
$cond_campo = '';
$cond_valor = '';
$prefixow   = 'listar';
//$imagem     = 'imagens/endereco_16.png';
//$goCad[] = vetCad('', 'Comunicação da Organização', 'gec_entidade_comunicacao', $prefixow, $mostrar, $imagem, $cond_campo, $cond_valor);

$TabelaPrinc  = "grc_atendimento_pessoa_tema_interesse";
$AliasPric    = "gec_apti";
$Entidade     = "Tema de Interesse da pessoa";
$Entidade_p   = "Temas de Interesse da Pessoa";
$CampoPricPai = "idt_atendimento_pessoa";

$barra_inc_h = "Incluir um Novo Registro de {$Entidade}";
$contlinfim  = "Existem #qt {$Entidade_p}.";

$Filtro = Array();
$Filtro['rs']    = 'Hidden';
$Filtro['id']    = 'entidade_situacao';
$Filtro['upCad'] = true;
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['situacao_pai'] = $Filtro;

$Filtro = Array();
$Filtro['rs']    = 'Hidden';
$Filtro['id']    = 'entidade_texto';
$Filtro['upCad'] = true;
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['texto_pai'] = $Filtro;
//
$Filtro = Array();
$Filtro['campo']     = 'descricao';
$Filtro['tabela']    = $TabelaPai;
$Filtro['id_select'] = 'idt';
$Filtro['id']        = 'entidade_idt';
$Filtro['nome']      = $EntidadePai;
$Filtro['valor']     = trata_id($Filtro);
$vetFiltro[$CampoPricPai] = $Filtro;
//
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
$vetCampo['grc_pt_descricao']       = CriaVetTabela('Tema');
$vetCampo['observacao']             = CriaVetTabela('Observação');
$vetCampo['plu_usu_nome_completo']  = CriaVetTabela('Responsável');
$vetCampo['data_registro']          = CriaVetTabela('Data Registro');
//
$sql = "select {$AliasPric}.*, ";
$sql .= "        plu_usu.nome_completo as plu_usu_nome_completo, ";
$sql .= "        grc_pt.descricao      as grc_pt_descricao ";
$sql .= " from {$TabelaPrinc} {$AliasPric}  ";
$sql .= " inner join {$TabelaPai} {$AliasPai} on  {$AliasPai}.idt = {$AliasPric}.{$CampoPricPai}";
$sql .= " left  join plu_usuario plu_usu on  plu_usu.id_usuario = {$AliasPric}.idt_responsavel";
$sql .= " left  join ".db_pir_grc."grc_tema_subtema grc_pt  on  grc_pt.idt = {$AliasPric}.idt_tema";

$sql .= " where {$AliasPric}.{$CampoPricPai} = ".null($vetFiltro[$CampoPricPai]['valor']);
if ($vetFiltro['texto']['valor'] != '') {
    $sql .= ' and ( ';
    $sql .= ' lower('.$AliasPric.'.observacao) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' or lower(grc_pt.descricao) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' or lower(plu_usu.nome_completo) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' ) ';
}
$orderby = "grc_pt.descricao ";
$sql .= " order by {$orderby}";
?>
//