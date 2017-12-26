<?php
$idCampo = 'idt';
$Tela = "a Execuчуo do Funil";

$TabelaPrinc      = "grc_funil_execucao";
$AliasPric        = "grc_fe";
$Entidade         = "Execuчуo do Funil";
$Entidade_p       = "Execuчѕes do Funil";

$barra_inc_h = "Incluir um Novo Registro de {$Entidade}";
$contlinfim  = "Existem #qt {$Entidade_p}.";

$tipoidentificacao = 'N';
$tipofiltro = 'S';
$comfiltro = 'A';
$comidentificacao = 'F';


$sql = '';
$sql .= ' select idt, descricao';
$sql .= ' from '.db_pir.'sca_organizacao_secao';
// $sql .= " where posto_atendimento <> 'S' ";
$sql .= " where tipo_estrutura = 'UR' ";
$sql .= ' order by classificacao';
$Filtro = Array();
$Filtro['rs'] = execsql($sql);
$Filtro['id'] = 'f_idt_unidade';
$Filtro['id_select'] = 'idt';
$Filtro['nome'] = 'Unidade';
$Filtro['LinhaUm'] = ' ';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['f_idt_unidade'] = $Filtro;


$anop='2017';
$Filtro = Array();
$Filtro['rs']       = $vetAno;
$Filtro['id']       = 'ano';
$Filtro['js_tam']   = '0';
$Filtro['nome']     = 'Ano';
//$Filtro['LinhaUm'] = '-- Todos --';
$Filtro['vlPadrao'] = $anop;
$Filtro['valor']    = trata_id($Filtro);
$vetFiltro['ano'] = $Filtro;



$Filtro = Array();
$Filtro['rs']       = 'Texto';
$Filtro['id']       = 'texto';
$Filtro['js_tam']   = '0';
$Filtro['nome']     = 'Texto';
$Filtro['valor']    = trata_id($Filtro);
$vetFiltro['texto'] = $Filtro;

$orderby = "{$AliasPric}.ano, sca_os.descricao  ";

$vetCampo['ano']                = CriaVetTabela('Ano');
$vetCampo['codigo_jurisdicao']   = CriaVetTabela('Cѓdigo Jurisdiчуo');
$vetCampo['descricao_jurisdicao']   = CriaVetTabela('Jurisdiчуo');
$vetCampo['sca_os_descricao']   = CriaVetTabela('Unidade Regional CRM');
$vetCampo['qtd_prospects']      = CriaVetTabela('Qtd. PROSPECTS');
$vetCampo['qtd_leads']          = CriaVetTabela('Qtd. LEADS');
$vetCampo['qtd_sem_avaliacao']  = CriaVetTabela('Qtd. CLIENTES SEM AVALIAЧУO');
$vetCampo['qtd_detrators']      = CriaVetTabela('Qtd. CLIENTES DETRATORES');
$vetCampo['qtd_neutros']        = CriaVetTabela('Qtd. CLIENTES NEUTROS');
$vetCampo['qtd_promotores']     = CriaVetTabela('Qtd. CLIENTES PROMOTORES');
$vetCampo['net_promoter_score'] = CriaVetTabela('% NET PROMOTORES SCORE');



$sql   = "select ";
$sql  .= "   {$AliasPric}.*, sca_os.descricao as sca_os_descricao  ";
$sql  .= " from {$TabelaPrinc} as {$AliasPric} ";
$sql  .= "   left join ".db_pir."sca_organizacao_secao sca_os on sca_os.idt = {$AliasPric}.idt_unidade_regional  ";

$sql  .= " where 1 = 1 ";

if ($vetFiltro['ano']['valor']!="")
{
    $sql .= ' and ';
    $sql .= ' ( ';
	$sql .= " {$AliasPric}.ano = ".aspa($vetFiltro['ano']['valor']);
    $sql .= ' ) ';
}

if ($vetFiltro['f_idt_unidade']['valor']!="" and $vetFiltro['f_idt_unidade']['valor']!=-1 )
{
    $sql .= ' and ';
    $sql .= ' ( ';
    $sql .= " {$AliasPric}.idt_unidade_regional = ".null($vetFiltro['f_idt_unidade']['valor']);
    $sql .= ' ) ';
}
if ($vetFiltro['texto']['valor']!="")
{
    $sql .= ' and ';
    $sql .= ' ( ';
    $sql .= '  lower('.$AliasPric.'.ano)      like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' or lower('.$AliasPric.'.detalhe) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' ) ';
}
//$sql  .= " order by {$orderby}";

?>