<?php
$idCampo = 'idt';
$Tela = "as Pendências do Atendimento";
//

$TabelaPai   = "grc_atendimento";
$AliasPai    = "grc_a";
$EntidadePai = "Atendimento";
$idPai       = "idt";

//
$TabelaPrinc      = "grc_atendimento_pendencia";
$AliasPric        = "grc_ap";
$Entidade         = "Pendência do Atendimento";
$Entidade_p       = "Pendências do Atendimento";
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
    $upCad[] = vetCadUp('idt', $EntidadePai.': ', 'grc_atendimento', $texto);


//Monta o vetor de Campo
$vetCampo['data']    = CriaVetTabela('Data da Pendência');
$vetCampo['plu_u_nome_completo']    = CriaVetTabela('Responsável');
$vetCampo['observacao'] = CriaVetTabela('Observação');


$sql  = "select {$AliasPric}.*, ";
$sql  .= "       plu_u.nome_completo as plu_u_nome_completo ";
$sql .= " from {$TabelaPrinc} {$AliasPric}  ";
$sql .= " inner join plu_usuario plu_u on plu_u.id_usuario = {$AliasPric}.idt_usuario ";

$sql .= " where {$AliasPric}.{$CampoPricPai} = ".null($vetFiltro[$CampoPricPai]['valor']);
$sql .= ' and ( ';
$sql .= ' lower('.$AliasPric.'.data) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
$sql .= ' or lower('.$AliasPric.'.observacao) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
$sql .= ' or lower(plu_u.nome_completo) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';

$sql .= ' ) ';

$sql .= whereAtendimentoPendencia();

$orderby = "{$AliasPric}.data desc";

$sql .= " order by {$orderby}";
?>
