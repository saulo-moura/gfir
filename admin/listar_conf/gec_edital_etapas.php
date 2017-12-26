<?php
$idCampo = 'idt';
$Tela = "a Etapa do Edital";
//
$TabelaPai1   = "gec_edital";
$AliasPai1    = "gec_ed";
$EntidadePai1 = "Edital";
$idPai1       = "idt";
//
$TabelaPai    = "gec_edital_processo";
$AliasPai     = "gec_edp";
$EntidadePai  = "Processo do Edital";
$idPai        = "idt";
//
//
$TabelaPrinc      = "gec_edital_etapas";
$AliasPric        = "gec_edets";
$Entidade         = "Etapa  do Edital";
$Entidade_p       = "Etapas do Edital";

$CampoPricPai1    = "idt_edital";
$CampoPricPai     = "idt_processo";

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
            $data_inicial_publicacao  = trata_data($rowt['data_inicial_publicacao']);
            $data_final_publicacao    = trata_data($rowt['data_final_publicacao']);
        }
    }
    $texto=" $codigo - $descricao ( Inicio: $data_inicial_publicacao  Tщrmino:$data_final_publicacao) ";
    
  //  $upCad[] = vetCadUp('idt', $EntidadePai, 'gec_edital', $rst->data[0][0]);
    $upCad[] = vetCadUp('idt', $EntidadePai1.': ', 'gec_edital', $texto);


    $texto="";
    $sql = 'select * from '.$TabelaPai.' where idt = '.null($vetFiltro[$CampoPricPai]['valor']);
    $rst = execsql($sql);
    if ($rst->rows != 0) {
        ForEach ($rst->data as $rowt) {
            $numero    = $rowt['numero'];
            $titulo    = $rowt['titulo'];
        }
    }
    $texto=" $numero - $titulo ";

  //  $upCad[] = vetCadUp('idt', $EntidadePai, 'gec_edital', $rst->data[0][0]);
    $upCad[] = vetCadUp('idt', $EntidadePai.': ', 'gec_edital_processo', $texto);


//Monta o vetor de Campo
$vetCampo['gec_ede_descricao']  = CriaVetTabela('Etapa');
$vetCampo['data_inicio']     = CriaVetTabela('Data Inicio', 'data');
$vetCampo['data_termino']     = CriaVetTabela('Data Tщrmino', 'data');

$vetCampo['ggec_edes_descricao']     = CriaVetTabela('Situaчуo');

$vetCampo['detalhe']         = CriaVetTabela('Observaчѕes');

//
$sql  = "select {$AliasPric}.*, ";
$sql  .= "       gec_ede.descricao as gec_ede_descricao, ";

$sql  .= "       gec_edes.descricao as ggec_edes_descricao ";

$sql .= " from {$TabelaPrinc} {$AliasPric}  ";
$sql .= " inner join {$TabelaPai} {$AliasPai} on  {$AliasPai}.idt = {$AliasPric}.{$CampoPricPai}";

$sql .= " inner join gec_edital_etapa gec_ede on gec_ede.idt = {$AliasPric}.idt_etapa ";

$sql .= " inner join gec_edital_etapas_situacao gec_edes on gec_edes.idt = {$AliasPric}.idt_situacao ";

//
$sql .= " where {$AliasPric}.{$CampoPricPai} = ".null($vetFiltro[$CampoPricPai]['valor']);
$sql .= ' and ( ';
$sql .= ' lower('.$AliasPric.'.data_inicio) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
$sql .= ' or lower('.$AliasPric.'.data_termino) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';

$sql .= ' or lower('.$AliasPric.'.detalhe) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';

$sql .= ' or lower(gec_ede.codigo) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
$sql .= ' or lower(gec_ede.descricao) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';



$sql .= ' ) ';

$orderby = "gec_ede.codigo";

$sql .= " order by {$orderby}";
?>