<style type="text/css">
    #lst_empresa_vinculado {
        margin: 0px;
        padding: 0px;
        list-style-type: none;
    }

    #lst_empresa_vinculado > li {
        background: #2f66b8 none repeat scroll 0 0;
        color: #FFFFFF;
        cursor: pointer;
        text-align: center;
        border-bottom: 2px solid #000000;
        padding: 10px;
        margin: 10px 10%;
    }
</style>
<script type="text/javascript">
    $(document).ready(function () {
        $('#lst_empresa_vinculado > li').click(function () {
            $.ajax({
                dataType: 'json',
                type: 'POST',
                url: 'ajax_atendimento.php?tipo=empreendimento_escolhido',
                data: {
                    cas: conteudo_abrir_sistema,
                    cnpj: $(this).data('cnpj'),
                    idt: $('#id').val()
                },
                beforeSend: function () {
                    processando();
                },
                complete: function () {
                    $("#dialog-processando").remove();
                },
                success: function (response) {
                    if (response.erro == '') {
                        for (var idx in response) {
                            $('#' + idx).val(url_decode(response[idx]));
                        }
                        
                        btFechaCTC($('#grc_atendimento_organizacao_cnae').data('session_cod'));
                    } else {
                        alert(url_decode(response.erro));
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert('Erro no ajax no: ' + textStatus + ' - ' + errorThrown);
                },
                async: false
            });

        });
    });
</script>
<?php
$variavel = Array();
PesquisarCPFTOTEM($cpf, $variavel);

/*
  $cpfcnpj_w = '04.848.154/0001-99';
  $vetEntidade = Array();
  $kretw = BuscaDadosEntidadePIR($cpfcnpj_w, 'O', $vetEntidade);
  $kretw = BuscaDadosEntidadeSIACBA($cpfcnpj_w, 'J', $vetEntidade);
  $kretw = BuscaDadosEntidadeSIACNA($cpfcnpj_w, 'J', $vetEntidade);
  $kretw = BuscaDadosEntidadeMEI($cpfcnpj_w, 'J', $vetEntidade);
  $kretw = BuscaDadosEntidadeRF($cpfcnpj_w, 'J', $vetEntidade);
  p($vetEntidade);
 * 
 */

echo '<ul id="lst_empresa_vinculado">';

for ($idx = 1; $idx <= $variavel['qtd_empresas']; $idx++) {
    echo '<li data-cnpj="'.$variavel['cnpj_'.$idx].'">'.$variavel['empreendimento_'.$idx].'</li>';
}

echo '<li data-cnpj="novo">Atendimento para uma nova empresa</li>';

echo '<ul>';
