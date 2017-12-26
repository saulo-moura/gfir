<?php
$idCampo = 'cep';
$Tela = "a CEP";

$menu_acesso = '';
$tipofiltro = 'S';
$comfiltro = 'A';

$sql = '';
$sql .= " select distinct uf_sigla, codcid as cidade";
$sql .= ' from '.db_pir_gec.'base_cep';
$sql .= ' where codcid = '.aspa($_SESSION[CS]['gdesc_codcid']);
$sql .= ' and cep_situacao = 1';
$rs = execsql($sql);
$row = $rs->data[0];

$Filtro = Array();
$Filtro['rs'] = $vetEstado;
$Filtro['id'] = 'uf_sigla';
$Filtro['nome'] = 'Estado';
$Filtro['LinhaUm'] = ' ';

if (count($_POST) == 0) {
    $Filtro['vlPadrao'] = $row['uf_sigla'];
}

$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['uf_sigla'] = $Filtro;

$sql = '';
$sql .= " select distinct codcid as cod, cidade";
$sql .= ' from '.db_pir_gec.'base_cep';
$sql .= ' where uf_sigla = '.aspa($vetFiltro['uf_sigla']['valor']);
$sql .= ' and cep_situacao = 1';
$sql .= ' order by cidade';

$Filtro = Array();
$Filtro['rs'] = execsql($sql);
$Filtro['id_select'] = 'cod';
$Filtro['id'] = 'cidade';
$Filtro['nome'] = 'Cidade';
$Filtro['LinhaUm'] = ' ';

if (count($_POST) == 0) {
    $Filtro['vlPadrao'] = $row['cidade'];
}

$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['cidade'] = $Filtro;

$sql = '';
$sql .= " select distinct codbairro as cod, bairro";
$sql .= ' from '.db_pir_gec.'base_cep';
$sql .= ' where codcid = '.aspa($vetFiltro['cidade']['valor']);
$sql .= ' and cep_situacao = 1';
$sql .= ' order by bairro';

$Filtro = Array();
$Filtro['rs'] = execsql($sql);
$Filtro['id_select'] = 'cod';
$Filtro['id'] = 'bairro';
$Filtro['nome'] = 'Bairro';
$Filtro['LinhaUm'] = ' ';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['bairro'] = $Filtro;

$sql = '';
$sql .= " select distinct logradouro as cod, logradouro";
$sql .= ' from '.db_pir_gec.'base_cep';
$sql .= ' where codbairro = '.aspa($vetFiltro['bairro']['valor']);
$sql .= ' and cep_situacao = 1';
$sql .= ' order by logradouro';

$Filtro = Array();
$Filtro['rs'] = execsql($sql);
$Filtro['id_select'] = 'cod';
$Filtro['id'] = 'logradouro';
$Filtro['nome'] = 'Logradouro';
$Filtro['LinhaUm'] = ' ';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['logradouro'] = $Filtro;
//p($vetFiltro['logradouro']);

$Filtro = Array();
$Filtro['rs'] = 'Texto';
$Filtro['id'] = 'texto';
$Filtro['nome'] = 'Texto';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['texto'] = $Filtro;

$Filtro = Array();
$Filtro['rs'] = 'Texto';
$Filtro['id'] = 'cep';
$Filtro['nome'] = 'CEP';
$Filtro['js'] = 'onkeyup="return Formata_Cep(this,event)" onblur="return IsCEP(this)"';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['cep'] = $Filtro;

//Monta o vetor de Campo
$vetCampo['uf_sigla'] = CriaVetTabela('Estado', 'descDominio', $vetEstado);
$vetCampo['cidade'] = CriaVetTabela('Cidade');
$vetCampo['bairro'] = CriaVetTabela('Bairro');
$vetCampo['logradouro'] = CriaVetTabela('Logradouro');
$vetCampo['complemento'] = CriaVetTabela('Complemento');
$vetCampo['cep'] = CriaVetTabela('CEP');

$sql = '';
$sql .= " select uf_sigla, cidade, bairro, logradouro, complemento, cep, cep as {$campoDescListarCmb}";
$sql .= ' from '.db_pir_gec.'base_cep';
$sql .= ' where cep_situacao = 1';

if ($vetFiltro['cep']['valor'] != '') {
    $sql .= ' and cep = '.null(preg_replace('/[^0-9]/i', '', $vetFiltro['cep']['valor']));
} else {
    if ($vetFiltro['uf_sigla']['valor'] != '0' && $vetFiltro['uf_sigla']['valor'] != '-1' && $vetFiltro['uf_sigla']['valor'] != '') {
        $sql .= ' and uf_sigla = '.aspa($vetFiltro['uf_sigla']['valor']);
    }

    if ($vetFiltro['cidade']['valor'] != '0' && $vetFiltro['cidade']['valor'] != '-1' && $vetFiltro['cidade']['valor'] != '') {
        $sql .= ' and codcid = '.aspa($vetFiltro['cidade']['valor']);
    }

    if ($vetFiltro['bairro']['valor'] != '0' && $vetFiltro['bairro']['valor'] != '-1' && $vetFiltro['bairro']['valor'] != '') {
        $sql .= ' and codbairro = '.aspa($vetFiltro['bairro']['valor']);
    }

    if ($vetFiltro['logradouro']['valor'] != '0' && $vetFiltro['logradouro']['valor'] != '-1' && $vetFiltro['logradouro']['valor'] != '') {
        $sql .= ' and logradouro = '.aspa($vetFiltro['logradouro']['valor']);
    }

    if ($vetFiltro['texto']['valor'] != '-1' && $vetFiltro['texto']['valor'] != '') {
        $sql .= ' and (';
        $sql .= '    lower(cidade) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
        $sql .= ' or lower(bairro) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
        $sql .= ' or lower(logradouro) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
        $sql .= ' )';
    }
}
?>
<script type="text/javascript">
    $(document).ready(function () {
        $("#cidade1").cascade("#uf_sigla0", {
            ajax: {
                url: ajax_plu + '&tipo=busca_cep_cidade&cas=' + conteudo_abrir_sistema
            }
        });

        $("#bairro2").cascade("#cidade1", {
            ajax: {
                url: ajax_plu + '&tipo=busca_cep_bairro&cas=' + conteudo_abrir_sistema
            }
        });

        $("#logradouro3").cascade("#bairro2", {
            ajax: {
                url: ajax_plu + '&tipo=busca_cep_logradouro&cas=' + conteudo_abrir_sistema
            }
        });
    });
</script>