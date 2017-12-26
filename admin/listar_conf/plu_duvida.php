<?php
$idCampo = 'idt';
$Tela = "a Dúvida";

$TabelaPrinc      = "plu_duvida";
$AliasPric        = "plu_du";
$Entidade         = "Dúvida";
$Entidade_p       = "Dúvidas";

$barra_inc_h      = "Incluir um Novo Registro de {$Entidade}";
$contlinfim       = "Existem #qt {$Entidade_p}.";


$Filtro = Array();
$Filtro['rs']       = 'Texto';
$Filtro['id']       = 'texto';
$Filtro['js_tam']   = '0';
$Filtro['nome']     = 'Texto';
$Filtro['valor']    = trata_id($Filtro);
$vetFiltro['texto'] = $Filtro;

$orderby = "pergunta";


//Monta o vetor de Campo
$vetCampo['pergunta'] = CriaVetTabela('Pergunta');
$vetCampo['resposta'] = CriaVetTabela('Resposta');

$vetOrig=Array();
$vetOrig['GE']='Geral';
$vetOrig['AT']='Atendimento';
$vetCampo['origem'] = CriaVetTabela('Origem','descDominio',$vetOrig);

$vetCampo['data_registro'] = CriaVetTabela('Data Registro','data');

$vetCampo['plu_us_nome_completo'] = CriaVetTabela('Responsável');

$sql  = "select plu_du.*, ";
$sql .= " plu_us.nome_completo as plu_us_nome_completo  ";
$sql .= " from plu_duvida plu_du ";

$sql .= ' inner join plu_usuario plu_us on plu_us.id_usuario = plu_du.idt_responsavel';


if ($vetFiltro['texto']['valor']!="")
{
    $sql .= ' where ';
    $sql .= ' ( ';
    $sql .= '  lower(pergunta)      like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' or lower(resposta) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' ) ';
}
$sql  .= " order by {$orderby}";






?>