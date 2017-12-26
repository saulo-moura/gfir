<?php
$tabela = 'grc_evento_cupom';
$id = 'idt';

$onSubmitDep = 'grc_evento_cupom_dep()';

$sql = '';
$sql .= ' select *';
$sql .= ' from grc_evento_cupom';
$sql .= ' where idt = ' . null($_GET['id']);
$rs = execsql($sql);
$rowDados = $rs->data[0];

$alt_campo = true;

if ($rowDados['qtd_resevada'] != 0 || $rowDados['qtd_utilizada'] != 0) {
    $alt_campo = false;
}

$vetFrm = Array();

if ($alt_campo) {
    $vetCampo['palavra_chave'] = objTexto('palavra_chave', 'Palavra Chave', true, 45);
    $vetCampo['perc_desconto'] = objDecimal('perc_desconto', '% Desconto', true, 6);
    $vetCampo['data_validade'] = objData('data_validade', 'Data Validade Cupom', true, '', '', 'S');
} else {
    $vetCampo['palavra_chave'] = objTextoFixo('palavra_chave', 'Palavra Chave', '', true);
    $vetCampo['perc_desconto'] = objTextoFixo('perc_desconto', '% Desconto', 6, true);
    $vetCampo['data_validade'] = objTextoFixo('data_validade', 'Data Validade Cupom', '10', true);
}

$vetCampo['ativo'] = objCmbVetor('ativo', 'Ativo?', True, $vetSimNao);
$vetCampo['utilizacao_direta'] = objCmbVetor('utilizacao_direta', 'Aplicável a todos os eventos do Sebrae Bahia?', True, $vetSimNao);

$vetCampo['qtd_disponivel'] = objInteiro('qtd_disponivel', 'Qtd. Disponível', true, 9);
$vetCampo['qtd_resevada'] = objTextoFixo('qtd_resevada', 'Qtd. Reservada', 9, true);
$vetCampo['qtd_utilizada'] = objTextoFixo('qtd_utilizada', 'Qtd. Utilizada', 9, true);

MesclarCol($vetCampo['palavra_chave'], 5);
MesclarCol($vetCampo['utilizacao_direta'], 5);

$vetFrm[] = Frame('', Array(
    Array($vetCampo['palavra_chave']),
    Array($vetCampo['perc_desconto'], '', $vetCampo['data_validade'], '', $vetCampo['ativo']),
    Array($vetCampo['qtd_disponivel'], '', $vetCampo['qtd_resevada'], '', $vetCampo['qtd_utilizada']),
    Array($vetCampo['utilizacao_direta']),
        ));

$vetCampoLC = Array();
$vetCampoLC['tit_evento'] = CriaVetTabela('Evento');
$vetCampoLC['situacao'] = CriaVetTabela('Situação', 'descDominio', $vetEventoPubSituacao);
$vetCampoLC['qtd_resevada'] = CriaVetTabela('Qtd. Reservada');
$vetCampoLC['qtd_disponivel'] = CriaVetTabela('Qtd. Disponível');
$vetCampoLC['qtd_utilizada'] = CriaVetTabela('Qtd. Utilizada');

$titulo = 'Utilização do Cupom no Evento';

$sql = '';
$sql .= " select pc.*, concat(e.codigo, '<br />', e.descricao) as tit_evento, p.situacao";
$sql .= ' from grc_evento_publicacao_cupom pc';
$sql .= ' inner join grc_evento_publicacao p on p.idt = pc.idt_evento_publicacao';
$sql .= ' inner join grc_evento e on e.idt = p.idt_evento';
$sql .= ' where pc.idt_evento_cupom = $vlID';
$sql .= " and p.situacao <> 'CA'";
$sql .= ' order by e.codigo, e.descricao';

$vetParametrosLC = Array(
    'comcontrole' => '0',
    'barra_inc_ap' => false,
    'barra_alt_ap' => false,
    'barra_con_ap' => false,
    'barra_exc_ap' => false,
);

$vetCampo['grc_evento_publicacao_cupom'] = objListarConf('grc_evento_publicacao_cupom', 'idt', $vetCampoLC, $sql, $titulo, false, $vetParametrosLC);

$vetParametros = Array(
    'width' => '100%',
);

$vetFrm[] = Frame('<span>' . $titulo . '</span>', Array(
    Array($vetCampo['grc_evento_publicacao_cupom']),
        ), '', '', true, $vetParametros);

$vetCad[] = $vetFrm;
?>
<script type="text/javascript">
    function grc_evento_cupom_dep() {
        if (valida == 'S') {
            if ($('#perc_desconto').val() != '') {
                var perc_desconto = str2float($('#perc_desconto').val());

                if (perc_desconto > 100) {
                    alert('O Desconto não pode ser maior que 100,00%!');
                    $('#perc_desconto').val('');
                    $('#perc_desconto').focus();
                    return false;
                }
            }
        }

        return true;
    }
</script>