<?php
$idCampo = 'idt';
$Tela = "os Arquivos do Documento da Entidade";
//
$TabelaPai1   = "gec_entidade";
$AliasPai1    = "gec_en";
$EntidadePai1 = "Entidade";
$idPai1       = "idt";
//
$TabelaPai    = "gec_entidade_documento";
$AliasPai     = "gec_ed";
$EntidadePai  = "Documento do Entidade";
$idPai        = "idt";
//
//
$TabelaPrinc      = "gec_entidade_documento_arquivo";
$AliasPric        = "gec_eda";
$Entidade         = "Arquivo do Documento da Entidade";
$Entidade_p       = "Arquivos do Documento da Entidade";

$CampoPricPai1    = "idt_entidade";
$CampoPricPai     = "idt_entidade_documento";

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
  //  $texto=" $codigo - $descricao ( Inicio: $data_inicial_publicacao  Término:$data_final_publicacao) ";
  
    $texto=" $codigo - $descricao";
    
  //  $upCad[] = vetCadUp('idt', $EntidadePai, 'gec_edital', $rst->data[0][0]);
    $upCad[] = vetCadUp('idt', $EntidadePai1.': ', 'gec_entidade', $texto);


    $texto="";
    $sql = "select $AliasPai.*, gec_d.descricao as gec_d_descricao from  $TabelaPai  $AliasPai ";
    
    $sql .= " inner join gec_documento gec_d on  gec_d.idt = $AliasPai.idt_documento";
    
    $sql .= " where $AliasPai.idt = ".null($vetFiltro[$CampoPricPai]['valor']);
    $rst = execsql($sql);
    if ($rst->rows != 0) {
        ForEach ($rst->data as $rowt) {
            $idt_documento    = $rowt['idt_documento'];
            $observacao       = $rowt['observacao'];
            $gec_d_descricao    = $rowt['gec_d_descricao'];
        }
    }
    $texto=" $gec_d_descricao ";

  //  $upCad[] = vetCadUp('idt', $EntidadePai, 'gec_edital', $rst->data[0][0]);
    $upCad[] = vetCadUp('idt', $EntidadePai.': ', 'gec_entidade_documento', $texto);


//Monta o vetor de Campo
$vetCampo = Array();
$vetCampo['plu_u_nome_completo'] = CriaVetTabela('Responsável');
$vetCampo['data_cadastro']       = CriaVetTabela('Data Cadastro', 'data');
$vetCampo['data_emissao']        = CriaVetTabela('Data Emissão', 'data');
$vetCampo['data_vencimento']     = CriaVetTabela('Data Vencimento', 'data');
$vetCampo['arquivo'] = CriaVetTabela('Arquivo','arquivo');
$vetCampo['observacao'] = CriaVetTabela('Observações');

//
$sql  = "select {$AliasPric}.*, ";
$sql  .= "       plu_u.nome_completo as plu_u_nome_completo ";

$sql .= " from {$TabelaPrinc} {$AliasPric}  ";
$sql .= " inner join {$TabelaPai} {$AliasPai} on  {$AliasPai}.idt = {$AliasPric}.{$CampoPricPai}";

$sql .= " inner join plu_usuario plu_u on plu_u.id_usuario = {$AliasPric}.idt_usuario ";


//
$sql .= " where {$AliasPric}.{$CampoPricPai} = ".null($vetFiltro[$CampoPricPai]['valor']);
$sql .= ' and ( ';
$sql .= ' lower('.$AliasPric.'.data_cadastro) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
$sql .= ' or lower('.$AliasPric.'.data_emissao) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
$sql .= ' or lower('.$AliasPric.'.data_vencimento) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
$sql .= ' or lower('.$AliasPric.'.observacao) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';

$sql .= ' or lower(plu_u.nome_completo) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';



$sql .= ' ) ';

$orderby = "{$AliasPric}.data_cadastro desc";

$sql .= " order by {$orderby}";
?>