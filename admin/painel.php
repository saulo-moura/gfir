
<style>
div#mostra_pk {
	text-align: right;
	font-size: 10px;
	margin-top: 35px;
	border:1px solid #C0C0C0;
	width:100%;
	display:block;
	background:#F1F1F1;
}

div#mostra_pk a {
	color: black;
}

</style>

<?php
$sql_listar = $sql;
$menu_inicial = $_GET['menu'];
if ($largura_tela == '') {
    $largura_tela = 1000;
}

if ($altura_tela == '') {
    $altura_tela = 500;
}

if ($codigo_painel == '') {
    $codigo_painel = $_REQUEST['codigo_painel'];
}

$sql = '';
$sql .= ' select *';
$sql .= ' from plu_painel';
$sql .= ' where codigo = '.aspa($codigo_painel);
$rs = execsql($sql);

if ($rs->rows == 0) {
    echo '<div align="center" class="Msg">Código do painel não encontrado! Código: "'.$codigo_painel.'"</div>';
} else {
    $_SESSION[CS]['painel_url_volta'][$codigo_painel] = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

    $row_p = $rs->data[0];
    ?>
    <style type="text/css">
        div.painel_grupo {
            background-color: #2c3e50;
            color: white;
            padding: 5px;
            text-align: center;
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 3px;
        }

        div.painel_grupo > img {
            float: left;
            margin-left: 5px;
            margin-top: 2px;
            vertical-align: middle;
            cursor: pointer;
        }

        div.painel_cont {
            xposition: relative;
            margin-bottom: 10px;
            overflow: hidden;
        }

        div.painel_cont > div.cell {
            xposition: absolute;
            overflow: hidden;
            cursor: pointer;
        }

        div.painel_cont > div.cell > div {
            display: table-cell;
            text-align: center;
            vertical-align: middle;
            padding: 0px;
        }

        div.painel_cont > div.cell > span {
            background: #FFFFFF;
            border: 0;
            border-radius: 1em;
            margin: 1px 5px;

            text-align:center;

            color: #2f66b8;
            text-decoration:none;
            font-family: Arial, Calibri, Helvetica, sans-serif;
            font-size:11px;
            font-weight: bold;
            display:block;
        }

        div.painel_cont > div.cell_desativado {
            cursor: auto;
        }

        div.painel_cont > div.cell_desativado > span {
            color: #000000;
        }

        div.painel_cont > div.cell_ativado > div > img.img_ativado {
            display: inline;
        }

        div.painel_cont > div.cell_ativado > div > img.img_desativado {
            display: none;
        }

        div.painel_cont > div.cell_desativado > div > img.img_ativado {
            display: none;
        }

        div.painel_cont > div.cell_desativado > div > img.img_desativado {
            display: inline;
        }

        div.painel_cont > div.cell_inc {
            position: absolute;
        }

        img.move_item {
            position: absolute;
            cursor: move;
            left: 0px;
            top: 0px;
        }

        .ui-resizable-helper {
            border: 2px dotted #00F;
        }        
    </style>
    <script type="text/javascript">
        $(document).ready(function () {
            $("img.move_item").click(function (event) {
                event.stopImmediatePropagation();
            });

            $('div.painel_grupo > img').click(function () {
                var img = $(this);

                if (img.attr('src') == 'imagens/seta_baixo.png') {
                    img.attr('src', 'imagens/seta_cima.png');
                } else {
                    img.attr('src', 'imagens/seta_baixo.png');
                }

                img.parent().next().toggle();

                TelaHeight();
                return false;
            });

            $("div.painel_cont_move div.cell, div.painel_cont_move div.cell_inc").draggable({
                zIndex: 1,
                cursor: 'move',
                handle: 'img.move_item',
                containment: "parent",
                scroll: true,
                create: function (event, ui) {
                    var painel_cont = $(this).parent();
                    var layout_grid = painel_cont.data('layout_grid');
                    var cont_largura = painel_cont.data('cont_largura');
                    var cont_altura = painel_cont.data('cont_altura');

                    if (layout_grid == 'S') {
                        $(this).draggable("option", "grid", [cont_largura, cont_altura]);
                    }
                },
                stop: function (event, ui) {
                    var cell = $(this);
                    var painel_cont = $(this).parent();
                    var cont_largura = painel_cont.data('cont_largura');
                    var cont_altura = painel_cont.data('cont_altura');

                    $.ajax({
                        dataType: 'json',
                        type: 'POST',
                        url: 'painel_ajax.php?tipo=move',
                        data: {
                            idt: cell.data('idt'),
                            idt_grupo: painel_cont.data('idt'),
                            top: ui.position.top,
                            left: ui.position.left
                        },
                        success: function (resultado) {
                            switch (resultado.erro) {
                                case 'ocupado':
                                case 'erro_msg':
                                    alert(url_decode(resultado.erro_msg));
                                    cell.css('top', ui.originalPosition.top).css('left', ui.originalPosition.left);
                                    break;
                                default:
                                    painel_cont.resizable("option", "minWidth", resultado.max_left + cont_largura);
                                    painel_cont.resizable("option", "minHeight", resultado.max_top + cont_altura);
                                    break;
                            }
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            alert('Erro no ajax: ' + textStatus + ' - ' + errorThrown);
                        },
                        async: false
                    });
                }
            });

            $("div.painel_cont_move").resizable({
                helper: "ui-resizable-helper",
                create: function (event, ui) {
                    $(this).resizable("option", "minWidth", $(this).data('min_largura'));
                    $(this).resizable("option", "minHeight", $(this).data('min_altura'));
                    $(this).resizable("option", "maxWidth", $(this).data('limite_largura'));
                    $(this).resizable("option", "maxHeight", $(this).height() * 10);
                },
                resize: function (event, ui) {
                    var maxHeight = $(this).resizable("option", "maxHeight");
                    var maxWidth = $(this).resizable("option", "maxWidth");

                    if (ui.size.height > maxHeight) {
                        ui.size.height = ui.originalSize.height;
                    }

                    if (ui.size.width > maxWidth) {
                        ui.size.width = ui.originalSize.width;
                    }
                },
                stop: function (event, ui) {
                    var obj = $(this);
                    TelaHeight();
                    $.ajax({
                        dataType: 'json',
                        type: 'POST',
                        url: 'painel_ajax.php?tipo=aumenta_painel',
                        data: {
                            idt: $(this).data('idt'),
                            altura: ui.size.height,
                            largura: ui.size.width
                        },
                        success: function (resultado) {
                            if (resultado.erro == '') {
                                obj.resizable("option", "maxHeight", ui.size.height * 10);
                            } else {
                                alert(url_decode(resultado.erro));
                            }
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            alert('Erro no ajax: ' + textStatus + ' - ' + errorThrown);
                        },
                        async: false
                    });
                }

            });

            $("div.painel_cont_move div.cell_inc").resizable({
                helper: "ui-resizable-helper",
                stop: function (event, ui) {
                    var obj = $(this);
                    TelaHeight();
                    $.ajax({
                        dataType: 'json',
                        type: 'POST',
                        url: 'painel_ajax.php?tipo=aumenta_include',
                        data: {
                            idt: $(this).data('idt'),
                            altura: ui.size.height,
                            largura: ui.size.width
                        },
                        success: function (resultado) {
                            if (resultado.erro != '') {
                                alert(url_decode(resultado.erro));
                            }
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            alert('Erro no ajax: ' + textStatus + ' - ' + errorThrown);
                        },
                        async: false
                    });
                }

            });

            $('.painel_cont').on('click', 'div.cell_ativado', function () {
                var cod_volta = '<?php echo $codigo_painel; ?>';
                var menu = $(this).attr('id');
                var prefixo = $(this).data('prefixo');
                var idtReg = $(this).data('idt');
                var painel_cont = $(this).parent();
                var origem_tela = painel_cont.data('origem_tela');

                if (origem_tela == 'painel_passo') {
                    cod_volta = '';
                }

                if ((prefixo.substr(0, 6) != 'janela') && (prefixo.substr(0, 9)) != 'janelapop') {
                    if (prefixo == 'grupo') {
                        alert('grupo');
                    } else {
                        self.location = 'conteudo' + cont_arq + '.php?prefixo=' + prefixo + '&menu=' + menu + '&origem_tela=' + origem_tela + '&cod_volta=' + cod_volta;
                    }
                } else {
				    if (prefixo.substr(0, 9) != 'janelapop')  {
						var left = 0;
						var top = 0;
						var height = $(window).height();
						var width = $(window).width();
						var link = menu;

						prefixo = prefixo.substr(7);

						if (prefixo != '') {
							link = link + '?' + prefixo;
						}

						window.open(link, "janela_" + idtReg, "left=" + left + ",top=" + top + ",width=" + width + ",height=" + height + ",resizable=yes,menubar=no,scrollbars=yes,toolbar=no");
					}
                    else
					{
	                    var left = 15;
						var top  = 145;
						var height  = $(window).height() - 20;
						var width   = 900 ;
						var link = menu;

						prefixo = prefixo.substr(7);

						if (prefixo != '') {
							link = link + '?' + prefixo;
						}

						//window.open(link, "janela_pop" + idtReg, "left=" + left + ",top=" + top + ",width=" + width + ",height=" + height + ",resizable=yes,menubar=no,scrollbars=yes,toolbar=no");
						
						
						var titulo=' AGENDAMENTO';
						showPopWin(link, titulo , width, height, null, true, 5); 
	
						
						
						
						
						
						
						
					}
                }

                return false;
            });
        });

        function ativa_funcao_painel(cod) {
            $('#' + cod).addClass('cell_ativado').removeClass('cell_desativado');
        }

        function desativa_funcao_painel(cod) {
            $('#' + cod).removeClass('cell_ativado').addClass('cell_desativado');
        }

        function esconde_funcao_painel(cod) {
            $('#' + cod).hide();
        }

        function mostra_funcao_painel(cod) {
            $('#' + cod).show();
        }
		function Close_JanelaPopup(returnVal) {  
	    }
	
    </script>
	
    
    <?php
	
    $path = "obj_file/plu_painel_funcao/";
    $path_inc         = "painel_inc/{$codigo_painel}_";
	$path_inc_sistema = "painel_inc/pir_grc_tema.php";
    $primeiro_passo = '';
    $passo_tit = '';
    $css = '';

    $sql = '';
    $sql .= ' select *';
    $sql .= ' from plu_painel_grupo';
    $sql .= ' where idt_painel = '.null($row_p['idt']);
    $sql .= ' order by ordem';
    $rs = execsql($sql);

    ForEach ($rs->data as $row) {
        $cont_largura = $row['img_largura'] + $row['img_margem_dir'] + $row['img_margem_esq'];
        $cont_altura = 0;

        if ($row['mostra_item'] == 'IT' || $row['mostra_item'] == 'SI') {
            $cont_altura += $row['img_altura'];
        }

        if ($row['mostra_item'] == 'IT' || $row['mostra_item'] == 'ST') {
            $cont_altura += $row['espaco_linha'];
        }

        if ($row['layout_grid'] == 'S') {
            $cont_altura += $row['texto_altura'];

            $limite_largura = floor($largura_tela / $cont_largura) * $cont_largura;
        } else {
            $limite_largura = $largura_tela;
        }

        $hint = $row['hint'];
        if ($hint == "") {
            $hint = $row['descricao'];
        }

        $sql = '';
        $sql .= ' select max(pf.pos_top) as max_top, max(pf.pos_left) as max_left';
        $sql .= ' from plu_painel_funcao pf';
        $sql .= ' where pf.idt_painel_grupo = '.null($row['idt']);
        $sql .= ' group by pf.idt_painel_grupo';
        $rst = execsql($sql);
        $rowt = $rst->data[0];

        $min_largura = $rowt['max_left'] + $cont_largura;
        $min_altura = $rowt['max_top'] + $cont_altura;

        if ($min_largura <= 0) {
            $min_largura = $limite_largura;
        }

        if ($min_altura <= 0) {
            $min_altura = $altura_tela;
        }

        $painel_altura = $row['painel_altura'];
        $painel_largura = $row['painel_largura'];

        if ($painel_largura <= 0) {
            $painel_largura = $limite_largura;
        }

        if ($painel_altura <= 0) {
            $painel_altura = $min_altura;
        }

        if ($row['tit_font_tam'] != '' || $row['tit_font_cor'] != '' || $row['tit_fundo'] != '') {
            $css .= ' div.tit_gr'.$row['idt'].' {';

            if ($row['tit_font_tam'] != '') {
                $css .= ' font-size: '.$row['tit_font_tam'].'px;';
            }

            if ($row['tit_font_cor'] != '') {
                $css .= ' color: #'.$row['tit_font_cor'].';';
            }

            if ($row['tit_fundo'] != '') {
                $css .= ' background-color: #'.$row['tit_fundo'].';';
            }

            $css .= ' }';
        }

        $css .= ' div.painel_cont > div.gr'.$row['idt'].' {';
        $css .= ' width: '.$cont_largura.'px;';
        $css .= ' height: '.$cont_altura.'px;';
        $css .= ' }';

        $css .= ' div.painel_cont > div.gr'.$row['idt'].' > div {';
        $css .= ' padding-left: '.$row['img_margem_esq'].'px;';
        $css .= ' padding-right: '.$row['img_margem_dir'].'px;';
        $css .= ' width: '.$row['img_largura'].'px;';
        $css .= ' height: '.$row['img_altura'].'px;';
        $css .= ' }';

        $css .= ' div.painel_cont > div.gr'.$row['idt'].' > span {';
        $css .= ' height: '.$row['texto_altura'].'px;';
        $css .= ' }';

        $style = '';
        //$style .= ' width: '.$painel_largura.'px;';
        //$style .= ' height: '.$painel_altura.'px;';

        $data = '';
        $data .= ' data-idt="'.$row['idt'].'"';
        $data .= ' data-origem_tela="'.($row['passo'] == 'S' ? 'painel_passo' : 'painel').'"';
        $data .= ' data-layout_grid="'.$row['layout_grid'].'"';
        $data .= ' data-min_largura="'.$min_largura.'"';
        $data .= ' data-min_altura="'.$min_altura.'"';
        $data .= ' data-cont_largura="'.$cont_largura.'"';
        $data .= ' data-cont_altura="'.$cont_altura.'"';
        $data .= ' data-limite_largura="'.$limite_largura.'"';

        $class = 'painel_cont';

        if ($row['move_item'] == 'S') {
            $class .= ' painel_cont_move';
        }

        if ($row['tit_mostrar'] == 'S') {
            $img = '';

            switch ($row['tit_bt_fecha']) {
                case 'A':
                    $img = '<img src="imagens/seta_baixo.png">';
                    break;

                case 'F':
                    $img = '<img src="imagens/seta_cima.png">';
                    $style .= ' display: none;';
                    break;
            }

            echo '<div class="painel_grupo tit_gr'.$row['idt'].'" title="'.$hint.'">';
            echo $img;
            echo $row['descricao'];
            echo '</div>';
        }

        $tmp = $path_inc.$row['codigo'].'_ant.php';
        if (file_exists($tmp)) {
            Require_Once($tmp);
        }

        echo '<div class="'.$class.'" '.$data.' style="'.$style.'">';

        $sql = '';
        $sql .= ' select pf.*, f.nm_funcao, f.prefixo_menu, f.parametros as f_parametros, f.cod_funcao';
        $sql .= ' from plu_painel_funcao pf left outer join plu_funcao f on pf.id_funcao = f.id_funcao';
        $sql .= ' where pf.idt_painel_grupo = '.null($row['idt']);
        $sql .= " and pf.visivel = 'S'";
        $sql .= ' order by pf.pos_top, pf.pos_left';
        $rs_item = execsql($sql);

        ForEach ($rs_item->data as $item) {
            if ($item['include'] == 'S') {
                $include_altura = $item['include_altura'];
                $include_largura = $item['include_largura'];

                if ($include_altura <= 0) {
                    $include_altura = $cont_altura;
                }

                if ($include_largura <= 0) {
                    $include_largura = $cont_largura;
                }

                $style = '';
                $style .= ' left: '.$item['pos_left'].'px;';
                $style .= ' top: '.$item['pos_top'].'px;';
                $style .= ' height: '.$include_altura.'px;';
                $style .= ' width: '.$include_largura.'px;';

                echo '<div class="cell_inc" data-idt="'.$item['idt'].'" style="'.$style.'">';

                if ($row['move_item'] == 'S') {
                    echo '<img class="move_item" src="imagens/bt_move.png" title="Mover o item na tela"/>';
                }

                $tmp = "painel_inc/".$item['include_arq'].'.php';
                if (file_exists($tmp)) {
                    Require_Once($tmp);
                } else {
                    echo '<span class="Msg">Arquivo não encontrado "'.$item['include_arq'].'.php"</span>';
                }

                echo '</div>';
            } else {
                parse_str($item['f_parametros'], $par_funcao);
                parse_str($item['parametros'], $par_painel);

                foreach ($par_painel as $key => $value) {
                    $par_funcao[$key] = $value;
                }

                if ($par_funcao['prefixo'] == '') {
                    $des_prefixo = $item['prefixo_menu'];
                } else {
                    $des_prefixo = $par_funcao['prefixo'];
                    unset($par_funcao['prefixo']);
                }

                $par = http_build_query($par_funcao);

                if ($par != '') {
                    $des_prefixo .= '&'.$par;
                }

                if ($item['cod_funcao'] == $menu) {
                    $passo_tit = $texto_cab;
                }

                if ($codigo_painel_passo != 'S') {
                    if ($row['passo'] == 'S') {
                        $_SESSION[CS]['painel_passo'][$item['cod_funcao']] = $prefixo.$menu.'.php';
                        $_SESSION[CS]['painel_volta'][$item['cod_funcao']] = $_SESSION[CS]['painel_url_volta'][$_GET['cod_volta']];

                        if ($primeiro_passo == '') {
                            $primeiro_passo = array(
                                'menu' => $item['cod_funcao'],
                                'prefixo' => $item['prefixo_menu'],
                                'extra' => $par_funcao,
                            );
                        }
                    } else {
                        unset($_SESSION[CS]['painel_passo'][$item['cod_funcao']]);
                    }
                }

                $texto_cab = $item['texto_cab'];
                if ($texto_cab == "") {
                    $texto_cab = $item['nm_funcao'];
                }

                $hint = $item['hint'];
                if ($hint == "") {
                    $hint = $texto_cab;
                }

                $class = 'cell gr'.$row['idt'];

                if (acesso($item['cod_funcao'])) {
                    $class .= ' cell_ativado cell_ativado_'.$item['idt'];
                } else {
                    $class .= ' cell_desativado cell_desativado_'.$item['idt'];
                }

                $texto_font_tam = $row['texto_font_tam'];
                $texto_ativ_font_cor = $row['texto_ativ_font_cor'];
                $texto_ativ_fundo = $row['texto_ativ_fundo'];
                $texto_desativ_font_cor = $row['texto_desativ_font_cor'];
                $texto_desativ_fundo = $row['texto_desativ_fundo'];

                if ($item['texto_font_tam'] != '') {
                    $texto_font_tam = $item['texto_font_tam'];
                }

                if ($item['texto_ativ_font_cor'] != '') {
                    $texto_ativ_font_cor = $item['texto_ativ_font_cor'];
                }

                if ($item['texto_ativ_fundo'] != '') {
                    $texto_ativ_fundo = $item['texto_ativ_fundo'];
                }

                if ($item['texto_desativ_font_cor'] != '') {
                    $texto_desativ_font_cor = $item['texto_desativ_font_cor'];
                }

                if ($item['texto_desativ_fundo'] != '') {
                    $texto_desativ_fundo = $item['texto_desativ_fundo'];
                }

                if ($texto_font_tam != '' || $texto_ativ_font_cor != '' || $texto_ativ_fundo != '') {
                    $css .= ' div.painel_cont > div.cell_ativado_'.$item['idt'].' > span {';

                    if ($texto_font_tam != '') {
                        $css .= ' font-size: '.$texto_font_tam.'px;';
                    }

                    if ($texto_ativ_font_cor != '') {
                        $css .= ' color: #'.$texto_ativ_font_cor.';';
                    }

                    if ($texto_ativ_fundo != '') {
                        $css .= ' background-color: #'.$texto_ativ_fundo.';';
                    }

                    $css .= ' }';
                }

                if ($texto_font_tam != '' || $texto_desativ_font_cor != '' || $texto_desativ_fundo != '') {
                    $css .= ' div.painel_cont > div.cell_desativado_'.$item['idt'].' > span {';

                    if ($texto_font_tam != '') {
                        $css .= ' font-size: '.$texto_font_tam.'px;';
                    }

                    if ($texto_desativ_font_cor != '') {
                        $css .= ' color: #'.$texto_desativ_font_cor.';';
                    }

                    if ($texto_desativ_fundo != '') {
                        $css .= ' background-color: #'.$texto_desativ_fundo.';';
                    }

                    $css .= ' }';
                }

                echo '<div class="'.$class.'" id="'.$item['cod_funcao'].'" data-prefixo="'.$des_prefixo.'" data-idt="'.$item['idt'].'" title="'.$hint.'" style="xleft: '.$item['pos_left'].'px; xtop: '.$item['pos_top'].'px; float: left;">';

                if ($row['move_item'] == 'S') {
                    echo '<img class="move_item" src="imagens/bt_move.png" title="Mover o item na tela"/>';
                }

                if ($row['mostra_item'] == 'IT' || $row['mostra_item'] == 'SI') {
                    echo '<div>';

                    if ($item['imagem_d'] == '') {
                        $item['imagem_d'] = $item['imagem'];
                    }

                    ImagemMostrarPainel($row['img_largura'], $row['img_altura'], $path, $item['imagem'], $hint, 'class="img_ativado"');
                    ImagemMostrarPainel($row['img_argura'], $row['img_altura'], $path, $item['imagem_d'], $hint, 'class="img_desativado"');

                    echo '</div>';
                }

                if ($row['mostra_item'] == 'IT' || $row['mostra_item'] == 'ST') {
                    echo "<span><div>".$texto_cab."</div></span>";
                }

                echo '</div>';
            }
        }


        echo '</div>';

        $tmp = $path_inc.$row['codigo'].'_dep.php';
        if (file_exists($tmp)) {
            Require_Once($tmp);
        }
    }
	
	
	// Tema especifico para o painel    
	$tmp = $path_inc_sistema;
	if (file_exists($tmp)) {
		Require_Once($tmp);
	}
    // Tema especifico para o painel    
	$tmp = $path_inc.'tema.php';
	if (file_exists($tmp)) {
		Require_Once($tmp);
	}
	

	
    echo '<style type="text/css">';
	echo $css;
	echo '</style>';

    if (is_array($primeiro_passo)) {
        $menu = $primeiro_passo['menu'];
        $prefixo = $primeiro_passo['prefixo'];

        $_GET['menu'] = $menu;
        $_REQUEST['menu'] = $menu;

        $_GET['prefixo'] = $prefixo;
        $_REQUEST['prefixo'] = $prefixo;

        if (is_array($primeiro_passo['extra'])) {
            foreach ($primeiro_passo['extra'] as $key => $value) {
                $_GET[$key] = $value;
                $_REQUEST[$key] = $value;
            }
        }

        if ($prefixo == 'listar' || $prefixo == 'listar_rel') {
            $Require_Once = "listar.php";
        } else if ($prefixo == 'cadastro') {
            $Require_Once = "cadastro.php";
        } else if ($prefixo == 'relatorio') {
            $Require_Once = "relatorio/$menu.php";
        } else {
            $Require_Once = "$prefixo$menu.php";
        }

        if (file_exists($Require_Once)) {
            Require_Once($Require_Once);
        }
    }

    if ($row['passo'] == 'S' && $row['passo_tit'] == 'S' && $passo_tit != '') {
        echo '<div class="painel_grupo">'.$passo_tit.'</div>';
    }
}

$sql = $sql_listar;


if ($_SESSION[CS]['g_mostra_pk'] == 'S') {
        ?>
    	 <div id="mostra_pk" style=''>
        	
			<a href="conteudo.php?prefixo=inc&menu=plu_funcao_seg&ondeestou=<?php echo $menu_inicial; ?>&origem_tela=painel&des_pk=<?php echo $vlID; ?>">
                FUNÇÃO: <?php echo $vlID; ?>
            </a>
        </div>
		
		
        <?php
    }
