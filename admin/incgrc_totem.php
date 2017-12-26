<style>
div#painel_cont {
    xborder: 1px solid;
    margin-left: 30px;
}

div#painel_cont > div.cell > span > div {
    padding-top:15px;
}

div#painel_cab {
    border: 1px solid;
    background:#0000ff;
    xmargin-left: 30px;
    color:#FFFFFF;
    text-align:center;
}
div#painel_rod {
    border: 1px solid;
    xmargin-left: 38px;
    background:#0000ff;
    color:#FFFFFF;
    text-align:center;
}



div.bt_volta_painel {
    Xborder: 1px solid;
    xmargin-left: 38px;
    background:#ECF0F1;
    color:#000000;
    text-align:left;
}

.bt_volta_painel {
    Xborder: 1px solid;
    xmargin-left: 38px;
    background:#ECF0F1;
    color:#000000;
    text-align:left;

}


Input.Botao {

    border: 1px solid transparent;
    padding-left:10px;
    background:#C4C9CD;
    color:#FFFFFF;


}

</style>



<?php
   $acao           = 'inc';
   $menu           = 'grc_atendimento_avulso';
  // $prefixo        = 'listar';
   $prefixo        = 'cadastro';
   $_GET['acao']   = "inc";
   $_GET['menu']   = $menu;
   $_GET['prefixo']= $prefixo;
   $_REQUEST['acao']   = "inc";
   $_REQUEST['menu']   = $menu;
   $_REQUEST['prefixo']= $prefixo;
   $_GET['id']=0;
   $_GET['idt0']=$_SESSION[CS]['g_idt_unidade_regional'];

  // p($_GET);
//   $Require_Once  = "listar.php";
   $Require_Once  = "cadastro_p.php";
   if (file_exists($Require_Once)) {
    	Require_Once($Require_Once);
   } else {
        //exit();
   }
