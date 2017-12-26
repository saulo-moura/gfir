<?php
$vetWizardTabelaLocal = $vetWizardTabela;
unset($vetWizardTabelaLocal[3]);

wizardCriaTela('wizardEvento', $vetWizardTabelaLocal, 'P', 'grc_politica_vendas_condicao_evento_formula_fix');
