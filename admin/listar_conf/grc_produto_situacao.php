<?php
$idCampo = 'idt';
$Tela = "a Situaчуo de Produto";

$TabelaPrinc      = "grc_produto_situacao";
$AliasPric        = "grc_psi";
$Entidade         = "Situaчуo de Produto";
$Entidade_p       = "Situaчѕes de Produto";

$barra_inc_h = "Incluir um Novo Registro de {$Entidade}";
$contlinfim  = "Existem #qt {$Entidade_p}.";

    $barra_inc_ap=false;
    $barra_alt_ap=false;
    $barra_con_ap=true;
    $barra_exc_ap=false;


$Filtro = Array();
$Filtro['rs']       = 'Texto';
$Filtro['id']       = 'texto';
$Filtro['js_tam']   = '0';
$Filtro['nome']     = 'Texto';
$Filtro['valor']    = trata_id($Filtro);
$vetFiltro['texto'] = $Filtro;

$orderby = "{$AliasPric}.codigo";

$vetCampo['codigo']    = CriaVetTabela('Cѓdigo');
$vetCampo['descricao'] = CriaVetTabela('Descriчуo');
$vetCampo['ativo']     = CriaVetTabela('Ativo?', 'descDominio', $vetSimNao );



$vetEmDesenvolvimentoEmExecucao=Array();
$vetEmDesenvolvimentoEmExecucao['D']='Em Desenvolvimento';
$vetEmDesenvolvimentoEmExecucao['E']='Em Execuчуo';

$vetCampo['situacao_etapa'] = CriaVetTabela('Etapa', 'descDominio', $vetEmDesenvolvimentoEmExecucao );

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