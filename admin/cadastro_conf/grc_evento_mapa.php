<style>
    fieldset.class_frame {
        background:#FFFFFF;
        border:0px solid #2C3E50;
    }

    div.class_titulo {
        text-align: left;
        background: #FFFFFF;
        color     : #FFFFFF;
        border    : 0px solid #2C3E50;
    }

    div.class_titulo span {
        padding-left:10px;
    }

    fieldset.class_frame_p {
        background:#FFFFFF;
        border:0px solid #FFFFFF;
    }

    div.class_titulo_p {
        background: #2F66B8;
        border    : 0px solid #2C3E50;
        color     : #FFFFFF;
        text-align: left;
        height    : 20px;
        font-size : 12px;
        padding-top:5px;
    }

    div.class_titulo_p span {
        padding:10px;
        text-align: left;
    }

    #bt_novo_desc {
        vertical-align: bottom;
    }

    #idt_cidade,
    #idt_local_pa,
    #idt_local_pa_mapa {
        width: 270px;
    }

    #legenda {
        margin: 10px;
    }

    #legenda > span {
        display: inline-block;
        margin: 0px 10px;
        color: black;
        font-weight: bold;
    }

    #legenda img {
        vertical-align: middle;
        padding-right: 5px;
    }
</style>
<?php
$class_frame_p = "class_frame_p";
$class_titulo_p = "class_titulo_p";
$class_frame = "class_frame";
$class_titulo = "class_titulo";

if ($_GET['idCad'] != '') {
    $_GET['idt0'] = $_GET['idCad'];
    $botao_volta = "parent.btFechaCTC('" . $_GET['session_cod'] . "');";
    $botao_acao = '<script type="text/javascript">parent.btFechaCTC("' . $_GET['session_cod'] . '");</script>';
}

$id = 'idt';
$tabela = 'grc_evento_mapa';

//$bt_exportar = true;
//$bt_exportar_desc = 'Exportar Mapa';

$sql = '';
$sql .= ' select l.idt as idt_local_pa, l.logradouro_codcid as idt_cidade, epm.idt_local_pa_mapa';
$sql .= ' from grc_evento_mapa epm';
$sql .= ' inner join grc_evento_local_pa l on l.idt = epm.idt_local_pa';
$sql .= ' where epm.idt = ' . null($_GET['id']);
$rs = execsql($sql);
$row = $rs->data[0];

if ($row['idt_local_pa'] == '') {
    $row['idt_local_pa'] = $_GET['idt_local'];
}

if ($row['idt_cidade'] == '') {
    $row['idt_cidade'] = $_GET['idt_cidade'];
} else {
    $_GET['idt_cidade'] = $row['idt_cidade'];
}

$vetFrm = Array();

$vetCampo['idt_evento'] = objHidden('idt_evento', $_GET['idt0']);
$vetCampo['bt_continua'] = objHidden('bt_continua', '', '', '', false);
$vetCampo['idt_cidade'] = objFixoBanco('idt_cidade', 'Cidade', db_pir_siac . 'cidade', 'codcid', 'desccid', 'idt_cidade', false);
$vetCampo['idt_local_pa'] = objFixoBanco('idt_local_pa', 'Local/Sala', 'grc_evento_local_pa', 'idt', 'descricao');

// Local Mapa
$sql = '';
$sql .= ' select idt, descricao';
$sql .= ' from grc_evento_local_pa_mapa';
$sql .= ' where idt_local_pa = ' . null($row['idt_local_pa']);
$sql .= " and (ativo = 'S' or idt = " . null($row['idt_local_pa_mapa']) . ")";
$sql .= ' order by descricao';
$vetCampo['idt_local_pa_mapa'] = objCmbBanco('idt_local_pa_mapa', 'Mapa', true, $sql, '');

$vetCampo['descricao'] = objTexto('descricao', 'Descrição', true, 90, 120);
$vetCampo['assento_mapa'] = objFile('assento_mapa', 'Mapa de assentos', false, 120, 'todos');

$maxlength = 2000;
$style = "width:700px;";
$js = "";
$vetCampo['detalhe'] = objTextArea('detalhe', 'Observação', false, $maxlength, $style);

MesclarCol($vetCampo['idt_evento'], 3);
MesclarCol($vetCampo['descricao'], 5);
MesclarCol($vetCampo['assento_mapa'], 5);
MesclarCol($vetCampo['detalhe'], 5);

$vetFrm[] = Frame('', Array(
    Array($vetCampo['idt_evento'], '', $vetCampo['bt_continua']),
    Array($vetCampo['idt_cidade'], '', $vetCampo['idt_local_pa'], '', $vetCampo['idt_local_pa_mapa']),
    Array($vetCampo['descricao']),
    Array($vetCampo['assento_mapa']),
    Array($vetCampo['detalhe']),
        ), $class_frame, $class_titulo, $titulo_na_linha);

// ASSENTOS DO MAPA DA SALA
$vetParametros = Array(
    'codigo_frm' => 'mapasala',
    'controle_fecha' => 'A',
);

$vetFrm[] = Frame('<span>Mapa da Sala</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

$vetParametros = Array(
    'codigo_pai' => 'mapasala',
    'width' => '100%',
);

$vetCampo['grc_evento_mapa_assento_tabela'] = objInclude('grc_evento_mapa_assento_tabela', 'cadastro_conf/grc_evento_mapa_assento_tabela.php');

$vetFrm[] = Frame('', Array(
    Array($vetCampo['grc_evento_mapa_assento_tabela']),
        ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);

/*
  $vetParametros = Array(
  'codigo_frm' => 'assentosmapasala',
  'controle_fecha' => 'F',
  'width' => '100%',
  );

  $vetFrm[] = Frame('<span>Assentos do Mapa da Sala</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

  $vetCampoLC = Array();
  $vetCampoLC['codigo'] = CriaVetTabela('Código');
  $vetCampoLC['descricao'] = CriaVetTabela('Descrição');
  $vetCampoLC['grc_elpta_descricao'] = CriaVetTabela('Tipo');
  $vetCampoLC['linha'] = CriaVetTabela('Linha');
  $vetCampoLC['coluna'] = CriaVetTabela('Coluna');
  $vetCampoLC['ativo'] = CriaVetTabela('Ativo?', 'descDominio', $vetSimNao);

  $titulo = 'Assentos do Mapa da Sala';

  $sql = "select epma.*, ";
  $sql .= "  grc_elpta.descricao as grc_elpta_descricao  ";
  $sql .= " from grc_evento_mapa_assento epma  ";
  $sql .= " inner join grc_evento_local_pa_tipo_assento grc_elpta on  grc_elpta.idt = epma.idt_tipo_assento ";
  $sql .= ' where epma.idt_evento_mapa = $vlID';
  $sql .= " order by epma.linha, epma.coluna";

  $vetCampo['grc_evento_mapa_assento'] = objListarConf('grc_evento_mapa_assento', 'idt', $vetCampoLC, $sql, $titulo, false, $vetParametros);

  $vetParametros = Array(
  'codigo_pai' => 'assentosmapasala',
  'width' => '100%',
  );

  $vetFrm[] = Frame('', Array(
  Array($vetCampo['grc_evento_mapa_assento']),
  ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);
 */

$vetCad[] = $vetFrm;
?>
<script type="text/javascript">
    var confirmMsg = true;

    $(document).ready(function () {
        $('#idt_local_pa_mapa').change(function () {
            var ok = true;

            if (confirmMsg) {
                ok = confirm('Com a troca do Mapa, vai ser apagado todos os dados referente a este mapa neste registro\n\nDeseja continuar?');
            }
            
            confirmMsg = true;

            if (ok) {
                $('#bt_continua').val('S');
                valida_cust = 'N';
                onSubmitMsgTxt = false;
                $(':submit:first').click();
            }
        });

        if ('<?php echo $row['idt_local_pa_mapa']; ?>' == '' && $('#idt_local_pa_mapa').val() != '') {
            confirmMsg = false;
            $('#idt_local_pa_mapa').change();
        }
    });

    /*
     function funcaoFechaCTC_grc_evento_mapa_assento() {
     processando();
     
     $.ajax({
     dataType: 'html',
     type: 'POST',
     url: ajax_sistema + '?tipo=grc_evento_mapa_assento_tabela',
     data: {
     cas: conteudo_abrir_sistema,
     acao: '<?php echo $acao; ?>',
     id: $('#id').val()
     },
     success: function (response) {
     $('#grc_evento_mapa_assento_tabela_desc').html(url_decode(response));
     },
     error: function (jqXHR, textStatus, errorThrown) {
     alert('Erro no ajax no: ' + textStatus + ' - ' + errorThrown);
     },
     async: false
     });
     
     $('#dialog-processando').remove();
     }
     
     function abreALT(idt) {
     $("#grc_evento_mapa_assento_desc a.Titulo[data-id='" + idt + "'][data-acao='alt']").click();
     }
     */
</script>
