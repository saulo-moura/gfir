<?php
$idCampo = 'siac_phrc.CodParceiro';
$Tela = "o Hist�rico Realiza��es Cliente";
//

$TabelaPai   = "db_pir_siac.parceiro";
$AliasPai    = "siac_p";
$EntidadePai = "Parceiro";
$idPai       = "siac_p.CodParceiro";

$TabelaPrinc      = "db_pir_siac.historicorealizacoescliente";
$AliasPric        = "siac_phrc";
$Entidade         = "Hist�rico Realiza��es Cliente";
$Entidade_p       = "Hist�ricos Realiza��es Cliente";
$CampoPricPai     = "siac_phrc.CodCliente";


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
$vetCampo['siac_s_descsebrae'] = CriaVetTabela('SEBRAE');
$vetCampo['DataHoraInicioRealizacao']   = CriaVetTabela('Inicio Realiza��o',data);
$vetCampo['DataHoraFimRealizacao']   = CriaVetTabela('Fim Realiza��o',data);
$vetCampo['NomeRealizacao']    = CriaVetTabela('Nome da Realiza��o');

$sql   = "select ";
$sql  .= "   {$AliasPric}.* ,";
$sql  .= "    siac_s.descsebrae as siac_s_descsebrae ";
$sql  .= " from {$TabelaPrinc} as {$AliasPric} ";
$sql .= " left join db_pir_siac.sebrae siac_s on siac_s.codsebrae = {$AliasPric}.CodSebrae ";

$sql .= " where {$AliasPric}.{$CampoPricPai} = ".null($vetFiltro[$CampoPricPai]['valor']);
$sql .= ' and ( ';
$sql .= '    lower('.$AliasPric.'.NomeMae) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
$sql .= ' or lower('.$AliasPric.'.Identidade) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
//$sql .= ' or lower(plu_u.nome_completo) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';

$sql .= ' ) ';

$orderby = "{$AliasPric}.DataHoraInicioRealizacao ";

$sql .= " order by {$orderby}";
?>
