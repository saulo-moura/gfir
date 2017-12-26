<?php
$idCampo = 'codparceiro';
$conSQL = conSIAC();
$Tela = "a Pesquisa no SiacWEB";

function ftd_siacweb_parceiro($valor, $row, $Campo) {
    return FormataCNPJ($valor);
}

// Monta o vetor de Campo
$vetCampo['nomerazaosocial'] = CriaVetTabela('RAZ�O SOCIAL');
$vetCampo['nomeabrevfantasia'] = CriaVetTabela('NOME FANTASIA');
$vetCampo['cgccpf'] = CriaVetTabela('CNPJ', 'func_trata_dado', ftd_siacweb_parceiro);
$vetCampo['inscest'] = CriaVetTabela('INSCRI��O ESTADUAL');
$vetCampo['coddap'] = CriaVetTabela('DAP');
$vetCampo['codpescador'] = CriaVetTabela('REGISTRO MINIST�RIO DA PESCA');
$vetCampo['nirf'] = CriaVetTabela('NIRF');
$vetCampo['codparceiro'] = CriaVetTabela('C�DIGO DO SIACWEB');

$sql = '';
$sql .= ' select p.nomerazaosocial, p.nomeabrevfantasia, p.cgccpf, j.inscest, j.coddap, j.codpescador, j.nirf, p.codparceiro';
$sql .= ' from parceiro p';
$sql .= ' inner join pessoaj j on j.codparceiro = p.codparceiro';
$sql .= ' where p.codparceiro in ('.$_SESSION[CS]['tmp'][$_GET['codparceiro_lista']].')';

$vetOrderby = Array(
    'p.nomerazaosocial' => 'RAZ�O SOCIAL',
    'p.nomeabrevfantasia' => 'NOME FANTASIA',
    'p.cgccpf' => 'CNPJ',
    'j.inscest' => 'INSCRI��O ESTADUAL',
    'j.coddap' => 'DAP',
    'j.codpescador' => 'REGISTRO MINIST�RIO DA PESCA',
    'j.nirf' => 'NIRF',
    'p.codparceiro' => 'C�DIGO DO SIACWEB',
);
