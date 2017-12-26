<!-- <lupe> <objeto> Inicio do Objeto -->
<?php
/* <lupe> <objeto>
  Documentação
</lupe> */ 
?>
<!-- <lupe> <estilo>  Definição dos estilos para HTML -->
<style>
</style>
<!-- <lupe> <raiz>  Definição Processos Servidor e Geração HTML -->
<?php
/* <lupe> <raiz>
  Documentação
</lupe> */ 
$tabela = 'grc_evento_status';
$id     = 'idt';
$vetFrm = Array();
// Seção 1
$vetCampo['codigo']    = objTexto('codigo', 'Código', True, 15, 45);
$vetCampo['descricao'] = objTexto('descricao', 'Descrição', True, 60, 120);
$vetCampo['ativo']     = objCmbVetor('ativo', 'Ativo?', True, $vetSimNao);
$vetFrm[] = Frame('<span>Identificação</span>', Array(
   Array($vetCampo['codigo'],'',$vetCampo['descricao'],'',$vetCampo['ativo']),
),$class_frame,$class_titulo,$titulo_na_linha);
// Seção 2
$maxlength  = 700;
$style      = "width:700px;";
$js         = "";
$vetCampo['detalhe'] = objTextArea('detalhe', 'Detalhe', false, $maxlength, $style, $js);
$vetFrm[] = Frame('<span>Resumo</span>', Array(
    Array($vetCampo['detalhe']),
),$class_frame,$class_titulo,$titulo_na_linha);
// Carrega tabela Tela
$vetCad[] = $vetFrm;
?>
<!-- <lupe> <script>  Definição processos Cliente -->
<script>
/* <lupe> <cliente> 
  Documentação
</lupe> */ 
</script>
