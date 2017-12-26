<?php
$tabela = 'plu_painel_funcao';
$id = 'idt';

$_GET['idt0'] = $_GET['idCad'];
$botao_volta = "parent.btFechaCTC('".$_GET['session_cod']."');";
$botao_acao = '<script type="text/javascript">parent.btFechaCTC("'.$_GET['session_cod'].'");</script>';

$onSubmitDep = 'plu_painel_funcao_dep()';

$vetCampo['idt_painel_grupo'] = objFixoBanco('idt_painel_grupo', 'Grupo', 'plu_painel_grupo', 'idt', 'descricao', 0);

$sql = 'select id_funcao, cod_classificacao, nm_funcao from plu_funcao order by cod_classificacao, nm_funcao';
$vetCampo['id_funcao'] = objCmbBanco('id_funcao', 'Função', false, $sql);

$vetCampo['visivel'] = objCmbVetor('visivel', 'Visível?', true, $vetSimNao, '');
$vetCampo['texto_cab'] = objTexto('texto_cab', 'texto Cab Icone', false, 70);

$vetCampo['parametros'] = objTexto('parametros', 'Parametros do GET (&campo=valor...)', False, 70, 200);

$vetCampo['imagem'] = objFile('imagem', 'Imagem Ativado', false, 40, 'imagem');
$vetCampo['imagem_d'] = objFile('imagem_d', 'Imagem Desativado', false, 40, 'imagem');

$vetCampo['texto_font_tam'] = objInteiro('texto_font_tam', 'Tamanho da Fonte', false, 6);
$vetCampo['texto_ativ_font_cor'] = objTexto('texto_ativ_font_cor', 'Cor da Fonte Ativado', false, 6);
$vetCampo['texto_ativ_fundo'] = objTexto('texto_ativ_fundo', 'Cor do Fundo Ativado', false, 6);
$vetCampo['texto_desativ_font_cor'] = objTexto('texto_desativ_font_cor', 'Cor da Fonte Desativado', false, 6);
$vetCampo['texto_desativ_fundo'] = objTexto('texto_desativ_fundo', 'Cor do Fundo Desativado', false, 6);

$vetCampo['include'] = objCmbVetor('include', 'Include?', true, $vetNaoSim, '');
$vetCampo['include_arq'] = objTexto('include_arq', 'Código do Include', false, 50);

$maxlength = 2000;
$style = "width:700px;";
$js = "";
$vetCampo['hint'] = objTextArea('hint', 'Hint', false, $maxlength, $style, $js);

$vetCampo['detalhe'] = objHTML('detalhe', 'Detalhe', false);

MesclarCol($vetCampo['idt_painel_grupo'], 9);
MesclarCol($vetCampo['id_funcao'], 9);
MesclarCol($vetCampo['visivel'], 3);
MesclarCol($vetCampo['texto_cab'], 5);
MesclarCol($vetCampo['parametros'], 9);
MesclarCol($vetCampo['imagem'], 3);
MesclarCol($vetCampo['imagem_d'], 5);
MesclarCol($vetCampo['include_arq'], 7);
MesclarCol($vetCampo['hint'], 9);
MesclarCol($vetCampo['detalhe'], 9);

$vetFrm[] = Frame('', Array(
    Array($vetCampo['idt_painel_grupo']),
    Array($vetCampo['id_funcao']),
    Array($vetCampo['visivel'], '', $vetCampo['texto_cab']),
    Array($vetCampo['parametros']),
    Array($vetCampo['imagem'],'',$vetCampo['imagem_d']),
    Array($vetCampo['texto_font_tam'], '', $vetCampo['texto_ativ_font_cor'], '', $vetCampo['texto_ativ_fundo'], '', $vetCampo['texto_desativ_font_cor'], '', $vetCampo['texto_desativ_fundo']),
    Array($vetCampo['include'], '', $vetCampo['include_arq']),
    Array($vetCampo['hint']),
    Array($vetCampo['detalhe']),
        ));

$vetCad[] = $vetFrm;
?>
<script type="text/javascript">
    function plu_painel_funcao_dep() {
        if ($('#id_funcao').val() == '' && $('#texto_cab').val() == '') {
            alert('Favor informar a "Função" ou "texto Cab Icone"!');
            return false;
        }
        
        return true;
    }
</script>