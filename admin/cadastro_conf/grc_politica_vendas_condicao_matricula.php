<?php
$vetWizardTabelaLocal = $vetWizardTabela;
unset($vetWizardTabelaLocal[1]);
unset($vetWizardTabelaLocal[2]);

wizardCriaTela('wizardMatricula', $vetWizardTabelaLocal, 'M', 'grc_politica_vendas_condicao_matricula_formula_fix');