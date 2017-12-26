<?php
$idCampo = 'idt';
$Tela = "o Mercado da Entidade";
//
$TabelaPai   = "gec_entidade";
$AliasPai    = "gec_en";
$EntidadePai = "Entidade";
$idPai       = "idt";
$veio = $_SESSION[CS][$TabelaPai]['veio'];

if ($veio=="O")
{
    $upCad = vetCad('idt', 'Organizaчуo', 'gec_organizacao');
}
else
{
    $upCad = vetCad('idt', 'Pessoa', 'gec_pessoa');
}

//
$TabelaPrinc      = "gec_entidade_area_conhecimento";
$AliasPric        = "gec_eac";
$Entidade         = "Сrea de Conhecimento da Entidade";
$Entidade_p       = "Сreas de Conhecimento da Entidade";
$CampoPricPai     = "idt_entidade";

$barra_inc_h      = "Incluir um Novo Registro de {$Entidade}";
$contlinfim       = "Existem #qt {$Entidade_p}.";




//
$Filtro = Array();
$Filtro['campo']  = 'descricao';
$Filtro['tabela'] = $TabelaPai;
$Filtro['id']     = 'idt';
$Filtro['nome']   = $EntidadePai;
$Filtro['valor']  = trata_id($Filtro);
$vetFiltro[$CampoPricPai] = $Filtro;
//
$Filtro = Array();
$Filtro['rs']       = 'Texto';
$Filtro['id']       = 'texto';
$Filtro['js_tam']   = '0';
$Filtro['nome']     = 'Texto';
$Filtro['valor']    = trata_id($Filtro);
$vetFiltro['texto'] = $Filtro;
//
$orderby = "gec_ac.descricao ";

//Monta o vetor de Campo
$vetCampo['gec_ac_descricao'] = CriaVetTabela('Сrea de Conhecimento');
$vetCampo['observacao']       = CriaVetTabela('Observaчуo');
//
$sql  = "select {$AliasPric}.*, ";
$sql .= "        gec_ac.descricao as gec_ac_descricao ";
$sql .= " from {$TabelaPrinc} {$AliasPric}  ";
$sql .= " inner join {$TabelaPai} {$AliasPai} on  {$AliasPai}.idt = {$AliasPric}.{$CampoPricPai}";
//
$sql .= " inner join gec_area_conhecimento gec_ac on  gec_ac.idt = {$AliasPric}.idt_area_conhecimento ";
$sql .= " where {$AliasPric}.{$CampoPricPai} = ".null($vetFiltro[$CampoPricPai]['valor']);
$sql .= ' and ( ';
$sql .= ' lower(gec_ac.descricao) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
$sql .= ' or lower(gec_eac.observacao) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
$sql .= ' ) ';
$sql .= " order by {$orderby}";

//p($sql);


?>