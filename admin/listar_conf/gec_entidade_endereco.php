<?php
$idCampo = 'idt';
$Tela = "o Endereço da Entidade";
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

$mostrar    = true;
$cond_campo = '';
$cond_valor = '';
$prefixow    = 'listar';
$imagem     = 'imagens/endereco_16.png';
$goCad[] = vetCad('idt,idt', 'Comunicação da Organização', 'gec_entidade_comunicacao', $prefixow, $mostrar, $imagem, $cond_campo, $cond_valor);

//
//$upCad   = vetCad('', $EntidadePai, $TabelaPai);


//
$TabelaPrinc      = "gec_entidade_endereco";
$AliasPric        = "gec_ee";
$Entidade         = "Endereço da Entidade";
$Entidade_p       = "Endereços da Entidade";
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
$orderby = "gec_et.codigo";
//Monta o vetor de Campo
$vetCampo['gec_et_descricao']       = CriaVetTabela('Tipo');
$vetCampo['cep']                    = CriaVetTabela('CEP');
$vetCampo['logradouro']             = CriaVetTabela('Logradouro');
$vetCampo['logradouro_numero']      = CriaVetTabela('Número');
$vetCampo['logradouro_complemento'] = CriaVetTabela('Complemento');
$vetCampo['logradouro_bairro']      = CriaVetTabela('Bairro');
$vetCampo['logradouro_municipio']   = CriaVetTabela('Município');
$vetCampo['logradouro_estado']      = CriaVetTabela('Estado');
$vetCampo['ativo']                  = CriaVetTabela('Ativo?', 'descDominio', $vetSimNao );

//
$sql  = "select {$AliasPric}.*, ";
$sql .= "        gec_et.descricao as gec_et_descricao ";
$sql .= " from {$TabelaPrinc} {$AliasPric}  ";
$sql .= " inner join {$TabelaPai} {$AliasPai} on  {$AliasPai}.idt = {$AliasPric}.{$CampoPricPai}";
//
$sql .= " inner join gec_endereco_tipo gec_et on  gec_et.idt = {$AliasPric}.idt_entidade_endereco_tipo";
$sql .= " where {$AliasPric}.{$CampoPricPai} = ".null($vetFiltro[$CampoPricPai]['valor']);
$sql .= ' and ( ';
$sql .= ' lower('.$AliasPric.'.codigo) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
$sql .= ' or lower('.$AliasPric.'.cep) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';

$sql .= ' or lower('.$AliasPric.'.logradouro) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
$sql .= ' or lower('.$AliasPric.'.logradouro_numero) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
$sql .= ' or lower('.$AliasPric.'.logradouro_complemento) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
$sql .= ' or lower('.$AliasPric.'.logradouro_bairro) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
$sql .= ' or lower('.$AliasPric.'.logradouro_municipio) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
$sql .= ' or lower('.$AliasPric.'.logradouro_estado) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';

$sql .= ' or lower(gec_et.descricao) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';


$sql .= ' ) ';
$sql .= " order by {$orderby}";
?>