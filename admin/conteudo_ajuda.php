<?php
Require_Once('configuracao.php');

$nome_site = 'Ajuda :: '.$nome_site;
$_SESSION[CS]['g_nom_tela'] = 'Ajuda';
$cont_arq = '_ajuda';

if ($_REQUEST['alt'] == '') {
    if ($_GET['id'] != '') {
        $sql = 'select * from plu_ajuda where idt = '.$_GET['id'];
        $rs = execsql($sql);
        $row = $rs->data[0];
        $des = $row['descricao'];
    } else {
        $menu = $_REQUEST['menu'];
        $acao = mb_strtolower($_REQUEST['acao']);

        switch ($menu) {
        	case 'sistema':
                $des = $nome_site;
                break;

            case 'versao':
                $des = 'Versão do Sistema '.$acao;
                break;

            default:
                $des = $vetMigalha[$menu].' :: '.$vetMenu[$menu].($vetDireito[$acao] == '' ? '' : ' :: '.$vetDireito[$acao]);
                break;
        }

        $sql = 'select * from plu_ajuda where codigo = '.aspa($menu.$acao);
        $rs = execsql($sql);
        $row = $rs->data[0];

        if ($rs->rows == 0) {
            $sql_inc = 'insert into plu_ajuda(codigo, descricao) values ('.aspa($menu.$acao).', '.aspa($des).')';
            execsql($sql_inc);

            $rs = execsql($sql);
            $row = $rs->data[0];
        } else if ($row['descricao'] != $des) {
            $sql_inc = 'update plu_ajuda set descricao = '.aspa($des).' where idt = '.$row['idt'];
            execsql($sql_inc);
        }
    }
} else {
    acesso('plu_ajuda', "'ALT'", true, 'top.close();');

    $sql = 'select * from plu_ajuda where idt = '.$_GET['id'];
    $rs = execsql($sql);
    $row = $rs->data[0];
    $des = $row['descricao'];
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php Require_Once('head.php'); ?>
<script type="text/javascript">
$(document).ready(function () {
    if ($('div#geral_ajuda').height() < $(window).height()) {
        var height = $(window).height() - $('div#geral_ajuda').height();
        height += $('div#conteudo_ajuda').height();
        $('div#conteudo_ajuda').height(height);
    }
});
</script>
</head>
<body id="body">
<center>
<div id="geral_ajuda">
    <div id="topo_ajuda">
        <table width="760" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td height="23" colspan="3"></td>
            </tr>
            <tr>
                <td width="32" height="21"></td>
                <td width="438" class="barra"><?php echo $des ?></td>
                <td width="24">
                    <?php
                    if (acesso('plu_ajuda', "'ALT'") && $_GET['alt'] == '') {
                        echo "<a href='conteudo_ajuda.php?alt=s&id=".$row['idt']."'>";
                        echo "<img src='imagens/alterar.gif' alt='Alterar Registro' border='0' />";
                        echo "</a>";
                    }
                    ?>
                </td>
                <td width="266"></td>
            </tr>
            <tr>
                <td height="8" colspan="3"></td>
            </tr>
        </table>
    </div>
    <div id="meio_ajuda">
        <div id="conteudo_ajuda">
            <?php
            if ($_REQUEST['alt'] == '') {
                echo $row['texto'];
            } else {
                $menu = 'plu_ajuda';
                Require_Once('cadastro.php');
            }
            ?>
        </div>
    </div>
    <div id="rodape_ajuda">&nbsp;</div>
</div>
</center>
</body>
</html>
