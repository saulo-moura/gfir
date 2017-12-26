<?php
$tabela = 'sca_nivel_estrutura';
$id = 'idt';
$vetCampo['nivel']        = objInteiro('nivel', 'Nнvel', True, 10);
$vetCampo['descricao']    = objTexto('descricao', 'Descriзгo', True, 60, 120);
$vetCampo['sigla']        = objTexto('sigla', 'Sigla', True, 45, 45);
$vetCampo['qtd_digitos']  = objInteiro('qtd_digitos', 'Digitos', True, 10);

$vetFrm = Array();
$vetFrm[] = Frame('', Array(
    Array($vetCampo['nivel'], '', $vetCampo['descricao']),
    Array($vetCampo['sigla'], '', $vetCampo['qtd_digitos']),
));
$vetCad[] = $vetFrm;
?>