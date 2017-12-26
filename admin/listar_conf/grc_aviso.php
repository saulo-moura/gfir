<?php
$idCampo = 'idt';
$Tela = "os Avisos";
//

/*
$TabelaPai   = "grc_atendimento";
$AliasPai    = "grc_a";
$EntidadePai = "Atendimento";
$idPai       = "idt";
*/
//
$TabelaPrinc      = "grc_aviso";
$AliasPric        = "grc_av";
$Entidade         = "Aviso";
$Entidade_p       = "Avisos";
$CampoPricPai     = "";


$barra_inc_h      = "Incluir um Novo Registro de {$Entidade}";
$contlinfim       = "Existem #qt {$Entidade_p}.";


$tipoidentificacao = 'N';
$tipofiltro = 'S';
$comfiltro = 'A';
$comidentificacao = 'F';

 $veio=$_GET['veio'];
 if ($veio==10)
 {
    $barra_inc_ap = false;
    $barra_alt_ap = false;
    $barra_con_ap = true;
    $barra_exc_ap = false;
    $barra_fec_ap = false;
 }

//
$Filtro = Array();
$Filtro['rs']       = 'Texto';
$Filtro['id']       = 'texto';
$Filtro['js_tam']   = '0';
$Filtro['nome']     = 'Texto';
$Filtro['valor']    = trata_id($Filtro);
$vetFiltro['texto'] = $Filtro;
//
//Monta o vetor de Campo

$vetPri=Array();
$vetPri['0']='Crítica';
$vetPri['1']='Urgente';
$vetPri['2']='Média';
$vetPri['3']='Baixa';

$vetCampo['protocolo']            = CriaVetTabela('Protocolo');
$vetCampo['prioridade']           = CriaVetTabela('Prioridade','descDominio',$vetPri);
$vetCampo['data_inicio']          = CriaVetTabela('Data Inicio','data');
$vetCampo['data_termino']         = CriaVetTabela('Data Término','data');
$vetCampo['plu_u_nome_completo']  = CriaVetTabela('Responsável');
$vetCampo['data_registro']        = CriaVetTabela('Data Registro','data');
$vetCampo['observacao']           = CriaVetTabela('Aviso');

$sql  = "select {$AliasPric}.*, ";
$sql  .= "       plu_u.nome_completo as plu_u_nome_completo ";
$sql .= " from {$TabelaPrinc} {$AliasPric}  ";
$sql .= " inner join plu_usuario plu_u on plu_u.id_usuario = {$AliasPric}.idt_usuario ";
$sql .= ' where ( ';
$sql .= ' lower('.$AliasPric.'.data_inicio) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
$sql .= ' or lower('.$AliasPric.'.data_termino) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
$sql .= ' or lower('.$AliasPric.'.data_registro) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
$sql .= ' or lower('.$AliasPric.'.origem) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
$sql .= ' or lower('.$AliasPric.'.referencia) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
$sql .= ' or lower('.$AliasPric.'.observacao) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
$sql .= ' or lower(plu_u.nome_completo) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
$sql .= ' ) ';

//$orderby = "{$AliasPric}.data_inicio desc";

if ($sqlOrderby == '') {
        $sqlOrderby = "data_inicio desc";
}


//$sql .= " order by {$orderby}";
?>
