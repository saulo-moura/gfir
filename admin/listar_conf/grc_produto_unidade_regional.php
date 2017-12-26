<?php
$idCampo = 'idt';
$Tela = "a Unidade Regional do Produto";
//
// Dados da tabela Pai (Nivel 1)

$TabelaPai   = "grc_produto";
$AliasPai    = "grc_pro";
$EntidadePai = "Produto";
$idPai       = "idt";

//
// Dados da tabela atual (deste programa)

$TabelaPrinc      = "grc_produto_unidade_regional";
$AliasPric        = "grc_procp";
$Entidade         = "Unidade Regional";
$Entidade_p       = "Unidades Regionais";
$CampoPricPai     = "idt_produto";

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

   $upCad[] = vetCadUp('idt', $EntidadePai.': ', 'grc_produto', $texto);

//Monta o vetor de Campo

$vetCampo['sca_os_descricao']    = CriaVetTabela('Unidade Regional');
$vetCampo['detalhe'] = CriaVetTabela('Detalhe');
//
$sql  = "select {$AliasPric}.*, ";
$sql  .= "       sca_os.descricao as sca_os_descricao ";
$sql .= " from {$TabelaPrinc} {$AliasPric}  ";
$sql .= " inner join ".db_pir."sca_organizacao_secao sca_os on sca_os.idt = {$AliasPric}.idt_unidade_regional ";
$sql .= " where {$AliasPric}.{$CampoPricPai} = ".null($vetFiltro[$CampoPricPai]['valor']);
$sql .= ' and ( ';
$sql .= ' lower(sca_os.codigo) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
$sql .= ' or lower(sca_os.descricao) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
$sql .= ' or lower('.$AliasPric.'.detalhe) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';

$sql .= ' ) ';

$orderby = "sca_os.codigo";

$sql .= " order by {$orderby}";
?>