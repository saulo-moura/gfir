<?php
$idCampo = 'idt';
$Tela = "o Participante do Evento";
//

$TabelaPai   = "grc_evento";
$AliasPai    = "grc_eve";
$EntidadePai = "Evento";
$idPai       = "idt";

//
$TabelaPrinc      = "grc_evento_participante";
$AliasPric        = "grc_evepar";
$Entidade         = "Participante do Evento";
$Entidade_p       = "Participantes do Evento";
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
$vetCampo['gec_ent_descricao'] = CriaVetTabela('Participante');
$vetCampo['grc_erc_descricao'] = CriaVetTabela('Relaзгo com o Evento');
$vetCampo['ativo']     = CriaVetTabela('Ativo?', 'descDominio', $vetSimNao );
//
$sql  = "select {$AliasPric}.*, ";
$sql  .= "       gec_ent.descricao as gec_ent_descricao, ";
$sql  .= "       grc_erc.descricao as grc_erc_descricao ";
$sql .= " from {$TabelaPrinc} {$AliasPric}  ";
$sql .= " inner join {$TabelaPai} {$AliasPai} on  {$AliasPai}.idt = {$AliasPric}.{$CampoPricPai}";

$sql .= " inner join gec_entidade gec_ent on gec_ent.idt = {$AliasPric}.idt_entidade ";
$sql .= " inner join grc_evento_relacao_participante grc_erc on grc_erc.idt = {$AliasPric}.idt_evento_relacao_participante ";
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