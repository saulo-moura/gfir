<?php
$idCampo = 'idt';
$Tela = "a Especialidade";

$TabelaPrinc      = "grc_atendimento_especialidade";
$AliasPric        = "grc_cam";
$Entidade         = "Especialidade";
$Entidade_p       = "Especialidades";

$barra_inc_h = "Incluir um Novo Registro de {$Entidade}";
$contlinfim  = "Existem #qt {$Entidade_p}.";

$Filtro = Array();
$Filtro['rs']       = 'Texto';
$Filtro['id']       = 'texto';
$Filtro['js_tam']   = '0';
$Filtro['nome']     = 'Texto';
$Filtro['valor']    = trata_id($Filtro);
$vetFiltro['texto'] = $Filtro;

//$orderby = "{$AliasPric}.codigo";

$vetCampo['tipo_atendimento']   = CriaVetTabela('Tipo<br />Atendimento', 'descDominio', $vetTPAT );
$vetCampo['codigo']             = CriaVetTabela('Código');
$vetCampo['descricao']          = CriaVetTabela('Título');
$vetCampo['periodo']            = CriaVetTabela('Duração do Atendimento<br />(Minutos)');
$vetCampo['quantidade_periodo'] = CriaVetTabela('Quantidade de Períodos<br /> (Minutos)');
$vetCampo['opcoes_escolher']    = CriaVetTabela('Opções de Escolha');
$vetCampo['ativo']              = CriaVetTabela('Ativo?', 'descDominio', $vetSimNao );

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
//$sql  .= " order by {$orderby}";

?>