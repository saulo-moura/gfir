<?php
$idCampo = 'idt';
$Tela = "a Execuчуo do Funil";


$vetRetorno=Array();
$ano_atual=Funil_parametro(1,$vetRetorno);


$TabelaPrinc      = "grc_funil_{$ano_atual}_gestao_meta";
$AliasPric        = "grc_fgm";
$Entidade         = "Gestуo de Meta do Funil";
$Entidade_p       = "Gestѕes de Meta do Funil";

$barra_inc_h = "Incluir um Novo Registro de {$Entidade}";
$contlinfim  = "Existem #qt {$Entidade_p}.";

$tipoidentificacao = 'N';
$tipofiltro = 'S';
$comfiltro = 'A';
$comidentificacao = 'F';

$barra_inc_ap = false;
$barra_alt_ap = false;
$barra_con_ap = true;
$barra_exc_ap = false;
$barra_fec_ap = false;


$Filtro = Array();
$Filtro['rs']       = $vetNaoSim;
$Filtro['id']       = 'meta7';
$Filtro['js_tam']   = '0';
$Filtro['nome']     = 'Meta 7';
$Filtro['valor']    = trata_id($Filtro);
$vetFiltro['meta7'] = $Filtro;

$Filtro = Array();
$Filtro['rs']       = 'Texto';
$Filtro['id']       = 'tipo_pessoa';
$Filtro['js_tam']   = '0';
$Filtro['nome']     = 'Tipo de Pessoa';
$Filtro['valor']    = trata_id($Filtro);
$vetFiltro['tipo_pessoa'] = $Filtro;


$Filtro = Array();
$Filtro['rs']       = 'Texto';
$Filtro['id']       = 'cpf';
$Filtro['js_tam']   = '0';
$Filtro['nome']     = 'CPF';
$Filtro['valor']    = trata_id($Filtro);
$vetFiltro['cpf'] = $Filtro;

$Filtro = Array();
$Filtro['rs']       = 'Texto';
$Filtro['id']       = 'cliente';
$Filtro['js_tam']   = '0';
$Filtro['nome']     = 'Cliente';
$Filtro['valor']    = trata_id($Filtro);
$vetFiltro['cliente'] = $Filtro;



$Filtro = Array();
$Filtro['rs']       = 'Texto';
$Filtro['id']       = 'cnpj';
$Filtro['js_tam']   = '0';
$Filtro['nome']     = 'CNPJ';
$Filtro['valor']    = trata_id($Filtro);
$vetFiltro['cnpj'] = $Filtro;

$Filtro = Array();
$Filtro['rs']       = 'Texto';
$Filtro['id']       = 'organizacao';
$Filtro['js_tam']   = '0';
$Filtro['nome']     = 'Empreendimento';
$Filtro['valor']    = trata_id($Filtro);
$vetFiltro['organizacao'] = $Filtro;


$Filtro = Array();
$Filtro['rs']       = 'Texto';
$Filtro['id']       = 'instrumento';
$Filtro['js_tam']   = '0';
$Filtro['nome']     = 'Instrumento';
$Filtro['valor']    = trata_id($Filtro);
$vetFiltro['instrumento'] = $Filtro;

$Filtro = Array();
$Filtro['rs']       = 'Texto';
$Filtro['id']       = 'jurisdicao';
$Filtro['js_tam']   = '0';
$Filtro['nome']     = 'Jurisdiчуo';
$Filtro['valor']    = trata_id($Filtro);
$vetFiltro['jurisdicao'] = $Filtro;


$Filtro = Array();
$Filtro['rs']       = 'Texto';
$Filtro['id']       = 'texto';
$Filtro['js_tam']   = '0';
$Filtro['nome']     = 'Texto';
$Filtro['valor']    = trata_id($Filtro);
$vetFiltro['texto'] = $Filtro;

$orderby = "{$AliasPric}.cnpj ";

$vetCampo['ano']              = CriaVetTabela('Ano');
//$vetCampo['escritorio_de_atendimento']     = CriaVetTabela('Ponto de Atendimento');
//$vetCampo['tipo_pessoa']     = CriaVetTabela('Tipo Pessoa');
$vetCampo['cnpj']             = CriaVetTabela('CNPJ');
$vetCampo['razao_social']     = CriaVetTabela('Razуo Social');
//$vetCampo['meta_afetada']     = CriaVetTabela('Metas Sensibilizadas');
$vetCampo['meta1']            = CriaVetTabela('Meta 1','descDominio',$vetSimNao);

$vetCampo['meta7']            = CriaVetTabela('Meta 7','descDominio',$vetSimNao);

//$vetCampo['cpf']             = CriaVetTabela('CPF');
//$vetCampo['nome_cliente']             = CriaVetTabela('Cliente');
//$vetCampo['setor']            = CriaVetTabela('Setor');
$vetCampo['porte']            = CriaVetTabela('Porte');
//$vetCampo['tiporealizacao']   = CriaVetTabela('Tipo de Realizaчуo');
$vetCampo['instrumento']      = CriaVetTabela('Instrumento');
$vetCampo['codmicro']      = CriaVetTabela('Jurisdiчуo');
$vetCampo['regional_da_jurisdicao']      = CriaVetTabela('Jurisdiчуo');


$vetCampo['datahorainicial']  = CriaVetTabela('Data Hora Inicial');
//$vetCampo['meta7']            = CriaVetTabela('Meta 7','descDominio',$vetSimNao);
$sql   = "select ";
$sql  .= "   {$AliasPric}.*  ";
$sql  .= " from {$TabelaPrinc} as {$AliasPric} ";


$temfiltro = 1;
if ($vetFiltro['cnpj']['valor']=="" and $vetFiltro['cpf']['valor']=="" and $vetFiltro['tipo_pessoa']['valor']=="" and $vetFiltro['cliente']['valor']==""  and $vetFiltro['organizacao']['valor']==""  and $vetFiltro['texto']['valor']=="")
{
    $temfiltro = 0;
   
}
if ($temfiltro==0)
{
	if ($vetFiltro['meta7']['valor']=="N")
	{
       // alert("Por favor, informar filtro para pesquisa.");
	   // $sql  .= " where 2 = 1 ";
	   $sql  .= " where 1 = 1 ";
	}
	else
	{
	    $sql  .= " where 1 = 1 ";
	}
}
else
{
    $sql  .= " where 1 = 1 ";
}

if ($vetFiltro['meta7']['valor']=="S")
{
    $sql .= ' and ';
    $sql .= ' ( ';
	$sql .=  $AliasPric.'.meta7 = "S" ';
    $sql .= ' ) ';
}



if ($vetFiltro['tipo_pessoa']['valor']!="")
{
    $sql .= ' and ';
    $sql .= ' ( ';
	$sql .= ' lower('.$AliasPric.'.tipo_pessoa) like lower('.aspa($vetFiltro['tipo_pessoa']['valor'], '%', '%').')';
    $sql .= ' ) ';
	$orderby = "{$AliasPric}.nome_cliente  ";
}


if ($vetFiltro['cpf']['valor']!="")
{
    $sql .= ' and ';
    $sql .= ' ( ';
	$sql .=  $AliasPric.'.cpf = '.aspa($vetFiltro['cpf']['valor']);
    $sql .= ' ) ';
	$orderby = "{$AliasPric}.nome_cliente  ";
}

if ($vetFiltro['cliente']['valor']!="")
{
    $sql .= ' and ';
    $sql .= ' ( ';
	$sql .= ' lower('.$AliasPric.'.nome_cliente) like lower('.aspa($vetFiltro['cliente']['valor'], '%', '%').')';
    $sql .= ' ) ';
	$orderby = "{$AliasPric}.nome_cliente  ";
}



if ($vetFiltro['cnpj']['valor']!="")
{
    $sql .= ' and ';
    $sql .= ' ( ';
	$sql .=  $AliasPric.'.cnpj = '.aspa($vetFiltro['cnpj']['valor']);
    $sql .= ' ) ';
	$orderby = "{$AliasPric}.nome_cliente  ";
}

if ($vetFiltro['organizacao']['valor']!="")
{
    $sql .= ' and ';
    $sql .= ' ( ';
    $sql .= ' lower('.$AliasPric.'.razao_social) like lower('.aspa($vetFiltro['organizacao']['valor'], '%', '%').')';
    $sql .= ' ) ';
	$orderby = "{$AliasPric}.razao_social  ";
}

if ($vetFiltro['instrumento']['valor']!="")
{
    $sql .= ' and ';
    $sql .= ' ( ';
    $sql .= ' lower('.$AliasPric.'.instrumento) like lower('.aspa($vetFiltro['instrumento']['valor'], '%', '%').')';
    $sql .= ' ) ';
	$orderby = "{$AliasPric}.instrumento  ";
}

if ($vetFiltro['jurisdicao']['valor']!="")
{
    $sql .= ' and ';
    $sql .= ' ( ';
    $sql .= ' lower('.$AliasPric.'.codmicro) like lower('.aspa($vetFiltro['jurisdicao']['valor'], '%', '%').')';
	$sql .= ' or lower('.$AliasPric.'.regional_da_jurisdicao) like lower('.aspa($vetFiltro['jurisdicao']['valor'], '%', '%').')';
    $sql .= ' ) ';
	$orderby = "{$AliasPric}.codmicro  ";
}


if ($vetFiltro['texto']['valor']!="")
{
    $sql .= ' and ';
    $sql .= ' ( ';
    $sql .= '  lower('.$AliasPric.'.ano)      like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' or lower('.$AliasPric.'.cnpj) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
	$sql .= ' or lower('.$AliasPric.'.razao_social) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
	$sql .= ' or lower('.$AliasPric.'.cpf) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
	$sql .= ' or lower('.$AliasPric.'.nome_cliente) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
	$sql .= ' or lower('.$AliasPric.'.escritorio_de_atendimento) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
	$sql .= ' or lower('.$AliasPric.'.tiporealizacao) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
	$sql .= ' or lower('.$AliasPric.'.instrumento) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
	$sql .= ' or lower('.$AliasPric.'.tipo_pessoa) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
	$sql .= ' or lower('.$AliasPric.'.tipo_de_empreendimento) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
	$sql .= ' or lower('.$AliasPric.'.setor) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
	$sql .= ' or lower('.$AliasPric.'.porte) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
	$sql .= ' or lower('.$AliasPric.'.atividade_economica) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
//	$sql .= ' or lower('.$AliasPric.'.tipo_realizacao) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
	$sql .= ' or lower('.$AliasPric.'.codmicro) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
	$sql .= ' or lower('.$AliasPric.'.regional_da_jurisdicao) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
	$sql .= ' or lower('.$AliasPric.'.cidade) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' ) ';
}
$sql  .= " order by {$orderby}";


?>