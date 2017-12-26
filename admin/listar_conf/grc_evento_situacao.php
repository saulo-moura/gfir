<?php
$idCampo = 'idt';
$Tela = "a Situaчуo de Evento";

$TabelaPrinc      = "grc_evento_situacao";
$AliasPric        = "grc_esi";
$Entidade         = "Situaчуo de Evento";
$Entidade_p       = "Situaчѕes de Evento";

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




$vetEtapaSit=Array();
$vetEtapaSit['D']='Desenvolvimento';
$vetEtapaSit['A']='Aprovaчуo';
$vetEtapaSit['E']='Execuчуo';
$vetEtapaSit['P']='Pendъncia';
$vetEtapaSit['C']='Parado';



$vetCampo['codigo']     = CriaVetTabela('Cѓdigo');
$vetCampo['descricao']  = CriaVetTabela('Descriчуo');
$vetCampo['vai_para']   = CriaVetTabela('Vai para');
$vetCampo['volta_para'] = CriaVetTabela('Volta para');

$vetCampo['situacao_etapa']     = CriaVetTabela('Etapa', 'descDominio', $vetEtapaSit );


$vetCampo['ativo']     = CriaVetTabela('Ativo?', 'descDominio', $vetSimNao );

$sql   = "select ";
$sql  .= "   {$AliasPric}.*  ";
$sql  .= " from {$TabelaPrinc} as {$AliasPric} ";





if ($vetFiltro['texto']['valor']!="")
{
    $sql .= ' where ';
    $sql .= ' ( ';
    $sql .= '  lower('.$AliasPric.'.codigo)      like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' or lower('.$AliasPric.'.descricao) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' ) ';
}
$sql  .= " order by {$orderby}";

?>