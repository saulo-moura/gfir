<?php
$ordFiltro  = false;
$idCampo    = 'idt';
$idCampoPar = 'gec_eai_idt';

$Tela        = "o  Arquivo de Interesse";
$TabelaPai   = "grc_atendimento";
$AliasPai    = "grc_at";
$EntidadePai = "Atendimento";
$idPai       = "idt";

$veio = $_SESSION[CS][$TabelaPai]['veio'];

if ($veio == "O") {
    $upCad = vetCad('', 'Organização', 'gec_organizacao');
} else {
    $upCad = vetCad('', 'Pessoa', 'gec_pessoa');
}

$mostrar    = true;
$cond_campo = '';
$cond_valor = '';
$prefixow   = 'listar';
//$imagem     = 'imagens/endereco_16.png';
//$goCad[] = vetCad('', 'Comunicação da Organização', 'gec_entidade_comunicacao', $prefixow, $mostrar, $imagem, $cond_campo, $cond_valor);

$TabelaPrinc  = "grc_atendimento_arquivo_interesse";
$AliasPric    = "gec_aai";
$Entidade     = "O arquivo de Interesse";
$Entidade_p   = "O arquivo de Interesse";
$CampoPricPai = "idt_atendimento";

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
$vetCampo['titulo']       = CriaVetTabela('Título');
$vetCampo['arquivo']             = CriaVetTabela('Arquivo','arquivo','gec_entidade_arquivo_interesse');
$vetCampo['plu_usu_nome_completo']  = CriaVetTabela('Responsável');
$vetCampo['data_registro']          = CriaVetTabela('Data Registro');
//
$sql  = "select {$AliasPric}.*, ";
$sql .= "        plu_usu.nome_completo as plu_usu_nome_completo ";
$sql .= " from {$TabelaPrinc} {$AliasPric}  ";
$sql .= " inner join {$TabelaPai} {$AliasPai} on  {$AliasPai}.idt = {$AliasPric}.{$CampoPricPai}";
$sql .= " left  join plu_usuario plu_usu on  plu_usu.id_usuario = {$AliasPric}.idt_responsavel";

$sql .= " where {$AliasPric}.{$CampoPricPai} = ".null($vetFiltro[$CampoPricPai]['valor']);
if ($vetFiltro['texto']['valor'] != '') {
    $sql .= ' and ( ';
    $sql .= ' lower('.$AliasPric.'.titulo) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' or lower(plu_usu.nome_completo) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' ) ';
}
$orderby = "{$AliasPric}.titulo ";
$sql .= " order by {$orderby}";
?>
//