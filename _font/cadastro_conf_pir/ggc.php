<?php
$tabela = 'ggc';
$id = 'idt';

$vetCampo['nome_resumo'] = objTexto('nome_resumo', 'Nome Resumo', True, 45, 45);
$vetCampo['nome_completo'] = objTexto('nome_completo', 'Nome Completo', True, 60, 120);

$sql = "select id_usuario, nome_completo from plu_usuario order by nome_completo";
$vetCampo['idt_usuario'] = objCmbBanco('idt_usuario', 'Login do GGC', true, $sql,'','width:180px;');


$vetFrm = Array();
$vetFrm[] = Frame('', Array(
    Array($vetCampo['nome_resumo']),
    Array($vetCampo['nome_completo']),
    Array($vetCampo['idt_usuario']),

));
$vetCad[] = $vetFrm;
?>