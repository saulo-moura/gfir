<?php
$Tela = "a mensagem de erro";

//Monta o vetor de Campo
$vetCampo['origem_msg'] = CriaVetTabela('Origem');
$vetCampo['num_erro'] = CriaVetTabela('N� do Erro');
$vetCampo['msg_erro'] = CriaVetTabela('Mensagem do Sistema');
$vetCampo['msg_usuario'] = CriaVetTabela('Mensagem do Usu�rio');

$sql = 'select * from erro_msg order by origem_msg, num_erro';
?>