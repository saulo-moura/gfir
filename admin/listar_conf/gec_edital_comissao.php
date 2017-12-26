<?php
$idCampo = 'idt';
$Tela = "a Comissão do Edital";
//
$TabelaPai   = "gec_edital";
$AliasPai    = "gec_ed";
$EntidadePai = "Edital";
$idPai       = "idt";






//
$TabelaPrinc      = "gec_edital_comissao";
$AliasPric        = "gec_edc";
$Entidade         = "Comissão do Edital";
$Entidade_p       = "Comissões do Edital";
$CampoPricPai     = "idt_edital";

$barra_inc_h      = "Incluir um Novo Registro de {$Entidade}";
$contlinfim       = "Existem #qt {$Entidade_p}.";



$orderby = "";

//$sql_orderby=Array();

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
$vetCampo['gec_ent_descricao']  = CriaVetTabela('PESSOA');
$vetCampo['gec_edr_descricao']  = CriaVetTabela('RELAÇÃO');
$vetCampo['email']              = CriaVetTabela('EMAIL');
$vetCampo['telefone']           = CriaVetTabela('TELEFONES');
//
$sql  = "select {$AliasPric}.*, ";
$sql  .= "        concat_ws('<br />',email_1,email_2) as email, ";
$sql  .= "        concat_ws('<br />',telefone_1,telefone_2) as telefone, ";
$sql  .= "       gec_edr.descricao as gec_edr_descricao, ";
$sql  .= "       gec_ent.descricao as gec_ent_descricao  ";
$sql .= " from {$TabelaPrinc} {$AliasPric}  ";
$sql .= " inner join {$TabelaPai} {$AliasPai} on  {$AliasPai}.idt = {$AliasPric}.{$CampoPricPai}";
$sql .= " inner join gec_edital_relacao gec_edr on gec_edr.idt = {$AliasPric}.idt_relacao ";
$sql .= " inner join gec_entidade       gec_ent on gec_ent.idt = {$AliasPric}.idt_pessoa ";
//
$sql .= " where {$AliasPric}.{$CampoPricPai} = ".null($vetFiltro[$CampoPricPai]['valor']);
$sql .= ' and ( ';
$sql .= ' lower(gec_edr.descricao) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
$sql .= ' or lower(gec_ent.descricao) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
$sql .= ' or lower('.$AliasPric.'.email_1) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
$sql .= ' or lower('.$AliasPric.'.email_2) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
$sql .= ' or lower('.$AliasPric.'.telefone_1) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
$sql .= ' or lower('.$AliasPric.'.telefone_2) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';

$sql .= ' ) ';

$orderby = "gec_edr.codigo";

$sql .= " order by {$orderby}";
?>