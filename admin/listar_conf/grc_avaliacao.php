<style>
    div.listar_cmb_div {
        width:350px;
    }
</style>
<?php
$idCampo = 'idt';
$Tela = "a Avaliação";



$TabelaPrinc = "grc_avaliacao";
$AliasPric = "grc_a";
$Entidade = "Avaliação";
$Entidade_p = "Avaliações";

$barra_inc_h = "Incluir um Novo Registro de {$Entidade}";
$contlinfim = "Existem #qt {$Entidade_p}.";


$sistema_origem = DecideSistema();
$mede = $_GET['mede'];
$vetGrupo = Array();
if ($sistema_origem == 'GEC') {
    $vetGrupo['GC'] = 'Gestão de Credenciados';
} else {
	if ($mede!='S')
	{
	    $vetGrupo['NAN']='Negócio a Negócio';
	}
    else
    {
	    $vetGrupo['MEDE']='MEDE';
    }
}
$Filtro = Array();
$Filtro['rs'] = $vetGrupo;
$Filtro['id'] = 'f_grupo';
$Filtro['nome'] = 'Grupo:';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['grupo'] = $Filtro;

$prefixow = 'listar';
$mostrar = false;
$cond_campo = '';
$cond_valor = '';


$tipoidentificacao = 'N';
$tipofiltro = 'S';
$comfiltro = 'A';
$comidentificacao = 'F';

// Cliente
$Filtro = Array();
$Filtro['rs'] = 'ListarCmb';
$Filtro['arq'] = 'gec_entidade_grc_avaliacao_organizacao_lista';
$Filtro['id'] = 'idt';
$Filtro['nome'] = 'Cliente PJ';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['idt_cliente_pj'] = $Filtro;

$Filtro = Array();
$Filtro['rs'] = 'ListarCmb';
$Filtro['arq'] = 'gec_entidade_grc_avaliacao_pessoa_lista';
$Filtro['id'] = 'idt';
$Filtro['nome'] = 'Representante Cliente PF';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['idt_cliente_pf'] = $Filtro;


if ($mede!='S')
{

	// Credenciado
	$Filtro = Array();
	$Filtro['rs'] = 'ListarCmb';
	$Filtro['arq'] = 'gec_entidade_grc_avaliacao_organizacao_lista';
	$Filtro['id'] = 'idt';
	$Filtro['nome'] = 'Credenciado PJ';
	$Filtro['valor'] = trata_id($Filtro);
	$vetFiltro['idt_credenciado_pj'] = $Filtro;

	$Filtro = Array();
	$Filtro['rs'] = 'ListarCmb';
	$Filtro['arq'] = 'gec_entidade_grc_avaliacao_pessoa_lista';
	$Filtro['id'] = 'idt';
	$Filtro['nome'] = 'Credenciado PF';
	$Filtro['valor'] = trata_id($Filtro);
	$vetFiltro['idt_credenciado_pf'] = $Filtro;
}
else
{
    

}
// Responsável pelo Registro
$sql = '';
$sql .= ' select distinct id_usuario, nome_completo';
$sql .= ' from plu_usuario';
$sql .= " where ativo = 'S'";
$sql .= ' order by nome_completo';
$Filtro = Array();
$Filtro['rs'] = execsql($sql);
$Filtro['id'] = 'id_usuario';
$Filtro['nome'] = 'Responsável<br /> pelo Registro';
$Filtro['LinhaUm'] = ' ';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['idt_responsavel'] = $Filtro;


$Filtro = Array();
$Filtro['rs'] = 'Texto';
$Filtro['id'] = 'texto';
$Filtro['js_tam'] = '0';
$Filtro['nome'] = 'Texto';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['texto'] = $Filtro;

$vetCampo['codigo'] = CriaVetTabela('Código');
$vetCampo['descricao'] = CriaVetTabela('Descrição');

$vetCampo['data_avaliacao'] = CriaVetTabela('Data', 'data');
$vetCampo['cliente'] = CriaVetTabela('Cliente');
if ($sistema_origem == 'GEC')
{
	$vetCampo['credenciado'] = CriaVetTabela('Credenciado');
}

$vetCampo['qtd_g'] = CriaVetTabela('Perguntas<br />Qtd. Total');
$vetCampo['qtd_e'] = CriaVetTabela('Perguntas<br />Sem resposta');
$vetCampo['qtd_r'] = CriaVetTabela('Perguntas<br />Com resposta');

$vetCampo['grc_as_descricao'] = CriaVetTabela('Situação');




$sql = "select ";
$sql .= "   {$AliasPric}.*,  ";
$sql .= "   grc_as.descricao as grc_as_descricao,  ";

$sql .= "   concat_ws('<br />',gec_eclio.descricao,gec_eclip.descricao) as cliente,  ";
$sql .= "   concat_ws('<br />',gec_ecreo.descricao,gec_ecrep.descricao) as credenciado  ";
$sql .= " from {$TabelaPrinc} as {$AliasPric} ";
$sql .= " inner join grc_avaliacao_situacao grc_as on grc_as.idt = grc_a.idt_situacao ";
$sql .= " left join ".db_pir_gec."gec_entidade gec_eclio on gec_eclio.idt = grc_a.idt_organizacao_avaliado ";
$sql .= " left join ".db_pir_gec."gec_entidade gec_eclip on gec_eclip.idt = grc_a.idt_avaliado ";

$sql .= " left join ".db_pir_gec."gec_entidade gec_ecreo on gec_ecreo.idt = grc_a.idt_organizacao_avaliador ";
$sql .= " left join ".db_pir_gec."gec_entidade gec_ecrep on gec_ecrep.idt = grc_a.idt_avaliador ";

$sql .= " where {$AliasPric}.grupo = ".aspa($vetFiltro['grupo']['valor']);

$idt_cliente_pj = $vetFiltro['idt_cliente_pj']['valor'];
$idt_cliente_pf = $vetFiltro['idt_cliente_pf']['valor'];

$idt_credenciado_pj = $vetFiltro['idt_credenciado_pj']['valor'];
$idt_credenciado_pf = $vetFiltro['idt_credenciado_pf']['valor'];
$idt_responsavel = $vetFiltro['idt_responsavel']['valor'];

if ($idt_cliente_pj != "") {
    $sql .= ' and ';
    $sql .= ' ( ';
    $sql .= ' gec_eclio.idt = '.null($idt_cliente_pj);
    $sql .= ' ) ';
}

if ($idt_cliente_pf != "") {
    $sql .= ' and ';
    $sql .= ' ( ';
    $sql .= ' gec_eclip.idt = '.null($idt_cliente_pf);
    $sql .= ' ) ';
}

if ($idt_credenciado_pj != "") {
    $sql .= ' and ';
    $sql .= ' ( ';
    $sql .= ' gec_ecreo.idt = '.null($idt_credenciado_pj);
    $sql .= ' ) ';
}

if ($idt_credenciado_pf != "") {
    $sql .= ' and ';
    $sql .= ' ( ';
    $sql .= ' gec_ecrep.idt = '.null($idt_credenciado_pf);
    $sql .= ' ) ';
}

if ($idt_responsavel != "" and $idt_responsavel != "-1") {
    $sql .= ' and ';
    $sql .= ' ( ';
    $sql .= ' grc_a.idt_responsavel_registro = '.null($idt_responsavel);
    $sql .= ' ) ';
}

if ($vetFiltro['texto']['valor'] != "") {
    $sql .= ' and ';
    $sql .= ' ( ';
    $sql .= '  lower('.$AliasPric.'.codigo)      like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' or lower('.$AliasPric.'.descricao) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';

    $sql .= ' or lower(gec_eclio.descricao) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' or lower(gec_eclip.descricao) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';

    $sql .= ' or lower(gec_ecreo.descricao) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' or lower(gec_ecrep.descricao) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';

    $sql .= ' ) ';
}

//echo "'".$sql."'<br />";
