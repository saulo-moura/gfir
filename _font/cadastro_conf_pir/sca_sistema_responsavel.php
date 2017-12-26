<?php
$tabela = 'sca_sistema_responsavel';
$id = 'idt';
$vetCampo['idt_sistema'] = objFixoBanco('idt_sistema', 'Sistema', 'sca_sistema', 'idt', 'descricao', 0);

$vetTipo=Array();
$vetTipo['1']='Gestor Sistema';
$vetTipo['2']='Administrador Sistema';
$vetTipo['3']='Usuário Máster';
$vetTipo['4']='Técnico TI';
$vetTipo['5']='Técnico Mantenedor';
$vetCampo['tipo']       = objCmbVetor('tipo', 'Tipo', True, $vetTipo,'','width:100px;');

$vetMaster=Array();
$vetMaster['N']='Não';
$vetMaster['S']='Sim';
$vetCampo['master']     = objCmbVetor('master', 'Master?', True, $vetMaster,'','width:100px;');


$sql = "select id_usuario, nome_completo from usuario order by nome_completo";
$vetCampo['idt_responsavel'] = objCmbBanco('idt_responsavel', 'Responsável', true, $sql,'','width:180px;');


$vetCampo['telefone1']   = objTexto('telefone1', 'Telefone 1', false, 35, 120);
$vetCampo['telefone2']   = objTexto('telefone2', 'Telefone 2', false, 35, 120);
$vetCampo['telefone3']   = objTexto('telefone3', 'Telefone 3', false, 35, 120);

$vetCampo['email1']   = objTexto('email1', 'Email 1', false, 35, 120);
$vetCampo['email2']   = objTexto('email2', 'Email 2', false, 35, 120);
$vetCampo['email3']   = objTexto('email3', 'Email 3', false, 35, 120);


$vetFrm = Array();
$vetFrm[] = Frame(' ', Array(
    Array($vetCampo['idt_sistema'] ),
));

MesclarCol($vetCampo['idt_responsavel'], 3);

$vetFrm[] = Frame(' ', Array(
    Array($vetCampo['tipo'], '', $vetCampo['master'] ),
    Array($vetCampo['idt_responsavel'] ),
));
$vetFrm[] = Frame(' ', Array(
    Array($vetCampo['telefone1'], ' ', $vetCampo['telefone2'], ' ', $vetCampo['telefone3'] ),
    Array($vetCampo['email1'], ' ', $vetCampo['email2'], ' ', $vetCampo['email3'] ),
));

$vetCad[] = $vetFrm;


?>