<?php
acesso($menu, "'CON'", true);
onLoadPag('origem_msg');

set_time_limit(1800);

if ($origem_msg != '') {
    $_POST['origem_msg'] = $origem_msg;
}

if ($_POST['data_ini'] == '') {
    $_POST['data_ini'] = date('d/m/Y', strtotime("-1 day"));
}

$sql = 'select * from plu_erro_log';

$where = ' where 1 = 1';

if ($_SESSION[CS]['g_id_usuario'] == '1') {
	//$where .= " and mensagem <> 'SQLSTATE[HY000]: General error: 1205 Lock wait timeout exceeded; try restarting transaction'";
	//$where .= " and mensagem <> 'SQLSTATE[40001]: Serialization failure: 1213 Deadlock found when trying to get lock; try restarting transaction'";
	//$where .= " and substring(mensagem, 1, 30) <> 'Registro duplicado no SiacWeb!'";
	//$where .= " and origem_msg <> 'timeout'";
}

if ($_POST['login'] != '') {
    $where .= ' and login = '.aspa($_POST['login']);
}

if ($_POST['nom_usuario'] != '') {
    $where .= ' and nom_usuario = '.aspa($_POST['nom_usuario']);
}

if ($_POST['nom_tela'] != '') {
    $where .= ' and nom_tela = '.aspa($_POST['nom_tela']);
}

if ($_POST['origem_msg'] != '') {
    $where .= ' and origem_msg = '.aspa($_POST['origem_msg']);
}

if ($_POST['num_erro'] != '') {
    $where .= ' and num_erro = '.aspa($_POST['num_erro']);
}

if ($_POST['data_ini'] != '') {
    $where .= ' and data >= '.aspa(trata_data($_POST['data_ini']));
}

if ($_POST['data_fim'] != '') {
    $where .= ' and data <= '.aspa(trata_data($_POST['data_fim'].' 23:59:59'));
}

if ($_POST['vl_pes'] != '') {
    $where .= ' and mensagem like '.aspa($_POST['vl_pes'], '%', '%');
}

$sql .= $where;
$sql .= ' order by data desc, idt desc limit 300';
$rs = execsqlNomeCol($sql);
?>
<style type="text/css">
    Tr.Registro:hover {
        background-color: #FF8080;
    }
</style>
<script type="text/javascript">
    function valida_ini(obj) {
        Valida_DataHora(obj);
        if (obj.value != '<?php echo $_POST['data_ini']; ?>')
            document.frm.submit();
    }

    function valida_fim(obj) {
        Valida_DataHora(obj);
        if (obj.value != '<?php echo $_POST['data_fim']; ?>')
            document.frm.submit();
    }

    function envia_frm(obj, txt) {
        if (obj.value != txt)
            document.frm.submit();
    }

    function pag(n) {
        document.frm.p.value = n;
        document.frm.submit();
    }

    function detalhe(idt) {
        var url = 'ajax.php?tipo=erro_log&idt=' + idt;
        showPopWin(url, 'Classe do Erro', $(window).width() - 40, $(window).height() - 100, null);
    }

</script>
<form id="frm" name="frm" target="_self" action="conteudo.php?<?php echo substr(getParametro('login,nom_usuario,nom_tela,num_erro,data_ini,data_fim,vl_pes,p,back'), 1); ?>" method="post">
    <input type="hidden" name="p" value="<?php echo $_POST['p']; ?>">
    <table border="0" cellspacing="0" cellpadding="0" align="center">
        <?php
        if ($origem_msg == '') {
            ?>
            <tr>
                <td class="Tit_Campo_Obr" align="right" style="padding-bottom: 5px;">Origem do Erro:&nbsp;</td>
                <td style="padding-bottom: 5px;">
                    <?php
                    $sql = "select distinct origem_msg as valor, origem_msg from plu_erro_log {$where} order by origem_msg";
                    criar_combo_rs(execsql($sql), 'origem_msg', $_POST['origem_msg'], ' ', "onChange = 'document.frm.submit();'");
                    ?>
                </td>
            </tr>
            <?php
        }
        ?>
        <tr>
            <td class="Tit_Campo_Obr" align="right" style="padding-bottom: 5px;">Login:&nbsp;</td>
            <td style="padding-bottom: 5px;">
                <?php
                $sql = "select distinct login as valor, login from plu_erro_log {$where} order by login";
                criar_combo_rs(execsql($sql), 'login', $_POST['login'], ' ', "onChange = 'document.frm.submit();'");
                ?>
            </td>
        </tr>
        <tr>
            <td class="Tit_Campo_Obr" align="right" style="padding-bottom: 5px;">Nome do Usuário:&nbsp;</td>
            <td style="padding-bottom: 5px;">
                <?php
                $sql = "select distinct nom_usuario as valor, nom_usuario from plu_erro_log {$where} order by nom_usuario";
                criar_combo_rs(execsql($sql), 'nom_usuario', $_POST['nom_usuario'], ' ', "onChange = 'document.frm.submit();'");
                ?>
            </td>
        </tr>
        <tr>
            <td class="Tit_Campo_Obr" align="right" style="padding-bottom: 5px;">Formulário:&nbsp;</td>
            <td style="padding-bottom: 5px;">
                <?php
                $sql = "select distinct nom_tela as valor, nom_tela from plu_erro_log {$where} order by nom_tela";
                criar_combo_rs(execsql($sql), 'nom_tela', $_POST['nom_tela'], ' ', "onChange = 'document.frm.submit();'");
                ?>
            </td>
        </tr>
        <tr>
            <td class="Tit_Campo_Obr" align="right" style="padding-bottom: 5px;">Nº do Erro:&nbsp;</td>
            <td style="padding-bottom: 5px;">
                <input name="num_erro" type="text" class="Texto" value="<?php echo $_POST['num_erro']; ?>" size="10" onblur="envia_frm(this, '<?php echo $_POST['num_erro'] ?>')">
            </td>
        </tr>
        <tr>
            <td class="Tit_Campo_Obr" align="right" style="padding-bottom: 5px;">Período:&nbsp;</td>
            <td class="Tit_Campo_Obr" style="padding-bottom: 5px;">
                <input name="data_ini" type="text" class="Texto" value="<?php echo $_POST['data_ini']; ?>" size="16" maxlength="16" onblur="valida_ini(this)" onkeyup="return Formata_DataHora(this, event)">
                &nbsp;&nbsp;a&nbsp;&nbsp;
                <input name="data_fim" type="text" class="Texto" value="<?php echo $_POST['data_fim']; ?>" size="16" maxlength="16" onblur="valida_fim(this)" onkeyup="return Formata_DataHora(this, event)">
            </td>
        </tr>
        <tr>
            <td class="Tit_Campo_Obr" align="right" style="padding-bottom: 5px;">Pesquisar por:&nbsp;</td>
            <td style="padding-bottom: 5px;">
                <input name="vl_pes" id="vl_pes" type="text" class="Texto" value="<?php echo $_POST['vl_pes'] ?>" size="40" onblur="envia_frm(this, '<?php echo $_POST['vl_pes'] ?>')">
            </td>
        </tr>
    </table>
    <br>
    <?php
    if ($rs->rows == 300) {
        echo '<div class="Msg" style="text-align: center;">Só esta mostrando os 300 primeiros registros, se desejar ver mais usar mais opção de filtro!</div><br/>';
    }
    ?>
    <table width='100%' border='1' cellspacing='0' cellpadding='0' vspace='0' hspace='0' class='Generica'>
        <tr class="Generica">
            <td class="Titulo"></td>
            <td class="Titulo">Dt. Registro</td>
            <?php
            if ($origem_msg == '') {
                echo '<td class="Titulo">Origem</td>';
            }
            ?>
            <td class="Titulo">Login</td>
            <td class="Titulo">Nome do Usuário</td>
            <td class="Titulo">Formulário</td>
            <td class="Titulo">Nº do Erro</td>
            <td class="Titulo">Mensagem</td>
        </tr>
        <?php
        if ($rs->rows > 0) {
            //Paginação
            $p = $_REQUEST['p'];
            $pag_tot = $rs->rows;

            if ($pag_tot <= $vetConf['reg_pagina'])
                $pag_tot = 1;
            elseif (($pag_tot % $vetConf['reg_pagina']) == 0)
                $pag_tot = ($pag_tot / $vetConf['reg_pagina']);
            else
                $pag_tot = (int)($pag_tot / $vetConf['reg_pagina']) + 1;

            $pag_tot--;

            if (!is_numeric($p) || $p <= 0)
                $p = 0;
            elseif ($p > $pag_tot)
                $p = $pag_tot;
            else
                $p--;

            $fim = (($p + 1) * $vetConf['reg_pagina']);
            if ($fim > $rs->rows)
                $fim = $rs->rows;

            $indMenu = -1;
            for ($i = ($p * $vetConf['reg_pagina']); $i < $fim; $i++) {
                $row = $rs->data[$i];
                echo '<tr class="Registro">';
                echo '<td class="Registro">';
                echo "<a href='#' onclick='detalhe(".$row['idt'].")' class='Titulo'>";
                echo "<img src='imagens/consultar.gif' title='Mostrar classe do erro' border='0'>";
                echo "</a>";
                echo '</td>';
                echo '<td class="Registro">'.trata_data($row['data'], true).'</td>';

                if ($origem_msg == '') {
                    echo '<td class="Registro">'.$row['origem_msg'].'</td>';
                }

                echo '<td class="Registro">'.$row['login'].'</td>';
                echo '<td class="Registro">'.$row['nom_usuario'].'</td>';
                echo '<td class="Registro">'.$row['nom_tela'].'</td>';
                echo '<td class="Registro">'.$row['num_erro'].'</td>';
                echo '<td class="Registro">'.$row['mensagem'].'</td>';
            }

            //Linha de Paginação
            $p++;
            $pag_tot++;

            $ini = $p - $vetConf['num_pagina'];
            $fim = $p + $vetConf['num_pagina'];

            if ($ini < 1) {
                $fim = $fim - $ini + 1;
                $ini = 1;
            }

            if ($fim >= $pag_tot) {
                $ini = $ini - ($fim - $pag_tot);
                if ($ini < 1)
                    $ini = 1;

                $fim = $pag_tot;
            }

            if ($ini != $fim) {
                echo "<tr class='Generica' align='center'>
                      <td class='Titulo' colspan='8'>
                      <a href='#' onclick='pag(1)' class='Titulo'>&lt;&lt;</a>&nbsp;
                      <a href='#' onclick='pag(".($p - 1).")' class='Titulo'>&lt;</a>&nbsp;";

                for ($i = $ini; $i <= $fim; $i++) {
                    if ($i == $p)
                        echo "<span class='titulo' style='color: Red;'>$i&nbsp;</span>";
                    else
                        echo "<a href='#' onclick='pag($i)' class='Titulo'>$i</a>&nbsp;";
                }

                echo "<a href='#' onclick='pag(".($p + 1).")' class='Titulo'>&gt;</a>&nbsp;
                      <a href='#' onclick='pag($pag_tot)' class='Titulo'>&gt;&gt;</a>\n";

                if ($pag_tot > (2 * $vetConf['num_pagina'])) {
                    echo '&nbsp;&nbsp;&nbsp;';

                    $tam = strlen($pag_tot);
                    for ($i = 1; $i <= $pag_tot; $i++) {
                        $vetPag[$i] = str_repeat("0", $tam - strlen($i)).$i;
                    }

                    criar_combo_vet($vetPag, 'goPag', $p, '', "onchange = 'pag(this.value)'", 'font-size : 11px; line-height : 11px;');
                }

                echo "</td></tr>\n";
            }
        }
        ?>
    </table>
</form>