<?php
$idCampo = 'idt';
$Tela = "a Not�cia do Sistema";

$TabelaPrinc      = "plu_noticia_sistema";
$AliasPric        = "plu_ns";
$Entidade         = "Not�cia Sistema";
$Entidade_p       = "Not�cias Sistema";

$barra_inc_h      = "Incluir um Novo Registro de {$Entidade}";
$contlinfim       = "Existem #qt {$Entidade_p}.";

$vetLocal=Array();
$vetLocal['T']='Site e GC';
$vetLocal['S']='Site';
$vetLocal['G']='Gerador de Conte�do - GC';

//Monta o vetor de Campo
$vetCampo['data']    = CriaVetTabela('data publica��o','data');
$vetCampo['hora'] = CriaVetTabela('Hora Publica��o');
$vetCampo['ativa'] = CriaVetTabela('Ativada?', 'descDominio', $vetSimNao);
$vetCampo['principal'] = CriaVetTabela('Principal?', 'descDominio', $vetSimNao);
$vetCampo['local_apresentacao'] = CriaVetTabela('Local Apresenta��o?', 'descDominio', $vetLocal);
$vetCampo['dt_mostra_ini'] = CriaVetTabela('Mostrar de', 'data');
$vetCampo['dt_mostra_fim'] = CriaVetTabela('Mostrar at�', 'data');

$vetCampo['descricao'] = CriaVetTabela('Descri��o');
$vetCampo['contato']      = CriaVetTabela('Contato');
//
$sql = 'select * from plu_noticia_sistema';
$sql .= ' order by principal desc, ativa desc, data desc, hora desc';