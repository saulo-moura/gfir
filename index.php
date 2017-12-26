<?php
$url = $_SERVER['HTTP_HOST'].str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']).'/admin';
$url = 'http://'.str_replace('//', '/', $url);
?>

<meta http-equiv="refresh" content="0;url=<?php echo mb_strtolower($url); ?>">

<?php
//Require_Once('index.php');
//Require_Once('configuracao.php');
//Require_Once('conteudo.php');
/*
  if ($debug) {
  Require_Once('conteudo.php');
  } else
  echo '
  <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
  <html xmlns="http://www.w3.org/1999/xhtml">
  <head>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
  <title>'.$nome_site.'</title>
  </head>
  <frameset id="frameset" rows="*" frameborder="no" border="0" framespacing="0">
  <frame name="conteudo" src="conteudo.php" noresize="noresize" scrolling="yes">
  </frameset>
  <noframes>
  <body>Favor atualizar o navegador para uma versão mais nova!</body>
  </noframes>
  </html>
  ';
 */
?>

