<?php
$css_sistema = true;
$html = '';
$html .= '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">';
$html .= '<html xmlns="http://www.w3.org/1999/xhtml">';
$html .= '<head>';
$html .= '<meta http-equiv="Content-Type" content="text/html; charset=win-1252" />';
$html .= '</head>';
$html .= '<body>';

if (_MPDF_PATH === '_MPDF_PATH') {
    define('_MPDF_PATH', lib_mpdf);
    include(lib_mpdf.'mpdf.php');
}

$ME = 5;
$MD = 5;
$MS = 5;
$MB = 0;
$MHEADER = 0;
$MFOOTER = 0;
$mpdf = new mPDF('win-1252', 'A4-L', '10', '', $ME, $MD, $MS, $MB, $MHEADER, $MFOOTER, 'L');
$include = "cadastro_conf/grc_nan_plano_facil.php";
if (file_exists($include)) {
    ob_start();
    Require_Once($include);
    $htmlTT = str_replace("font-family", 'xfont-family', ob_get_contents());
    $html .= $htmlTT;
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

$html = htmlspecialchars_decode($html, ENT_QUOTES);
$html = html_entity_decode($html, ENT_QUOTES, "ISO-8859-1");

$html = utf8_encode($html);
// echo $html;exit();
// MPDF
set_time_limit(0);

/*
if ($css_sistema) {
    $mpdf->WriteHTML(file_get_contents('padrao.css'), 1);
    if (img_dispositivo == '_32') {
        $mpdf->WriteHTML(file_get_contents('padrao_32.css'), 1);
    }
}
 * 
 */

$sql = "select ";
$sql .= "   grc_at.idt_grupo_atendimento, grc_nga.num_visita_atu, grc_nga.pdf_plano_facil";
$sql .= " from  grc_avaliacao grc_a ";
$sql .= " inner join grc_atendimento grc_at on grc_at.idt = grc_a.idt_atendimento ";
$sql .= " inner join grc_nan_grupo_atendimento grc_nga on grc_nga.idt = grc_at.idt_grupo_atendimento ";
$sql .= " where grc_a.idt  =  ".null($idt_avaliacao);
$rsGA = execsql($sql);
$rowGA = $rsGA->data[0];

if ($rowGA['num_visita_atu'] == 1) {
    $mpdf->watermark_font = 'DejaVuSansCondensed';
    $mpdf->showWatermarkText = true;
    $mpdf->SetWatermarkText('RASCUNHO', 0.1);
}

$mpdf->WriteHTML($html);
$microtime = substr(time(), -3);
$nome_arquivo = $rowGA['idt_grupo_atendimento']."_pdf_plano_facil_{$microtime}_plano_facil.pdf";
$pathPDF = "obj_file/grc_nan_grupo_atendimento/".$nome_arquivo;
$mpdf->Output($pathPDF, 'F');
$arquivo = $nome_arquivo;
$tipo = "PF";
$veterro = Array();
AtualizarPathPDF($idt_avaliacao, $arquivo, $tipo, $veterro);

$exportPath = dirname($_SERVER['SCRIPT_FILENAME']);
$exportPath .= DIRECTORY_SEPARATOR.$dir_file;
$exportPath .= DIRECTORY_SEPARATOR.'grc_nan_grupo_atendimento';
$exportPath .= DIRECTORY_SEPARATOR;
$exportPath = str_replace('\\', '/', $exportPath);

$arq = $exportPath.$rowGA['pdf_plano_facil'];
if (file_exists($arq)) {
    unlink($arq);
}

if (count($veterro) > 0) {
    $vetRetorno['erro'] = implode('\n', $veterro);
}