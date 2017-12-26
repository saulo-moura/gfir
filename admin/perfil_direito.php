<?php
echo "
    <script type='text/javascript'>
    var c = 0;
    var l = 0;
    var col = new Array();
    var lin = new Array();
    var val = new Array();
                
    col[col.length] = '00';
    lin[lin.length] = '00';
    val[0] = 'N';
";

$vetDifu = Array();
$vetDipe = Array();

$sql = 'select id_funcao, id_direito, id_difu, descricao from plu_direito_funcao';
$trs = execsql($sql);

ForEach ($trs->data as $lin) {
    $vetDifu[$lin['id_funcao']][$lin['id_direito']] = $lin;
}

$sql = 'select id_difu from plu_direito_perfil where id_perfil = '.$_GET['id'];
$trs = execsql($sql);

ForEach ($trs->data as $lin) {
    $vetDipe[$lin['id_difu']] = 'ok';
}

$sql = 'select id_direito, nm_direito from plu_direito order by desc_funcao, nm_direito';
$rs_direito = execsql($sql);
$tot_direito = $rs_direito->rows;

ForEach ($rs_direito->data as $lin) {
    echo "col[col.length] = new Array('".$lin['id_direito']."','".$lin['nm_direito']."');\n";
}

$sql = 'select id_funcao, nm_funcao, cod_funcao, cod_classificacao from plu_funcao order by cod_classificacao';
$trs = execsql($sql);
$tot_funcao = $trs->rows;

ForEach ($trs->data as $func) {
    $nm_funcao = trata_aspa(alinha_nm_funcao($func['nm_funcao'], $func['cod_classificacao']));
	$nm_funcao .= ' - ' . $func['cod_funcao'];
    echo "lin[lin.length] = new Array('".$func['id_funcao']."','".$nm_funcao."');\n";

    echo "l++;\n";
    echo "c = 0;\n";
    echo "val[l] = new Array(col.length);\n";

    ForEach ($rs_direito->data as $dir) {
        echo 'c++;';
        $id_difu = $vetDifu[$func['id_funcao']][$dir['id_direito']]['id_difu'];
        $descricao = trata_aspa($vetDifu[$func['id_funcao']][$dir['id_direito']]['descricao']);

        if ($id_difu != '') {
            if ($vetDipe[$id_difu])
                $t = "S";
            else
                $t = "N";

            echo "val[l][c] = new Array('$id_difu','$t','$descricao');\n";
        } else
            echo "val[l][c] = new Array('','','');\n";
    }
}

echo '</script>';

$max_c = 9;
$max_l = 10;

$max_l = 100;

if ($tot_direito < $max_c)
    $max_c = $tot_direito;

$max_pc = $tot_direito / $max_c;

if ($max_pc < 1) {
    $max_pc = 1;
} else {
    if (($tot_direito % $max_c) != 0)
        $max_pc = ((int)$max_pc) + 1;
}

if ($tot_funcao < $max_l)
    $max_l = $tot_funcao;

$max_pl = $tot_funcao / $max_l;
if ($max_pl < 1) {
    $max_pl = 1;
} else {
    if (($tot_funcao % $max_l) != 0)
        $max_pl = ((int)$max_pl) + 1;
}
?>
<input type="hidden" name="id_difu">
<div align="center" class="Tit_Campo_Obr" style="width: 100%;">
    <br>Direitos do Perfil<br>
    <img id='id_esquerda' style='cursor: pointer; visibility: hidden;' src='imagens/esquerda.gif' onclick='esquerda()'>&nbsp;&nbsp;&nbsp;&nbsp;
    <img id='id_sobe' style='cursor: pointer; visibility: hidden;' src='imagens/sobe.gif' onclick='sobe()'>&nbsp;&nbsp;&nbsp;&nbsp;
    <img id='id_desce' style='cursor: pointer; visibility: <?php echo ($max_pl > 1 ? 'visible' : 'hidden') ?>;' src='imagens/desce.gif' onclick='desce()'>&nbsp;&nbsp;&nbsp;&nbsp;
    <img id='id_direita' style='cursor: pointer; visibility: <?php echo ($max_pc > 1 ? 'visible' : 'hidden') ?>;' src='imagens/direita.gif' onclick='direita()'>
</div>
<div id='matriz'></div>
<script type="text/javascript">
    var pl = 1;
    var pc = 1;
    var max_pc = <?php echo $max_pc ?>;
    var max_pl = <?php echo $max_pl ?>;

    function direita() {
        if ((pc + 1) <= max_pc) {
            pc++;
            matriz();

            if (pc > 1)
                document.getElementById('id_esquerda').style.visibility = 'visible';

            if (pc == max_pc)
                document.getElementById('id_direita').style.visibility = 'hidden';
        }
    }

    function esquerda() {
        if ((pc - 1) >= 1) {
            pc--;
            matriz();

            if (pc >= 1)
                document.getElementById('id_direita').style.visibility = 'visible';

            if (pc == 1)
                document.getElementById('id_esquerda').style.visibility = 'hidden';
        }
    }

    function desce() {
        if ((pl + 1) <= max_pl) {
            pl++;
            matriz();

            if (pl > 1)
                document.getElementById('id_sobe').style.visibility = 'visible';

            if (pl == max_pl)
                document.getElementById('id_desce').style.visibility = 'hidden';
        }
    }

    function sobe() {
        if ((pl - 1) >= 1) {
            pl--;
            matriz();

            if (pl >= 1)
                document.getElementById('id_desce').style.visibility = 'visible';

            if (pl == 1)
                document.getElementById('id_sobe').style.visibility = 'hidden';
        }
    }

    function matriz() {
        var html = '';
        var td = '';
        var c = 0;
        var l = 0;
        var max_c = <?php echo $max_c ?>;
        var max_l = <?php echo $max_l ?>;

        var fim_c = max_c * pc;
        var fim_l = max_l * pl;

        if (fim_c > col.length - 1)
            fim_c = col.length - 1;

        if (fim_l > lin.length - 1)
            fim_l = lin.length - 1;

        var ini_c = fim_c - max_c + 1;
        var ini_l = fim_l - max_l + 1;

        td += " <table class='Perfil'><tr><td class='Perfil_Titulo'>";
        td += " <input type='checkbox' name='marca'";

        if (val[0] == 'S')
            td += " checked ";

        td += " value='' onclick='Marca(marca)'>&nbsp;Todos os Direitos";
        td += " </td>";

        for (c = ini_c; c <= fim_c; c++) {
            td += " <td class='Perfil_Titulo' align='center'>" + col[c][1] + "</td>";
        }

        td += " </tr>";

        for (l = ini_l; l <= fim_l; l++) {
            td += " <tr><td class='Perfil_Titulo'>" + lin[l][1] + "</td>";

            for (c = ini_c; c <= fim_c; c++) {
                td += " <td class='Perfil_Registro' align='center'>";
                html = "";

                if (val[l][c][0] != '') {
                    html += " <input type='checkbox'";

                    if (val[l][c][1] == 'S')
                        html += " checked";

                    html += " value='" + val[l][c][0] + "' onclick='chk(this, " + l + ", " + c + ")'>";

                    if (val[l][c][2] != '') {
                        html += '<img src="imagens/about.gif" title="' + val[l][c][2] + '">';
                    }

                    td += html;
                }

                td += " </td>";
            }

            td += " </tr>";
        }

        td += " </table>";

        document.getElementById('matriz').innerHTML = td;

        if (acao == 'con' || acao == 'exc') {
            $("input:visible:not([name=\'btnAcao\']), select:visible, textarea:visible").attr("disabled", "true");
            $(':disabled').addClass('campo_disabled');
        }
    }

    function Marca(obj) {
        var Frm = document.frm;

        for (i = 0; i < Frm.elements.length; i++) {
            if ("checkbox".indexOf(Frm.elements[i].type) != -1) {
                Frm.elements[i].checked = obj.checked;
            }
        }

        if (obj.checked)
            val[0] = 'S';
        else
            val[0] = 'N';

        for (l = 1; l <= lin.length - 1; l++) {
            for (c = 1; c <= col.length - 1; c++) {
                if (val[l][c][0] != '')
                    val[l][c][1] = val[0];
            }
        }
    }

    function chk(obj, l, c) {
        if (obj.checked)
            val[l][c][1] = 'S';
        else
            val[l][c][1] = 'N';
    }

    matriz();
</script>