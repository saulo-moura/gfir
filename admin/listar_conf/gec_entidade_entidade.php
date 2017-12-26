<?php
$idCampo = 'idt';
$Tela = "o Relacionamento da Entidade";
//
$TabelaPai   = "gec_entidade";
$AliasPai    = "gec_en";
$EntidadePai = "Entidade";
$idPai       = "idt";
//
//$upCad   = vetCad('', $EntidadePai, $TabelaPai);
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
$TabelaPrinc      = "gec_entidade_entidade";
$AliasPric        = "gec_ene";
$Entidade         = "Relacionamento da Entidade";
$Entidade_p       = "Relacionamentos da Entidade";
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
$orderby = " gec_er.codigo, gec_ef.descricao ";
//Monta o vetor de Campo

$vetCampo['gec_er_descricao']       = CriaVetTabela('Tipo de Relaчуo');

$vetCampo['gec_ef_descricao']       = CriaVetTabela('Entidade Relacionada');

$vetCampo['observacao']             = CriaVetTabela('Observaчуo');
$vetCampo['ativo']                  = CriaVetTabela('Ativo?', 'descDominio', $vetSimNao );

//
$sql  = "select {$AliasPric}.*, ";
$sql .= "        gec_ef.descricao as gec_ef_descricao, ";
$sql .= "        gec_er.descricao as gec_er_descricao ";
//
$sql .= " from {$TabelaPrinc} {$AliasPric}  ";
$sql .= " inner join {$TabelaPai} {$AliasPai} on  {$AliasPai}.idt = {$AliasPric}.{$CampoPricPai}";
//
$sql .= " inner join gec_entidade gec_ep on  gec_ep.idt = {$AliasPric}.idt_entidade";
$sql .= " inner join gec_entidade gec_ef on  gec_ef.idt = {$AliasPric}.idt_entidade_relacionada";
//
$sql .= " inner join gec_entidade_relacao gec_er on  gec_er.idt = {$AliasPric}.idt_entidade_relacao";
//
$sql .= " where {$AliasPric}.{$CampoPricPai} = ".null($vetFiltro[$CampoPricPai]['valor']);
$sql .= ' and ( ';
$sql .= ' lower('.$AliasPric.'.observacao) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
$sql .= ' or lower(gec_er.codigo) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
$sql .= ' or lower(gec_er.descricao) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';

$sql .= ' or lower(gec_ef.codigo) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
$sql .= ' or lower(gec_ef.descricao) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';

$sql .= ' ) ';
$sql .= " order by {$orderby}";
?>