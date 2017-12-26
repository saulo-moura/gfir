<?php
$idCampo = 'codparceiro';
$conSQL = conSIAC();
$Tela = "a Pesquisa no SiacWEB";

function ftd_siacweb_parceiro($valor, $row, $Campo) {
    return FormataCNPJ($valor);
}

// Monta o vetor de Campo
$vetCampo['nomerazaosocial'] = CriaVetTabela('RAZÃO SOCIAL');
$vetCampo['nomeabrevfantasia'] = CriaVetTabela('NOME FANTASIA');
$vetCampo['cgccpf'] = CriaVetTabela('CNPJ', 'func_trata_dado', ftd_siacweb_parceiro);
$vetCampo['inscest'] = CriaVetTabela('INSCRIÇÃO ESTADUAL');
$vetCampo['coddap'] = CriaVetTabela('DAP');
$vetCampo['codpescador'] = CriaVetTabela('REGISTRO MINISTÉRIO DA PESCA');
$vetCampo['nirf'] = CriaVetTabela('NIRF');
$vetCampo['codparceiro'] = CriaVetTabela('CÓDIGO DO SIACWEB');

$sql = '';
$sql .= ' select p.nomerazaosocial, p.nomeabrevfantasia, p.cgccpf, j.inscest, j.coddap, j.codpescador, j.nirf, p.codparceiro';
$sql .= ' from parceiro p';
$sql .= ' inner join pessoaj j on j.codparceiro = p.codparceiro';
$sql .= ' where p.codparceiro in ('.$_SESSION[CS]['tmp'][$_GET['codparceiro_lista']].')';

$vetOrderby = Array(
    'p.nomerazaosocial' => 'RAZÃO SOCIAL',
    'p.nomeabrevfantasia' => 'NOME FANTASIA',
    'p.cgccpf' => 'CNPJ',
    'j.inscest' => 'INSCRIÇÃO ESTADUAL',
    'j.coddap' => 'DAP',
    'j.codpescador' => 'REGISTRO MINISTÉRIO DA PESCA',
    'j.nirf' => 'NIRF',
    'p.codparceiro' => 'CÓDIGO DO SIACWEB',
);
