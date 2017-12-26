<?php
$tabela = 'plu_perfil';
$id = 'id_perfil';
$onSubmitAnt = 'perfil()';
$par_url .= 'id_difu,';

$vetCampo['classificacao'] = objTexto('classificacao', 'Classificação', false, 45);
$vetCampo['nm_perfil'] = objTexto('nm_perfil', 'Nome', True, 40);
$vetCampo['direito'] = objInclude('direito', 'perfil_direito.php');
$vetCampo['ativo'] = objCmbVetor('ativo', 'Ativo?', True, $vetSimNao);
$vetCampo['atendimento_digitador'] = objCmbVetor('atendimento_digitador', 'É Digitador de Atendimento?', True, $vetSimNao);
$vetCampo['mostra_pk'] = objCmbVetor('mostra_pk', 'Mostra a PK do registro?', True, $vetSimNao);
$vetCampo['coloca_evento_retroaitvo'] = objCmbVetor('coloca_evento_retroaitvo', 'Pode colocar o evento como Retroativo?', True, $vetSimNao);
$vetCampo['trans_resp_aprova_cgp'] = objCmbVetor('trans_resp_aprova_cgp', 'Aprova a Transferência de Responsabilidade na etapa CGP', True, $vetSimNao);

if ($_GET['id'] == 0) {
    $sql = 'select id_perfil, nm_perfil from plu_perfil order by nm_perfil';
    $vetCampo['id_copia'] = objCmbBanco('id_copia', 'Copiar direitos do Perfil', false, $sql, ' ', '', '', false);
}

$vetFrm = Array();

MesclarCol($vetCampo['nm_perfil'], 9);
MesclarCol($vetCampo['trans_resp_aprova_cgp'], 9);

$vetFrm[] = Frame('', Array(
    Array($vetCampo['nm_perfil']),
    Array($vetCampo['classificacao'], '', $vetCampo['ativo'], '', $vetCampo['atendimento_digitador'], '', $vetCampo['mostra_pk'], '', $vetCampo['coloca_evento_retroaitvo']),
    Array($vetCampo['trans_resp_aprova_cgp']),
        ));

$vetFrm[] = Frame('', Array(
    Array($vetCampo['id_copia']),
    Array($vetCampo['direito'])
        ));
$vetCad[] = $vetFrm;
?>
<script type="text/javascript">
    $(document).ready(function () {
        $('#id_copia').change(function () {
            if ($(this).val() == '') {
                return true;
            }

            $.ajax({
                dataType: 'json',
                type: 'POST',
                url: ajax_plu + '&tipo=perfil_copia',
                data: {
                    cas: conteudo_abrir_sistema,
                    id_copia: $(this).val()
                },
                success: function (response) {
                    if (response.erro == '') {
                        pl = 1;
                        pc = 1;
                        val = response.val;

                        $('#id_esquerda, #id_sobe').css('visibility', 'hidden');
                        
                        if (max_pl > 1) {
                            $('#id_desce').css('visibility', 'visible');
                        } else {
                            $('#id_desce').css('visibility', 'hidden');
                        }
                        
                        if (max_pc > 1) {
                            $('#id_direita').css('visibility', 'visible');
                        } else {
                            $('#id_direita').css('visibility', 'hidden');
                        }
                        
                        matriz();

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