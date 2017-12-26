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

$TabelaPrinc      = "grc_evento_ocorrencia";
$AliasPric        = "grc_eo";
$Entidade         = "Ocorrencia Associada ao Evento";
$Entidade_p       = "Ocorrencias Associada ao Evento";
$CampoPricPai     = "idt_evento";

// Barra de inclusгo e de totalizaзгo de registros (barra de rodapй) do full

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
  
 $upCad[] = vetCadUp('idt', $EntidadePai.': ', 'grc_produto', $texto);

//Monta o vetor de Campo

//$vetCampo['codigo']    = CriaVetTabela('Cуdigo');

$vetCampo['data']      = CriaVetTabela('Data','data');
$vetCampo['descricao'] = CriaVetTabela('Descriзгo');
$vetCampo['ativo']     = CriaVetTabela('Ativo?', 'descDominio', $vetSimNao );
$vetCampo['plu_usu_nome_completo'] = CriaVetTabela('Responsбvel');

//
$sql  = "select {$AliasPric}.*, ";
$sql  .= "       plu_usu.nome_completo as plu_usu_nome_completo ";
$sql .= " from {$TabelaPrinc} {$AliasPric}  ";
$sql .= " inner join {$TabelaPai} {$AliasPai} on  {$AliasPai}.idt = {$AliasPric}.{$CampoPricPai}";

//$sql .= " inner join grc_produto gec_pp on gec_pp.idt = {$AliasPric}.idt_produto ";

$sql .= " inner join plu_usuario plu_usu on plu_usu.id_usuario = {$AliasPric}.idt_responsavel ";





//
$sql .= " where {$AliasPric}.{$CampoPricPai} = ".null($vetFiltro[$CampoPricPai]['valor']);
$sql .= ' and ( ';
$sql .= ' lower('.$AliasPric.'.codigo) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
$sql .= ' or lower('.$AliasPric.'.descricao) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
$sql .= ' or lower('.$AliasPric.'.detalhe) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';

$sql .= ' ) ';

$orderby = "{$AliasPric}.codigo";

$sql .= " order by {$orderby}";
?>