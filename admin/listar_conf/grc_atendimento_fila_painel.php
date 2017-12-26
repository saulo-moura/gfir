<?php
$idCampo = 'idt';
$Tela = "os Painéis da Fila";


$TabelaPai   = "grc_atendimento_fila";
$AliasPai    = "grc_af";
$EntidadePai = "Fila";
$idPai       = "idt";

$mostrar    = true;
$cond_campo = '';
$cond_valor = '';
$prefixow    = 'listar';
$imagem     = 'imagens/endereco_16.png';

$upCad = vetCad('idt', 'Fila', 'grc_atendimento_fila');


$TabelaPrinc      = "grc_atendimento_fila_painel";
$AliasPric        = "grc_afp";
$Entidade         = "Painel da Fila";
$Entidade_p       = "Paineis da Filo";
$CampoPricPai     = "idt_fila";

$barra_inc_h = "Incluir um Novo Registro de {$Entidade}";
$contlinfim  = "Existem #qt {$Entidade_p}.";


$Filtro = Array();
$Filtro['rs']       = $rs;
$Filtro['id']       = 'idt_fila';
$Filtro['js_tam']   = '0';
$Filtro['nome']     = 'Paineis';
$Filtro['valor']    = trata_id($Filtro);
$vetFiltro['fila']  = $Filtro;

$Filtro = Array();
$Filtro['rs']       = 'Texto';
$Filtro['id']       = 'texto';
$Filtro['js_tam']   = '0';
$Filtro['nome']     = 'Texto';
$Filtro['valor']    = trata_id($Filtro);
$vetFiltro['texto'] = $Filtro;


    $comfiltro = 'A';
    $comidentificacao = 'A';

$orderby = "gap_descricao";

$vetCampo['gap_descricao'] = CriaVetTabela('Painel');


$sql   = "select ";
$sql  .= "   {$AliasPric}.*, gap.descricao as gap_descricao  ";
$sql  .= " from {$TabelaPrinc} as {$AliasPric} ";
$sql  .= " inner join grc_atendimento_painel as gap on gap.idt = .{$AliasPric}.idt_painel ";

$sql .= ' where ';
$sql .= " {$AliasPric}.idt_fila =  ".null($vetFiltro['fila']['valor']);


if ($vetFiltro['texto']['valor']!="")
{
    $sql .= ' and ';
    $sql .= ' ( ';
    $sql .= '    lower(gae.descricao)    like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' or lower(pu.nome_completo) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' ) ';
}
$sql  .= " order by {$orderby}";

?>
