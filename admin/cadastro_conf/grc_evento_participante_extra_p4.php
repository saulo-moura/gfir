<?php
$tabela = 'grc_evento_participante';
$id = 'idt';

$class_frame = "class_frame";
$class_titulo = "class_titulo";
$class_titulo_p = "class_titulo_p";
$titulo_na_linha = false;

$rowDados = $vetParametrosMC['par_rowDados'];

$sql = '';
$sql .= ' select descricao_md5, descricao';
$sql .= ' from grc_evento_participante_motivo_ic';

if ($rowDados['motivo_cancelamento_md5'] != '') {
    $sql .= ' union';
    $sql .= " select '{$rowDados['motivo_cancelamento_md5']}' as descricao_md5, '{$rowDados['motivo_cancelamento']}' as descricao";
}

$sql .= ' order by descricao';
$vetCampo['motivo_cancelamento_md5'] = objCmbBanco('motivo_cancelamento_md5', 'Motivo do Cancelamento', false, $sql);
$vetCampo['motivo_cancelamento'] = objHidden('motivo_cancelamento', '');
$vetCampo['justificativa_cancelamento'] = objTextArea('justificativa_cancelamento', 'Justificativa do Cancelamento (Limitado a 1000 caracteres)', false, 1000);

$vetParametros = Array(
    'width' => '100%',
);

$vetFrm = Array();

$vetFrm[] = Frame('', Array(
    Array($vetCampo['motivo_cancelamento_md5']),
    Array($vetCampo['motivo_cancelamento']),
    Array($vetCampo['justificativa_cancelamento']),
        ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);


$vetCad[] = $vetFrm;
?>
<script type="text/javascript">
    $(document).ready(function () {
        if ('<?php echo $vetParametrosMC['par_acaoOrg']; ?>' == 'exc') {
            setTimeout(function () {
                //$("#motivo_cancelamento_md5_desc").addClass("Tit_Campo_Obr").removeClass("Tit_Campo");
                $('#motivo_cancelamento_md5, #motivo_cancelamento, #justificativa_cancelamento').removeProp("disabled").removeClass("campo_disabled");
            }, 500);

            setTimeout(function () {
                //$("#motivo_cancelamento_md5_desc").addClass("Tit_Campo_Obr").removeClass("Tit_Campo");
                $('#motivo_cancelamento_md5, #motivo_cancelamento, #justificativa_cancelamento').removeProp("disabled").removeClass("campo_disabled");
            }, 2000);
        }
    });
</script>