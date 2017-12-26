<style>


    div#credenciamento {
        background:#FFFFFF;
        color:#000000;
        font-size: 20px;
        font-weight: bold;
        width:100%;
    }

    tr.instrucoes_insc {
        xdisplay: block;
        font-size: 12px;
        background:#14ADCC;
        color:#FFFFFF;
    }

    table.itemsepara {
        border-bottom:1px solid #FFFFFF;
    }


    table.cabpasso {
        border-bottom:1px solid #FFFFFF;
    }
    tr.cab_insc {
        font-size: 18px;
        background:#2F66B8;
        color:#FFFFFF;
    }





    div.Login {
        padding-left : 50px;
        padding-top  : 10px;

    }

    div.Senha {
        padding-left : 50px;
        padding-top  : 30px;

    }

    .Login_candidato {
        xpadding-left : 50px;
        xpadding-top  : 10px;

    }

    .Senha_candidato {
        xpadding-left : 50px;
        xpadding-top  : 30px;

    }

    .BtSenha_candidato {
        cursor: pointer;
        width: 155px;
        height: 25px;
        border:1px solid red;
    }
    .BtEnter_candidato {
        cursor: pointer;
        width: 70px;
        height: 25px;
        border:1px solid red;
    }


    .BtIdentificacao_candidato {
        cursor: pointer;
        width: 155px;
        height: 25px;
        border:1px solid red;

    }

    table.LoginCandidato input {
        height: 25px;
    }


</style>



<?php
echo "<div id='credenciamento' >";
////////////////////// mostrar editais abertos
$vetEdital = Array();
$vetEdital = CarregaEditaisAbertos();

$candidato_ativo = $_SESSION[CS]['g_nome_candidato'];


echo "<table class='cabpasso' width='100%' border='0' cellspacing='1' cellpadding='5' vspace='0' hspace='0'> ";
echo "<tr class='cab_insc' style=''>  ";
echo "   <td style='text-align:center; font-size:18px; border-bottom:1px solid #FFFFFF;'>";
echo " {$candidato_ativo}<br />PASSO 4 - CADASTRO DO CANDIDATO";
echo "</td>";
echo "</tr>";
echo "</table>";
echo "<br />";
if ($_SESSION[CS]['g_idt_etapa'] != "") {
    $idt_etapa_escolhido = $_SESSION[CS]['g_idt_etapa'];
} else {
    $idt_etapa_escolhido = 0;
}
if ($_SESSION[CS]['g_ca_id_usuario'] > 0) {
    $idt_candidato = $_SESSION[CS]['g_ca_id_usuario'];
} else {
    $idt_candidato = $_SESSION[CS]['g_ca_id_usuario'];
}
if ($idt_etapa_escolhido == 0 or $idt_candidato == 0) {
    echo "Erro";
    exit();
}

//p($_SESSION[CS]);
//p($_SESSION[CS]['g_cnpjcpf']);
if ($_SESSION[CS]['g_cnpjcpf'] == 'CPF' or $_SESSION[CS]['g_cnpjcpf'] == 'CNPJ') {
    if ($_SESSION[CS]['g_cnpjcpf'] == 'CNPJ') {
        $veio = 'O';
    } else {
        $veio = 'P';
    }
} else {
    echo "Erro Tipo Pessoa";
    exit();
}

$acao = "inc";
$_GET['acao'] = "inc";
$_GET['id'] = 0;
$veioinscricao = "I";
//echo " tetse $veio ";

if ($veio == 'O') {
    $menu = 'gec_organizacao';
    $prefixo = 'cadastro';
} else {
    $menu = 'gec_pessoa';
    $prefixo = 'cadastro';
}
//
// Criar relacionamento com o edital
//
$sql = "select * from plu_usuario where login = ".aspa($_SESSION[CS]['g_identificacao']);
$result = execsql($sql);
$row = $result->data[0];



if ($result->rows == 0) {
    // erro
    echo "Candidato não esta Autenticado e não pode entrar em Cadastro.";
} else {
    $idt_usuario = $row['id_usuario'];
    //
    $sql = "select * from gec_edital_processo_etapa_candidato ";
    $sql .= " where idt_etapa     = ".null($idt_etapa_escolhido);
    $sql .= "   and idt_candidato = ".null($idt_usuario);
    $result = execsql($sql);
    $row = $result->data[0];
    // p($sql);

    if ($result->rows == 0) {
        $idt_etapa = $_SESSION[CS]['g_idt_etapa'];
        $idt_candidato = $idt_usuario;
        $tipo = 'C';
        $sql_i = ' insert into gec_edital_processo_etapa_candidato ';
        $sql_i .= ' (idt_etapa, idt_candidato, tipo) values ( ';
        $sql_i .= null($idt_etapa).' , ';
        $sql_i .= null($idt_candidato).' ,  ';
        $sql_i .= aspa($tipo).'  ';
        $sql_i .= ') ';
        $result = execsql($sql_i);
        $idt_etapa_candidato = lastInsertId();
        //
        $sql = "select * from gec_entidade ";
        $sql .= " where codigo  = ".aspa($_SESSION[CS]['g_identificacao']);
        $sql .= " and reg_situacao = 'A'";
        $result = execsql($sql);
        $row = $result->data[0];
        //   p($sql);
        if ($result->rows != 0) {
            //
            // Entidade já possui cadastro
            //
            $acao = "alt";
            $_GET['acao'] = "alt";
            $_GET['id'] = $row['idt'];
            $_GET['idt0'] = $row['idt'];
            //
            // Entidade já possui cadastro
            //
            $sql_a = ' update gec_edital_processo_etapa_candidato set ';
            $sql_a .= ' idt_entidade   = '.null($_GET['idt0']);
            $sql_a .= ' where idt = '.null($idt_etapa_candidato);
            $result = execsql($sql_a);
            //
        }
    } else {
        //    p($sql);

        $idt_etapa_candidato = $row['idt'];
        $idt_entidade = $row['idt_entidade'];
        if ($idt_entidade != "") {
            $acao = "alt";
            $_GET['acao'] = "alt";
            $_GET['id'] = $idt_entidade;
            $_GET['idt0'] = $idt_entidade;
        } else {
            $sql = "select * from gec_entidade ";
            $sql .= " where codigo  = ".aspa($_SESSION[CS]['g_identificacao']);
            $sql .= " and reg_situacao = 'A'";
            $result = execsql($sql);
            $row = $result->data[0];
            //     p($sql);
            if ($result->rows != 0) {
                $acao = "alt";
                $_GET['acao'] = "alt";
                $_GET['id'] = $row['idt'];
                $_GET['idt0'] = $row['idt'];
                //
                // Entidade já possui cadastro
                //
                $sql_a = ' update gec_edital_processo_etapa_candidato set ';
                $sql_a .= ' idt_entidade   = '.null($_GET['idt0']);
                $sql_a .= ' where idt = '.null($idt_etapa_candidato);
                $result = execsql($sql_a);
            }
        }
    }
    //
    if (file_exists('cadastro.php')) {
        Require_Once('cadastro.php');
    }
}

