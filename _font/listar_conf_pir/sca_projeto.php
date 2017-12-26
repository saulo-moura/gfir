<?php
$idCampo = 'idt';
$Tela = "o projeto";
$goCad[] = vetCad('idt', 'Participação', 'empreendimento_participacao');
$goCad[] = vetCad('idt', 'Conjunto', 'empreendimento_conjunto');
$goCad[] = vetCad('idt', 'Torre', 'empreendimento_torre');
//Monta o vetor de Campo
$vetCampo['imagem']     = CriaVetTabela('Logomarca', 'arquivo', '100', 'sca_projeto');
$vetCampo['descricao']  = CriaVetTabela('Projeto');
$vetCampo['est_codigo'] = CriaVetTabela('Estado');
$vetCampo['ativo']      = CriaVetTabela('Ativo?','descDominio',$vetSimNao);
$vetCampo['status']      = CriaVetTabela('Status');


$sql = '';
$sql .= ' select proj.*, est.codigo as est_codigo, projs.descricao as status  ';
$sql .= ' from sca_projeto proj';
$sql .= ' left join estado est on est.codigo = proj.estado ';
$sql .= ' left join sca_projeto_situacao projs on projs.idt = proj.idt_situacao_projeto ';
$rs = execsql($sql);
?>