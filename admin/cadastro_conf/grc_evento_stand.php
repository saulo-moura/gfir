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

$TabelaPrinc = "grc_evento_stand";
$AliasPric = "grc_at";
$Entidade = "Controle de Stand do Evento";
$Entidade_p = "Controle de Stand do Evento";
$CampoPricPai = "idt_evento";

$id = 'idt';
$tabela = $TabelaPrinc;

$vetCampo[$CampoPricPai] = objHidden($CampoPricPai, $_GET['idt0']);
$vetCampo['numero'] = objTexto('numero', 'Numero', true, 71, 120);
$vetCampo['area'] = objDecimal('area', 'Área', true, 15);
$vetCampo['rua'] = objTexto('rua', 'Rua', true, 71, 120);
$vetCampo['vl_stand'] = objTextoFixo('vl_stand', 'Valor do STAND', 15, true);
$vetCampo['caracteristica'] = objTexto('caracteristica', 'Características', true, 71, 120);
$vetCampo['cnae'] = objListarCmb('cnae', 'gec_cnae', 'Atividade Econômica', true, '860px');

MesclarCol($vetCampo['rua'], 3);
MesclarCol($vetCampo['cnae'], 5);

$vetFrm[] = Frame('', Array(
    Array($vetCampo[$CampoPricPai]),
    Array($vetCampo['numero'], '', $vetCampo['rua']),
    Array($vetCampo['caracteristica'], '', $vetCampo['area'], '', $vetCampo['vl_stand']),
    Array($vetCampo['cnae']),
        ), $class_frame, $class_titulo, $titulo_na_linha);

$vetCad[] = $vetFrm;
?>
<script type="text/javascript">
    $(document).ready(function () {
        $('#area').change(function () {
            var vl = str2float('<?php echo $_GET['vl_metro']; ?>');
            
            if (vl === NaN) {
                vl = 0;
            }
            
            var area = str2float($(this).val());
            
            if (area === NaN) {
                area = 0;
            }
            
            var tot = float2str(area * vl);
            $('#vl_stand').val(tot);
            $('#vl_stand_fix').html(tot);
        });
    });
    
    function parListarCmb_cnae() {
        var par = '';

        par += '&idt_evento=<?php echo $_GET['idt0']; ?>';

        return par;
    }
</script>