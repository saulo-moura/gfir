<?php
$idCampo = 'idt';
$Tela = "o Mercado da Entidade";
//
$TabelaPai   = "gec_entidade";
$AliasPai    = "gec_en";
$EntidadePai = "Entidade";
$idPai       = "idt";
$veio = $_SESSION[CS][$TabelaPai]['veio'];


$mostrar    = true;
$cond_campo = '';
$cond_valor = '';
$prefixow    = 'listar';
$imagem     = 'imagens/endereco_16.png';

if ($veio=="O")
{
    $upCad = vetCad('idt', 'Organização', 'gec_organizacao');
    $goCad[] = vetCad('idt,idt', 'Produtos do Mercados da Organização', 'gec_entidade_mercado_produto', $prefixow, $mostrar, $imagem, $cond_campo, $cond_valor);

}
else
{
    $upCad = vetCad('idt', 'Pessoa', 'gec_pessoa');
    $goCad[] = vetCad('idt,idt', 'Produtos do Mercados da Pessoa', 'gec_entidade_mercado_produto', $prefixow, $mostrar, $imagem, $cond_campo, $cond_valor);

}


//
//$upCad   = vetCad('', $EntidadePai, $TabelaPai);


//
$TabelaPrinc      = "gec_entidade_mercado";
$AliasPric        = "gec_em";
$Entidade         = "Mercado da Entidade";
$Entidade_p       = "Mercados da Entidade";
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
$orderby = "gec_m.codigo, gec_mt.codigo";

//Monta o vetor de Campo
$vetCampo['gec_m_descricao']        = CriaVetTabela('Merdcado');
$vetCampo['gec_mt_descricao']       = CriaVetTabela('Tipo');
$vetCampo['data_inicio']            = CriaVetTabela('Data Inicio','data');
$vetCampo['data_termino']           = CriaVetTabela('Data Término','data');


$vetCampo['ativo']                  = CriaVetTabela('Ativo?', 'descDominio', $vetSimNao );

//
$sql  = "select {$AliasPric}.*, ";
$sql .= "        gec_m.descricao as gec_m_descricao, ";
$sql .= "        gec_mt.descricao as gec_mt_descricao ";
$sql .= " from {$TabelaPrinc} {$AliasPric}  ";
$sql .= " inner join {$TabelaPai} {$AliasPai} on  {$AliasPai}.idt = {$AliasPric}.{$CampoPricPai}";
//
$sql .= " inner join gec_mercado gec_m on  gec_m.idt = {$AliasPric}.idt_mercado ";

$sql .= " inner join gec_mercado_tipo gec_mt on  gec_mt.idt = {$AliasPric}.idt_tipo ";


$sql .= " where {$AliasPric}.{$CampoPricPai} = ".null($vetFiltro[$CampoPricPai]['valor']);
$sql .= ' and ( ';
$sql .= ' lower(gec_m.codigo) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
$sql .= ' or lower(gec_m.descricao) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
$sql .= ' or lower(gec_mt.codigo) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
$sql .= ' or lower(gec_mt.descricao) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';


$sql .= ' ) ';
$sql .= " order by {$orderby}";

//p($sql);


?>