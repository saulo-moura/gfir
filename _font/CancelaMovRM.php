<?php
ini_set('memory_limit', '1024M');

require_once '../configuracao.php';

$vetSistema = Array(969498, 969499, 969500, 969501, 947418);
$mensagem = 'Movimentaчуo nуo encontrada no GEC!';

CancelaMovRM('GCBA0620160105', $vetSistema, $mensagem);
