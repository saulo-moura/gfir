<?php
$idCampo = 'idt';
$Tela = "o Responsavel Associado ao Evento";
//

$TabelaPai   = "grc_evento";
$AliasPai    = "grc_eve";
$EntidadePai = "Evento";
$idPai       = "idt";

//
$TabelaPrinc      = "grc_evento_responsavel";
$AliasPric        = "grc_evecol";
$Entidade         = "Responsavel Associado ao Evento";
$Entidade_p       = "Responsaveles Associado ao Evento";
$CampoPricPai     = "idt_evento";


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
        }
    }
    $texto=" $codigo - $descricao ";
    
  //  $upCad[] = vetCadUp('idt', $EntidadePai, 'gec_edital', $rst->data[0][0]);
  
  
    $upCad[] = vetCadUp('idt', $EntidadePai.': ', 'grc_evento', $texto);


//Monta o vetor de Campo
$vetCampo['codigo']    = CriaVetTabela('Cуdigo');
$vetCampo['descricao'] = CriaVetTabela('Descriзгo');
$vetCampo['plu_usu_nome_completo'] = CriaVetTabela('responsavel');
$vetCampo['grc_erc_descricao'] = CriaVetTabela('Funзгo no Evento');
$vetCampo['ativo']     = CriaVetTabela('Ativo?', 'descDominio', $vetSimNao );
//
$sql  = "select {$AliasPric}.*, ";
$sql  .= "       plu_usu.nome_completo as plu_usu_nome_completo, ";
$sql  .= "       grc_erc.descricao as grc_erc_descricao ";
$sql .= " from {$TabelaPrinc} {$AliasPric}  ";
$sql .= " inner join {$TabelaPai} {$AliasPai} on  {$AliasPai}.idt = {$AliasPric}.{$CampoPricPai}";

$sql .= " inner join plu_usuario plu_usu on plu_usu.id_usuario = {$AliasPric}.idt_usuario ";
$sql .= " inner join grc_evento_relacao_colaborador grc_erc on grc_erc.idt = {$AliasPric}.idt_evento_relacao_colaborador";
//
$sql .= " where {$AliasPric}.{$CampoPricPai} = ".null($vetFiltro[$CampoPricPai]['valor']);
$sql .= ' and ( ';
$sql .= ' lower('.$AliasPric.'.codigo) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
$sql .= ' or lower('.$AliasPric.'.descricao) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
$sql .= ' or lower('.$AliasPric.'.detalhe) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';

$sql .= ' ) ';

$orderby = "{$AliasPric}.codigo";

$sql .= " order by {$orderby}";
?>