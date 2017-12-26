<?php
$idCampo = 'idt';
$Tela = "a Seчуo da Organizaчуo";

 $tipoidentificacao='N';
 $tipofiltro='S';

$comfiltro = 'A';
//$comidentificacao = 'F';



$mostrar    = false;
$cond_campo = '';
$cond_valor = '';



$sql  = "select sca_eo.idt, sca_eo.descricao from ".db_pir."sca_estrutura_organizacional sca_eo";
$sql .= " where idt = 1";
$sql .= " order by sca_eo.descricao";
$Filtro = Array();
$Filtro['rs']       = execsql($sql);
$Filtro['id']       = 'idt';
$Filtro['nome']     = 'Organizaчуo';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['idt_organizacao'] = $Filtro;

$tipofiltro='S';
$Filtro = Array();
$Filtro['rs'] = 'Texto';
$Filtro['id'] = 'texto';
$Filtro['js_tam'] = '0';
$Filtro['nome'] = 'Texto';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['texto'] = $Filtro;



$vetListarCmbRegValido = Array(
    'posto_atendimento' => Array('S'),
);


$TabelaPrinc = "".db_pir."sca_organizacao_secao";
$AliasPric = "gec_ac";
$Entidade = "Ponto de Atendimento";
$Entidade_p = "Pontos de Atendimento";

$contlinfim = "Existem #qt Сreas - Subсreas - Especialidades";



$vetCampo=Array();
$vetCampo['descricao']      = CriaVetTabela('Descriчуo');
$vetCampo['sigla']          = CriaVetTabela('Sigla');
//  $vetCampo['est_descricao']  = CriaVetTabela('Estado');

$sql   = 'select ';
$sql  .= '   scaos.*,  ';
$sql  .= '   est.descricao as est_descricao, ';
$sql  .= " concat_ws(' - ', scaos.descricao) as {$campoDescListarCmb}";

$sql  .= ' from '.db_pir.'sca_organizacao_secao as scaos ';
$sql  .= ' left join db_pir_gec.plu_estado est on est.idt = scaos.idt_estado ';

$sql  .= ' where scaos.idt_organizacao = '.null($vetFiltro['idt_organizacao']['valor']);
$sql  .= ' and (posto_atendimento = '.aspa('S').' or posto_atendimento = '.aspa('UR').' ) ';

if ($vetFiltro['texto']['valor']!='')
{
    $sql  .= '   and ( ';
    $sql  .= ' lower(scaos.localidade) like lower('.aspa($vetFiltro['texto']['valor'], '', '%').')';
    $sql  .= ' or lower(scaos.codigo) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql  .= ' or lower(scaos.descricao) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';

    $sql  .= '  ) ';
}

$sql  .= ' order by scaos.classificacao ';


?>