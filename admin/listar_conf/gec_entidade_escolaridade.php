<?php
$idCampo = 'idt';
$Tela = "a Escolaridade da Pessoa";
//
$TabelaPai   = "gec_entidade";
$AliasPai    = "gec_en";
$EntidadePai = "Entidade";
$idPai       = "idt";
$veio = $_SESSION[CS][$TabelaPai]['veio'];

if ($veio=="O")
{
    $upCad = vetCad('idt', 'Organização', 'gec_organizacao');
}
else
{
    $upCad = vetCad('idt', 'Pessoa', 'gec_pessoa');
}

//
$TabelaPrinc      = "gec_entidade_escolaridade";
$AliasPric        = "gec_ee";
$Entidade         = "Escolaridade da Pessoa";
$Entidade_p       = "Escolaridades da Pessoa";
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
$orderby = "{$AliasPric}.ano_conclusao desc ";

//Monta o vetor de Campo
$vetCampo = Array();
//
$vetCampo['gec_egf_descricao']  = CriaVetTabela('Grau de Formação');
$vetCampo['gec_ecf_descricao']  = CriaVetTabela('Curso');
$vetCampo['plu_p_descricao']    = CriaVetTabela('País');
$vetCampo['cidade_estado']      = CriaVetTabela('Cidade/Estado');
$vetCampo['nome_entidade']      = CriaVetTabela('Nome Entidade');
$vetCampo['ano_conclusao']      = CriaVetTabela('Ano Conclusão');
$vetCampo['detalhe']            = CriaVetTabela('Observações');

//
$sql  = "select {$AliasPric}.*, ";
$sql .= "        plu_p.descricao   as plu_p_descricao, ";
$sql .= "        gec_ecf.descricao as gec_ecf_descricao, ";
$sql .= "        gec_egf.descricao as gec_egf_descricao ";
$sql .= " from {$TabelaPrinc} {$AliasPric}  ";
$sql .= " inner join {$TabelaPai} {$AliasPai} on  {$AliasPai}.idt = {$AliasPric}.{$CampoPricPai}";
//
$sql .= " inner join gec_entidade_curso_formacao gec_ecf on  gec_ecf.idt = {$AliasPric}.idt_curso_formacao ";
$sql .= " inner join gec_entidade_grau_formacao  gec_egf on  gec_egf.idt = {$AliasPric}.idt_grau_formacao ";
$sql .= " inner join plu_pais                    plu_p   on  plu_p.idt   = {$AliasPric}.idt_pais ";
//
$sql .= " where {$AliasPric}.{$CampoPricPai} = ".null($vetFiltro[$CampoPricPai]['valor']);
$sql .= ' and ( ';
$sql .= ' lower('.$AliasPric.'.nome_entidade) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
$sql .= ' or lower('.$AliasPric.'.cidade_estado) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
$sql .= ' ) ';
$sql .= " order by {$orderby}";

//p($sql);


?>