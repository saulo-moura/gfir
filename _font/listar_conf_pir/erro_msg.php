<?php
$Tela = "a mensagem de erro";

//Monta o vetor de Campo
$vetCampo['origem_msg'] = CriaVetTabela('Origem');
$vetCampo['num_erro'] = CriaVetTabela('Nº do Erro');
$vetCampo['msg_erro'] = CriaVetTabela('Mensagem do Sistema');
$vetCampo['msg_usuario'] = CriaVetTabela('Mensagem do Usuário');

$sql = 'select * from erro_msg order by origem_msg, num_erro';
?>