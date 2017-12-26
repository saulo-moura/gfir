<?php
$tabela = 'grc_evento_publicacao_cupom';
$id = 'idt';
$onSubmitDep = 'grc_evento_publicacao_cupom_dep()';

$vetFrm = Array();

$sql = "select idt, palavra_chave, concat(format(perc_desconto, 2, 'pt_BR'), '%') as perc_desconto, data_validade from grc_evento_cupom order by palavra_chave";
$vetCampo['idt_evento_cupom'] = objCmbBanco('idt_evento_cupom', 'Cupom', true, $sql);

$vetCampo['qtd_resevada'] = objInteiro('qtd_resevada', 'Qtd. de Cupons', true, 9);

if ($_SESSION[CS]['tmp'][CSU]['vetParametrosMC']['situacao'] == 'AP') {
    $vetCampo['qtd_disponivel'] = objTextoFixo('qtd_disponivel', 'Qtd. Disponível', 9, true);
    $vetCampo['qtd_utilizada'] = objTextoFixo('qtd_utilizada', 'Qtd. Utilizada', 9, true);
}

MesclarCol($vetCampo['idt_evento_cupom'], 5);

$vetFrm[] = Frame('', Array(
    Array($vetCampo['idt_evento_cupom']),
    Array($vetCampo['qtd_resevada'], '', $vetCampo['qtd_disponivel'], '', $vetCampo['qtd_utilizada']),
        ));

$vetCad[] = $vetFrm;
?>
<script type="text/javascript">
    function grc_evento_publicacao_cupom_dep() {
        if (valida == 'S') {
            var erro = '';

            $.ajax({
                dataType: 'json',
                type: 'POST',
                url: ajax_sistema + '?tipo=grc_evento_publicacao_cupom_dep',
                data: {
                    cas: conteudo_abrir_sistema,
                    idt_evento: '<?php echo $_GET['idt0']; ?>',
                    idt_evento_cupom: $('#idt_evento_cupom').val(),
                    qtd_resevada: $('#qtd_resevada').val()
                },
                success: function (response) {
                    if (response.erro != '') {
                        erro += url_decode(response.erro);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert('Erro no ajax no: ' + textStatus + ' - ' + errorThrown);
                },
                async: false
            });

            $('#dialog-processando').remove();

            if (erro != '') {
                alert(erro);
                return false;
            }
        }

        return true;
    }
</script>