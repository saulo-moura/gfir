<?php
Require_Once('configuracao.php');
 $login  = $_GET['login'];
 $senha  = $_GET['senha'];
?>
<script>
var login  = '<?php echo $login; ?>';
var senha  = '<?php echo $senha; ?>';
var left   = 0;
var top    = 0;


var height = screen.height;
var width  = screen.width;

var link   = "conteudo_atendimento_totem.php?totem=S&login="+login+'&senha='+senha;

totemPop   = window.open(link, "TotemPop", "left=" + left + ",top=" + top + ",width=" + width + ",height=" + height + ",location=no,resizable=yes,menubar=no,scrollbars=yes,toolbar=no,alwaysLowered=yes,alwaysRaised=no,dependent=yes,directories=no,hotkeys=no,menubar=no,personalbar=no,scrollbars=yes,status=no,titlebar=no,z-lock=yes,titlebar=no");
totemPop.focus();

window.history.back();

</script>
