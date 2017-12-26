<?php
$idCampo = 'idt';
$Tela = "o Produto do Mercado";
//
$TabelaPai1   = "gec_entidade";
$AliasPai1    = "gec_en";
$EntidadePai1 = "Entidade";
$idPai1       = "idt";
//
$TabelaPai    = "gec_entidade_mercado";
$AliasPai     = "gec_em";
$EntidadePai  = "Mercado";
$idPai        = "idt";
//
//
$TabelaPrinc      = "gec_entidade_mercado_produto";
$AliasPric        = "gec_emp";
$Entidade         = "Produto do Mercado";
$Entidade_p       = "Produtos do Mercado";

$CampoPricPai1    = "idt_entidade";
$CampoPricPai     = "idt_entidade_mercado";

$barra_inc_h      = "Incluir um Novo Registro de {$Entidade}";
$contlinfim       = "Existem #qt {$Entidade_p}.";


$orderby = "";

//$sql_orderby=Array();


//
$Filtro = Array();
//$Filtro['campo']  = 'descricao';
//$Filtro['tabela'] = $TabelaPai;
$Filtro['id']     = 'idt';
$Filtro['nome']   = $EntidadePai1;
$Filtro['valor']  = trata_id($Filtro);
$vetFiltro[$CampoPricPai1] = $Filtro;

//
$Filtro = Array();
//$Filtro['campo']  = 'descricao';
//$Filtro['tabela'] = $TabelaPai;
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
    $texto="";
    $sql = 'select * from '.$TabelaPai1.' where idt = '.null($vetFiltro[$CampoPricPai1]['valor']);
    $rst = execsql($sql);
    if ($rst->rows != 0) {
        ForEach ($rst->data as $rowt) {
            $codigo    = $rowt['codigo'];
            $descricao = $rowt['descricao'];
        //    $data_inicial_publicacao  = trata_data($rowt['data_inicial_publicacao']);
        //    $data_final_publicacao    = trata_data($rowt['data_final_publicacao']);
        }
    }
    $texto=" $codigo - $descricao  ";
    
  //  $upCad[] = vetCadUp('idt', $EntidadePai, 'gec_edital', $rst->data[0][0]);
    $upCad[] = vetCadUp('idt', $EntidadePai1.': ', 'gec_edital', $texto);


    $texto="";
    $sql  = "select $AliasPai.*, ";
    $sql .= "  gec_m.descricao as gec_m_descricao, ";
    $sql .= "  gec_mt.descricao as gec_mt_descricao ";
    $sql .= '  from '.$TabelaPai.' '.$AliasPai;
    
    $sql .= " inner join gec_mercado      gec_m  on gec_m.idt  = {$AliasPai}.idt_mercado ";
    $sql .= " inner join gec_mercado_tipo gec_mt on gec_mt.idt = {$AliasPai}.idt_tipo ";


    $sql .= "  where $AliasPai.idt = ".null($vetFiltro[$CampoPricPai]['valor']);
    
    $rst = execsql($sql);
    if ($rst->rows != 0) {
        ForEach ($rst->data as $rowt) {
            $gec_m_descricao    = $rowt['gec_m_descricao'];
            $gec_mt_descricao    = $rowt['gec_mt_descricao'];

            $data_inicio  = trata_data($rowt['data_inicio']);
            $data_termino = trata_data($rowt['data_termino']);

        }
    }
    $texto=" $gec_m_descricao - $gec_mt_descricao ";

  //  $upCad[] = vetCadUp('idt', $EntidadePai, 'gec_edital', $rst->data[0][0]);
    $upCad[] = vetCadUp('idt', $EntidadePai.': ', 'gec_entidade_mercado', $texto);


//Monta o vetor de Campo
$vetCampo['gec_mp_descricao']  = CriaVetTabela('Produto');
$vetCampo['data_inicio']        = CriaVetTabela('Data Inicio', 'data');
$vetCampo['data_termino']       = CriaVetTabela('Data Término', 'data');
$vetCampo['ativo']                  = CriaVetTabela('Ativo?', 'descDominio', $vetSimNao );


//
$sql  = "select {$AliasPric}.*, ";
$sql  .= "       gec_mp.descricao as gec_mp_descricao ";

$sql .= " from {$TabelaPrinc} {$AliasPric}  ";
$sql .= " inner join {$TabelaPai} {$AliasPai} on  {$AliasPai}.idt = {$AliasPric}.{$CampoPricPai}";

$sql .= " inner join gec_mercado_produto gec_mp on gec_mp.idt = {$AliasPric}.idt_produto ";


//
$sql .= " where {$AliasPric}.{$CampoPricPai} = ".null($vetFiltro[$CampoPricPai]['valor']);
$sql .= ' and ( ';
$sql .= ' lower('.$AliasPric.'.data_inicio) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
$sql .= ' or lower('.$AliasPric.'.data_termino) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';

$sql .= ' or lower('.$AliasPric.'.detalhe) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';

$sql .= ' or lower(gec_mp.codigo) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
$sql .= ' or lower(gec_mp.descricao) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';



$sql .= ' ) ';

$orderby = "gec_mp.codigo";

$sql .= " order by {$orderby}";
?>