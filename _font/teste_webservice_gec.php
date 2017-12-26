<?php
/*
  Endereço do WebService do sistema SGC, ambiente de homologação):

  http://www.homolog.sgc.sebrae.com.br/Administracao/webservices/wscontratacao.asmx?wsdl
  Login: lupe.sebrae
  Senha: Lupe2015!
 */

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

class PF_SAP extends SoapClient {

    public function __doRequest($request, $location, $action, $version) {
        $request = str_replace('xmlns:ns1="', 'xmlns:web="', $request);
        $result = parent::__doRequest($request, $location, $action, $version);
        return $result;
    }

    public function __construct() {
        $SOAP_AUTH = array(
            'trace' => true,
            'exceptions' => true,
            'soap_version' => SOAP_1_2,
        );

        $WSDL = "http://www.homolog.sgc.sebrae.com.br/Administracao/webservices/wscontratacao.asmx?wsdl";

        return parent::__construct($WSDL, $SOAP_AUTH);
    }

    public function executa($funcao, $Z, $parametros, $retorno_tratado = true) {
        $chave = base64_encode("lupe.sebrae|Lupe2015!|".date('YYYY-m-d H:i:s.u'));
        $request = '';

        $request .= '<web:'.$funcao.'>';
        $request .= "<web:key>{$chave}</web:key>";

        foreach ($parametros as $key => $value) {
            $request .= "<web:{$key}>{$value}</web:{$key}>";
        }

        $request .= '</web:'.$funcao.'>';

        $xmlvar = new SoapVar($request, XSD_ANYXML);
        $result = parent::__soapCall($funcao, Array($xmlvar));

        if ($retorno_tratado) {
            $data = Array();
            $class_retorno = $funcao.'Result';
            $obj = $result->$class_retorno->$Z;

            if (is_array($obj)) {
                foreach ($obj as $item) {
                    $data[] = array_map('utf8_decode', get_object_vars($item));
                }
            } else if (count($obj) > 0) {
                $data[] = array_map('utf8_decode', get_object_vars($obj));
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
    $PF_SAP = new PF_SAP();
    //
    echo " vou fazer<br /> ";



    $parametro = Array(
    );

    $info = $PF_SAP->executa('ConsultaAreaSGC', 'ZAREASGC', $parametro);
    p($info);
    echo 'Fim';
    $info = $PF_SAP->executa('ConsultaAreaSGC', 'ZAREASGC', $parametro, false);
    p($info);
} catch (SoapFault $fault) {
    echo "Request :<br>", htmlentities($PF_SAP->__getLastRequest()), "<br>";
    echo "Response :<br>", htmlentities($PF_SAP->__getLastResponse()), "<br>";
    echo "RequestHeaders :<br>", htmlentities($PF_SAP->__getLastRequestHeaders()), "<br><br>";
    echo "ResponseHeaders :<br>", htmlentities($PF_SAP->__getLastResponseHeaders()), "<br>";

    p($fault);
    p($PF_SAP);
}

unset($PF_SAP);
