<?php
$idCampo = 'idt';
$Tela = "o Per�odo da Programa��o de Evento";
//

$TabelaPai   = "grc_evento";
$AliasPai    = "grc_ppr";
$EntidadePai = "Programa��o de Evento";
$idPai       = "idt";

//
$TabelaPrinc      = "grc_evento_etapa";
$AliasPric        = "grc_eveper";
$Entidade         = "Etapa da Programa��o de Evento";
$Entidade_p       = "Etapas da Programa��o de Evento";
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
$vetCampo['codigo']    = CriaVetTabela('C�digo');
$vetCampo['nome_etapa'] = CriaVetTabela('Nome da Etapa');
$vetCampo['data_inicial']  = CriaVetTabela('Data Inicial <br />Etapa','data');
$vetCampo['data_final']  = CriaVetTabela('Data Final <br />Etapa','data');
$vetCampo['plu_usu_nome_completo'] = CriaVetTabela('Responsavel');
$vetCampo['grc_erc_descricao'] = CriaVetTabela('Fun��o<br>(Na Etapa)</br>');
$vetCampo['ativo']     = CriaVetTabela('Ativo?', 'descDominio', $vetSimNao );

//
$sql  = "select {$AliasPric}.*, ";
$sql  .= "       plu_usu.nome_completo as plu_usu_nome_completo, ";
$sql  .= "       grc_erc.descricao as grc_erc_descricao ";
$sql .= " from {$TabelaPrinc} {$AliasPric}  ";
$sql .= " inner join {$TabelaPai} {$AliasPai} on  {$AliasPai}.idt = {$AliasPric}.{$CampoPricPai}";

$sql .= " inner join plu_usuario plu_usu on plu_usu.id_usuario = {$AliasPric}.idt_usuario ";
$sql .= " inner join grc_evento_relacao_colaborador grc_erc on grc_erc.idt = {$AliasPric}.idt_evento_relacao_colaborador ";
//
$sql .= " where {$AliasPric}.{$CampoPricPai} = ".null($vetFiltro[$CampoPricPai]['valor']);
$sql .= ' and ( ';
$sql .= ' lower('.$AliasPric.'.codigo) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
$sql .= ' or lower(grc_erc.descricao) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
$sql .= ' or lower('.$AliasPric.'.nome_etapa) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
$sql .= ' or lower(plu_usu.nome_completo) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';

$sql .= ' ) ';

$orderby = "{$AliasPric}.codigo";

$sql .= " order by {$orderby}";
?>