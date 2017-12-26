<style>
  .proprio {
      width:100%;
      background: #2F66B8;
      color     : #FFFFFF;
      text-align: center;
      font-size:18px;
      height:20px;
      padding:10px;
      
  }
</style>
<?php
$idCampo = 'idt';
$Tela = "os Atores do NAN";

$TabelaPrinc      = "grc_nan_estrutura";
$AliasPric        = "grc_ne";
$Entidade         = "Ator do NAN";
$Entidade_p       = "Atores do NAN";


$tipoidentificacao = 'N';
$tipofiltro = 'S';
$comfiltro = 'A';
$comidentificacao = 'F';

$reg_pagina_esp = 120;

$barra_inc_ap = false;
$barra_alt_ap = false;
$barra_con_ap = true;
$barra_exc_ap = false;
$barra_fec_ap = false;



$barra_inc_h = "Incluir um Novo Registro de {$Entidade}";
$contlinfim  = "Existem #qt {$Entidade_p}.";



$sql   = 'select ';
$sql  .= '   idt, descricao  ';
$sql  .= ' from '.db_pir.'sca_organizacao_secao sac_os ';
//$sql  .= " where posto_atendimento = 'UR' or posto_atendimento = 'S' ";
$sql  .= " where tipo_estrutura = 'UR' ";
$sql  .= ' order by descricao ';
$rs = execsql($sql);

$Filtro = Array();
$Filtro['rs']       = $rs;
$Filtro['id']       = 'idt';
$Filtro['js_tam']   = '0';
$Filtro['nome']     = 'Unidade Regional';
$Filtro['LinhaUm']  = '-- Todas --';
$Filtro['valor']    = trata_id($Filtro);
$vetFiltro['ponto_atendimento'] = $Filtro;

$Filtro = Array();
$Filtro['rs']       = 'Texto';
$Filtro['id']       = 'texto';
$Filtro['js_tam']   = '0';
$Filtro['nome']     = 'Texto';
$Filtro['valor']    = trata_id($Filtro);
$vetFiltro['texto'] = $Filtro;

//$vetCampo['codigo']             = CriaVetTabela('Código');
//$vetCampo['grc_nte_descricao']  = CriaVetTabela('Tipo de Ator');
$vetCampo['plu_usuario']          = CriaVetTabela('Agente');
$vetCampo['gec_e_executora']      = CriaVetTabela('Empresa Executora');

$vetCampo['plu_usut_usuario']     = CriaVetTabela('Tutor');

$vetCampo['grc_p_descricao']      = CriaVetTabela('Projeto');
$vetCampo['grc_pa_descricao']     = CriaVetTabela('Ação');
$vetCampo['sca_nan_ur']           = CriaVetTabela('Unidade Regional');
$vetCampo['ativo']                = CriaVetTabela('Ativo?','descDominio',$vetSimNao);




$sql   = "select ";
$sql  .= "   {$AliasPric}.*, ";
$sql  .= '   gec_e.descricao as gec_e_executora, ';
$sql  .= '   sca_nan.descricao as sca_nan_ur, ';

$sql  .= "   grc_p.descricao as grc_p_descricao,  ";

$sql  .= "   grc_pa.descricao as grc_pa_descricao,  ";

$sql  .= "   grc_nte.descricao as grc_nte_descricao,  ";
$sql  .= "   plu_usu.nome_completo as plu_usuario,  ";
$sql  .= "   plu_usut.nome_completo as plu_usut_usuario  ";
$sql  .= " from {$TabelaPrinc} as {$AliasPric} ";
$sql  .= " inner join grc_nan_estrutura_tipo grc_nte on grc_nte.idt = {$AliasPric}.idt_nan_tipo ";

$sql  .= " left  join grc_projeto_acao grc_pa on grc_pa.idt = {$AliasPric}.idt_acao ";
$sql  .= " left  join grc_projeto grc_p on grc_p.idt = grc_pa.idt_projeto ";

$sql  .= " left  join plu_usuario plu_usu on plu_usu.id_usuario = {$AliasPric}.idt_usuario ";
$sql  .= " left  join ".db_pir_gec."gec_contratar_credenciado gec_cc on gec_cc.idt = {$AliasPric}.idt_contrato ";

$sql  .= " left join ".db_pir_gec."gec_entidade gec_e on gec_e.idt = gec_cc.idt_organizacao";
$sql  .= " left join ".db_pir."sca_organizacao_secao sca_nan on sca_nan.idt = gec_cc.nan_idt_unidade_regional";

$sql  .= " left  join grc_nan_estrutura grc_net on grc_net.idt = {$AliasPric}.idt_tutor ";

$sql  .= " left  join plu_usuario plu_usut on plu_usut.id_usuario = grc_net.idt_usuario ";

//$sql  .= " left  join plu_usuario plu_usut on plu_usut.id_usuario =  {$AliasPric}.idt_tutor ";

$sql  .= " where {$AliasPric}.idt_nan_tipo = 6";

if ($vetFiltro['ponto_atendimento']['valor']!="" and $vetFiltro['ponto_atendimento']['valor']!="-1")
{
    $sql  .= ' and gec_cc.nan_idt_unidade_regional = '.null($vetFiltro['ponto_atendimento']['valor']);
}
if ($vetFiltro['texto']['valor']!="")
{
    $sql .= ' and ';
    $sql .= ' ( ';
    $sql .= "     lower({$AliasPric}.descricao) like lower(".aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= "  or lower({$AliasPric}.codigo) like lower(".aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= "  or lower({$AliasPric}.detalhe) like lower(".aspa($vetFiltro['texto']['valor'], '%', '%').')';
	$sql .= "  or lower({$AliasPric}.detalhe) like lower(".aspa($vetFiltro['texto']['valor'], '%', '%').')';
	
	$sql .= "  or lower(gec_e.descricao) like lower(".aspa($vetFiltro['texto']['valor'], '%', '%').')';
	$sql .= "  or lower(sca_nan.descricao) like lower(".aspa($vetFiltro['texto']['valor'], '%', '%').')';
	$sql .= "  or lower(grc_p.descricao) like lower(".aspa($vetFiltro['texto']['valor'], '%', '%').')';
	
	$sql .= "  or lower(grc_pa.descricao) like lower(".aspa($vetFiltro['texto']['valor'], '%', '%').')';
	
	$sql .= "  or lower(grc_nte.descricao) like lower(".aspa($vetFiltro['texto']['valor'], '%', '%').')';
	$sql .= "  or lower(plu_usu.nome_completo) like lower(".aspa($vetFiltro['texto']['valor'], '%', '%').')';
	$sql .= "  or lower(plu_usut.nome_completo) like lower(".aspa($vetFiltro['texto']['valor'], '%', '%').')';
	
	
    $sql .= ' ) ';
}

//if ($sqlOrderby == '') {
//    $sqlOrderby = "grc_nte.codigo asc";
//}
//$sql  .= ' order by grc_ne.idt_tutor asc , grc_nte.codigo asc ';


?>
