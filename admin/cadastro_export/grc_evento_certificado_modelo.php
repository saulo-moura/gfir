<?php
$vetParametro = array_map(create_function('', ''), $vetParametroEventoCertificado);

//Gerando PDF
if ($_POST['mpdf_papel_orientacao'] == 'L') {
    $papel = 'A4-L';
} else {
    $papel = 'A4';
}

$mpdf = new mPDF('win-1252', $papel, '10', '', $_POST['mpdf_me'], $_POST['mpdf_md'], $_POST['mpdf_ms'], $_POST['mpdf_mb'], $_POST['mpdf_mh'], $_POST['mpdf_mf'], $_POST['mpdf_papel_orientacao']);

$header = $_POST['html_header'];
$footer = $_POST['html_footer'];
$htmlPDF = $_POST['html_corpo'];

foreach ($vetParametro as $key => $value) {
    $header = str_replace($key, $value, $header);
    $footer = str_replace($key, $value, $footer);
    $htmlPDF = str_replace($key, $value, $htmlPDF);
}

$header = utf8_encode($header);
$mpdf->SetHTMLHeader($header);
$mpdf->SetHTMLHeader($header, 'E');

$footer = utf8_encode($footer);
$mpdf->SetHTMLFooter($footer);
$mpdf->SetHTMLFooter($footer, 'E');

$return = $vetParametro;
echo $htmlPDF;
