<?php
$idCampo = 'siac_pe.CodParceiro';
$Tela = "a Comunicação";
//

$TabelaPai   = "db_pir_siac.parceiro";
$AliasPai    = "siac_p";
$EntidadePai = "Parceiro";
$idPai       = "siac_p.CodParceiro";

$TabelaPrinc      = "db_pir_siac.comunicacao";
$AliasPric        = "siac_pc";
$Entidade         = "Comunicacao";
$Entidade_p       = "Comunicações";
$CampoPricPai     = "siac_pc.CodParceiro";


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
if ($rst->rows != 0)
{
   ForEach ($rst->data as $rowt)
   {
      $data  = $rowt['TituloConteudo'];
   }
}
$texto=" $data ";
    
//$upCad[] = vetCadUp('idt', $EntidadePai.': ', 'bia_conteudobia', $texto);

//Monta o vetor de Campo
$vetCampo['numseqcom']    = CriaVetTabela('Nº');
$vetCampo['desc_comunic']   = CriaVetTabela('Tipo Comunicação');
$vetCampo['numero'] = CriaVetTabela('Número');
$vetCampo['IndInternet']    = CriaVetTabela('Ind.Internet');


$sql  = "select {$AliasPric}.* , desccomunic as desc_comunic";
$sql .= " from {$TabelaPrinc} {$AliasPric}  ";
$sql .= " left  join db_pir_siac.tipocomunic tp on tp.codcomunic = {$AliasPric}.codcomunic ";

$sql .= " where {$AliasPric}.{$CampoPricPai} = ".null($vetFiltro[$CampoPricPai]['valor']);
$sql .= ' and ( ';
$sql .= '    lower('.$AliasPric.'.NomeMae) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
$sql .= ' or lower('.$AliasPric.'.Identidade) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
//$sql .= ' or lower(plu_u.nome_completo) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';

$sql .= ' ) ';

$orderby = "{$AliasPric}.numseqcom ";

$sql .= " order by {$orderby}";
?>
