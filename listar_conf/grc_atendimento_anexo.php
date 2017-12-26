<?php
$idCampo = 'idt';
$Tela = "os Anexos do Atendimento";
//

$TabelaPai   = "grc_atendimento";
$AliasPai    = "grc_a";
$EntidadePai = "Atendimento";
$idPai       = "idt";

//
$TabelaPrinc      = "grc_atendimento_anexo";
$AliasPric        = "grc_aa";
$Entidade         = "Anexo do Atendimento";
$Entidade_p       = "Anexos do Atendimento";
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
$vetCampo['descricao']         = CriaVetTabela('Título');
$vetCampo['arquivo']           = CriaVetTabela('Arquivo anexado','arquivo','','grc_atendimento_anexo');
$vetCampo['plu_nome_completo'] = CriaVetTabela('Responsável');
$vetCampo['data_respónsavel']  = CriaVetTabela('Data Registro','data');
$sql  = "select {$AliasPric}.*  ";
$sql .= " from {$TabelaPrinc} {$AliasPric}  ";
$sql .= " where {$AliasPric}.{$CampoPricPai} = ".null($vetFiltro[$CampoPricPai]['valor']);
$sql .= ' and ( ';
$sql .= ' lower('.$AliasPric.'.descricao) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
$sql .= ' or lower('.$AliasPric.'.arquivo) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
$sql .= ' or lower(plu_nome_completo) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
$sql .= ' ) ';
$orderby = "{$AliasPric}.descricao ";
$sql .= " order by {$orderby}";
?>
