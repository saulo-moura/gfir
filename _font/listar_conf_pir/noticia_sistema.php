<?php
$idCampo = 'idt';
$Tela = "a Not�cia do Sistema";


//Monta o vetor de Campo
$vetCampo['data']    = CriaVetTabela('data publica��o','data');
$vetCampo['hora'] = CriaVetTabela('Hora Publica��o');
$vetCampo['ativa'] = CriaVetTabela('Ativada?', 'descDominio', $vetSimNao);
$vetCampo['principal'] = CriaVetTabela('Principal?', 'descDominio', $vetSimNao);
$vetCampo['descricao'] = CriaVetTabela('Descri��o');
$vetCampo['contato']      = CriaVetTabela('Contato');
//
$sql = 'select * from '.$pre_table.'noticia_sistema';
$sql .= ' order by principal desc, ativa desc, data desc, hora desc';
?>