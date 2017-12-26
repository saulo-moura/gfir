<?php
ini_set('memory_limit', '1024M');

require_once 'configuracao.php';

beginTransaction();

$automatico = true;
$usa_rodizio = true;
$variavel = array();
$ret = GEC_contratacao_credenciado_ordem(24706, $variavel, $automatico, $usa_rodizio, false);

p($variavel);

if ($variavel['erro'] == '') {
	commit();
} else {
	rollBack();

	foreach ($variavel['ordem_codigo'] as $ordem_codigo) {
		$chave_origem = 'GC' . $ordem_codigo;
		$mensagemRM = 'Empenho não encontrado na Ordem de Contratação no sistema GEC';
		$vetIdMov = Array();

		$sql = '';
		$sql .= ' select rm.rm_idmov';
		$sql .= ' from ' . db_pir_gec . 'gec_contratacao_credenciado_ordem_rm rm';
		$sql .= ' inner join ' . db_pir_gec . 'gec_contratacao_credenciado_ordem o on o.idt = rm.idt_gec_contratacao_credenciado_ordem';
		$sql .= ' where o.codigo = ' . aspa($ordem_codigo);
		$sql .= ' and rm.rm_idmov is not null';
		$rstt = execsql($sql);

		foreach ($rstt->data as $rowtt) {
			$vetIdMov[] = $rowtt['rm_idmov'];
		}

		CancelaMovRM($chave_origem, $vetIdMov, $mensagemRM);
	}

	$variavel['erro'] = 'Erro na geração da Ordem de Contratação.<br />' . $variavel['erro'];
	erro_try($variavel['erro'], 'evento_ordem_sg');
	msg_erro($variavel['erro']);
}