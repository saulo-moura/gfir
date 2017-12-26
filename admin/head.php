<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php echo $nome_site ?></title>
<link rel="shortcut icon" href="imagens/favicon.jpg" />
<link href="padrao.css" rel="stylesheet" type="text/css" />
<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
<?php
if (img_dispositivo == '_32') {
    echo '<link href="padrao_32.css" rel="stylesheet" type="text/css" />';
}
?>
<script type="text/javascript">
	var acao_alt_con = '';
    var acao = '<?php echo $acao ?>';
    var menu = '<?php echo $menu ?>';
    var prefixo = '<?php echo $prefixo ?>';
    var popup = '<?php echo $cont_arq ?>';
    var print_tela = '<?php echo $print_tela ?>';
    var ajax_sistema = '<?php echo ajax_sistema ?>';
    var ajax_plu = '<?php echo ajax_plu ?>';
    var cont_arq = '<?php echo $cont_arq ?>';
    var conteudo_abrir_sistema = '<?php echo conteudo_abrir_sistema ?>';
    var postMessageUrl = 'http://<?php echo $_SERVER['HTTP_HOST'] ?>';

    var hoje = new Date();
    var $tabs = '';

    function gsdA_Class() {
		this.latitude     = '<?php echo $_SESSION[CS]['latitude'] ?>';
		this.longitude    = '<?php echo $_SESSION[CS]['longitude'] ?>';
		this.aviso_tovivo = '<?php echo $_SESSION[CS]['aviso_tovivo'] ?>';
    }

	function vetConf_Class() {
<?php
ForEach ($vetConfJS as $idx => $valor) {
    echo "this.{$idx} = '".str_replace("'", "\'", $valor)."';\n";
}
?>
    }

    var vetConf = new vetConf_Class();

    function vetMime_Class() {
<?php
ForEach ($vetMimeJS as $idx => $valor) {
    echo "this.{$idx} = '".str_replace("'", "\'", $valor)."';\n";
}
?>
    }

<?php
if ($_SESSION[CS]['g_id_usuario'] == '') {
    echo 'var popup_open = "";'.nl();
} else {
	$_SESSION[CS]['g_popup'] = 'S';
    echo 'var popup_open = "'.$_SESSION[CS]['g_popup'].'";'.nl();
}
?>

    var vetMime = new vetMime_Class();
<?php
echo "var exporting_url = '".url."js/highcharts/exporting/'";
?>
</script>
<script language="JavaScript" src="goCad.js" type="text/javascript"></script>
<script language="JavaScript" src="js/css_browser_selector.js" type="text/javascript"></script>
<script language="JavaScript" src="js/jquery-1.11.2.min.js" type="text/javascript"></script>
<script language="JavaScript" src="js/funcao.js<?php echo versao_js; ?>" type="text/javascript"></script>

<script language="JavaScript" src="js/gsdA.js<?php echo versao_js; ?>" type="text/javascript"></script>

<script language="JavaScript" src="js/jquery.cascade/jquery.cascade.js<?php echo versao_js; ?>" type="text/javascript"></script>
<script language="JavaScript" src="js/jquery.cascade/jquery.cascade.ext.js<?php echo versao_js; ?>" type="text/javascript"></script>
<link href="js/jquery.cascade/cascade.css" rel="stylesheet" type="text/css" />

<script language="JavaScript" src="js/submodal-1.6/common.js<?php echo versao_js; ?>" type="text/javascript"></script>
<script language="JavaScript" src="js/submodal-1.6/subModal.js<?php echo versao_js; ?>" type="text/javascript"></script>
<link href="js/submodal-1.6/subModal.css" rel="stylesheet" type="text/css" />

<link href="js/jquery-ui-1.11.4/jquery-ui.min.css" rel="stylesheet" type="text/css" />
<script language="JavaScript" src="js/jquery-ui-1.11.4/jquery-ui.min.js" type="text/javascript"></script>
<script language="JavaScript" src="js/jquery-ui-1.11.4/ui.datepicker-pt-BR.js" type="text/javascript"></script>

<link href="js/colorpicker/colorpicker.css" rel="stylesheet" type="text/css" media="print, projection, screen" />
<script language="JavaScript" src="js/colorpicker/colorpicker.js" type="text/javascript"></script>

<script language="JavaScript" src="js/funcao_site.js<?php echo versao_js; ?>" type="text/javascript"></script>

<script language="JavaScript" src="js/highcharts/highcharts.js" type="text/javascript"></script>
<!--<script language="JavaScript" src="js/highcharts/grid.js" type="text/javascript"></script>-->
<script language="JavaScript" src="js/highcharts/exporting.js" type="text/javascript"></script>

<!-- <link rel="stylesheet" href="js/tablesorter-2.26.6/css/theme.default.min.css"> -->
<script type="text/javascript" src="js/tablesorter-2.26.6/js/jquery.tablesorter.min.js"></script>
<!-- <script type="text/javascript" src="js/tablesorter-2.26.6/js/jquery.tablesorter.widgets.js"></script> -->

<script type="text/javascript" src="js/pivottable-2.1.0/papaparse.min.js"></script>
<link rel="stylesheet" href="js/pivottable-2.1.0/dist/pivot.min.css">
<script type="text/javascript" src="js/pivottable-2.1.0/dist/pivot.min.js"></script>
<script type="text/javascript" src="js/pivottable-2.1.0/dist/pivot.pt.min.js"></script>
<script type="text/javascript" src="js/pivottable-2.1.0/subtotal.min.js"></script>

<?php
$path_tema_sistema="grc_tema.php";
$tmp = $path_tema_sistema;
if (file_exists($tmp)) {
   Require_Once($tmp);
}
?>
<script type="text/javascript" >
    $(document).ready(function () {
        Highcharts.theme = {
            exporting: {
                enabled: false,
                url: exporting_url,
                width: 2000
            },
            yAxis: {
                gridLineWidth: 0,
                labels: {
                    enabled: false
                }
            }
        };
        var highchartsOptions = Highcharts.setOptions(Highcharts.theme);
        
        
    });
</script>
<?php
if (file_exists("../analyticstracking.php"))
    include_once("../analyticstracking.php");?>