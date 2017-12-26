<?php
Require_Once('configuracao.php');

if ($_REQUEST['menu'] == '') {
    $menu = 'vazio';
} else {
    $menu = $_REQUEST['menu'];
}

if ($_REQUEST['prefixo'] == '') {
    $prefixo = 'inc';
} else {
    $prefixo = $_REQUEST['prefixo'];
}

if ($_REQUEST['titulo_rel'] == '') {
    $nome_titulo = '';
} else {
    $nome_titulo = $_REQUEST['titulo_rel'];
}

$acao        = 'con';
$print_tela  = $_REQUEST['print_tela'];
$cont_arq    = '_pdf';
$css_sistema = true;

$html = '';
$html .= '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">';
$html .= '<html xmlns="http://www.w3.org/1999/xhtml">';
$html .= '<head>';
$html .= '<meta http-equiv="Content-Type" content="text/html; charset=win-1252" />';
$html .= '</head>';
$html .= '<body>';


/*
if ($prefixo == 'listar' || $prefixo == 'listar_rel') {
    $Require_Once = "listar.php";
} else if ($prefixo == 'cadastro') {
    $path = 'cadastro_export'.DIRECTORY_SEPARATOR.$menu.'.php';

    if (file_exists($path)) {
        $Require_Once = $path;
        $css_sistema = false;
    } else {
        $Require_Once = "cadastro.php";
    }
} else {
    $Require_Once = "$prefixo$menu.php";
}
*/



//$Require_Once="cadastro_conf/grc_nan_plano_facil.php";

$Devolutiva = "cadastro_conf/grc_nan_devolutiva_rel_inc.php";

$PlanoFacil = "cadastro_conf/grc_nan_plano_facil.php";
	
	
   
	
	
	
define('_MPDF_PATH', lib_mpdf);
include(lib_mpdf.'mpdf.php');

//$mpdf=new mPDF('iso-8859-1','A4','','',ME,MD,MS,MB,MHEADER,MFOOTER);

//$ME = 5;
//$MD = 5;
//$MS = 27;
//$MB = 7;
//$MHEADER = 3;
//$MFOOTER = 5;

$ME = 5;
$MD = 5;
$MS = 5;
$MB = 0;
$MHEADER = 0;
$MFOOTER = 0;

$mpdf = new mPDF('win-1252', 'A4-L', '10', '', $ME, $MD, $MS, $MB, $MHEADER, $MFOOTER, 'L');
//$mpdf = new mPDF('win-1252', 'A4', '10', '', $ME, $MD, $MS, $MB, $MHEADER, $MFOOTER, 'P');
//$mpdf = new mPDF('win-1252', 'A4-L', '10', '', 1, 1, 23, 5, 1, 1, 'L');

$header = '';
$header .= '<table border="0" cellpadding="0" width="100%" cellspacing="0">';
$header .= '<tr>';
$header .= '<td align="left" width="236" style="padding:5px; border-bottom: 1px solid #ecf0f1;">';
$header .= '<img style="padding:5px;" src="imagens/logo_sebrae.png" alt="" border="0" />';
$header .= '</td>';
$header .= '<td align="center" style="font-size: 24px;  padding:5px; border-bottom: 1px solid #ecf0f1;" colspan="2">';
$header .= $nome_titulo;
$header .= '</td>';
$header .= '<td align="right" width="200" style="font-size: 10px; padding-right:20px; border-bottom: 1px solid #ecf0f1;">';
$header .= 'Emitido em:&nbsp;';
$header .= '<br />'.date('d/m/Y').' '.(date('H') - date('I')).':'.date('i');
$header .= '<br />';
$header .= $_SESSION[CS]['g_nome_completo'];
$header .= '<br />Pagina: {PAGENO} / {nbpg}';
$header .= '</td>';
$header .= '</tr>';
$header .= '</table>';

$header = utf8_encode($header);


//$mpdf->SetHTMLHeader($header);
//$mpdf->SetHTMLHeader($header, 'E');

$footer = '';
$footer .= '<table border="0" cellpadding="0" width="100%" cellspacing="0">';
$footer .= '<tr>';
$footer .= '<td style="border-bottom: 1px solid #ecf0f1;">';
$footer .= '&nbsp;';
$footer .= '</td>';
$footer .= '</tr>';
$footer .= '</table>';

$footer = utf8_encode($footer);
//$mpdf->SetHTMLFooter($footer);
//$mpdf->SetHTMLFooter($footer, 'E');

if (file_exists($PlanoFacil)) {
    ob_start();
	Require_Once($Devolutiva);
    Require_Once($PlanoFacil);
    $html .= ob_get_contents();
    //$html .= '·ÈÌÛ˙‡ËÏÚ˘‚ÍÓÙ˚‰ÎÔˆ¸„ı@#$%^&*()+=~`Á|\/:,?"<>';
    ob_end_clean();
} else {
    echo "<script type='text/javascript'>top.location = 'index.php';</script>";
    exit();
}

$html .= '</body>';
$html .= '</html>';

//var_dump(strlen($html));
//$html = preg_replace("|<style\b[^>]*>(.*?)</style>|s", "", $html);
$html = preg_replace("|<script\b[^>]*>(.*?)</script>|s", "", $html);
$html = str_replace('  ', ' ', $html);
$html = str_replace("\n", '', $html);
$html = str_replace(chr(10), '', $html);
$html = str_replace(chr(13), '', $html);
$html = str_replace("&nbsp;", '', $html);
$html = utf8_encode($html);

/*
 * Este erro da em PHP antigos vers„o de luiz
  if (strlen($html) > 1000000) {
  echo 'Erro na geraÁ„o do PDF, pois tem muitos registros..<br>';
  echo 'Utilize outro meio de exportaÁ„o.<br>';
  exit();
  }
 * 
 */

//var_dump(strlen($html));
// echo $html;exit();
//MPDF
set_time_limit(0);

//$mpdf->debug = true;
//$mpdf->allow_output_buffering = true;
//$mpdf->allow_charset_conversion = true;
//$mpdf->ignore_invalid_utf8 = true;


//$mpdf->shrink_tables_to_fit = 0;
//$mpdf->use_kwt = true;


if ($css_sistema) {
    $mpdf->WriteHTML(file_get_contents('padrao.css'), 1);

    if (img_dispositivo == '_32') {
        $mpdf->WriteHTML(file_get_contents('padrao_32.css'), 1);
    }

    $css = '';

    $css .= 'table#table_barra_full {';
    $css .= 'display: none;';
    $css .= '}';

    $css .= '#barra_full {';
    $css .= 'display: none;';
    $css .= '}';

    $css .= 'Table#Tabela_Filtro td.Tit_Campo_Obr {';
    $css .= 'padding-left: 10px;';
    $css .= 'padding-right: 5px;';
    $css .= 'vertical-align: middle;';
    $css .= '}';

    $mpdf->WriteHTML($css, 1);
}

$mpdf->WriteHTML($html);

/*
 * Tem que mudar para quebrar no final da tag..
  $limite_mpdf = 100000;
  $long_html = strlen($html);
  $long_int = intval($long_html / $limite_mpdf);

  if ($long_int > 0) {
  for ($i = 0; $i < $long_int; $i++) {
  $temp_html = substr($html, ($i * $limite_mpdf), $limite_mpdf - 1);
  $mpdf->WriteHTML($temp_html);
  }
  //Last block
  $temp_html = substr($html, ($i * $limite_mpdf), ($long_html - ($i * $limite_mpdf)));
  $mpdf->WriteHTML($temp_html);
  } else {
  $mpdf->WriteHTML($html);
  }
 * 
 */
$pathPDF="obj_file/segundavisita.pdf";
if ($pathPDF == '') {
    $mpdf->Output();
} else {
    $mpdf->Output($pathPDF, 'F');
}