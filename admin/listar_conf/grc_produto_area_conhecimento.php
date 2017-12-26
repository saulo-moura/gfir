<?php
$idCampo = 'idt';
$Tela = "a Сrea de Conhecimento do Produto";
//
// Dados da tabela Pai (Nivel 1)

$TabelaPai   = "grc_produto";
$AliasPai    = "grc_pro";
$EntidadePai = "Produto";
$idPai       = "idt";

//
// Dados da tabela atual (deste programa)

$TabelaPrinc      = "grc_produto_area_conhecimento";
$AliasPric        = "grc_procp";
$Entidade         = "Сrea de Conhecimento";
$Entidade_p       = "Сrea de Conhecimento";
$CampoPricPai     = "idt_produto";

// Barra de inclusуo e de totalizaчуo de registros (barra de rodapщ) do full

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

$vetCampo['gec_ac_descricao']    = CriaVetTabela('Сrea de Conhecimento');
$vetCampo['detalhe'] = CriaVetTabela('Detalhe');
//
$sql  = "select {$AliasPric}.*, ";
$sql  .= "       gec_ac.descricao as gec_ac_descricao ";
$sql .= " from {$TabelaPrinc} {$AliasPric}  ";
$sql .= " inner join {$TabelaPai} {$AliasPai} on  {$AliasPai}.idt = {$AliasPric}.{$CampoPricPai}";
$sql .= " inner join gec_area_conhecimento gec_ac on gec_ac.idt = {$AliasPric}.idt_area ";
$sql .= " where {$AliasPric}.{$CampoPricPai} = ".null($vetFiltro[$CampoPricPai]['valor']);
$sql .= ' and ( ';
$sql .= ' lower(gec_ac.codigo) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
$sql .= ' or lower(gec_ac.descricao) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
$sql .= ' or lower('.$AliasPric.'.detalhe) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';

$sql .= ' ) ';

$orderby = "gec_ac.codigo";

$sql .= " order by {$orderby}";
?>