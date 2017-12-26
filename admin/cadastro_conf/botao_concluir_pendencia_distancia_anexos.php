<style>
    .arquivo_cab {
	    background:#F1F1F1;
		color:#666666;
		font-size: 16px;  
        text-align:center;
        border-top:1px solid #C0C0C0;
		border-bottom:1px solid #C0C0C0;
		width:750px;
		display:block;
    }
	.descricao {
	    background:#FFFFFF;
		color:#0000FF;
        text-align:left;
        border-bottom:1px solid #C0C0C0;
	    cursor:pointer;
		
    }
	.descricao :hover {
		text-decoration:none;
		
    }
</style>
<?php
echo " <div class='anexos_distancia' >";
$TabelaPrinc = "grc_atendimento_anexo";
$AliasPric   = "grc_aa";
$Entidade    = "Anexo do Atendimento";
$Entidade_p = "Anexos do Atendimento";
$orderby = "{$AliasPric}.descricao ";
$sql = "select {$AliasPric}.*  ";
$sql .= " from {$TabelaPrinc} {$AliasPric}  ";
$sql .= " where {$AliasPric}".'.idt_atendimento = '.null($idt_atendimento);
$sql .= "  and {$AliasPric}".'.devolutiva_distancia = '.aspa('S');
$sql .= " order by {$orderby}";
$rs   = execsql($sql);
echo " <div class='arquivo_cab ' >";
echo " <div style='margin:8px; '>Arquivos anexos</div>";
echo " </div>";

if ($rs->rows ==0)
{
    $descricaow = "Devolutiva sem Documentos em anexo."; 
	echo " <div class='descricao ' >";
	echo " <div style='margin:8px; '>{$descricaow}</div>";
	echo " </div>";

}
else
{
    $path="obj_file/grc_atendimento_anexo/";
	ForEach($rs->data as $row)
	{
		$descricao = $row['descricao'];
		$arquivo   = $row['arquivo'];
		if ($descricao=="")
		{
		   $descricaow="sem título [{$arquivo}]";
		}
		else
		{
		   $descricaow=" {$descricao} - [{$arquivo}]";
		}
		$hint="Clique para visualizar o arquivo.\nATENÇÃO...\n Será aberto em outra Janela.";
		//echo " <div class='botao_ag_bl' onclick='return VoltarDevolutiva();'>";
		echo " <div title='{$hint}' class='descricao ' >";
		$link  = '<a href="'.$path.$arquivo.'" target="_blank" class="">';
		$link .= $descricaow;
		$link .= '</a>';
		echo " <div style='padding:8px; '>{$link}</div>";
		echo " </div>";
	}
}
echo " </div>";
?>
<script>
</script>