<?php
$idCampo = 'id_perfil';
$Tela = "o perfil do Site";

$TabelaPrinc      = "plu_site_perfil";
$AliasPric        = "plu_sp";
$Entidade         = "Perfil do Site";
$Entidade_p       = "Perfies do Site";

$barra_inc_h      = "Incluir um Novo Registro de {$Entidade}";
$contlinfim       = "Existem #qt {$Entidade_p}.";


//Monta o vetor de Campo
$vetCampo['em_estado'] = CriaVetTabela('Estado');
$vetCampo['em_descricao'] = CriaVetTabela('Empreendimento');
$vetCampo['nm_perfil'] = CriaVetTabela('Nome do Perfil');
$vetCampo['todos'] = CriaVetTabela('Visualiza Todo Site', 'descDominio', $vetSimNao);
//$sql  = 'select sp.*, em.descricao as em_descricao, em.estado as em_estado from plu_site_perfil sp ';
//$sql .= ' left join empreendimento em on em.idt = sp.idt_empreendimento ';
//$sql .= ' order by em.estado, em.descricao, nm_perfil';
$sql  = 'select sp.* from plu_site_perfil sp ';
$sql .= ' order by nm_perfil';


?>