<?php
$idCampo = 'idt';
$Tela = "o Edital";

$prefixow    = 'listar';
$mostrar    = true;
$cond_campo = '';
$cond_valor = '';
//$goCad[] = vetCad('idt', 'Etapas do Edital', 'gec_edital_etapas', $prefixow, $mostrar, $imagem, $cond_campo, $cond_valor);


$imagem     = 'imagens/empresa_16.png';
$goCad[] = vetCad('idt', 'Comissão do Edital', 'gec_edital_comissao', $prefixow, $mostrar, $imagem, $cond_campo, $cond_valor);


$imagem     = 'imagens/empresa_16.png';
$goCad[] = vetCad('idt', 'Processos do Edital', 'gec_edital_processo', $prefixow, $mostrar, $imagem, $cond_campo, $cond_valor);


$imagem     = 'imagens/empresa_16.png';
$goCad[] = vetCad('idt', 'Áreas de Conhecimento do Edital', 'gec_edital_area_conhecimento', $prefixow, $mostrar, $imagem, $cond_campo, $cond_valor);

$imagem     = 'imagens/empresa_16.png';
$goCad[] = vetCad('idt', 'Documentos do Edital', 'gec_edital_documento', $prefixow, $mostrar, $imagem, $cond_campo, $cond_valor);

$imagem     = 'imagens/empresa_16.png';
$goCad[] = vetCad('idt', 'Acompanhamento', 'gec_edital_acompanhamento', $prefixow, $mostrar, $imagem, $cond_campo, $cond_valor);


/*
$imagem     = 'imagens/empresa_16.png';
$goCad[] = vetCad('idt', 'Comissão do Edital', 'gec_edital_comissao', $prefixo, $mostrar, $imagem, $cond_campo, $cond_valor);

$imagem     = 'imagens/empresa_16.png';
$goCad[] = vetCad('idt', 'Etapas do Edital', 'gec_edital_etapa', $prefixo, $mostrar, $imagem, $cond_campo, $cond_valor);

$imagem     = 'imagens/empresa_16.png';
$goCad[] = vetCad('idt', 'Documentos do Edital', 'gec_edital_documento', $prefixo, $mostrar, $imagem, $cond_campo, $cond_valor);

$imagem     = 'imagens/empresa_16.png';
$goCad[] = vetCad('idt', 'Áreas, Subareas e Especialidades do Edital', 'gec_edital_area', $prefixo, $mostrar, $imagem, $cond_campo, $cond_valor);
*/


$TabelaPrinc      = "gec_edital";
$AliasPric        = "gec_ed";
$Entidade         = "Edital";
$Entidade_p       = "Editais";
$barra_inc_h      = "Incluir um Novo Registro de {$Entidade}";
$contlinfim       = "Existem #qt {$Entidade_p}.";

$Filtro = Array();
$Filtro['rs'] = 'Texto';
$Filtro['id'] = 'texto';
$Filtro['js_tam'] = '0';
$Filtro['nome'] = 'Texto';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['texto'] = $Filtro;
// Monta o vetor de Campo
$vetCampo['codigo']              = CriaVetTabela('CÓDIGO');
$vetCampo['ano']                 = CriaVetTabela('ANO');
$vetCampo['descricao']           = CriaVetTabela('DESCRIÇÃO');
$vetCampo['gec_edt_descricao']   = CriaVetTabela('TIPO');
$vetCampo['gec_eds_descricao']   = CriaVetTabela('SITUAÇÃO');


$vetCampo['publica']                    = CriaVetTabela('PUBLICA?');
$vetCampo['data_inicial_publicacao']    = CriaVetTabela('DATA INICIO <br />PUBLICAção','data');
$vetCampo['data_final_publicacao']      = CriaVetTabela('DATA FINAL <br />PUBLICAção','data');

$sql   = "select gec_ed.*, ";
$sql  .= "       gec_edt.descricao as gec_edt_descricao, ";
$sql  .= "       gec_eds.descricao as gec_eds_descricao ";
$sql  .= " from {$TabelaPrinc} {$AliasPric} ";
$sql  .= " inner join gec_edital_situacao gec_eds on gec_eds.idt = gec_ed.idt_situacao ";
$sql  .= " inner join gec_edital_tipo     gec_edt on gec_edt.idt = gec_ed.idt_tipo    ";

$sql .= ' where ';
$sql .= ' ( ';
$sql .= '  lower(gec_ed.codigo)      like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
$sql .= ' or lower(gec_ed.descricao) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
$sql .= ' or lower(gec_eds.codigo)    like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
$sql .= ' or lower(gec_eds.descricao) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
$sql .= ' or lower(gec_edt.codigo)    like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
$sql .= ' or lower(gec_edt.descricao) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
$sql .= ' ) ';
//$sql .= ' order by gec_en.codigo';
?>