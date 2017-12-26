<?php
$idCampo = 'idt';
$Tela = "a Notнcia do Sistema";


//Monta o vetor de Campo
$vetCampo['data']    = CriaVetTabela('data publicaзгo','data');
$vetCampo['hora'] = CriaVetTabela('Hora Publicaзгo');
$vetCampo['ativa'] = CriaVetTabela('Ativada?', 'descDominio', $vetSimNao);
$vetCampo['principal'] = CriaVetTabela('Principal?', 'descDominio', $vetSimNao);
$vetCampo['descricao'] = CriaVetTabela('Descriзгo');
$vetCampo['contato']      = CriaVetTabela('Contato');
//
$sql = 'select * from '.$pre_table.'noticia_sistema';
$sql .= ' order by principal desc, ativa desc, data desc, hora desc';
?>