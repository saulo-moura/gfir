<?php
/*
VPN
User: lupe.luispereira
Senha: lUp&2015!P!R
*/

//$chave = base64_encode("wsecm.rm|wsecm2013|".date('YYYY-m-d H:i:s.u'));
//echo $chave;
//exit();

ini_set('display_errors', 'On');

class dbx {

    var $info = Array('name' => Array(), 'type' => Array());
    var $data = Array();
    var $cols = -1;
    var $rows = -1;

}

function p($valor) {
    echo '<pre>';
    print_r($valor);
    echo '</pre>';
}

class SoapSebraeRM extends SoapClient {

    var $chave;

    public function __doRequest($request, $location, $action, $version) {
        $request = str_replace('xmlns:ns1="', 'xmlns:tem="', $request);
        $result = parent::__doRequest($request, $location, $action, $version);
        return $result;
    }

    public function __construct() {
        $this->chave = base64_encode("wsecm.rm|wsecm2013|".date('YYYY-m-d H:i:s.u'));

        $SOAP_AUTH = array(
            'trace' => true,
            'exceptions' => true,
            'soap_version' => SOAP_1_2,
        );

        $WSDL = "http://basrvrmh01:81/BusinessConnect/wsEcm.asmx?wsdl";

        return parent::__construct($WSDL, $SOAP_AUTH);
    }

    public function executaParams($funcao, $parametros, $retorno_tratado = true) {
        $request = '';

        $request .= '<tem:'.$funcao.'>';
        $request .= "<tem:CodColigada>1</tem:CodColigada>";
        $request .= "<tem:Schema>false</tem:Schema>";
        $request .= "<tem:key>{$this->chave}</tem:key>";
        $request .= '<tem:Params>';
        $request .= '<![CDATA[<PARAMS>';
        $request .= '<CODCOLIGADA>1</CODCOLIGADA>';

        foreach ($parametros as $key => $value) {
            $request .= "<{$key}>{$value}</{$key}>";
        }

        $request .= '</PARAMS>]]>';
        $request .= '</tem:Params>';
        $request .= '</tem:'.$funcao.'>';

        $xmlvar = new SoapVar($request, XSD_ANYXML);
        $result = parent::__soapCall($funcao, Array($xmlvar));

        if ($retorno_tratado) {
            $data = Array();
            $class_retorno = $funcao.'Result';
            $obj = simplexml_load_string($result->$class_retorno);

            ForEach ($obj->Row as $row) {
                $vetRow = Array();

                ForEach ($row as $campo => $valor) {
                    $vetRow[mb_strtolower($campo)] = utf8_decode($valor);
                }

                $data[] = $vetRow;
            }

            $dbx = new dbx;
            $dbx->data = $data;
            $dbx->cols = count($data[0]);
            $dbx->rows = count($data);

            return $dbx;
        } else {
            return $result;
        }
    }

    public function executa($funcao, $Z, $parametros, $retorno_tratado = true) {
        $request = '';

        $request .= '<tem:'.$funcao.'>';
        $request .= "<tem:CodColigada>1</tem:CodColigada>";
        $request .= "<tem:Schema>false</tem:Schema>";
        $request .= "<tem:key>{$this->chave}</tem:key>";

        foreach ($parametros as $key => $value) {
            $request .= "<tem:{$key}>{$value}</tem:{$key}>";
        }

        $request .= '</tem:'.$funcao.'>';

        $xmlvar = new SoapVar($request, XSD_ANYXML);
        $result = parent::__soapCall($funcao, Array($xmlvar));

        if ($retorno_tratado) {
            $data = Array();
            $class_retorno = $funcao.'Result';
            $obj = $xml = simplexml_load_string($result->$class_retorno);

            ForEach ($obj->$Z as $row) {
                $vetRow = Array();

                ForEach ($row as $campo => $valor) {
                    $vetRow[mb_strtolower($campo)] = utf8_decode($valor);
                }

                $data[] = $vetRow;
            }

            $dbx = new dbx;
            $dbx->data = $data;
            $dbx->cols = count($data[0]);
            $dbx->rows = count($data);

            return $dbx;
        } else {
            return $result;
        }
    }

}

try {
    $SoapSebraeRM = new SoapSebraeRM();

    $parametro = Array(
        'CODPROJETO' => '01001',
    );
    $info = $SoapSebraeRM->executaParams('ConsultaAcao', $parametro, true);
    p($info);

    $parametro = Array(
        'ResultFields' => 'NOME;NOMEFANTASIA',
        'Filter' => "NOMEFANTASIA like 'filial 1%'",
    );
    $info = $SoapSebraeRM->executa('ConsultaFilial', 'GFilial', $parametro, true);
    p($info);

    echo 'Fim';
} catch (SoapFault $fault) {
    p($fault);
    p($SoapSebraeRM);

    echo "Request :<br>", htmlentities($SoapSebraeRM->__getLastRequest()), "<br>";
    echo "Response :<br>", htmlentities($SoapSebraeRM->__getLastResponse()), "<br>";
    echo "RequestHeaders :<br>", htmlentities($SoapSebraeRM->__getLastRequestHeaders()), "<br><br>";
    echo "ResponseHeaders :<br>", htmlentities($SoapSebraeRM->__getLastResponseHeaders()), "<br>";
}

unset($SoapSebraeRM);
