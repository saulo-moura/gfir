<?php
$idCampo = 'CodParceiro';

//$idCampo = 'idt';


$Tela = "o Parceiro";

$TabelaPrinc      = "db_pir_siac.parceiro";
$AliasPric        = "siac_p";
$Entidade         = "Parceiro";
$Entidade_p       = "Parceiros";

$barra_inc_h = "Incluir um Novo Registro de {$Entidade}";
$contlinfim  = "Existem #qt {$Entidade_p}.";

$tipoidentificacao = 'N';
$tipofiltro = 'S';
$comfiltro = 'A';
$comidentificacao = 'F';


$sql   = 'select ';
$sql  .= '   siac_s.codsebrae, siac_s.descsebrae  ';
$sql  .= ' from db_pir_siac.sebrae siac_s ';
// $sql  .= ' left join bia_menubia bia_mb on bia_mb.idt_sebrae = bia_s.idt ';
// $sql  .= ' left join bia_submenubia bia_smb on bia_smb.idt_menubia = bia_mb.idt ';
// $sql  .= ' where  bia_s.idt = 17 ';
$sql  .= ' order by  siac_s.descsebrae ';
$rs = execsql($sql);

$Filtro = Array();
$Filtro['rs']       = $rs;
$Filtro['id']       = 'codsebrae';
$Filtro['js_tam']   = '0';
$Filtro['LinhaUm']  = '-- Seleciona Todos --';
$Filtro['nome']     = 'Sebrae';
$Filtro['valor']    = trata_id($Filtro);
$vetFiltro['codsebrae'] = $Filtro;

// Descida para o nivel 2

$prefixow    = 'listar';
$mostrar    = false;
$cond_campo = '';
$cond_valor = '';

//$imagem  = 'imagens/empresa_16.png';
//$goCad[] = vetCad('idt', 'Diagnóstico', 'grc_atendimento_diagnostico', $prefixow, $mostrar, $imagem, $cond_campo, $cond_valor);

//$imagem  = 'imagens/empresa_16.png';
//$goCad[] = vetCad('idt', 'Produtos', 'grc_atendimento_produto', $prefixow, $mostrar, $imagem, $cond_campo, $cond_valor);

$Filtro = Array();
$Filtro['rs']       = 'Texto';
$Filtro['id']       = 'texto';
$Filtro['js_tam']   = '0';
$Filtro['nome']     = 'Texto Principal';
$Filtro['valor']    = trata_id($Filtro);
$vetFiltro['texto'] = $Filtro;

$Filtro = Array();
$Filtro['rs']       = 'Texto';
$Filtro['id']       = 'texto1';
$Filtro['js_tam']   = '0';
$Filtro['nome']     = 'Texto Secundario (AND)';
$Filtro['valor']    = trata_id($Filtro);
$vetFiltro['texto1'] = $Filtro;

$vetCampo['siac_s_descsebrae'] = CriaVetTabela('SEBRAE');
$vetCampo['CgcCpf']            = CriaVetTabela('CNPJ/CPF');
$vetCampo['NomeAbrevFantasia'] = CriaVetTabela('Nome Fantasia');
$vetCampo['NomeRazaoSocial']   = CriaVetTabela('Nome/Razão Social');
$vetCampo['TipoParceiro']      = CriaVetTabela('Tipo');
//$vetCampo['TipoParceiro']   = CriaVetTabela('Status',   'descDominio', $vetConteudoBIAStatus);
//$vetCampo['Situacao']           = CriaVetTabela('Situação', 'descDominio', $vetConteudoBIASituacao);



//$vetCampo['ativo']     = CriaVetTabela('Ativo?', 'descDominio', $vetSimNao );

//$vetCampo['bia_cbsm_Principal'] = CriaVetTabela('Principal');

//$orderby = "{$AliasPric}.NomeRazaoSocial";

$sql   = "select ";
$sql  .= "   {$AliasPric}.* ,";
$sql  .= "    siac_s.descsebrae as siac_s_descsebrae ";
$sql  .= " from {$TabelaPrinc} as {$AliasPric} ";
//$sql .= " inner join bia_conteudobiasubmenu bia_cbsm on bia_cbsm.idt_conteudobia = {$AliasPric}.idt ";
$sql .= " left join db_pir_siac.sebrae siac_s on siac_s.codsebrae = {$AliasPric}.CodSebrae ";




 if ($vetFiltro['codsebrae']['valor']=='' or $vetFiltro['codsebrae']['valor']=='-1')
{
    $kwhere=' where(2=1) ';
    $sql  .=  $kwhere;
    $kwhere=' or ';

}
else
{
     $sql  .= " where {$AliasPric}.CodSebrae = ".null($vetFiltro['codsebrae']['valor']);
     $kwhere=' and ';
}




$AliasSebrae = 'siac_s';

if ($vetFiltro['texto']['valor']!="")
{
    $sql .= $kwhere;
    $sql .= ' ( ';
    $sql .= '    lower('.$AliasPric.'.CgcCpf)            like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' or lower('.$AliasPric.'.NomeAbrevFantasia) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' or lower('.$AliasPric.'.NomeRazaoSocial)   like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' or lower('.$AliasPric.'.TipoParceiro)      like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' or lower('.$AliasSebrae.'.descsebrae)      like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' ) ';
}


if ($vetFiltro['texto1']['valor']!="")
{
    if ($vetFiltro['texto']['valor']!="")
    {
        $sql .= ' or ';
    }
    else
    {
        $sql .= ' or ';
    }
    $sql .= ' ( ';
    $sql .= '    lower('.$AliasPric.'.CgcCpf)            like lower('.aspa($vetFiltro['texto1']['valor'], '%', '%').')';
    $sql .= ' or lower('.$AliasPric.'.NomeAbrevFantasia) like lower('.aspa($vetFiltro['texto1']['valor'], '%', '%').')';
    $sql .= ' or lower('.$AliasPric.'.NomeRazaoSocial)   like lower('.aspa($vetFiltro['texto1']['valor'], '%', '%').')';
    $sql .= ' or lower('.$AliasPric.'.TipoParceiro)      like lower('.aspa($vetFiltro['texto1']['valor'], '%', '%').')';
    $sql .= ' or lower('.$AliasSebrae.'.descsebrae)      like lower('.aspa($vetFiltro['texto1']['valor'], '%', '%').')';
    $sql .= ' ) ';
}

//p($sql);
//$sql  .= " order by {$orderby}";
//$sql .= " order by bia_cbsm.Principal desc, bia_cbsm.Ordem asc ";
//$sql .= " order by bia_cbsm.Principal desc, DataCadastro desc ";
//if ($sqlOrderby == '') {
   //     $sqlOrderby = "bia_cbsm.Principal desc, DataPublicacao desc";
//}

?>
