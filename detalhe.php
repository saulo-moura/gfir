<link href="detalhe.css" rel="stylesheet" type="text/css" />
<?php
$vetCampo = Array();
$idCampo = 'idt';
$tabela = $menu;

$url_volta = 'conteudo'.$cont_arq.'.php';

//p('nnnnnnnnnnnnnnnnnn '.$_SERVER['HTTP_REFERER']);

$sql = '';

$path = 'detalhe_conf/'.$menu.'.php';

if (file_exists($path)) {
	Require_Once($path);
    
    if ($sql == '') $sql = 'select * from '.$tabela.' where '.$idCampo.' = '.null($_GET['id']);;
    
    onLoadPag();
    
    $rs = execsql($sql);
    $row = $rs->data[0];
    
    echo '<div class="detalhe_row">'.nl();
    
    ForEach($vetCampo as $campo => $dados) {
        if ($dados['style'] == '')
            $style = '';
        else
            $style = 'class="detalhe_'.$dados['style'].'"';
        
        echo '<div '.$style.'>';
        echo $dados['antes'];
        if ($dados['mostra_nome']) echo $dados['nome'].':&nbsp;';
        echo '<span title="'.$dados['nome'].'">';
        
        switch ($dados['tipo']) {
        	case 'data':
                echo trata_data($row[$campo]);
        		break;
        	
        	case 'decimal':
                echo format_decimal($row[$campo]);
        		break;
        	
        	case 'arquivo':
                $path = $dir_file.'/'.$tabela.'/';
                ImagemProd(0, $path, $row[$campo], $row[$idCampo].'_'.$campo.'_');
        		break;
            
          	case 'link':
                if ($row[$campo] != '')
                    echo '<a href="'.$dados['link'].$row[$campo].'">'.$dados['nome'].'</a>';
        		break;
        	
        	case 'email':
                echo '<a href="mailto:'.$row[$campo].'">'.$row[$campo].'</a>';
        		break;
        	
            default:
                echo $row[$campo];
        		break;
        }
        
        echo '</span>';
        echo $dados['depois'];
        echo '</div>'.nl();
    }
    
    echo '</div>'.nl();
    ?>
    
    
    <div id="voltar_full">
    <div class="voltar">
        <img src="imagens/menos_full_PCO.jpg" title="Voltar"  alt="Voltar" border="0" onclick="self.location = '<?php echo $url_volta; ?>'" style="cursor: pointer;">
    </div>
    </div>

    <?php
} else {
    echo "<br><br><div align='center' class='Msg'>Função em desenvolvimento...</div>";
    onLoadPag();
}
?>