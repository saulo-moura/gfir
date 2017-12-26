<?php

class dbx {

    var $info = Array('name' => Array(), 'type' => Array());
    var $data = Array();
    var $cols = -1;
    var $rows = -1;

}

function new_pdo_acao($host, $bd_user, $password, $tipodb) {
    set_time_limit(120);

    $con = new PDO($host, $bd_user, $password);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $con->setAttribute(PDO::ATTR_CASE, PDO::CASE_LOWER);

    if ($tipodb == 'sqlsrv') {
        $con->setAttribute(PDO::SQLSRV_ATTR_ENCODING, PDO::SQLSRV_ENCODING_SYSTEM);
    }

    if ($tipodb == 'mysql') {
        $con->exec("SET NAMES 'latin1';");
        $con->exec("SET CHARACTER SET latin1;");
        $con->exec("SET innodb_lock_wait_timeout = 100;");
        $con->exec("SET SESSION group_concat_max_len = 4294967295;");
    }

    return $con;
}

/**
 * Cria objeto PDO
 * @access public
 * @return pdo
 * */
function new_pdo($host, $bd_user, $password, $tipodb, $try_erro = true) {
    if ($try_erro) {
        try {
            return new_pdo_acao($host, $bd_user, $password, $tipodb);
        } catch (PDOException $e) {
            die('Conexão '.$e->getMessage());
        }
    } else {
        return new_pdo_acao($host, $bd_user, $password, $tipodb);
    }
}

class clsTexto {

    /**
     * Retorna o valor de um número por extenso
     * @access public
     * @return string
     * @param int $valor <p>
     * Valor a ser convertido em extenso
     * </p>
     * @param boolena $bolExibirMoeda [opcional] <p>
     * Define se a função vai adicionar uma referência à moeda (centavos, real, etc)
     * </p>
     * @param boolena $bolPalavraFeminina [opcional] <p>
     * Define se a função vai retornar duzentos ou duzentas, por exemplo.
     * </p>
     * */
    public static function valorPorExtenso($valor = 0, $bolExibirMoeda = true, $bolPalavraFeminina = false) {

        $valor = self::removerFormatacaoNumero($valor);

        $singular = null;
        $plural = null;

        if ($bolExibirMoeda) {
            $singular = array("centavo", "real", "mil", "milhão", "bilhão", "trilhão", "quatrilhão");
            $plural = array("centavos", "reais", "mil", "milhões", "bilhões", "trilhões", "quatrilhões");
        } else {
            $singular = array("", "", "mil", "milhão", "bilhão", "trilhão", "quatrilhão");
            $plural = array("", "", "mil", "milhões", "bilhões", "trilhões", "quatrilhões");
        }

        $c = array("", "cem", "duzentos", "trezentos", "quatrocentos", "quinhentos", "seiscentos", "setecentos", "oitocentos", "novecentos");
        $d = array("", "dez", "vinte", "trinta", "quarenta", "cinquenta", "sessenta", "setenta", "oitenta", "noventa");
        $d10 = array("dez", "onze", "doze", "treze", "quatorze", "quinze", "dezesseis", "dezesete", "dezoito", "dezenove");
        $u = array("", "um", "dois", "três", "quatro", "cinco", "seis", "sete", "oito", "nove");


        if ($bolPalavraFeminina) {

            if ($valor == 1) {
                $u = array("", "uma", "duas", "três", "quatro", "cinco", "seis", "sete", "oito", "nove");
            } else {
                $u = array("", "um", "duas", "três", "quatro", "cinco", "seis", "sete", "oito", "nove");
            }


            $c = array("", "cem", "duzentas", "trezentas", "quatrocentas", "quinhentas", "seiscentas", "setecentas", "oitocentas", "novecentas");
        }


        $z = 0;

        $valor = number_format($valor, 2, ".", ".");
        $inteiro = explode(".", $valor);

        for ($i = 0; $i < count($inteiro); $i++) {
            for ($ii = mb_strlen($inteiro[$i]); $ii < 3; $ii++) {
                $inteiro[$i] = "0".$inteiro[$i];
            }
        }

        // $fim identifica onde que deve se dar junção de centenas por "e" ou por "," ;)
        $rt = null;
        $fim = count($inteiro) - ($inteiro[count($inteiro) - 1] > 0 ? 1 : 2);
        for ($i = 0; $i < count($inteiro); $i++) {
            $valor = $inteiro[$i];
            $rc = (($valor > 100) && ($valor < 200)) ? "cento" : $c[$valor[0]];
            $rd = ($valor[1] < 2) ? "" : $d[$valor[1]];
            $ru = ($valor > 0) ? (($valor[1] == 1) ? $d10[$valor[2]] : $u[$valor[2]]) : "";

            $r = $rc.(($rc && ($rd || $ru)) ? " e " : "").$rd.(($rd && $ru) ? " e " : "").$ru;
            $t = count($inteiro) - 1 - $i;
            $r .= $r ? " ".($valor > 1 ? $plural[$t] : $singular[$t]) : "";
            if ($valor == "000")
                $z++;
            elseif ($z > 0)
                $z--;

            if (($t == 1) && ($z > 0) && ($inteiro[0] > 0))
                $r .= ( ($z > 1) ? " de " : "").$plural[$t];

            if ($r)
                $rt = $rt.((($i > 0) && ($i <= $fim) && ($inteiro[0] > 0) && ($z < 1)) ? ( ($i < $fim) ? ", " : " e ") : " ").$r;
        }

        $rt = mb_substr($rt, 1);

        return($rt ? trim($rt) : "zero");
    }

    /**
     * remove formatação de número, fazendo com que ?R$ 1.487.257,55? se transforme numa string com o formato de um float, ou seja, ?1487257.55?.
     * @access public
     * @return float
     * @param string $strNumero <p>
     * String de numero para ser convertido em numero
     * </p>
     * */
    public static function removerFormatacaoNumero($strNumero) {

        $strNumero = trim(str_replace("R$", null, $strNumero));

        $vetVirgula = explode(",", $strNumero);
        if (count($vetVirgula) == 1) {
            $acentos = array(".");
            $resultado = str_replace($acentos, "", $strNumero);
            return $resultado;
        } else if (count($vetVirgula) != 2) {
            return $strNumero;
        }

        $strNumero = $vetVirgula[0];
        $strDecimal = mb_substr($vetVirgula[1], 0, 2);

        $acentos = array(".");
        $resultado = str_replace($acentos, "", $strNumero);
        $resultado = $resultado.".".$strDecimal;

        return $resultado;
    }

}

if (file_exists('funcao_sgc.php')) {
    Require_Once('funcao_sgc.php');
}
