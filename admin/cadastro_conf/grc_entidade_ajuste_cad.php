<?php
if ($_GET['acao'] == 'con') {
    $veio = "O";
    Require_Once('cadastro_conf/gec_entidade.php');
} else {
    $tabela = '';
    $id = 'idt';
    $onSubmitDep = 'grc_entidade_ajuste_cad_dep() ';

    $botao_volta = "parent.btFechaCTC('".$_GET['session_cod']."');";
   $botao_acao = '<script type="text/javascript">parent.btFechaCTC("'.$_GET['session_cod'].'");</script>';

    $sql = '';
    $sql .= ' select e.descricao, o.dap, o.nirf, o.rmp, o.ie_prod_rural, e.codigo,';
    $sql .= ' o.dap_old, o.nirf_old, o.rmp_old, o.ie_prod_rural_old, e.codigo_old';
    $sql .= ' from '.db_pir_gec.'gec_entidade e';
    $sql .= ' inner join '.db_pir_gec.'gec_entidade_organizacao o on o.idt_entidade = e.idt';
    $sql .= ' where e.idt = '.null($_GET['id']);
    $rs = execsql($sql);
    $row = $rs->data[0];
    
    $row['codigo'] = formataCPFCNPJ($row['codigo']);
    $row['codigo_old'] = formataCPFCNPJ($row['codigo_old']);

    $vetCampo['descricao'] = objTexto('descricao', 'Razão Social', True, 120, '', '', $row['descricao']);
    $vetCampo['dap'] = objTexto('dap', 'DAP', false, 28, 45, '', $row['dap']);
    $vetCampo['nirf'] = objTexto('nirf', 'NIRF', false, 11, 11, ' onblur="return Valida_Nirf(this);" onkeyup="return Formata_Nirf(this);"', $row['nirf']);
    $vetCampo['rmp'] = objTexto('rmp', 'Registro Ministério da Pesca', false, 28, 45, '', $row['rmp']);
    $vetCampo['ie_prod_rural'] = objTexto('ie_prod_rural', 'IE', false, 28, 45, '', $row['ie_prod_rural']);
    
    $js = 'onblur="return Valida_CNPJ(this)" onkeyup="return Formata_Cnpj(this,event)"';
    $vetCampo['codigo'] = objTexto('codigo', 'CNPJ', false, 21, 21, $js, $row['codigo']);

    $vetCampo['dap_old'] = objTextoFixo('dap_old', 'DAP', '', false, false, $row['dap_old']);
    $vetCampo['nirf_old'] = objTextoFixo('nirf_old', 'NIRF', '', false, false, $row['nirf_old']);
    $vetCampo['rmp_old'] = objTextoFixo('rmp_old', 'Registro Ministério da Pesca', '', false, false, $row['rmp_old']);
    $vetCampo['ie_prod_rural_old'] = objTextoFixo('ie_prod_rural_old', 'IE', '', false, false, $row['ie_prod_rural_old']);
    $vetCampo['codigo_old'] = objTextoFixo('codigo_old', 'CNPJ', '', false, false, $row['codigo_old']);
    
    MesclarCol($vetCampo['descricao'], 7);

    $vetFrm[] = Frame('', Array(
        Array($vetCampo['descricao']),
        Array($vetCampo['dap'], '', $vetCampo['nirf'], '', $vetCampo['rmp'], '', $vetCampo['ie_prod_rural'], '', $vetCampo['codigo']),
    ));

    $vetFrm[] = Frame('Informações Originais (antes de arrumar o produtor rural)', Array(
        Array($vetCampo['dap_old'], '', $vetCampo['nirf_old'], '', $vetCampo['rmp_old'], '', $vetCampo['ie_prod_rural_old'], '', $vetCampo['codigo_old']),
    ));
    
    $vetCad[] = $vetFrm;
    ?>
    <script type="text/javascript">
        function grc_entidade_ajuste_cad_dep() {
            if ($('#dap').val() == '' && $('#nirf').val() == '' && $('#rmp').val() == '' && $('#ie_prod_rural').val() == '') {
                alert('Favor informar um dos campos - DAP, NIRF, Registro Ministério da Pesca ou IE');
                return false;
            }
            
            if ($('#codigo').val() != '') {
                alert('Favor não informar o campo CNPJ para Produtor Rural');
                return false;
            }
            
            var tot = 0;
            var campo = '';

            if ($('#dap').val() != '') {
                campo = 'dap';
                tot++;
            }

            if ($('#nirf').val() != '') {
                campo = 'nirf';
                tot++;
            }

            if ($('#rmp').val() != '') {
                campo = 'rmp';
                tot++;
            }

            if ($('#ie_prod_rural').val() != '') {
                campo = 'ie_prod_rural';
                tot++;
            }

            if (tot > 1) {
                alert('Para Produtor Rural só pode ser informar um dos campos - DAP, NIRF, Registro Ministério da Pesca ou IE');
                return false;
            }

            var ok = false;

            $.ajax({
                dataType: 'json',
                type: 'POST',
                url: ajax_sistema + '?tipo=grc_entidade_ajuste_cad_dep',
                data: {
                    campo: campo,
                    valor: $('#' + campo).val(),
                    idt_entidade: '<?php echo $_GET['id']; ?>'
                },
                beforeSend: function () {
                    processando();
                },
                complete: function () {
                    $("#dialog-processando").remove();
                },
                success: function (response) {
                    if (response.erro == '') {
                        ok = true;
                    } else {
                        $("#dialog-processando").remove();
                        alert(url_decode(response.erro));
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    $("#dialog-processando").remove();
                    alert('Erro no ajax no: ' + textStatus + ' - ' + errorThrown);
                },
                async: false
            });

            return ok;
        }
    </script>
    <?php
}
