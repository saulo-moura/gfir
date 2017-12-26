<?php
acesso($menu, "'CON'", true);
onLoadPag('login');

if ($_POST['log_sistema'] == '') {
    $_POST['log_sistema'] = log_sistema;
}

if ($_POST['des_pk'] == '') {
    $_POST['des_pk'] = $_GET['des_pk'];
}

if ($_GET['back'] == 's') {
    $_POST = $_SESSION[CS]['g_log_sis_sql'];
} else {
    $_SESSION[CS]['g_log_sis_sql'] = $_POST;
}

$sql = 'select * from ' . $_POST['log_sistema'] . ' l where 1 = 1';

if ($_POST['login'] != '') {
    $sql .= ' and login = ' . aspa($_POST['login']);
}

if ($_POST['nom_usuario'] != '') {
    $sql .= ' and nom_usuario = ' . aspa($_POST['nom_usuario']);
}

if ($_POST['nom_tela'] != '') {
    $sql .= ' and nom_tela = ' . aspa($_POST['nom_tela']);
}

if ($_POST['sts_acao'] != '') {
    $sql .= ' and sts_acao = ' . aspa($_POST['sts_acao']);
}

if ($_POST['des_pk'] != '') {
    $sql .= ' and des_pk = ' . aspa($_POST['des_pk']);
}

if ($_POST['dtc_registro_ini'] != '') {
    $sql .= ' and dtc_registro >= ' . aspa(trata_data($_POST['dtc_registro_ini']));
}

if ($_POST['dtc_registro_fim'] != '') {
    $sql .= ' and dtc_registro <= ' . aspa(trata_data($_POST['dtc_registro_fim'] . ' 23:59:59'));
}

if ($_POST['vl_pes'] != '') {
    $sql .= ' and (';
    $sql .= ' exists(select d.id_lsd from ' . $_POST['log_sistema'] . '_detalhe d where l.id_log_sistema = d.id_log_sistema';
    $sql .= ' and (d.desc_ant like ' . aspa($_POST['vl_pes'], '%', '%') . ' or d.desc_atu like ' . aspa($_POST['vl_pes'], '%', '%') . '))';

    $sql .= ' or des_registro like ' . aspa($_POST['vl_pes'], '%', '%');
    $sql .= ' )';
}

$sql .= ' order by dtc_registro desc, id_log_sistema desc limit 500';
$rs = execsql($sql);

$strpar = 'log_sistema,nom_cliente,login,nom_usuario,nom_tela,sts_acao,des_pk,dtc_registro_ini,dtc_registro_fim,vl_pes,back,goPag,id';
?>
<style type="text/css">
    Tr.Registro:hover {
        background-color: #FF8080;
    }
</style>
<script type="text/javascript">
    function valida_ini(obj) {
        checkdate(obj);
        if (obj.value != '<?php echo$_POST['dtc_registro_ini'] ?>')
            document.frm.submit();
    }

    function valida_fim(obj) {
        checkdate(obj);
        if (obj.value != '<?php echo$_POST['dtc_registro_fim'] ?>')
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

    function abre_popup_srv(id) {
        showPopWin('conteudo_cadastro.php?menu=plu_log_sis&prefixo=srv&log_sistema=<?php echo $_POST['log_sistema'] ?>&id=' + id, 'Dados do Servidor', $('div.showPopWin_width').width() - 30, $(window).height() - 100);
        return false;
    }
    
    function abre_popup(id) {
        showPopWin('conteudo_cadastro.php?menu=plu_log_sis&prefixo=extra&log_sistema=<?php echo $_POST['log_sistema'] ?>&id=' + id, 'Informações do Regsitro', $('div.showPopWin_width').width() - 30, $(window).height() - 40);
        return false;
    }
</script>
<form id="frm" name="frm" target="_self" action="conteudo.php?<?php echo substr(getParametro($strpar), 1) ?>" method="post">
    <input type="hidden" name="p" value="<?php echo$_POST['p'] ?>">
    <table border="0" cellspacing="0" cellpadding="0" align="center">
        <tr>
            <td class="Tit_Campo_Obr" align="right" style="padding-bottom: 5px;">Tabela de LOG:&nbsp;</td>
            <td style="padding-bottom: 5px;">
                <?php
                $sql = "select tabela, descricao from plu_log_sistema_tab order by descricao";
                criar_combo_rs(execsql($sql), 'log_sistema', $_POST['log_sistema'], '', "onChange = 'document.frm.submit();'");
                ?>
            </td>
        </tr>
        <tr>
            <td class="Tit_Campo_Obr" align="right" style="padding-bottom: 5px;">Login:&nbsp;</td>
            <td style="padding-bottom: 5px;">
                <?php
                $sql = "select distinct login as valor, login from " . $_POST['log_sistema'] . " order by login";
                criar_combo_rs(execsql($sql), 'login', $_POST['login'], ' ', "onChange = 'document.frm.submit();'");
                ?>
            </td>
        </tr>
        <tr>
            <td class="Tit_Campo_Obr" align="right" style="padding-bottom: 5px;">Nome do Usuário:&nbsp;</td>
            <td style="padding-bottom: 5px;">
                <?php
                $sql = "select distinct nom_usuario as valor, nom_usuario from " . $_POST['log_sistema'] . " order by nom_usuario";
                criar_combo_rs(execsql($sql), 'nom_usuario', $_POST['nom_usuario'], ' ', "onChange = 'document.frm.submit();'");
                ?>
            </td>
        </tr>
        <tr>
            <td class="Tit_Campo_Obr" align="right" style="padding-bottom: 5px;">Formulário:&nbsp;</td>
            <td style="padding-bottom: 5px;">
                <?php
                $sql = "select distinct nom_tela as valor, nom_tela from " . $_POST['log_sistema'] . " order by nom_tela";
                criar_combo_rs(execsql($sql), 'nom_tela', $_POST['nom_tela'], ' ', "onChange = 'document.frm.submit();'");
                ?>
            </td>
        </tr>
        <tr>
            <td class="Tit_Campo_Obr" align="right" style="padding-bottom: 5px;">Ação:&nbsp;</td>
            <td style="padding-bottom: 5px;">
                <?php
                criar_combo_vet($vetLogAcao, 'sts_acao', $_POST['sts_acao'], ' ', "onChange = 'document.frm.submit();'");
                ?>
            </td>
        </tr>
        <tr>
            <td class="Tit_Campo_Obr" align="right" style="padding-bottom: 5px;">Nº PK:&nbsp;</td>
            <td style="padding-bottom: 5px;">
                <input name="des_pk" type="text" class="Texto" value="<?php echo $_POST['des_pk'] ?>" size="20" onblur="envia_frm(this, '<?php echo $_POST['des_pk'] ?>')">
            </td>
        </tr>
        <tr>
            <td class="Tit_Campo_Obr" align="right" style="padding-bottom: 5px;">Período:&nbsp;</td>
            <td class="Tit_Campo_Obr" style="padding-bottom: 5px;">
                <input name="dtc_registro_ini" type="text" class="Texto" value="<?php echo$_POST['dtc_registro_ini'] ?>" size="10" maxlength="10" onblur="valida_ini(this)" onkeyup="return Formata_Data(this, event)">
                &nbsp;&nbsp;a&nbsp;&nbsp;
                <input name="dtc_registro_fim" type="text" class="Texto" value="<?php echo$_POST['dtc_registro_fim'] ?>" size="10" maxlength="10" onblur="valida_fim(this)" onkeyup="return Formata_Data(this, event)">
            </td>
        </tr>
        <tr>
            <td class="Tit_Campo_Obr" align="right" style="padding-bottom: 5px;">Pesquisar por:&nbsp;</td>
            <td style="padding-bottom: 5px;">
                <input name="vl_pes" id="vl_pes" type="text" class="Texto" value="<?php echo $_POST['vl_pes'] ?>" size="20" onblur="envia_frm(this, '<?php echo $_POST['vl_pes'] ?>')">
            </td>
        </tr>
    </table>
    <br>
    <?php
    if ($rs->rows == 500) {
        echo '<div class="Msg" style="text-align: center;">Só esta mostrando os 500 primeiros registros, se desejar ver mais usar mais opção de filtro!</div><br/>';
    }
    ?>
    <table width='100%' border='1' cellspacing='0' cellpadding='0' vspace='0' hspace='0' class='Generica'>
        <tr class="Generica">
            <td class="Titulo">Dt. Registro</td>
            <td class="Titulo">Login</td>
            <td class="Titulo">Nome do Usuário</td>
            <td class="Titulo">IP</td>
            <td class="Titulo">Formulário</td>
            <td class="Titulo">Ação</td>
            <td class="Titulo">Nº PK</td>
            <td class="Titulo">Descrição</td>
        </tr>
        <?php
        if ($rs->rows > 0) {
            //Paginação
            $p = $_REQUEST['p'];
            $pag_tot = $rs->rows;
            $reg_pagina = $vetConf['reg_pagina'];

            if ($pag_tot <= $reg_pagina)
                $pag_tot = 1;
            elseif (($pag_tot % $reg_pagina) == 0)
                $pag_tot = ($pag_tot / $reg_pagina);
            else
                $pag_tot = (int) ($pag_tot / $reg_pagina) + 1;

            $pag_tot--;

            if (!is_numeric($p) || $p <= 0)
                $p = 0;
            elseif ($p > $pag_tot)
                $p = $pag_tot;
            else
                $p--;

            $fim = (($p + 1) * $reg_pagina);
            if ($fim > $rs->rows)
                $fim = $rs->rows;

            $indMenu = -1;
            for ($i = ($p * $reg_pagina); $i < $fim; $i++) {
                $row = $rs->data[$i];
                echo '<tr class="Registro">';
                echo '<td class="Registro">';
                echo "<a class='Registro' href='#' onclick='return abre_popup_srv(" . $row['id_log_sistema'] . ")' title='Informação do Servidor'>" . trata_data($row['dtc_registro']) . "</a>";
                echo '</td>';
                echo '<td class="Registro">' . $row['login'] . '</td>';
                echo '<td class="Registro">' . $row['nom_usuario'] . '</td>';
                echo '<td class="Registro">' . $row['ip_usuario'] . '</td>';
                echo '<td class="Registro">' . $row['nom_tela'] . '</td>';
                echo '<td class="Registro">';

                switch ($row['sts_acao']) {
                    case 'A':
                    case 'I':
                    case 'E':
                        echo "<a class='Registro' href='conteudo.php?prefixo=det&log_sistema=" . $_POST['log_sistema'] . "&id=" . $row['id_log_sistema'] . getParametro($strpar . ',prefixo') . "' title='Ver quais dados foi alterado'>" . $vetLogAcao[$row['sts_acao']] . "</a>";
                        break;

                    case 'R':
                        if ($row['obj_extra'] == '') {
                            echo $vetLogAcao[$row['sts_acao']];
                        } else {
                            echo "<a class='Registro' href='#' onclick='return abre_popup(" . $row['id_log_sistema'] . ")'>" . $vetLogAcao[$row['sts_acao']] . "</a>";
                        }
                        break;

                    default:
                        echo $vetLogAcao[$row['sts_acao']];
                        break;
                }

                echo '</td>';

                echo '<td class="Registro">' . $row['des_pk'] . '</td>';
                echo '<td class="Registro" title="' . $vetLogSisDes[$row['nom_tabela']] . '">' . $row['des_registro'] . '</td>';
                echo '</tr>';
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
                      <td class='Titulo' colspan='9'>
                      <a href='#' onclick='pag(1)' class='Titulo'>&lt;&lt;</a>&nbsp;
                      <a href='#' onclick='pag(" . ($p - 1) . ")' class='Titulo'>&lt;</a>&nbsp;";

                for ($i = $ini; $i <= $fim; $i++) {
                    if ($i == $p)
                        echo "<span class='titulo' style='color: Red;'>$i&nbsp;</span>";
                    else
                        echo "<a href='#' onclick='pag($i)' class='Titulo'>$i</a>&nbsp;";
                }

                echo "<a href='#' onclick='pag(" . ($p + 1) . ")' class='Titulo'>&gt;</a>&nbsp;
                      <a href='#' onclick='pag($pag_tot)' class='Titulo'>&gt;&gt;</a>\n";

                if ($pag_tot > (2 * $vetConf['num_pagina'])) {
                    echo '&nbsp;&nbsp;&nbsp;';

                    $tam = strlen($pag_tot);
                    for ($i = 1; $i <= $pag_tot; $i++) {
                        $vetPag[$i] = str_repeat("0", $tam - strlen($i)) . $i;
                    }

                    criar_combo_vet($vetPag, 'goPag', $p, '', "onchange = 'funcPag(this)'", 'font-size : 11px; line-height : 11px;');

                    echo "
                        <script type='text/javascript'>
                            function funcPag(obj) {
                                pag(obj.value);
                            }
                        </script>
                    ";
                }

                echo "</td></tr>\n";
            }
        }
        ?>
    </table>
</form>