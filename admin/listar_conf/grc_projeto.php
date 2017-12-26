<?php
$idCampo = 'idt';
$Tela = "o Projeto";

$tipoidentificacao = 'N';
$tipofiltro = 'S';

$comfiltro        = 'A';
$comidentificacao = 'F';

$barra_inc_ap = false;
$barra_alt_ap = false;
$barra_con_ap = true;
$barra_exc_ap = false;
$barra_fec_ap = false;

if ($_SESSION[CS]['g_id_usuario']==1 || $_SESSION[CS]['g_id_usuario']==111 || $_SESSION[CS]['g_id_usuario']==120)
{
    $barra_alt_ap = true;
}

$veio_nan = 0;

if ($_SESSION[CS]['$veio']=='NAN')
{
    $veio_nan = 1;
    $barra_alt_ap = true;
}
if ($veio=='NAN')
{
    $veio_nan = 1;
	$_SESSION[CS]['$veio']='NAN';
	$barra_inc_ap = false;
    $barra_alt_ap = true;
    $barra_con_ap = true;
    $barra_exc_ap = false;
    $barra_fec_ap = false;
}

$TabelaPrinc      = "grc_projeto";
$AliasPric        = "grc_pro";
$Entidade         = "Projeto";
$Entidade_p       = "Projetos";

$barra_inc_h = "Incluir um Novo Registro de {$Entidade}";
$contlinfim  = "Existem #qt {$Entidade_p}.";

// Descida para o nivel 2

$prefixow    = 'listar';
$mostrar    = true;
$cond_campo = '';
$cond_valor = '';

/*
$imagem  = 'imagens/empresa_16.png';
$goCad[] = vetCad('idt', 'Ações', 'grc_projeto_acao', $prefixow, $mostrar, $imagem, $cond_campo, $cond_valor);
*/


$vetNAN = Array();
if ($veio_nan==0)
{
	$vetNAN['T'] = 'Todos os Projetos'; 
	$vetNAN['S'] = 'Negócio a Negócio'; 
}
else
{
    $vetNAN['S'] = 'Negócio a Negócio'; 
	$vetNAN['T'] = 'Todos os Projetos'; 
}
$Filtro = Array();
$Filtro['rs']       = $vetNAN;
$Filtro['id']       = 'nan';
$Filtro['js_tam']   = '0';
$Filtro['nome']     = 'Negócio a Negócio?';
$Filtro['valor']    = trata_id($Filtro);
$vetFiltro['nan'] = $Filtro;


$Filtro = Array();
$Filtro['rs']       = 'Texto';
$Filtro['id']       = 'texto';
$Filtro['js_tam']   = '0';
$Filtro['nome']     = 'Texto';
$Filtro['valor']    = trata_id($Filtro);
$vetFiltro['texto'] = $Filtro;

$Filtro = Array();
$Filtro['rs']       = 'Texto';
$Filtro['id']       = 'gestor';
$Filtro['js_tam']   = '0';
$Filtro['nome']     = 'Gestor';
$Filtro['valor']    = trata_id($Filtro);
$vetFiltro['gestor'] = $Filtro;




$Filtro = Array();
$Filtro['rs']       = $vetSimNao;
$Filtro['id']       = 'gestor';
$Filtro['js_tam']   = '0';
$Filtro['nome']     = 'Existe SiacWeb';
$Filtro['valor']    = trata_id($Filtro);
$vetFiltro['existesiacweb'] = $Filtro;

$Filtro = Array();
$Filtro['rs']       = $vetSimNao;
$Filtro['id']       = 'gestor';
$Filtro['js_tam']   = '0';
$Filtro['nome']     = 'Ativo SiacWeb';
$Filtro['valor']    = trata_id($Filtro);
$vetFiltro['ativosiacweb'] = $Filtro;


$sql   = 'select ';
$sql  .= '   grc_ps.idt, grc_ps.descricao  ';
$sql  .= ' from grc_projeto_situacao grc_ps ';
$sql  .= ' order by grc_ps.codigo ';
$rs = execsql($sql);
$Filtro = Array();
$Filtro['rs']        = $rs;
$Filtro['id']        = 'idt';
$Filtro['js_tam']    = '0';
$Filtro['LinhaUm']   = '-- Todas as Etapas --';
$Filtro['nome']      = 'Etapas do Projeto';
$Filtro['valor']     = trata_id($Filtro);
$vetFiltro['idt_projeto_situacao'] = $Filtro;



$orderby = "{$AliasPric}.codigo";

/*
$vetCampo['codigo']    = CriaVetTabela('Código');
$vetCampo['descricao'] = CriaVetTabela('Descrição');
$vetCampo['ativo']     = CriaVetTabela('Ativo?', 'descDominio', $vetSimNao );
$vetCampo['data_inicio']  = CriaVetTabela('Data Inicio','data');
$vetCampo['data_termino']  = CriaVetTabela('Data Termino','data');
$vetCampo['plu_usu_nome_completo'] = CriaVetTabela('Gestor');
$vetCampo['grc_ps_descricao'] = CriaVetTabela('Situação');
$vetCampo['codigo_sge'] = CriaVetTabela('Cod.SGE');
*/

//$vetCampo['codigo']    = CriaVetTabela('Código');
$vetCampo['descricao']        = CriaVetTabela('Título');
$vetCampo['grc_ps_descricao'] = CriaVetTabela('Etapa');
$vetCampo['gestor']           = CriaVetTabela('Gestor');
$vetCampo['existe_siacweb']   = CriaVetTabela('Existe SIACWEB?', 'descDominio', $vetSimNao );
$vetCampo['ativo_siacweb']    = CriaVetTabela('Ativo SIACWEB?', 'descDominio', $vetSimNao );
$vetCampo['nan']              = CriaVetTabela('NAN?', 'descDominio', $vetSimNao );
$vetCampo['ativo_nan']        = CriaVetTabela('Ativo NAN?', 'descDominio', $vetSimNao );


$sql   = "select ";
$sql  .= "   {$AliasPric}.*,  ";
$sql  .= "  grc_ps.descricao as grc_ps_descricao, ";
$sql  .= "  plu_usu.nome_completo as plu_usu_nome_completo ";
$sql  .= " from {$TabelaPrinc} as {$AliasPric} ";
$sql .= " left  join grc_projeto_situacao grc_ps on grc_ps.idt = {$AliasPric}.idt_projeto_situacao ";
$sql .= " left  join plu_usuario plu_usu on plu_usu.id_usuario = {$AliasPric}.idt_usuario_gestor ";


$conector = " where ";
if ($vetFiltro['idt_projeto_situacao']['valor']!="" and $vetFiltro['idt_projeto_situacao']['valor']!="-1")
{
    $sql .= ' where ';
    $sql .= ' (  idt_projeto_situacao = '.null($vetFiltro['idt_projeto_situacao']['valor'])." ) ";
    $conector = " and ";


}
if ($vetFiltro['texto']['valor']!="")
{
    $sql .= " $conector ";
    $sql .= ' ( ';
    $sql .= '    lower('.$AliasPric.'.descricao) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' or lower('.$AliasPric.'.gestor) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' ) ';
    $conector = " and ";
}
else
{
    if ($vetFiltro['gestor']['valor']!="")
    {
        $sql .= " $conector ";
        $sql .= ' ( ';
        $sql .= '    lower('.$AliasPric.'.gestor) like lower('.aspa($vetFiltro['gestor']['valor'], '%', '%').')';
        $sql .= ' ) ';
        $conector = " and ";
    }
}


if ($vetFiltro['existesiacweb']['valor']!="")
{
        $sql .= " $conector ";
        $sql .= ' ( ';
        $sql .= '    existe_siacweb ='.aspa($vetFiltro['existesiacweb']['valor']) ;
        $sql .= ' ) ';
        $conector = " and ";
}

if ($vetFiltro['ativo']['valor']!="")
{
        $sql .= " $conector ";
        $sql .= ' ( ';
        $sql .= '    ativo_siacweb ='.aspa($vetFiltro['ativosiacweb']['valor']) ;
        $sql .= ' ) ';
        $conector = " and ";
}

if ($vetFiltro['nan']['valor']=="S")
{
        $sql .= " $conector ";
        $sql .= ' ( ';
        $sql .= '    ativo_nan ='.aspa($vetFiltro['nan']['valor']) ;
        $sql .= ' ) ';
        $conector = " and ";
}


if ($sqlOrderby == '') {
        $sqlOrderby = "descricao asc";
}


?>