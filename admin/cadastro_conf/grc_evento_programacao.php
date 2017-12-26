<style>
    fieldset.class_frame {
        background:#ECF0F1;
        border:1px solid #14ADCC;
    }
    div.class_titulo {
        background: #ABBBBF;
        border    : 1px solid #14ADCC;
        color     : #FFFFFF;
        text-align: left;
    }
    div.class_titulo span {
        padding-left:10px;
    }
</style>
<?php
if ($_GET['idCad'] != '') {
    $_GET['idt0'] = $_GET['idCad'];
    $botao_volta = "parent.btFechaCTC('".$_GET['session_cod']."');";
    $botao_acao = '<script type="text/javascript">parent.btFechaCTC("'.$_GET['session_cod'].'");</script>';
}

$onSubmitDep = 'grc_evento_programacao_dep()';

$TabelaPrinc = "grc_evento_programacao";
$AliasPric = "grc_at";
$Entidade = "Programação do Evento";
$Entidade_p = "Programações do Evento";
$CampoPricPai = "idt_evento";

$id = 'idt';
$tabela = $TabelaPrinc;

$vetCampo[$CampoPricPai] = objHidden($CampoPricPai, $_GET['idt0']);
$vetCampo['descricao'] = objTexto('descricao', 'Descrição', true, 142, 200);
$vetCampo['data'] = objData('data', 'Data', true, '', '', 'S');
$vetCampo['hora'] = objHora('hora', 'Hora', true);
$vetCampo['local'] = objTexto('local', 'Local', true, 110, 200);

$maxlength = 1000;
$style = "";
$js = " ";
$vetCampo['objetivo'] = objTextArea('objetivo', 'Objetivo (Limitado a 1000 caracteres)', true, $maxlength, $style, $js);

MesclarCol($vetCampo['descricao'], 5);
MesclarCol($vetCampo['objetivo'], 5);

$vetFrm[] = Frame('', Array(
    Array($vetCampo[$CampoPricPai]),
    Array($vetCampo['descricao']),
    Array($vetCampo['data'], '', $vetCampo['hora'], '', $vetCampo['local']),
    Array($vetCampo['objetivo']),
        ), $class_frame, $class_titulo, $titulo_na_linha);

$vetCad[] = $vetFrm;
?>
<script type="text/javascript">
    function grc_evento_programacao_dep() {
        if (valida == 'S') {
            if (validaDataMaiorStr(false, $('#data'), '', '<?php echo $_GET['ini'] ?>', 'Início do Evento') === false) {
                return false;
            }
            
            if (validaDataMenorStr(false, $('#data'), '', '<?php echo $_GET['fim'] ?>', 'Término do Evento') === false) {
                return false;
            }
        }

        return true;
    }
</script>