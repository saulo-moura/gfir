<?php
if ($debug || $_SESSION[CS]['g_vetConf'] == '') {
    $sql = 'select * from plu_config';
    $rs = execsql($sql);

    $vetConf = Array();
    $vetConfJS = Array();

    ForEach ($rs->data as $row) {
        if ($row['variavel'] == 'max_upload_size') {
            $row['valor'] *= 1024 * 1024;
        }

        $vetConf[$row['variavel']] = trim($row['valor'] . ($row['extra'] == '' ? '' : ' ' . $row['extra']));
        $vetConf[$row['variavel'] . '_valor'] = $row['valor'];
        $vetConf[$row['variavel'] . '_extra'] = $row['extra'];

        if ($row['js'] == 'S') {
            $vetConfJS[$row['variavel']] = trim($row['valor'] . ($row['extra'] == '' ? '' : ' ' . $row['extra']));
            $vetConfJS[$row['variavel'] . '_valor'] = $row['valor'];
            $vetConfJS[$row['variavel'] . '_extra'] = $row['extra'];
        }
    }

    $_SESSION[CS]['g_vetConf'] = $vetConf;
    $_SESSION[CS]['g_vetConfJS'] = $vetConfJS;
} else {
    $vetConf = $_SESSION[CS]['g_vetConf'];
    $vetConfJS = $_SESSION[CS]['g_vetConfJS'];
}

if ($debug || $_SESSION[CS]['g_vetFuncaoSistema'] == '') {
    $sql = "select cod_funcao, abrir_sistema from plu_funcao where abrir_sistema is not null and abrir_sistema <> 'atual'";
    $rs = execsql($sql);

    $vetFuncaoSistema = Array();

    ForEach ($rs->data as $row) {
        $vetFuncaoSistema[$row['cod_funcao']] = $vetSistemaUtiliza[$row['abrir_sistema']]['url'];
    }

    $_SESSION[CS]['g_vetFuncaoSistema'] = $vetFuncaoSistema;
} else {
    $vetFuncaoSistema = $_SESSION[CS]['g_vetFuncaoSistema'];
}

if ($debug || $_SESSION[CS]['g_vetMenu'] == '' || $_SESSION[CS]['g_vetMigalha'] == '') {
    $sql = 'select * from plu_funcao order by cod_classificacao';
    $rs = execsql($sql);

    $vetMenu = Array();
    $vetMenuNum = Array();
    $vetMigalha = Array();

    ForEach ($rs->data as $row) {
        $class = explode(' ', $row['cod_classificacao']);
        $class = $class[0];

        if (substr($class, 3) == '' and substr($class, 0, 2) == '33') {
            continue;
        }

        $vetMenu[$row['cod_funcao']] = $row['nm_funcao'];
        $vetMenuNum[$class] = $row['nm_funcao'];

        $vetCod = explode('.', $class);
        array_pop($vetCod);

        $c = '';
        ForEach ($vetCod as $cod) {
            if ($c != '')
                $c .= '.';
            $c .= $cod;

            if ($vetMigalha[$row['cod_funcao']] != '')
                $vetMigalha[$row['cod_funcao']] .= ' :: ';
            $vetMigalha[$row['cod_funcao']] .= $vetMenuNum[$c];
        }
    }

    $_SESSION[CS]['g_vetMenu'] = $vetMenu;
    $_SESSION[CS]['g_vetMigalha'] = $vetMigalha;
} else {
    $vetMenu = $_SESSION[CS]['g_vetMenu'];
    $vetMigalha = $_SESSION[CS]['g_vetMigalha'];
}

if ($debug || $_SESSION[CS]['g_vetDireito'] == '') {
    $sql = 'select * from plu_direito order by nm_direito';
    $rs = execsql($sql);

    $vetDireito = Array();
    ForEach ($rs->data as $row) {
        $vetDireito[mb_strtolower($row['cod_direito'])] = $row['nm_direito'];
    }

    $_SESSION[CS]['g_vetDireito'] = $vetDireito;
} else {
    $vetDireito = $_SESSION[CS]['g_vetDireito'];
}

if ($debug || $_SESSION[CS]['g_vetMime'] == '' || $_SESSION[CS]['g_vetMimeJS'] == '') {
    $sql = 'select gr.cod_grupo, ma.des_extensao, mt.des_tipo from
            plu_mime_grupo gr inner join plu_mime_grar mg on gr.idt_migr = mg.idt_migr
            inner join plu_mime_arquivo ma on mg.idt_miar = ma.idt_miar
            inner join plu_mime_tipo mt on ma.idt_miar = mt.idt_miar';
    $rs = execsql($sql);

    $vetMime = Array();
    ForEach ($rs->data as $row) {
        $vetMime[mb_strtolower($row['cod_grupo'])][mb_strtolower($row['des_extensao'])][] = mb_strtolower($row['des_tipo']);
    }

    $vetMimeJS = Array();
    ForEach ($vetMime as $idx => $row) {
        $vetMimeJS[$idx] = implode(",", array_keys($row));
    }

    $_SESSION[CS]['g_vetMime'] = $vetMime;
    $_SESSION[CS]['g_vetMimeJS'] = $vetMimeJS;
} else {
    $vetMime = $_SESSION[CS]['g_vetMime'];
    $vetMimeJS = $_SESSION[CS]['g_vetMimeJS'];
}
if ($g_MJs == "") {
    if ($debug || $_SESSION[CS]['g_strMenuJS'] == '') {
        if ($_SESSION[CS]['g_id_perfil'] != '') {
            $sql = "select * from plu_funcao ";
            if ($_SESSION[CS]['g_pri_vez_log'] == 1 and $_SESSION[CS]['g_tipo_usuario'] == 'A' and $_SESSION[CS]['g_idt_obra'] == '') {
                // $sql .= "  where substring(cod_classificacao,1,2)>='28' ";
            }
            // $sql .= "  where substring(cod_classificacao,1,2)='33' or substring(cod_classificacao,1,2)>'34'";
            $sql .= "  order by cod_classificacao";
            $rs = execsql($sql);

            $vetMenuJS = Array();

            ForEach ($rs->data as $row) {
                ForEach (explode(' ', $row['cod_classificacao']) as $idx => $Cod) {
                    $Codw = $Cod;
                    if (substr($Cod, 0, 2) == '33') {
                        $Codw = substr($Cod, 3);
                        if ($Codw == '') {
                            continue;
                        }
                    }

                    $vetCod = explode('.', $Codw);
                    func_vetMenuJS($vetMenuJS, $vetCod, $idx);
                }
            }
//        p($vetMenuJS);


            $strMenuJS = '<div id="qm0" class="qmmc">';

            $primeiro = true;
            ForEach ($vetMenuJS as $vet) {
                if (!$primeiro && $antMenuJS != $strMenuJS)
                    $strMenuJS .= '<span class="qmdivider qmdividery" ></span>';

                $antMenuJS = $strMenuJS;
                $primeiro = false;

                func_strMenuJS($vet);
//            p($strMenuJS);
            }

            $strMenuJS .= '<span class="qmclear"></span></div>';
        } else {
            $strMenuJS = '';
        }

        $_SESSION[CS]['g_strMenuJS'] = $strMenuJS;
    }

//    p($_SESSION[CS]['g_strMenuJS']);
}

function func_strMenuJS($vet) {
    global $strMenuJS, $vetConf;

    if (!acesso($vet['cod']))
        return;

    if (is_array($vet['sub'])) {
        $sub = current($vet['sub']);
        if ($sub['cod'] == '')
            $ok = false;
        else
            $ok = true;
    } else {
        $ok = true;
    }

    if (count($vet['sub']) > 0 && $ok) {
        $strMenuJS .= '<a href="javascript:void(0)">' . $vet['nome'] . '</a><div>';

        ForEach ($vet['sub'] as $sub) {
            func_strMenuJS($sub);
        }

        $strMenuJS .= '</div>';
    } else {
        if ($vet['cod'] == 'link_pbf')
            $strMenuJS .= '<a href="http://' . $vetConf['link_pbf'] . '" target="_blank">' . $vet['nome'] . '</a>';
        else
            $strMenuJS .= '<a href="conteudo.php?prefixo=' . $vet['prefixo'] . '&menu=' . $vet['cod'] . '&origem_tela=menu&class=' . $vet['class'] . '">' . $vet['nome'] . '</a>';

        if ($vet['linha'] == 'S')
            $strMenuJS .= '<span class="linha"></span>';
    }
}

function func_vetMenuJS(&$menu, $vet, $idx) {
    global $row;

    $pos = array_shift($vet);

    if (count($vet) > 0) {
        func_vetMenuJS($menu[$pos]['sub'], $vet, $idx);
    } else {
        if (($idx == 0 && $row['sts_menu'] == 'S') || $idx != 0) {
            $menu[$pos]['cod'] = $row['cod_funcao'];
            $menu[$pos]['nome'] = $row['nm_funcao'];
            $menu[$pos]['linha'] = $row['sts_linha'];
            $menu[$pos]['prefixo'] = $row['des_prefixo'];
            $menu[$pos]['class'] = $idx;
        }
    }
}
