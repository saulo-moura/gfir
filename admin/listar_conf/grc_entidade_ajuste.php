<?php
$idCampo = 'idt';

$listar_sql_limit = false;

$vetBtBarra[] = vetBtBarra($menu, '', 'imagens/bt_reload.png', 'CRMxSIACWEB()', '', 'Verificar o CRM x SiacWeb');

$Filtro = Array();
$Filtro['rs'] = 'Texto';
$Filtro['id'] = 'f_texto';
$Filtro['js_tam'] = '0';
$Filtro['nome'] = 'Texto';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['f_texto'] = $Filtro;

$vetCampo['dap'] = CriaVetTabela('DAP');
$vetCampo['nirf'] = CriaVetTabela('NIRF');
$vetCampo['rmp'] = CriaVetTabela('RMP');
$vetCampo['ie_prod_rural'] = CriaVetTabela('IE');
$vetCampo['qtd_gec'] = CriaVetTabela('Qtd. CRM');
$vetCampo['qtd_siac'] = CriaVetTabela('Qtd. SiacWEB');
$vetCampo['verificado'] = CriaVetTabela('Verificado', 'descDominio', $vetSimNao);

$sql = '';
$sql .= ' select dap, nirf, rmp, ie_prod_rural, count(distinct idt_entidade) as qtd_gec, count(distinct codparceiro_siac) as qtd_siac, max(idt) as idt,';
$sql .= ' max(verificado) as verificado';
$sql .= ' from grc_entidade_ajuste';

if ($vetFiltro['f_texto']['valor'] != '') {
    $sql .= ' where ( ';
    $sql .= '    dap = '.aspa($vetFiltro['f_texto']['valor']);
    $sql .= ' or nirf = '.aspa($vetFiltro['f_texto']['valor']);
    $sql .= ' or rmp = '.aspa($vetFiltro['f_texto']['valor']);
    $sql .= ' or ie_prod_rural = '.aspa($vetFiltro['f_texto']['valor']);
    $sql .= ' ) ';
}

$sql .= ' group by dap, nirf, rmp, ie_prod_rural';
$sql .= ' having count(idt) > 1';
?>
<script type="text/javascript">
    function CRMxSIACWEB() {
        if (confirm('Deseja verificar o CRM x SiacWeb?')) {
            processando();

            $.ajax({
                dataType: 'json',
                type: 'POST',
                url: ajax_sistema + '?tipo=grc_entidade_ajuste_acao',
                success: function (response) {
                    if (response.erro != '') {
                        $("#dialog-processando").remove();
                        alert(url_decode(response.erro));
                    }

                    document.frm.submit();
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    $("#dialog-processando").remove();
                    alert('Erro no ajax no: ' + textStatus + ' - ' + errorThrown);
                },
                async: false
            });

            $("#dialog-processando").remove();
        }

        return false;
    }
</script>