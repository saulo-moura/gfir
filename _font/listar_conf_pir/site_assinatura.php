<?php
$idCampo = 'idt';
$Tela    = "a Assinatura do Site";


$sql     = 'select  idt, estado, descricao from empreendimento ';
$sql    .= '    where idt = '.null($_SESSION[CS]['g_idt_obra']);
$sql    .= '    order by estado, descricao ';
$Filtro  = Array();
$Filtro['rs'] = execsql($sql);
$Filtro['vlPadrao'] = $_SESSION[CS]['g_idt_obra'];
$Filtro['id'] = 'idt';
$Filtro['nome'] = 'Empreendimento';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['empreendimento'] = $Filtro;

//  Monta o vetor de Campo
$vetCampo['sf_classificacao'] = CriaVetTabela('Classificação');
$vetCampo['sf_nm_funcao']     = CriaVetTabela('menu');
$vetCampo['chave']            = CriaVetTabela('Chave');
$vetCampo['assinado']         = CriaVetTabela('Assinado');
$vetCampo['data']             = CriaVetTabela('Data','data');
$vetCampo['mes']             = CriaVetTabela('Mês');
$vetCampo['ano']             = CriaVetTabela('Ano');
$vetCampo['usu_nome_completo']   = CriaVetTabela('Assinante');

$sql  = 'select ';
$sql .= ' sass.*, ';
$sql .= ' sf.cod_classificacao as sf_classificacao, ';
$sql .= ' sf.nm_funcao as sf_nm_funcao, ';
$sql .= ' usu.nome_completo as usu_nome_completo ';
$sql .= ' from site_assinatura sass ';
$sql .= ' left join site_funcao sf on sf.cod_assinatura = sass.chave ';
$sql .= ' inner join usuario usu on usu.id_usuario = sass.idt_usuario ';
$sql .= ' where sass.idt_empreendimento = '.null($vetFiltro['empreendimento']['valor']);
$sql .= ' order by cod_classificacao';


?>