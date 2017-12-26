<?php
$tabela = 'plu_link_util_grupo';
$id = 'idt';

//$TabelaPai   = "".db_pir."sca_organizacao_secao";
//$AliasPai    = "sca_os";
//$EntidadePai = "PA's";
//$idPai       = "idt";

//$CampoPricPai     = "idt_organizacao_secao";
//$vetCampo[$CampoPricPai] = objFixoBanco($CampoPricPai, $EntidadePai, $TabelaPai, 'idt', 'descricao', 0);

$vetCampo['codigo']    = objTexto('codigo', 'Código', True, 15, 45);
$vetCampo['descricao'] = objTexto('descricao', 'Descrição', True, 60, 120);

$sql   = 'select ';
$sql  .= '   idt, descricao  ';
$sql  .= ' from '.db_pir.'sca_organizacao_secao sac_os ';
$sql  .= " where posto_atendimento = 'UR' or posto_atendimento = 'S' ";
$sql  .= ' order by classificacao ';
$js = " ";
$vetCampo['idt_ponto_atendimento'] = objCmbBanco('idt_ponto_atendimento', 'Ponto Atendimento', false, $sql,' ','width:250px;',$js);


//$vetFrm[] = Frame('<span>Ponto de Atendimento</span>', Array(
//    Array($vetCampo[$CampoPricPai]),
//),$class_frame,$class_titulo,$titulo_na_linha);

$vetFrm = Array();
$vetFrm[] = Frame('<span>Identificação</span>', Array(
    Array($vetCampo['codigo'],'',$vetCampo['descricao'],'',$vetCampo['idt_ponto_atendimento']),
),$class_frame,$class_titulo,$titulo_na_linha);


// INÍCIO
// DEFINIÇÃO DE TELA FORMATO FULL SCREEN DENTRO DA FICHA DE ATENDIMENTO
// PRODUTOS DE ATENDIMENTO
//____________________________________________________________________________


$vetParametros = Array(
    'codigo_frm' => 'plu_link_util_grupo_usuario_w',
    'controle_fecha' => 'A',
);
$vetFrm[] = Frame('<span>02 - USUÁRIOS</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

// Definição de campos formato full que serão editados na tela full

$vetCampo = Array();
//Monta o vetor de Campo

$vetCampo['pu_nome_completo']    = CriaVetTabela('Usuário');


// Parametros da tela full conforme padrão

$titulo = 'Usuários';

$TabelaPrinc      = "plu_link_util_grupo_usuario";
$AliasPric        = "plu_lugu";
$Entidade         = "Usuário do Grupo";
$Entidade_p       = "Usuários do Grupo";

// Select para obter campos da tabela que serão utilizados no full

$orderby = "pu_nome_completo";


$sql   = "select ";
$sql  .= "   {$AliasPric}.*, pu.nome_completo as pu_nome_completo  ";
$sql  .= " from {$TabelaPrinc} as {$AliasPric} ";
$sql  .= " inner join plu_usuario as pu on pu.id_usuario = .{$AliasPric}.idt_usuario ";
//
$sql .= " where {$AliasPric}".'.idt_grupo = $vlID';
$sql .= " order by {$orderby}";

// Carrega campos que serão editados na tela full


$vetCampo['plu_link_util_grupo_usuario'] = objListarConf('plu_link_util_grupo_usuario', 'idt', $vetCampo, $sql, $titulo, false);

// Fotmata lay_out de saida da tela full

$vetParametros = Array(
    'codigo_pai' => 'plu_link_util_grupo_usuario_w',
    'width' => '100%',
);

$vetFrm[] = Frame('<span></span>', Array(
    Array($vetCampo['plu_link_util_grupo_usuario']),
),$class_frame,$class_titulo,$titulo_na_linha,$vetParametros);

// FIM ____________________________________________________________________________







$vetCad[] = $vetFrm;
?>
