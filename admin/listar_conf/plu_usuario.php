<?php
$idCampo = 'id_usuario';
$Tela = "o usuário";

$TabelaPrinc = "plu_usuario";
$AliasPric = "plu_usu";
$Entidade = "Usuário";
$Entidade_p = "Usuários";

$barra_inc_h = "Incluir um Novo Registro de Usuário";
$contlinfim = "Existem #qt Usuários.";

$tipofiltro = 'S';
$comfiltro = 'A';

$Filtro = Array();
$Filtro['rs'] = $vetSimNao;
$Filtro['id'] = 'f_ativo';
$Filtro['nome'] = 'Ativo';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['ativo'] = $Filtro;

$Filtro = Array();
$Filtro['rs'] = 'Texto';
$Filtro['id'] = 'texto';
$Filtro['js_tam'] = '0';
$Filtro['nome'] = 'Texto';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['texto'] = $Filtro;

//Monta o vetor de Campo
$vetCampo['nome_completo'] = CriaVetTabela('Nome');
$vetCampo['plu_un_descricao'] = CriaVetTabela('Natureza');
$vetCampo['login'] = CriaVetTabela('Login');
$vetCampo['ativo'] = CriaVetTabela('Ativo', 'descDominio', $vetSimNao);
$vetCampo['dt_validade'] = CriaVetTabela('Válido até', 'data');

$sql = 'select usu.*,  ';
$sql .= ' plu_un.descricao as plu_un_descricao  ';
$sql .= ' from plu_usuario usu ';
$sql .= ' left outer join plu_usuario_natureza plu_un on plu_un.idt = usu.idt_natureza';
$sql .= ' where ativo = '.aspa($vetFiltro['ativo']['valor']);

if ($vetFiltro['texto']['valor'] != '') {
    $sql .= ' and ( ';
    $sql .= ' lower(nome_completo) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' or lower(login) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' or lower(plu_un.descricao) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' or lower(plu_un.codigo) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' ) ';
}