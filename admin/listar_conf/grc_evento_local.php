<?php
$idCampo = 'idt';
$Tela = "a Ocorrencia Associada ao Evento";
//
// Dados da tabela Pai (Nivel 1)

$TabelaPai   = "grc_evento";
$AliasPai    = "grc_e";
$EntidadePai = "Evento";
$idPai       = "idt";

//
// Dados da tabela atual (deste programa)

$TabelaPrinc      = "grc_evento_local";
$AliasPric        = "grc_el";
$Entidade         = "Local do Evento";
$Entidade_p       = "Locais do Evento";
$CampoPricPai     = "idt_evento";

// Barra de inclusão e de totalização de registros (barra de rodapé) do full

$barra_inc_h      = "Incluir um Novo Registro de {$Entidade}";
$contlinfim       = "Existem #qt {$Entidade_p}.";

$orderby = "";

//$sql_orderby=Array();

//  Filtro do PAI (Fixo) com o registro selecionado na tela PAI

$Filtro = Array();
//$Filtro['campo']  = 'descricao';
//$Filtro['tabela'] = $TabelaPai;
$Filtro['id']     = 'idt';
$Filtro['nome']   = $EntidadePai;
$Filtro['valor']  = trata_id($Filtro);
$vetFiltro[$CampoPricPai] = $Filtro;

//   Filtro para selecionar registros deste programa

$Filtro = Array();
$Filtro['rs']       = 'Texto';
$Filtro['id']       = 'texto';
$Filtro['js_tam']   = '0';
$Filtro['nome']     = 'Texto';
$Filtro['valor']    = trata_id($Filtro);
$vetFiltro['texto'] = $Filtro;
//
//  Seleciona os registros com a chave do pai igual a chave estrangeira da tabela
//  principal do full
//
    $texto="";
    $sql = 'select * from '.$TabelaPai.' where idt = '.null($vetFiltro[$CampoPricPai]['valor']);
    $rst = execsql($sql);
    if ($rst->rows != 0) {
        ForEach ($rst->data as $rowt) {
            $codigo    = $rowt['codigo'];
            $descricao = $rowt['descricao'];
        }
    }
    $texto=" $codigo - $descricao ";
    
  //  $upCad[] = vetCadUp('idt', $EntidadePai, 'gec_edital', $rst->data[0][0]);

 // Retorno para o nivel anterior...
  
 $upCad[] = vetCadUp('idt', $EntidadePai.': ', 'grc_evento', $texto);

//Monta o vetor de Campo

//$vetCampo['codigo']    = CriaVetTabela('Código');

$orderby = "gec_et.codigo";

//Monta o vetor de Campo
$vetCampo['gec_et_descricao'] = CriaVetTabela('Tipo');


$vetCampo['gec_et_ordem_contratacao'] = CriaVetTabela('Rodízio?', 'descDominio', $vetSimNao);

$vetCampo['cep']                    = CriaVetTabela('CEP');
$vetCampo['logradouro']             = CriaVetTabela('Logradouro');
$vetCampo['logradouro_numero']      = CriaVetTabela('Número');
$vetCampo['logradouro_complemento'] = CriaVetTabela('Complemento');
$vetCampo['logradouro_bairro']      = CriaVetTabela('Bairro');
$vetCampo['logradouro_municipio']   = CriaVetTabela('Município');
$vetCampo['logradouro_estado']      = CriaVetTabela('Estado');
$vetCampo['ativo'] = CriaVetTabela('Ativo?', 'descDominio', $vetSimNao);

$sql = "select {$AliasPric}.*, ";
$sql .= "        gec_et.descricao as gec_et_descricao, ";
$sql .= "        gec_et.ordem_contratacao as gec_et_ordem_contratacao ";

$sql .= " from {$TabelaPrinc} {$AliasPric}  ";
$sql .= " inner join {$TabelaPai} {$AliasPai} on  {$AliasPai}.idt = {$AliasPric}.{$CampoPricPai}";
$sql .= " inner join ".db_pir_gec."gec_endereco_tipo gec_et on  gec_et.idt = {$AliasPric}.idt_evento_local_tipo";
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