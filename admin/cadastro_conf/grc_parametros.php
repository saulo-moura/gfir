<?php
$tabela = 'grc_parametros';
$id = 'idt';
$vetCampo['codigo'] = objTexto('codigo', 'Código', True, 45, 45);
$vetCampo['descricao'] = objTexto('descricao', 'Descrição', True, 50, 120);
$vetCampo['ativo'] = objCmbVetor('ativo', 'Ativo?', True, $vetSimNao);
$vetCampo['html'] = objCmbVetor('html', 'Informação em HTML?', True, $vetSimNao, ' ', 'onchange="ativaHtml();"');
//
$maxlength = 700;
$style = "width:700px;";
$js = "";
//$vetCampo['detalhe'] = objTextArea('detalhe', 'Detalhe', false, $maxlength, $style, $js);

$vetCampo['detalhe'] = objHTML('detalhe', 'Detalhe', false);

$vetCampo['classificacao'] = objTexto('classificacao', 'Classificação', True, 15, 45);

//$sql = "select idt, codigo, descricao from plu_estado order by descricao";
//$vetCampo['idt_estado'] = objCmbBanco('idt_estado', 'Estado', true, $sql,'','width:180px;');
$vetFrm = Array();
$vetFrm[] = Frame('<span>Identificação</span>', Array(
    Array($vetCampo['codigo'], '', $vetCampo['classificacao'], '', $vetCampo['descricao'], '', $vetCampo['ativo']),
        ), $class_frame, $class_titulo, $titulo_na_linha);


$vetFrm[] = Frame('<span>Resumo</span>', Array(
    Array($vetCampo['html']),
    Array($vetCampo['detalhe']),
        ), $class_frame, $class_titulo, $titulo_na_linha);

$vetCad[] = $vetFrm;
?>
<script type="text/javascript">
    function ativaHtml() {
        var obj = $('#html');
        var oEditor = FCKeditorAPI.GetInstance('detalhe');
        var Source = oEditor.Commands.GetCommand('Source');
        var sts = Source.GetState();
        var xToolbarRow = '';
        
        alert('fazer logica para desativar bt Source');

        if (obj.val() == 'N') {
            if (sts == 0) {
                Source.Execute();
            }

            xToolbarRow = "none";
        } else {
            if (sts == 1) {
                Source.Execute();
            }

            xToolbarRow = "block";
        }
        
        //oEditor.EditorWindow.parent.document.getElementById('xToolbarRow').style.display = xToolbarRow;
    }
</script>