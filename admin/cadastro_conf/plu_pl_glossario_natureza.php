<?php
$tabela = db_pir.'plu_pl_glossario_natureza';
$id = 'idt';
$vetCampo['codigo'] = objTexto('codigo', 'C�digo', True, 20, 45);
$vetCampo['descricao'] = objTexto('descricao', 'Descri��o', True, 60, 120);
$vetFrm = Array();
$vetFrm[] = Frame('', Array(
    Array($vetCampo['codigo']),
    Array($vetCampo['descricao']),
));
$vetCad[] = $vetFrm;
?>