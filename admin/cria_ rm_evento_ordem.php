<?php
require_once 'configuracao.php';

$vet = Array(
1873,
4158,
4653,
4778,
5024,
5062,
5120,
5154,
5165,
5224,
5285,
5330,
5369,
5421,
5436,
5445,
5508,
);

foreach ($vet as $idt) {
	$vetErro = rmConsolidacaoPrevista($idt, 'valor_real');
	p($vetErro);

	if (count($vetErro) == 0) {
		$vetErro = rmConsolidacaoRealizado($idt);
		p($vetErro);
	}
}