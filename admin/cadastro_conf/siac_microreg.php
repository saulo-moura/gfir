<?php
$tabela = 'db_pir_siac.microreg';
$id = 'idt';

$vetCampo['codmicro']   = objInteiro('codmicro', 'Código', True, 6, 6);
$vetCampo['descmicro']  = objTexto('descmicro', 'Descrição', True, 30, 30);

$sql = "select CodEst, DescEst from db_pir_siac.estado order by DescEst";
$vetCampo['codest'] = objCmbBanco('codest', 'Estado', true, $sql,'','width:800px;');

$sql = "select CodCid, DescCid from db_pir_siac.cidade order by DescCid";
$vetCampo['numcidade'] = objCmbBanco('numcidade', 'Cidade', false, $sql,'','width:800px;');

$sql = "select codmeso, descmeso from db_pir_siac.mesoreg order by descmeso";
$vetCampo['codmeso'] = objCmbBanco('codmeso', 'Mesoregião', false, $sql,'','width:800px;');

//
$maxlength  = 700;
$style      = "width:700px;";
$js         = "";
$vetCampo['detalhe'] = objTextArea('detalhe', 'Detalhe', false, $maxlength, $style, $js);
//$sql = "select idt, codigo, descricao from plu_estado order by descricao";
//$vetCampo['idt_estado'] = objCmbBanco('idt_estado', 'Estado', true, $sql,'','width:180px;');
$vetFrm = Array();
$vetFrm[] = Frame('<span>Identificação</span>', Array(
    Array($vetCampo['codmicro'],'',$vetCampo['descmicro']),
),$class_frame,$class_titulo,$titulo_na_linha);

$vetFrm[] = Frame('<span>Associação</span>', Array(
    Array($vetCampo['codest']),
    Array($vetCampo['numcidade']),
    Array($vetCampo['codmeso']),

),$class_frame,$class_titulo,$titulo_na_linha);



//$vetFrm[] = Frame('<span>Resumo</span>', Array(
//    Array($vetCampo['detalhe']),
//),$class_frame,$class_titulo,$titulo_na_linha);

$vetCad[] = $vetFrm;
?>
