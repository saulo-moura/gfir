<?php
$idCampo = 'idt';
$Tela = "o Tema do Atendimento";
//

$TabelaPai   = "grc_atendimento";
$AliasPai    = "grc_a";
$EntidadePai = "Atendimento";
$idPai       = "idt";

//
$TabelaPrinc      = "grc_atendimento_tema";
$AliasPric        = "grc_at";
$Entidade         = "Tema do Atendimento";
$Entidade_p       = "Temas do Atendimento";
$CampoPricPai     = "idt_atendimento";


$barra_inc_h      = "Incluir um Novo Registro de {$Entidade}";
$contlinfim       = "Existem #qt {$Entidade_p}.";

$orderby = "";

//$sql_orderby=Array();

//
$Filtro = Array();
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
    $sql = 'select * from '.$TabelaPai.' where idt = '.null($vetFiltro[$CampoPricPai]['valor']);
    $rst = execsql($sql);
    if ($rst->rows != 0) {
        ForEach ($rst->data as $rowt) {
            $data    = $rowt['data'];
        }
    }
    $texto=" $data ";
    
  //  $upCad[] = vetCadUp('idt', $EntidadePai, 'gec_edital', $rst->data[0][0]);
  
  
    $upCad[] = vetCadUp('idt', $EntidadePai.': ', 'grc_atendimento', $texto);


//Monta o vetor de Campo
$vetCampo['grc_tema']    = CriaVetTabela('Tema');
$vetCampo['grc_sub_tema']    = CriaVetTabela('Sub-Tema');


$sql  = "select {$AliasPric}.*, ";
$sql  .= "       grc_t.descricao as grc_tema, ";
$sql  .= "       grc_ts.descricao as grc_sub_tema ";
$sql .= " from {$TabelaPrinc} {$AliasPric}  ";
$sql .= " inner join grc_tema_subtema grc_t on grc_t.idt = {$AliasPric}.idt_tema ";
$sql .= " inner join grc_tema_subtema grc_ts on grc_ts.idt = {$AliasPric}.idt_sub_tema ";

$sql .= " where {$AliasPric}.{$CampoPricPai} = ".null($vetFiltro[$CampoPricPai]['valor']);
$sql .= ' and ( ';
$sql .= ' lower('grc_t.descricao') like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
$sql .= ' or lower('grc_ts.descricao') like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';

$sql .= ' ) ';

$orderby = "grc_t.descricao, grc_ts.descricao";

$sql .= " order by {$orderby}";
?>
