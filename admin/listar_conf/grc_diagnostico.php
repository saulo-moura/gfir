<?php
$idCampo = 'idt';
$Tela = "o Diagnóstico";

$TabelaPrinc      = "grc_diagnostico";
$AliasPric        = "grc_dis";
$Entidade         = "Diagnóstico";
$Entidade_p       = "Diagnóstico";

$barra_inc_h = "Incluir um Novo Registro de {$Entidade}";
$contlinfim  = "Existem #qt {$Entidade_p}.";
// Descida para o nivel 2

$prefixow    = 'listar';
$mostrar    = false;
$cond_campo = '';
$cond_valor = '';

$imagem     = 'imagens/empresa_16.png';
$goCad[] = vetCad('idt', 'Perguntas', 'grc_diagnostico_pergunta', $prefixow, $mostrar, $imagem, $cond_campo, $cond_valor);

$Filtro = Array();
$Filtro['rs']       = 'Texto';
$Filtro['id']       = 'texto';
$Filtro['js_tam']   = '0';
$Filtro['nome']     = 'Texto';
$Filtro['valor']    = trata_id($Filtro);
$vetFiltro['texto'] = $Filtro;

$orderby = "{$AliasPric}.codigo";

$vetCampo['codigo']    = CriaVetTabela('Código');
$vetCampo['descricao'] = CriaVetTabela('Descrição');
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