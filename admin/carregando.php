<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Carregando Sistema...</title>
<link rel="shortcut icon" href="imagens/favicon.ico" />
<link href="padrao.css" rel="stylesheet" type="text/css" />
<script language="JavaScript" src="js/jquery-1.11.2.min.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function () {
    height = ($(window).height() - $("#carregando").height()) / 2;
    width  = ($(window).width() - $("#carregando").width()) / 2;
    $("#carregando").css('top', height + 'px');
    $("#carregando").css('left', width + 'px');
});
</script>
</head>
<body>
<span id="carregando"><img src="imagens/carregando.gif" />Aguarde, processando...</span>
</body>
</html>
