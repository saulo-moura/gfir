<?php
if ($acao == 'inc') {
    $datadia = (date('d/m/Y H:i:s'));
    $vetRow['grc_nan_ordem_pagamento']['idt_cadastrante'] = $_SESSION[CS]['g_id_usuario'];
    $vetRow['grc_nan_ordem_pagamento']['data_cadastrante'] = trata_data($datadia);
    
    $tabela = 'grc_nan_ordem_pagamento';
    $Campo = 'protocolo';
    $tam = 7;
    $codigow = numerador_arquivo($tabela, $Campo, $tam);
    $codigo = 'OP'.$codigow;

    $vetRow['grc_nan_ordem_pagamento']['protocolo'] = $codigo;
    
    $vetRow['grc_nan_ordem_pagamento']['data_inicio'] = trata_data('01/01/'.date('Y'));
    $vetRow['grc_nan_ordem_pagamento']['data_fim'] = trata_data(date('d/m/Y'));
}