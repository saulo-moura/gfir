<?php
$idCampo = 'idt';
$Tela = "o Parвmetro da Lista";



$TabelaPrinc      = "plu_parametros_lista";
$AliasPric        = "plu_pl";
$Entidade         = "Parвmetro da Lista";
$Entidade_p       = "Parвmetros da Lista";
$barra_inc_h = "Incluir um Novo Registro de {$Entidade}";
$contlinfim  = "Existem #qt {$Entidade_p}.";
$Filtro = Array();
$Filtro['rs']       = 'Texto';
$Filtro['id']       = 'texto';
$Filtro['js_tam']   = '0';
$Filtro['nome']     = 'Texto';
$Filtro['valor']    = trata_id($Filtro);
$vetFiltro['texto'] = $Filtro;
$orderby = "{$AliasPric}.codigo";
$vetCampo['codigo']                = CriaVetTabela('Cуdigo');
$vetCampo['numero']                = CriaVetTabela('Nъmero');
$vetCampo['descricao']             = CriaVetTabela('Descriзгo');
$vetCampo['plu_usu_nome_completo'] = CriaVetTabela('Proprietбrio');
$vetCampo['ativo']                 = CriaVetTabela('Ativo?','descDominio',$vetSimNao);
$sql   = "select ";
$sql  .= "   {$AliasPric}.*,  ";
$sql  .= "   plu_usu.nome_completo as plu_usu_nome_completo ";
$sql  .= " from {$TabelaPrinc} as {$AliasPric} ";
$sql  .= " inner join plu_usuario plu_usu on plu_usu.id_usuario = {$AliasPric}.idt_proprietario ";
if ($vetFiltro['texto']['valor']!="")
{
    $sql .= ' where ';
    $sql .= ' ( ';
    $sql .= '  lower('.$AliasPric.'.codigo)      like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' or lower('.$AliasPric.'.descricao) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
	$sql .= ' or lower('.$AliasPric.'.plu_usu.nome_completo) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' ) ';
}
//$sql  .= " order by {$orderby}";
