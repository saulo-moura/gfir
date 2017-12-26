<?php
$idCampo = 'idt';
$Tela = "a Situa��o de Evento";

$TabelaPrinc      = "grc_evento_situacao";
$AliasPric        = "grc_esi";
$Entidade         = "Situa��o de Evento";
$Entidade_p       = "Situa��es de Evento";

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
$vetEtapaSit['A']='Aprova��o';
$vetEtapaSit['E']='Execu��o';
$vetEtapaSit['P']='Pend�ncia';
$vetEtapaSit['C']='Parado';



$vetCampo['codigo']     = CriaVetTabela('C�digo');
$vetCampo['descricao']  = CriaVetTabela('Descri��o');
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