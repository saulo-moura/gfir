<?php
$tabela = '';
$id = 'idt';

$sql = '';
$sql .= ' select coalesce(dap, nirf, rmp, ie_prod_rural) as vl, verificado';
$sql .= ' from grc_entidade_ajuste';
$sql .= ' where idt = '.null($_GET['id']);
$rs = execsql($sql);
$row = $rs->data[0];

$vetParametros = Array(
    'width' => '100%',
);

$titulo = 'Cadastro no CRM';

$vetCampoLC = Array();
$vetCampoLC['idt_entidade'] = CriaVetTabela('Cod. CRM');
$vetCampoLC['descricao'] = CriaVetTabela('Descrição');
$vetCampoLC['codparceiro_gec'] = CriaVetTabela('Cod. SiacWEB');
$vetCampoLC['dap'] = CriaVetTabela('DAP');
$vetCampoLC['nirf'] = CriaVetTabela('NIRF');
$vetCampoLC['rmp'] = CriaVetTabela('RMP');
$vetCampoLC['ie_prod_rural'] = CriaVetTabela('IE');
$vetCampoLC['codigo'] = CriaVetTabela('CNPJ');

$sql = '';
$sql .= ' select distinct idt_entidade, codparceiro_gec, descricao, dap, nirf, rmp, ie_prod_rural, codigo';
$sql .= ' from grc_entidade_ajuste';

if ($row['vl'] == '') {
    $sql .= ' where coalesce(dap, nirf, rmp, ie_prod_rural) is null';
} else {
    $sql .= ' where coalesce(dap, nirf, rmp, ie_prod_rural) = '.aspa($row['vl']);
}

$sql .= ' order by descricao, codparceiro_gec';

$vetParametrosLC = Array(
    'barra_inc_ap' => false,
    'barra_alt_ap' => true,
    'barra_con_ap' => true,
    'barra_exc_ap' => false,
    'menu_acesso' => 'grc_entidade_ajuste',
);

$vetCampo['grc_entidade_ajuste_cad'] = objListarConf('grc_entidade_ajuste_cad', 'idt_entidade', $vetCampoLC, $sql, $titulo, false, $vetParametrosLC);

$vetFrm[] = Frame('Registros no CRM', Array(
    Array($vetCampo['grc_entidade_ajuste_cad']),
        ), '', '', true, $vetParametros);

$titulo = 'Cadastro no SiacWEB';

$vetCampoLC = Array();
$vetCampoLC['descricao_siac'] = CriaVetTabela('Descrição');
$vetCampoLC['codparceiro_siac'] = CriaVetTabela('Cod. SiacWEB');
$vetCampoLC['dap_siac'] = CriaVetTabela('DAP');
$vetCampoLC['nirf_siac'] = CriaVetTabela('NIRF');
$vetCampoLC['rmp_siac'] = CriaVetTabela('RMP');
$vetCampoLC['ie_prod_rural_siac'] = CriaVetTabela('IE');
$vetCampoLC['codigo_siac'] = CriaVetTabela('CNPJ');

$sql = '';
$sql .= ' select distinct codparceiro_siac, descricao_siac, dap_siac, nirf_siac, rmp_siac, ie_prod_rural_siac, codigo_siac';
$sql .= ' from grc_entidade_ajuste';

if ($row['vl'] == '') {
    $sql .= ' where coalesce(dap, nirf, rmp, ie_prod_rural) is null';
} else {
    $sql .= ' where coalesce(dap, nirf, rmp, ie_prod_rural) = '.aspa($row['vl']);
}

$sql .= ' order by descricao_siac, codparceiro_siac';

$vetParametrosLC = Array(
    'comcontrole' => 0,
    'barra_inc_ap' => false,
    'barra_alt_ap' => false,
    'barra_con_ap' => false,
    'barra_exc_ap' => false,
);

$vetCampo['gec_organizacao_siac'] = objListarConf('gec_organizacao_siac', 'codparceiro_siac', $vetCampoLC, $sql, $titulo, false, $vetParametrosLC);

$vetFrm[] = Frame('Registros no SiacWEB', Array(
    Array($vetCampo['gec_organizacao_siac']),
        ), '', '', true, $vetParametros);

$vetCampo['verificado'] = objCmbVetor('verificado', 'Verificado', true, $vetSimNao, ' ', '', '', true, $row['verificado']);

$vetFrm[] = Frame('', Array(
    Array($vetCampo['verificado']),
        ), '', '', true, $vetParametros);

$vetCad[] = $vetFrm;
