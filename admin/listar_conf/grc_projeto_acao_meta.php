<?php
$idCampo = 'idt';
$Tela = "a Meta da Ação do Projeto";
//

$TabelaPai   = "grc_projeto_acao";
$AliasPai    = "grc_pa";
$EntidadePai = "Ação do Projeto";
$idPai       = "idt";

$TabelaPrinc      = "grc_projeto_acao_meta";
$AliasPric        = "grc_pam";
$Entidade         = "Meta da Ação do Projeto";
$Entidade_p       = "Metas da Ação do Projeto";
$CampoPricPai     = "idt_projeto_acao";


$barra_inc_h      = "Incluir um Novo Registro de {$Entidade}";
$contlinfim       = "Existem #qt {$Entidade_p}.";

$orderby = "";

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

$texto="";
$sql = 'select * from '.$TabelaPai.' where idt = '.null($vetFiltro[$CampoPricPai]['valor']);
$rst = execsql($sql);
if ($rst->rows != 0)
{
   ForEach ($rst->data as $rowt)
   {
      $codigo    = $rowt['codigo'];
      $descricao = $rowt['descricao'];
   }
}

$texto=" $codigo - $descricao ";
$upCad[] = vetCadUp('idt', $EntidadePai.': ', 'grc_projeto_acao', $texto);

//Monta o vetor de Campo
$vetCampo['ano']              = CriaVetTabela('Ano', 'descDominio', $vetAno );
$vetCampo['mes']              = CriaVetTabela('Mês', 'descDominio', $vetMes );
$vetCampo['grc_ai_descricao'] = CriaVetTabela('Instrumento');
$vetCampo['quantitativo']     = CriaVetTabela('Quantitativo');
$vetCampo['grc_am_descricao'] = CriaVetTabela('Métrica');


$sql  = "select {$AliasPric}.*, ";
$sql  .= "       grc_ai.descricao as grc_ai_descricao, ";
$sql  .= "       grc_am.descricao as grc_am_descricao ";
$sql .= " from {$TabelaPrinc} {$AliasPric}  ";
$sql .= " inner join {$TabelaPai} {$AliasPai} on  {$AliasPai}.idt = {$AliasPric}.{$CampoPricPai}";
$sql .= " inner join grc_atendimento_metrica grc_am on grc_am.idt = {$AliasPric}.idt_metrica ";
$sql .= " inner join grc_atendimento_instrumento grc_ai on grc_ai.idt = {$AliasPric}.idt_instrumento ";

$sql .= " where {$AliasPric}.{$CampoPricPai} = ".null($vetFiltro[$CampoPricPai]['valor']);
$sql .= ' and ( ';
$sql .= ' lower('.$AliasPric.'.ano) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
$sql .= ' or lower('.$AliasPric.'.mes) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';

$sql .= ' ) ';

//$orderby = "{$AliasPric}.ano, {$AliasPric}.mes";

//$sql .= " order by {$orderby}";

if ($sqlOrderby == '') {
        $sqlOrderby = "ano asc, grc_ai.descricao asc, grc_am.descricao asc ";
}

?>
