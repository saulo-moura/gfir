<?php
$ordFiltro  = false;
$idCampo    = 'idt';
$idCampoPar = 'boletim_idt';

$idCampo = 'idt';
$Tela = "o Boletim";

$prefixow = 'listar';

$tipoidentificacao = 'N';
$tipofiltro = 'S';

$mostrar = false;
$cond_campo = '';
$cond_valor = '';


$TabelaPrinc = db_pir."plu_boletim_informativo";
$AliasPric   = "plu_bi";
$Entidade    = "Boletim Informativo";
$Entidade_p  = "Boletins Informativos";
$barra_inc_h = "Incluir um Novo Registro de {$Entidade}";
$contlinfim  = "Existem #qt {$Entidade_p}.";

$Filtro = Array();
$Filtro['rs']       = 'Texto';
$Filtro['id']       = 'boletim_texto';
$Filtro['js_tam']   = '0';
$Filtro['nome']     = 'Texto';
$Filtro['valor']    = trata_id($Filtro);
$vetFiltro['texto'] = $Filtro;

// Monta o vetor de Campo
$vetCampo['codigo']       = CriaVetTabela('CÓDIGO');
$vetCampo['descricao']    = CriaVetTabela('DESCRIÇÃO');
$vetCampo['ativo']        = CriaVetTabela('Ativo?','descDominio',$vetSimNao);
$vetCampo['publica']      = CriaVetTabela('Publica?','descDominio',$vetSimNao);
$vetCampo['data_inicial'] = CriaVetTabela('DATA INICIO <br />PUBLICAção', 'data');
$vetCampo['data_final']   = CriaVetTabela('DATA FINAL <br />PUBLICAção', 'data');


$sql  = "select {$AliasPric}.*, ";
$sql .= "  concat_ws('<br />',descricao,detalhe) as descricao ";
$sql .= " from {$TabelaPrinc} {$AliasPric} ";
$sql .= ' where ';
$sql .= ' ( ';
$sql .= "  lower({$AliasPric}.codigo)      like lower(".aspa($vetFiltro['texto']['valor'], '%', '%').')';
$sql .= " or lower({$AliasPric}.descricao) like lower(".aspa($vetFiltro['texto']['valor'], '%', '%').')';
$sql .= " or lower({$AliasPric}.detalhe)   like lower(".aspa($vetFiltro['texto']['valor'], '%', '%').')';
$sql .= ' ) ';
