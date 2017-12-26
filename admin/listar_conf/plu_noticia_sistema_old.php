<?php
$idCampo = 'idt';
$Tela = "a Notícia do Sistema";

$TabelaPrinc      = "plu_noticia_sistema";
$AliasPric        = "plu_ns";
$Entidade         = "Notícia Sistema";
$Entidade_p       = "Notícias Sistema";

$barra_inc_h      = "Incluir um Novo Registro de {$Entidade}";
$contlinfim       = "Existem #qt {$Entidade_p}.";

$vetLocal=Array();
$vetLocal['T']='Site e GC';
$vetLocal['S']='Site';
$vetLocal['G']='Gerador de Conteúdo - GC';

//Monta o vetor de Campo
$vetCampo['data']    = CriaVetTabela('data publicação','data');
$vetCampo['hora'] = CriaVetTabela('Hora Publicação');
$vetCampo['ativa'] = CriaVetTabela('Ativada?', 'descDominio', $vetSimNao);
$vetCampo['principal'] = CriaVetTabela('Principal?', 'descDominio', $vetSimNao);
$vetCampo['local_apresentacao'] = CriaVetTabela('Local Apresentação?', 'descDominio', $vetLocal);
$vetCampo['dt_mostra_ini'] = CriaVetTabela('Mostrar de', 'data');
$vetCampo['dt_mostra_fim'] = CriaVetTabela('Mostrar até', 'data');

$vetCampo['descricao'] = CriaVetTabela('Descrição');
$vetCampo['contato']      = CriaVetTabela('Contato');
//
$sql = 'select * from plu_noticia_sistema';
$sql .= ' order by principal desc, ativa desc, data desc, hora desc';