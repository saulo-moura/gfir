<?php
require_once '../configuracao.php';

$dt_contratacao_ini = '24/04/2017';

$dt_contratacao_fim = Calendario::Intervalo_Util($dt_contratacao_ini, 60);
p($dt_contratacao_fim);

echo 'FIM...';
