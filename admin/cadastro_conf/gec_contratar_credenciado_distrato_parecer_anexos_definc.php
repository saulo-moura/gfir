<?php
if ($acao == 'inc') {
    $vetRow[$TabelaPrinc]['idt_responsavel'] = $_SESSION[CS]['g_id_usuario_sistema']['GEC'];
    $vetRow[$TabelaPrinc]['data_registro'] = trata_data(getdata(true, true));
}
