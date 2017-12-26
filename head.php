<link href="padrao.css" rel="stylesheet" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<title><?php echo $nome_site ?></title>
<link rel="shortcut icon" href="admin/imagens/favicon.jpg" />
<script type="text/javascript">
    var acao = '<?php echo $acao ?>';
    var menu = '<?php echo $menu ?>';
    var prefixo = '<?php echo $prefixo ?>';
    var ajax_plu = '<?php echo ajax_plu ?>';
    var cont_arq = '<?php echo $cont_arq ?>';
    var print_tela = '<?php echo $print_tela ?>';
    var conteudo_abrir_sistema = '<?php echo conteudo_abrir_sistema ?>';
    var postMessageUrl = 'http://<?php echo $_SERVER['HTTP_HOST'] ?>';

    var hoje = new Date();
    var $tabs = '';

    var subMenuF = new Array();
    var subMenuP = new Array();
<?php
if (is_array($vetMenuSub)) {
    ForEach ($vetMenuSub as $idx => $valor) {
        echo "subMenuF[subMenuF.length] = '".$idx."';\n";
        echo "subMenuP[subMenuP.length] = '".$valor."';\n";
    }
}
?>

    function gsdA_Class() {
		this.latitude = '<?php echo $_SESSION[CS]['latitude'] ?>';
		this.longitude = '<?php echo $_SESSION[CS]['longitude'] ?>';
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

    var vetMime = new vetMime_Class();
<?php
if ($_SESSION[CS]['g_id_usuario'] == '') {
    echo 'var popup_open = "S";'.nl();
} else {
    echo 'var popup_open = "'.$_SESSION[CS]['g_popup'].'";'.nl();
}
?>
</script>
<script language="JavaScript" src="js/css_browser_selector.js" type="text/javascript"></script>
<script language="JavaScript" src="js/jquery-1.11.2.min.js" type="text/javascript"></script>

<script language="JavaScript" src="admin/js/funcao.js" type="text/javascript"></script>
<script language="JavaScript" src="js/funcao_site.js" type="text/javascript"></script>

<script language="JavaScript" src="admin/js/gsdA.js" type="text/javascript"></script>


<script language="JavaScript" src="js/jquery.cascade/jquery.cascade.js" type="text/javascript"></script>
<script language="JavaScript" src="js/jquery.cascade/jquery.cascade.ext.js" type="text/javascript"></script>
<link href="js/jquery.cascade/cascade.css" rel="stylesheet" type="text/css" />

<script language="JavaScript" src="js/submodal-1.6/common.js" type="text/javascript"></script>
<script language="JavaScript" src="js/submodal-1.6/subModal.js" type="text/javascript"></script>
<link href="js/submodal-1.6/subModal.css" rel="stylesheet" type="text/css" />

<link href="js/jquery-ui-1.11.4/jquery-ui.min.css" rel="stylesheet" type="text/css" />
<script language="JavaScript" src="js/jquery-ui-1.11.4/jquery-ui.min.js" type="text/javascript"></script>
<script language="JavaScript" src="js/jquery-ui-1.11.4/ui.datepicker-pt-BR.js" type="text/javascript"></script>

<link href="js/jquery-lightbox-0.5/jquery.lightbox-0.5.css" rel="stylesheet" type="text/css" media="screen" />
<script language="JavaScript" src="js/jquery-lightbox-0.5/jquery.lightbox-0.5.js" type="text/javascript"></script>

<link href="js/prettyphoto_3.1.2/prettyPhoto.css" rel="stylesheet" type="text/css" media="screen" />
<script language="JavaScript" src="js/prettyphoto_3.1.2/jquery.prettyPhoto.js" type="text/javascript"></script>

<script language="JavaScript" src="js/highcharts/highcharts.js" type="text/javascript"></script>
<!--<script language="JavaScript" src="js/highcharts/grid.js" type="text/javascript"></script>-->
<!--<script language="JavaScript" src="js/highcharts/exporting.js" type="text/javascript"></script>-->

<script type="text/javascript" >
    $(document).ready(function () {
        Highcharts.theme = {
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
if (file_exists("analyticstracking.php")) {
    include_once("analyticstracking.php");
}