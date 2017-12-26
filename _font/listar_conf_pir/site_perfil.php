<?php
$idCampo = 'id_perfil';
$Tela = "o perfil do Site";

//Monta o vetor de Campo
$vetCampo['em_estado'] = CriaVetTabela('Estado');
$vetCampo['em_descricao'] = CriaVetTabela('Empreendimento');
$vetCampo['nm_perfil'] = CriaVetTabela('Nome do Perfil');
$vetCampo['todos'] = CriaVetTabela('Visualiza Todo Site', 'descDominio', $vetSimNao);
$sql  = 'select sp.*, em.descricao as em_descricao, em.estado as em_estado from site_perfil sp ';
$sql .= ' left join empreendimento em on em.idt = sp.idt_empreendimento ';
$sql .= ' order by em.estado, em.descricao, nm_perfil';


?>