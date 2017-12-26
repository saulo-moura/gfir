<?php
$tabela = 'db_pir_siac.mesoreg';
$id = 'idt';

$vetCampo['codmeso']    = objTexto('codmeso', 'Código', True, 6, 6);
$vetCampo['descmeso']   = objTexto('descmeso', 'Descrição', True, 30, 30);
$sql = "select CodEst, DescEst from db_pir_siac.estado order by DescEst";
$vetCampo['codest'] = objCmbBanco('codest', 'Estado', true, $sql,'','width:800px;');


//
$maxlength  = 700;
$style      = "width:700px;";
$js         = "";
$vetCampo['detalhe'] = objTextArea('detalhe', 'Detalhe', false, $maxlength, $style, $js);
//$sql = "select idt, codigo, descricao from plu_estado order by descricao";
//$vetCampo['idt_estado'] = objCmbBanco('idt_estado', 'Estado', true, $sql,'','width:180px;');
$vetFrm = Array();
$vetFrm[] = Frame('<span>Identificação</span>', Array(
    Array($vetCampo['codmeso'],'',$vetCampo['descmeso']),
),$class_frame,$class_titulo,$titulo_na_linha);

$vetFrm[] = Frame('<span>Associação</span>', Array(
    Array($vetCampo['codest']),
  ),$class_frame,$class_titulo,$titulo_na_linha);

//$vetFrm[] = Frame('<span>Resumo</span>', Array(
//    Array($vetCampo['detalhe']),
//),$class_frame,$class_titulo,$titulo_na_linha);

$vetCad[] = $vetFrm;
?>
