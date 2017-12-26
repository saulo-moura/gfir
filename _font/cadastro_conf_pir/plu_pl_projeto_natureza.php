<?php
$tabela = 'plu_pl_projeto_natureza';
$id = 'idt';
$vetCampo['codigo']        = objTexto('codigo', 'Cуdigo', True, 20, 45);
$vetCampo['descricao']     = objTexto('descricao', 'Descriзгo', True, 60, 120);

$vetFrm = Array();
$vetFrm[] = Frame('', Array(
    Array($vetCampo['codigo']),
    Array($vetCampo['descricao']),
));


$vetCad[] = $vetFrm;
?>