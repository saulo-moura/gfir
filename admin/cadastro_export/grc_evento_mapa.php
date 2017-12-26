<?php
$sql = '';
$sql .= ' select cid.desccid as cidade, l.descricao as local_sala, epm.descricao,';
$sql .= ' e.codigo as cod_evento, e.descricao as des_evento';
$sql .= ' from grc_evento_mapa epm';
$sql .= ' inner join grc_evento e on e.idt = epm.idt_evento';
$sql .= ' left outer join grc_evento_local_pa l on l.idt = epm.idt_local_pa';
$sql .= ' left outer join ' . db_pir_siac . 'cidade cid on cid.codcid = l.logradouro_codcid';
$sql .= ' where epm.idt = ' . null($_GET['id']);
$rs = execsqlNomeCol($sql);

if ($rs->rows == 1) {
    $row = $rs->data[0];
    unset($sql);
    unset($rs);
    ?>
    <style type="text/css">
        table.tabela {
            width: 100%;
            border: none;
            border-spacing: 0px;
        }

        table.tabela tr td {
            font-size: 11px;
            padding: 10px;
        }

        div.tit {
            text-align: center;
            padding: 10px;
            font-size: 14px;
            font-weight: bold;
            color: white;
            background-color: #2f66b8;
        }

        table.tabela tr td.cT {
            font-weight: bold;
            width: 180px;
            background-color: #ecf0f1;
        }

        #mapa_tabela tr td,
        #mapa_tabela tr th {
            padding: 0px;
            font-family: Calibri, Arial, Helvetica, sans-serif;
            font-style: normal;
            font-weight: normal;
            color: #678053;
        }

        span.legenda {
            font-family: Calibri, Arial, Helvetica, sans-serif;
            font-size: 11px;
            font-style: normal;
            display: inline-block;
            margin: 0px 10px;
            color: black;
            font-weight: bold;
        }
        
        img.legenda {
            vertical-align: middle;
            padding-right: 5px;
            padding-left: 10px;
        }
    </style>
    <div class="tit">MAPA DO EVENTO</div>
    <table class="tabela">
        <tr>
            <td class="cT">Evento:</td><td class="cD"><?php echo $row['cod_evento'] . ' - ' . $row['des_evento']; ?></td>
        </tr>
        <tr>
            <td class="cT">Cidade:</td><td class="cD"><?php echo $row['cidade']; ?></td>
        </tr>
        <tr>
            <td class="cT">Local/Sala:</td><td class="cD"><?php echo $row['local_sala']; ?></td>
        </tr>
        <tr>
            <td class="cT">Mapa:</td><td class="cD"><?php echo $row['descricao']; ?></td>
        </tr>
    </table>
    <br />
    <table class="tabela">
        <tr>
            <td>
                <?php require_once 'cadastro_conf/grc_evento_mapa_assento_tabela.php'; ?>
            </td>
        </tr>
    </table>
    <?php
}

unset($row);
