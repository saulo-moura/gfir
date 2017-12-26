<?php
$sql = '';
$sql .= ' select d.id_direito, d.nm_direito, df.descricao';
$sql .= ' from plu_direito d';
$sql .= ' left outer join plu_direito_funcao df on df.id_direito = d.id_direito and df.id_funcao = '.null($_GET['id']);
$sql .= " where d.desc_funcao = 'S'";
$sql .= ' order by d.nm_direito';
$rst = execsql($sql);

foreach ($rst->data as $rowt) {
    echo '<div id="desc_funcao_'.$rowt['id_direito'].'" class="Tit_Campo_Obr" style="display: none;">';
    echo 'Descrição do direito: '.$rowt['nm_direito'].'<br />';
    echo '<input type="text" maxlength="200" size="100" value="'.$rowt['descricao'].'" class="Texto" name="desc_funcao_'.$rowt['id_direito'].'">';
    echo '</div>';
}
?>
<script type="text/javascript">
    $(document).ready(function () {
        var btInc = $('#id_direito_desc input.Botao:first');
        btInc.removeAttr('onclick');

        btInc.click(function () {
            inclui(document.frm.sistema, document.frm.funcao);
            btAcaoDireito();
        });

        var btExc = $('#id_direito_desc input.Botao:last');
        btExc.removeAttr('onclick');

        btExc.click(function () {
            exclui(document.frm.sistema, document.frm.funcao);
            btAcaoDireito();
        });

        btAcaoDireito();
    });

    function btAcaoDireito() {
        $('#id_direito_lista option').each(function () {
            var id = $(this).val().substr(1);
            var div = $('#desc_funcao_' + id);

            if (div.length == 1) {
                div.show();
            }
        });

        $('#id_direito_org option').each(function () {
            var id = $(this).val().substr(1);
            var div = $('#desc_funcao_' + id);

            if (div.length == 1) {
                div.hide();
            }
        });
    }

    function plu_funcao_dep() {
        var ok = true;
        
        $('#id_direito_lista option').each(function () {
            var id = $(this).val().substr(1);
            var input = $('#desc_funcao_' + id + ' input');

            if (input.length == 1) {
                if (input.val() == '') {
                    ok = false;
                }
            }
        });
        
        if (!ok) {
            alert('Favor informar todas as "Descrição do direito"!');
        }
        
        return ok;
    }
</script>
