<?php
$idCampo = 'idt';
$Tela = "o GGC";


//Monta o vetor de Campo
$vetCampo['nome_resumo'] = CriaVetTabela('C�digo');
$vetCampo['nome_completo'] = CriaVetTabela('Descri��o');
$vetCampo['us_login'] = CriaVetTabela('Login');

$sql   = 'select ';
$sql  .= '   ggc.*,  ';
$sql  .= '   us.login as us_login  ';
$sql  .= ' from ggc as ggc ';
$sql  .= ' inner join usuario us on us.id_usuario = ggc.idt_usuario ';
$sql  .= ' order by nome_resumo';

?>