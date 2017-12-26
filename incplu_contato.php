<?php
//echo ' bbbbbbbbbbbbbbbbbbbbbbbbbbb  entrou ';




$nome = $_SESSION[CS]['g_nome_completo'];
$email = $_SESSION[CS]['g_email'];
$telefone = '';

$erro = '5';


switch ($_POST['btnAcao']) {
    case 'Enviar':
        $sql = "select
                    idt_responsavel,
                    descricao,
    				email
    			from 
    				plu_contato
    			where
    				idt = ".$_POST['fale'];
        $rs = execsql($sql);
        $row = $rs->data[0];

        $msg = "Setor para contato: ".$row['descricao']."<br>";
        $msg .= "Nome: ".$_POST['nome']."<br>";
        $msg .= "Telefone: ".$_POST['telefone']."<br>";
        $msg .= "E-Mail: ".$_POST['email']."<br>";
        $msg .= "Mensagem: ".$_POST['detalhe']."<br>";

        $respEmail = enviarEmail(db_pir_gec, "[$sigla_site] Fale Conosco", $msg, $row['email'], $row['descricao'], false, $semuso, $_POST['email'], $_POST['nome']);
        $erro = '0';

        if ($respEmail !== true) {
            $erro = '1';
            echo "<script type='text/javascript'>alert('Erro na transmissão.\\nTente outra vez!\\n\\n".trata_aspa($respEmail)."');</script>";
        }
        break;
}

$varCampos = array("frm",
    "fale", "Setor",
    "nome", "Nome",
    "telefone", "Telefone",
    "email", "e-Mail",
    "detalhe", "Mensagem"
);
camposObrigatorios($varCampos);
onLoadPag("fale");


$btretorna = "<input type='button' value='Retornar' name='btretornar' id='btretornar' style='width:150px; height:25px; margin-left:10px; cursor: pointer;'  onclick='desiste_duvida();'  />";
echo '<div id="barra"><div id="tela"><div class="tit_home">';
echo 'Fale conosco';
echo '&nbsp;&nbsp;</div></div></div>';


//echo $vetConf[$menu];





echo "<div id='home_fale'>";

echo "   <div id='home_fale_titulo'>";
//echo " <span> ";
//if ($erro=='5')
//{
//    echo "   Nessa função você pode enviar <b>e-mail</b> para Falar com a <b>oas empreendimentos</b>.<br>Preencha os campos solicitados abaixo e aguarde resposta de nossos técnicos que será enviada para o <b>seu e-mail</b>.";
//}

if ($erro == '1') {
    echo "<div id='home_fornecedor_titulo_erro'>";
    echo "ATENÇÃO...<br> Seu e-mail não pode ser enviado pelo sistema...";
    echo "</div>";
} else {
    if ($erro == '0') {
        echo "<div id='home_fornecedor_titulo_sucesso'>";
        echo "ATENÇÃO...<br> Seu e-mail foi enviado com sucesso...";
        echo "</div>";
    }
}

//echo " </span> ";

echo "   </div>";



echo "<form name='frm' action='conteudo.php? ".substr(getParametro(), 1)."' method='post' onSubmit='return frmFcn()'>";


echo "<table class='table_contato' width='100%' border='0' cellspacing='4' cellpadding='4' vspace='0' hspace='0'> ";

//echo "<fieldset>";

echo "<tr class='table_contato_linha'> ";
$setorlabelw = "<label for='telefone' >Setor para contato no <b>Sebrae</b><span>*</span>:&nbsp;</label>";
echo "   <td class='table_contato_celula_label'>{$setorlabelw}</td> ";
$sql = "select
				idt,
				descricao
			from
				plu_contato
			order by
				descricao";
$rs = execsql($sql);
//criar_combo_rs($rs, 'fale', '', '', '');
echo "   <td class='table_contato_celula_value'>";
criar_combo_rs($rs, 'fale', '', '', '');
echo "</td> ";
echo "</tr>";

echo "<tr class='table_contato_linha'> ";
$nomelabelw = "<label for='nome' >Seu Nome<span>*</span>:&nbsp;</label>";
echo "   <td class='table_contato_celula_label'>{$nomelabelw}</td> ";
$nomew = "<input class='Texto' type='text' name='nome' value='{$nome}' size='45' maxlength='80'><br>";
echo "   <td class='table_contato_celula_value'>{$nomew}</td> ";
echo "</tr>";

echo "<tr class='table_contato_linha'> ";
$emaillabelw = "<label for='email' >Seu e-mail<span>*</span>:&nbsp;</label>";
echo "   <td class='table_contato_celula_label'>{$emaillabelw}</td> ";
$emailw = "<input class='Texto' type='text' name='email' value='{$email}' size='45' maxlength='80' onblur='Valida_Email(email)'><br>";
echo "   <td class='table_contato_celula_value'>{$emailw}</td> ";
echo "</tr>";

echo "<tr class='table_contato_linha'> ";
$telefonelabelw = "<label for='telefone' >Seu Telefone<span>*</span>:&nbsp;</label>";
echo "   <td class='table_contato_celula_label'>{$telefonelabelw}</td> ";
$telefonew = "<input class='Texto' type='text' name='telefone' value='{$telefone}' maxlength='13' size='13' onblur='return Valida_Telefone(this)' onkeyup='return Formata_Telefone(this,event)'><br>";
echo "   <td class='table_contato_celula_value'>{$telefonew}</td> ";
echo "</tr>";

echo "<tr class='table_contato_linha'> ";
$mensagemlabelw = "<label for='telefone' >Sua Mensagem<span>*</span>:&nbsp;</label>";
echo "   <td class='table_contato_celula_label'>{$mensagemlabelw}</td> ";
$mensagemw = "<textarea class='Texto' name='detalhe' style='height: 100px; width: 350px;'></textarea><br>";
echo "   <td class='table_contato_celula_value'>{$mensagemw}</td> ";
echo "</tr>";

echo "</table >";

echo "<table class='table_contato' width='100%' border='0' cellspacing='4' cellpadding='4' vspace='0' hspace='0'> ";
$btconfirma = "<input type='submit' name='btnAcao' value='Enviar' onClick='valida = ".'"'."S".'"'."' style='width:150px; height:25px; margin-left:10px; cursor: pointer;'/>";
$btdesiste = "<input type='button' value='Desistir' name='btdesiste' id='btdesiste' style='width:150px; height:25px; margin-left:10px; cursor: pointer;'  onclick='desiste_altera_faleconosco();'  />";
$btretorna = "<input type='button' value='Retornar' name='btretornar' id='btretornar' style='width:150px; height:25px; margin-left:10px; cursor: pointer;'  onclick='desiste_duvida();'  />";


echo "<tr class='table_contato_linha'> ";
$msgrodapeobrigatoriow = '( * ) campo obrigatório';
echo "   <td class='table_contato_celula_msgrodape' >{$msgrodapeobrigatoriow}</td> ";
echo "</tr>";

echo "<tr class='table_contato_linha'> ";
echo "   <td class='table_contato_celula_btconfirmar' >{$btconfirma}{$btdesiste}{$btretorna}</td> ";
//echo "   <td class='table_contato_celula_btdesistir'>{$btdesiste}</td> ";
echo "</tr>";
echo "</table >";

//echo "</fieldset>";


echo "</form>";

echo "</div>";
