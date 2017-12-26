<?php

if ($_GET['idCad'] != '') {
   $_GET['idt0'] = $_GET['idCad'];
   $botao_volta = "parent.btFechaCTC('".$_GET['session_cod']."');";
   $botao_acao = '<script type="text/javascript">parent.btFechaCTC("'.$_GET['session_cod'].'");</script>';
}

$TabelaPai   = "gec_entidade";
$AliasPai    = "gec_en";
$EntidadePai = "Entidade";
$idPai       = "idt";

//
$TabelaPrinc      = "gec_entidade_mercado";
$AliasPric        = "gec_em";
$Entidade         = "Mercado da Entidade";
$Entidade_p       = "Mercados da Entidade";
$CampoPricPai     = "idt_entidade";

$tabela = $TabelaPrinc;

$id = 'idt';
$vetCampo[$CampoPricPai] = objFixoBanco($CampoPricPai, $EntidadePai, $TabelaPai, 'idt', 'descricao', 0);

$sql = "select idt, descricao from gec_mercado order by codigo";
$vetCampo['idt_mercado'] = objCmbBanco('idt_mercado', 'Mercado', true, $sql,' ','width:280px;');
$sql = "select idt, descricao from gec_mercado_tipo order by codigo";
$vetCampo['idt_tipo'] = objCmbBanco('idt_tipo', 'Tipo Mercado', true, $sql,' ','width:280px;');

$vetCampo['ativo']     = objCmbVetor('ativo', 'Ativo?', True, $vetSimNao,'');

$maxlength  = 2000;
$style      = "width:700px;";
$js         = "";
$vetCampo['detalhe'] = objTextArea('detalhe', 'Observação', false, $maxlength, $style, $js);



$vetCampo['data_inicio'] = objData('data_inicio', 'Data Inicio Atuação', true);
$vetCampo['data_termino'] = objData('data_termino', 'Data Término Atuação', False);



//
$vetFrm = Array();
$vetFrm[] = Frame('<span>Entidade</span>', Array(
    Array($vetCampo[$CampoPricPai]),
),$class_frame,$class_titulo,$titulo_na_linha);


$vetFrm[] = Frame('<span>Mercado</span>', Array(
    Array($vetCampo['idt_mercado'],'',$vetCampo['idt_tipo'],'',$vetCampo['ativo']),
),$class_frame,$class_titulo,$titulo_na_linha);

//MesclarCol($vetCampo['logradouro_pais'], 5);
$vetFrm[] = Frame('<span>Período de atuação</span>', Array(
    Array($vetCampo['data_inicio'],'',$vetCampo['data_termino']),
),$class_frame,$class_titulo,$titulo_na_linha);

$vetFrm[] = Frame('<span>Observações</span>', Array(
    Array($vetCampo['detalhe']),
),$class_frame,$class_titulo,$titulo_na_linha);


// produtos do mercado da entidade

$vetCampo = Array();
$vetCampo['gec_mp_descricao']  = CriaVetTabela('Produto');
$vetCampo['data_inicio']        = CriaVetTabela('Data Inicio', 'data');
$vetCampo['data_termino']       = CriaVetTabela('Data Término', 'data');
$vetCampo['ativo']                  = CriaVetTabela('Ativo?', 'descDominio', $vetSimNao );


$titulo = 'Produtos do Mercado da Entidade';



$TabelaPai    = "gec_entidade_mercado";
$AliasPai     = "gec_em";
$EntidadePai  = "Mercado";
$idPai        = "idt";

//
$TabelaPrinc      = "gec_entidade_mercado_produto";
$AliasPric        = "gec_emp";
$Entidade         = "Produto do Mercado";
$Entidade_p       = "Produtos do Mercado";

$CampoPricPai1    = "idt_entidade";
$CampoPricPai     = "idt_entidade_mercado";

//$orderby = " {$AliasPric}.origem ";
$orderby = "gec_mp.codigo";



$sql  = "select {$AliasPric}.*, ";
$sql  .= "       gec_mp.descricao as gec_mp_descricao ";

$sql .= " from {$TabelaPrinc} {$AliasPric}  ";
$sql .= " inner join {$TabelaPai} {$AliasPai} on  {$AliasPai}.idt = {$AliasPric}.{$CampoPricPai}";

$sql .= " inner join gec_mercado_produto gec_mp on gec_mp.idt = {$AliasPric}.idt_produto ";



$sql .= " where {$AliasPric}.{$CampoPricPai}".' = $vlID';
//$sql .= " where {$AliasPric}.{$CampoPricPai}".' = '.null($_GET['id']);
$sql .= " order by {$orderby}";
//p($sql);
//p($_GET);

$vetCampo['gec_entidade_mercado_produto'] = objListarConf('gec_entidade_mercado_produto', $idPai , $vetCampo, $sql, $titulo, true);

$vetParametros = Array(
    'width' => '100%',
);
$vetFrm[] = Frame('<span>Produtos</span>', Array(
    Array($vetCampo['gec_entidade_mercado_produto']),
),$class_frame,$class_titulo,$titulo_na_linha, $vetParametros);





$vetCad[] = $vetFrm;
?>