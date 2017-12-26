<?php
$idCampo = 'idt';
$Tela = "o Acompanhamento do Edital";
//
$TabelaPai   = "gec_edital";
$AliasPai    = "gec_ed";
$EntidadePai = "Edital";
$idPai       = "idt";






//
$TabelaPrinc      = "gec_edital_acompanhamento";
$AliasPric        = "gec_eac";
$Entidade         = "Acompanhamento do Edital";
$Entidade_p       = "Acompanhamento do Edital";
$CampoPricPai     = "idt_edital";

$barra_inc_h      = "Incluir um Novo Registro de {$Entidade}";
$contlinfim       = "Existem #qt {$Entidade_p}.";




$orderby = "";

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
    $sql = 'select * from '.$TabelaPai.' where idt = '.null($vetFiltro[$CampoPricPai]['valor']);
    $rst = execsql($sql);
    if ($rst->rows != 0) {
        ForEach ($rst->data as $rowt) {
            $codigo    = $rowt['codigo'];
            $descricao = $rowt['descricao'];
            $data_inicial_publicacao  = trata_data($rowt['data_inicial_publicacao']);
            $data_final_publicacao    = trata_data($rowt['data_final_publicacao']);
        }
    }
    $texto=" $codigo - $descricao ( Inicio: $data_inicial_publicacao  Término:$data_final_publicacao) ";
    
  //  $upCad[] = vetCadUp('idt', $EntidadePai, 'gec_edital', $rst->data[0][0]);
  
  
    $upCad[] = vetCadUp('idt', $EntidadePai.': ', 'gec_edital', $texto);




//Monta o vetor de Campo
$vetCampo['data']                 = CriaVetTabela('Data Ocorrência','data');
$vetCampo['gec_ep_descricao']     = CriaVetTabela('Documento');
$vetCampo['plu_u_nome_completo']  = CriaVetTabela('Responsável pelo Registro');
$vetCampo['demandante']           = CriaVetTabela('Demandante');
$vetCampo['ocorrencia']           = CriaVetTabela('Ocorrência');
//
$sql  = "select {$AliasPric}.*, ";
$sql  .= "       plu_u.nome_completo as plu_u_nome_completo, ";
$sql  .= "       gec_ep.descricao as gec_ep_descricao ";
$sql .= " from {$TabelaPrinc} {$AliasPric}  ";
$sql .= " inner join {$TabelaPai} {$AliasPai} on  {$AliasPai}.idt = {$AliasPric}.{$CampoPricPai}";
$sql .= " inner join gec_edital_peca gec_ep on gec_ep.idt = {$AliasPric}.idt_peca ";
$sql .= " inner join plu_usuario plu_u on plu_u.id_usuario = {$AliasPric}.idt_usuario ";

//
$sql .= " where {$AliasPric}.{$CampoPricPai} = ".null($vetFiltro[$CampoPricPai]['valor']);
$sql .= ' and ( ';
$sql .= ' lower(plu_u.nome_completo) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
$sql .= ' or lower(gec_ep.descricao) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
$sql .= ' or lower('.$AliasPric.'.ocorrencia) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
$sql .= ' or lower('.$AliasPric.'.data) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
$sql .= ' or lower('.$AliasPric.'.demandante) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
$sql .= ' ) ';
$orderby = "{$AliasPric}.data desc, plu_u.nome_completo ";
$sql .= " order by {$orderby}";
?>