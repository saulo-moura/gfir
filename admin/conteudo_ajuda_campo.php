<?php
Require_Once('configuracao.php');

$nome_site = 'Ajuda Campo:: '.$nome_site;
$_SESSION[CS]['g_nom_tela'] = 'Ajuda Campo';
$cont_arq = '_ajuda_campo';

if ($_REQUEST['alt'] == '') {
    if ($_GET['id'] != '') {
        $sql = 'select * from plu_help_campo where idt = '.$_GET['id'];
        $rs = execsql($sql);
        $row = $rs->data[0];
        $des = $row['descricao'];
    } else {
        $tabela = $_REQUEST['tabela'];
        $campo = mb_strtolower($_REQUEST['campo']);
        /*
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
        */
        $des = $tabela.' :: '.$campo;
        $des = $_GET['descricao'];
        $sql = 'select * from plu_help_campo where tabela = '.aspa($tabela). '  and campo = '.aspa($campo);
        $rs = execsql($sql);
        $row = $rs->data[0];

        if ($rs->rows == 0) {
//            $sql_inc = 'insert into help_campo(codigo, descricao) values ('.aspa($menu.$acao).', '.aspa($des).')';
//            execsql($sql_inc);
//            $rs = execsql($sql);
//            $row = $rs->data[0];
        } else if ($row['resumo'] != $des) {
          //  $sql_inc = 'update ajuda_campo set descricao = '.aspa($des).' where idt = '.$row['idt'];
          //  execsql($sql_inc);
        }
    }
} else {
    acesso('plu_ajuda_campo', "'ALT'", true, 'top.close();');

    $sql  = 'select * from plu_help_campo ';
    $sql .= '   where ';
    $sql .= '       tabela = '.aspa($_GET['tabela']);
    $sql .= '   and campo  = '.aspa($_GET['campo']);
    $rs = execsql($sql);
    $row = $rs->data[0];
    $resumo     = $row['resumo'];
    $texto      = $row['texto'];
    $des        = $row['descricao'];
    $_GET['id']=$row['idt'];
    if ($rs->rows<=0)
    {
        $des = ' erro acesso registro akuda campo ';
    }

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

                    $tabela = $_GET['tabela'];
                    $campo  = $_GET['campo'];

                    if (acesso('plu_ajuda_campo', "'ALT'") && $_GET['alt'] == '') {
                        echo "<a href='conteudo_ajuda_campo.php?alt=s&id=".$_GET['id']."&tabela=".$tabela."&campo=".$campo."'>";
                        echo "<img src='imagens/alterar.gif' title='Alterar conteúdo do Help de Campo' alt='Alterar conteúdo do Help de Campo' border='0' />";
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
                echo '<div style="background:#C0C0C0; color:#FFFFFF; width:100%; display:block;" >'.$row['descricao'].'</div>';
                echo '<div style="background:#900000; color:#FFFFFF; width:100%; display:block;" >'.$row['resumo'].'</div>';
                echo '<div >'.$row['texto'].'</div>';
                /*
                echo $row['descricao'];
                echo $row['resumo'];
                echo $row['texto'];
                */


            } else {
                $menu = 'plu_ajuda_campo';
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
