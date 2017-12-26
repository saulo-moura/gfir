<?php
$tabela = 'contato';
$id = 'idt';
$vetCampo['descricao'] = objTexto('descricao', 'Setor', True, 10, 10);
$vetCampo['email'] = objTexto('email', 'E-mail', True, 45,45);
$sql = 'select id_usuario, nome_completo from plu_usuario
                order by nome_completo';
$vetCampo['idt_responsavel'] = objCmbBanco('idt_responsavel', 'Responsável', false, $sql,'' ,'' ,'' , true );

$vetFrm = Array();
$vetFrm[] = Frame('', Array(
    Array($vetCampo['descricao']),
    Array($vetCampo['email']),
    Array($vetCampo['idt_responsavel']),
));
$vetCad[] = $vetFrm;
?>