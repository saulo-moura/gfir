<?php

//p($_GET);

if ($_GET['idCad'] != '') {
   $_GET['idt0'] = $_GET['idCad'];
   $botao_volta = "parent.btFechaCTC('".$_GET['session_cod']."');";
   $botao_acao = '<script type="text/javascript">parent.btFechaCTC("'.$_GET['session_cod'].'");</script>';
}
//p($_GET);


$TabelaPai   = "gec_edital";
$AliasPai    = "gec_ed";
$EntidadePai = "Edital";
$idPai       = "idt";



//
$TabelaPrinc      = "gec_edital_processo";
$AliasPric        = "gec_edp";
$Entidade         = "Processo  do Edital";
$Entidade_p       = "Processos do Edital";
$CampoPricPai     = "idt_edital";

$tabela = $TabelaPrinc;

$id = 'idt';
$vetCampo[$CampoPricPai] = objFixoBanco($CampoPricPai, $EntidadePai, $TabelaPai, 'idt', 'descricao', 0);


//$vetCampo['data_inicio'] = objDatahora('data_inicio', 'Data Inicio', False);
//$vetCampo['data_termino']   = objDatahora('data_termino', 'Data Termino', False);

$vetCampo['numero']        = objTexto('numero', 'Número', True, 20, 45);
$vetCampo['titulo']     = objTexto('titulo', 'Título', True, 60, 120);

$sql  = "select idt, codigo, descricao from gec_edital_processo_situacao ";
$sql .= " order by codigo";
$vetCampo['idt_situacao'] = objCmbBanco('idt_situacao', 'Situação', true, $sql,'','width:180px;');


$maxlength  = 2000;
$style      = "width:700px;";
$js         = "";
$vetCampo['detalhe'] = objTextArea('detalhe', 'Objeto do Processo', false, $maxlength, $style, $js);


//
$vetFrm = Array();
$vetFrm[] = Frame('<span>Edital</span>', Array(
    Array($vetCampo[$CampoPricPai]),
),$class_frame,$class_titulo,$titulo_na_linha);

MesclarCol($vetCampo['idt_situacao'], 3);

$vetFrm[] = Frame('<span>Datas</span>', Array(
    Array($vetCampo['numero'],'',$vetCampo['titulo']),
    Array($vetCampo['idt_situacao']),
),$class_frame,$class_titulo,$titulo_na_linha);

$vetFrm[] = Frame('<span>Observações</span>', Array(
    Array($vetCampo['detalhe']),
),$class_frame,$class_titulo,$titulo_na_linha);




//--------------------------------------- ETAPAS


$vetParametros = Array(
    'codigo_frm' => 'etapa',
    'controle_fecha' => 'A',
);
$vetFrm[] = Frame('<span>2 - ETAPAS</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

$vetCampo = Array();
$vetCampo['gec_ede_descricao']  = CriaVetTabela('Etapa');
$vetCampo['data_inicio']     = CriaVetTabela('Data Inicio', 'data');
$vetCampo['data_termino']     = CriaVetTabela('Data Término', 'data');

$vetCampo['ggec_edes_descricao']     = CriaVetTabela('Situação');

$vetCampo['detalhe']         = CriaVetTabela('Observações');


$titulo = 'Etapas do Processo';

$TabelaPrinc      = "gec_edital_etapas";
$AliasPric        = "gec_edets";
$Entidade         = "Etapa  do Edital";
$Entidade_p       = "Etapas do Edital";

$CampoPricPai1    = "idt_edital";
$CampoPricPai     = "idt_processo";

$orderby = "gec_ede.codigo";

$sql  = "select {$AliasPric}.*, ";
$sql  .= "       gec_ede.descricao as gec_ede_descricao, ";

$sql  .= "       gec_edes.descricao as ggec_edes_descricao ";

$sql .= " from {$TabelaPrinc} {$AliasPric}  ";
$sql .= " inner join gec_edital_etapa gec_ede on gec_ede.idt = {$AliasPric}.idt_etapa ";

$sql .= " inner join gec_edital_etapas_situacao gec_edes on gec_edes.idt = {$AliasPric}.idt_situacao ";
//
$sql .= " where {$AliasPric}".'.idt_processo = $vlID';
$sql .= " order by {$orderby}";


$vetCampo['gec_edital_processo_etapa'] = objListarConf('gec_edital_processo_etapa', 'idt', $vetCampo, $sql, $titulo, true);

$vetParametros = Array(
    'codigo_pai' => 'etapas',
    'width' => '100%',
);

$vetFrm[] = Frame('<span>Etapas</span>', Array(
    Array($vetCampo['gec_edital_processo_etapa']),
),$class_frame,$class_titulo,$titulo_na_linha,$vetParametros);









$vetCad[] = $vetFrm;
?>