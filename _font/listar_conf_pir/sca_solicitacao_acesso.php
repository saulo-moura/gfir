<?php
$idCampo = 'idt';
$Tela = "a Solicitaηγo de Acesso";


$tipofiltro='S';


$vetStatus=Array();
$vetStatus['P']='Pendente';
$vetStatus['G']='Analisado pelo Gestor';
$vetStatus['A']='Analisado pelo Administrador';
$vetStatus['R']='Recusado o Acesso';
$vetStatus['H']='Acesso Concedido';

$Filtro = Array();
$Filtro['rs'] = $vetStatus;
$Filtro['id'] = 'status';
$Filtro['js_tam'] = '0';
$Filtro['nome'] = 'Status';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['status'] = $Filtro;


$Filtro = Array();
$Filtro['rs'] = 'Texto';
$Filtro['id'] = 'texto';
$Filtro['js_tam'] = '0';
$Filtro['nome'] = 'Texto';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['texto'] = $Filtro;


//Monta o vetor de Campo
$vetCampo['data_solicitacao']    = CriaVetTabela('Data Solicitaηγo','data');
$vetCampo['scasa_idt']           = CriaVetTabela('Protocolo');
$vetCampo['fecha_gestor']        = CriaVetTabela('FG','descDominio',$vetSimNao);
$vetCampo['fecha_administrador'] = CriaVetTabela('FA','descDominio',$vetSimNao);


$vetCampo['status']      = CriaVetTabela('Status','descDominio',$vetStatus);

$vetCampo['nome_solicitante']     = CriaVetTabela('Nome do Solicitante');

$vetCampo['scas_codigo']     = CriaVetTabela('Sigla');
$vetCampo['scas_descricao']     = CriaVetTabela('Sistema');
$vetCampo['em_descricao']     = CriaVetTabela('Ambiente');



$filtrogestores = AcessaFiltrosGestor('scas');

//echo " vvvvvvvvvvvv ".$filtrogestores;

        


$sql = '';
$sql .= ' select scasa.*,  ';
$sql .= '        scasa.idt   as scasa_idt,  ';
$sql .= '        scas.codigo as scas_codigo,  ';
$sql .= '        scas.descricao as scas_descricao,  ';
$sql .= '        em.descricao as em_descricao  ';
$sql .= ' from sca_solicitacao_acesso scasa';
$sql .= ' inner join empreendimento em on em.idt = scasa.idt_sistema_ambiente ';
$sql .= ' inner join sca_sistema scas on scas.idt = em.idt_sistema ';

$kwhw = " where ";


if ($filtrogestores!="")
{


    $sql  .= $kwhw.$filtrogestores;
    $kwhw  = " and ";

}

if ($vetFiltro['texto']['valor']!='')
{
    $sql .= " $kwhw ( ";
    $sql .= '       lower(status) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= '    or lower(nome_solicitante) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= '    or lower(data_solicitacao) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= '    or lower(scas.codigo) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= '    or lower(scas.descricao) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= '    or lower(em.descricao) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' ) ';
    $kwhw  = " and ";
}

if ($vetFiltro['status']['valor']!='')
{
    $sql .= " $kwhw ( ";
    $sql .= '       status = '.aspa($vetFiltro['status']['valor']);
    $sql .= ' ) ';
    $kwhw  = " and ";
}


$sql .= ' order by data_solicitacao desc ';


$rs = execsql($sql);
?>