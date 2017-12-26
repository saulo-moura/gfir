<style type="text/css">

   div#ssssconteudo {
        padding:0px;
        margin:0px;
        margin-top:5px;
        margin-left:10px;
        width:685px;
    }

    div#ssssconteudo img {
        text-align:center;

    }
    

    
    div#link_e_doc  {

       swidth:685px;
       height: 80px;
       background:#C0C0C0;
       cursor:pointer;

       margin-bottom:20px;
       text-align:center;
       padding-top:10px;
    }
    div#link_e_doc  a {
       text-decoration:none;
       font-family : Arial, Helvetica, sans-serif;
       font-style: normal;
       font-size: 14px;
       font-weight: bold;
       color:#CC0000;


    }


</style>

<?php


//$linkw ='conteudo_posicao_peca.php?prefixo=inc&menu=posicao_peca&print=s&lupa=s&titulo_rel=&ampliar=S&origem=S';
$linkw = $vetConf['LINK_SGC'];
echo "<div id='link_e_doc' > ";
if ($linkw!='')
{
    echo "<span style='text-align:center; padding-bottom:5px; font-weight: bold; font-size:16px; color:#FFFFFF; '>Essa Função possibilita acessar o sistema SGC - Sistema de Gestão de Contratos para utilização da funcionlidade de Exportação de um contrato do sistema SGC para o PCO.</span>";
    echo '<a href="'.$linkw.'" target="_blank" title="Clique aqui para acessar SGC - Sistema de Gestão de Contratos"><br /><br />Clique aqui para acessar SGC - Sistema de Gestão de Contratos</a>';
}
else
{
    echo '<a  title="Clique aqui para acessar SGC - Sistema de Gestão de Contratos"><br /><br />Sem parametrização do LINK para acessar SGC - Sistema de Gestão de Contratos</a>';
}
echo "</div>";



$url_volta = 'conteudo'.$cont_arq.'.php';
echo ' <div id="voltar_full_m">';
echo ' <div class="voltar">';
echo '         <img src="imagens/menos_full_PCO.jpg" title="Voltar"  alt="Voltar" border="0" onclick="self.location = '."'".$url_volta."'".'" style="cursor: pointer;">';
echo ' </div>';
echo ' </div>';
if ($linkw!='')
{
    /*
    echo " <script type='text/javascript'> ";
    echo " var  left       = 0; ";
    echo " var  top        = 0; ";
    echo " var  height     = $(window).height(); ";
    echo " var  width      = $(window).width(); ";
    echo " var link        = '{$linkw}'; ";
    echo ' autodoc         = window.open(link,"SistemaSGC","left="+left+",top="+top+",width="+width+",height="+height+",resizable=yes,menubar=no,scrollbars=yes,toolbar=no"); ';
    echo " autodoc.focus(); ";
    echo " </script> ";
    */
}
?>
