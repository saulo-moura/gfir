<?php
    //
    // gerar o PQO em PDF
    //


    $html  = '';
    $html .= "<html>";
    $html .= "<body style='font-size: 12px; background: #FFFFFF; font-weight:normal; font-style:italic; font-family : Arial, Helvetica, sans-serif;''>";
    $html .= '<header>';
    $html .= '</header>';

    $html .= '<style type="text/css">';
    $html .= 'div#indice { ';
    $html .= 'font-family : Arial, Helvetica, sans-serif;';
    $html .= 'font-size: 12px; ';
   // $html .= 'font-style: normal;';
    $html .= 'font-weight: normal; ';
    $html .= 'font-style:italic; ';
    $html .= 'color:#000000;';
    $html .= 'background: #FFFFFF;';
    $html .= 'width:100%;';
    $html .= 'height:100%;';
    $html .= '} ';


    $html .= 'div#capa { ';
    $html .= 'font-family : Arial, Helvetica, sans-serif;';
    $html .= 'font-size: 12px; ';
    $html .= 'font-style: normal;';
    $html .= 'font-weight: bold; ';
    $html .= 'font-style:italic; ';
    $html .= 'color:#000000;';
    $html .= 'background: #FFFFFF;';
    $html .= 'width:100%;';
    $html .= 'height:100%;';
    $html .= '} ';

    $html .= 'div#revisoes { ';
    $html .= 'font-family : Arial, Helvetica, sans-serif;';
    $html .= 'font-size: 12px; ';
    $html .= 'font-style: normal;';
    $html .= 'font-weight: bold; ';
    $html .= 'font-style:italic; ';
    $html .= 'color:#000000;';
    $html .= 'background: #FFFFFF;';
    $html .= 'width:100%;';
    $html .= 'height:100%;';
    $html .= '} ';

    $html .= 'div#revisoes1 { ';
    $html .= 'font-family : Arial, Helvetica, sans-serif;';
    $html .= 'font-size: 12px; ';
    $html .= 'font-style: normal;';
    $html .= 'font-weight: bold; ';
    $html .= 'font-style:italic; ';
    $html .= 'color:#000000;';
    $html .= 'background: #FFFFFF;';
    $html .= 'padding-top:100px;';
    $html .= '} ';

    $html .= 'div#revisoes2 { ';
    $html .= 'font-family : Arial, Helvetica, sans-serif;';
    $html .= 'font-size: 12px; ';
    $html .= 'font-style: normal;';
    $html .= 'font-weight: bold; ';
    $html .= 'font-style:italic; ';
    $html .= 'color:#000000;';
    $html .= 'background: #FFFFFF;';
    $html .= 'padding-top:200px;';
    $html .= '} ';

    $html .= 'div#indice { ';
    $html .= 'font-family : Arial, Helvetica, sans-serif;';
    $html .= 'font-size: 12px; ';
    $html .= 'font-style: normal;';
    $html .= 'font-weight: normal; ';
    $html .= 'font-style:italic; ';
    $html .= 'color:#000000;';
    $html .= 'background: #FFFFFF;';
    $html .= 'width:100%;';
    $html .= 'height:100%;';
    $html .= '} ';

    $html .= 'div#corpo_geral { ';
    $html .= 'font-family : Arial, Helvetica, sans-serif;';
    $html .= 'font-size: 12px; ';
    $html .= 'font-style: normal;';
    $html .= 'font-weight: bold; ';
    $html .= 'font-style:italic;';
    $html .= 'color:#000000;';
    $html .= 'background: #FFFFFF;';
    //$html .= 'width:100%;';
    //$html .= 'height:100%;';
    $html .= '} ';

    $html .= 'div#anexos { ';
    $html .= 'font-family : Arial, Helvetica, sans-serif;';
    $html .= 'font-size: 12px; ';
    $html .= 'font-style: normal;';
    $html .= 'font-weight: bold; ';
    $html .= 'font-style:italic;';
    $html .= 'color:#000000;';
    $html .= 'background: #FFFFFF;';
    $html .= 'width:100%;';
    $html .= 'height:100%;';
    $html .= '} ';

    $html .= '.linha_campo_td { ';
    $html .= 'font-family : Arial, Helvetica, sans-serif;';
    $html .= 'font-size: 12px; ';
    $html .= 'font-weight: normal; ';
    $html .= 'font-style:italic;';
    $html .= 'color:#000000;';
    $html .= 'background: #FFFFFF;';
    //$html .= 'width:100%;';
    //$html .= 'height:100%;';
    $html .= '} ';
    $html .= '.linha_campo_td td { ';
    $html .= 'font-family : Arial, Helvetica, sans-serif;';
    $html .= 'font-size: 12px; ';
    $html .= 'font-weight: normal; ';
    $html .= 'font-style:italic;';
    $html .= 'color:#000000;';
    $html .= 'background: #FFFFFF;';
    //$html .= 'width:100%;';
    //$html .= 'height:100%;';
    $html .= '} ';

    $html .= '</style>';



    $retw = 0;

    $titulo  = 'Titulo do pdf';
    $assunto = 'assunto do PDF';

   // ini_set("memory_limit", "32M");
    ini_set('memory_limit', '-1');
   // ini_set("memory_limit", "24M");


    $idt_versao_pqo =$_GET['id_versao'];

    $kwherew = ' where iovpqo.idt = '.null($idt_versao_pqo);
    $sql     = 'select ';
    $sql    .= ' iovpqo.* , nome_completo, iop.*, em.descricao as em_descricao, em.idt as em_idt , em.imagem as em_imagem ';
    $sql    .= ' from  ';
    $sql    .= ' qu_indice_obra_versao_pqo iovpqo ';
    $sql    .= ' inner join qu_indice_obra_pqo as iop on iop.idt_versao = iovpqo.idt ';
    $sql    .= ' inner join usuario as us on us.id_usuario = idt_responsavel ';
    $sql    .= ' inner join empreendimento as em on em.idt = iovpqo.idt_empreendimento ';
    $sql    .= $kwherew;
    $sql    .= ' order by numero ';
    $rs = execsql($sql);
    $numero = '';
    $pri = 0;
    if ($rs->rows == 0)
    {
        $html .= "<div id='marca_fundo' style='text-align:justify; background:#C0C0C0;' >";
        $html .='<a> PQO sem elementos cadastrados</a>';
        //$html .=$sql ;
        $html .= "</div>";
    }
    else
    {
        // CAPA
        $em_idt=0;
        ForEach($rs->data as $row)
        {
           $data         = trata_data($row['data']);
           $revisao      = $row['revisao'];
           $responsavel  = $row['nome_completo'];
           $aprovacao    = $row['aprovacao'];
           $observacao   = $row['observacao'];
           $em_descricao = $row['em_descricao'];
           $em_idt       = $row['em_idt'];
           $em_imagem    = $row['em_imagem'];
           $data_atual   = $row['data'];

           $fonte = 'getimagem.php';
           $path='imagens/capa_pqo.jpg';
           $texto='PLANO DE QUALIDADE DA OBRA';
           $texto2='Obra: '.$em_descricao;
           $texto_x=0;
           $texto_y=440;
           $font    = 'arialnbi.ttf';
           $font_tam=25;
           $cor_t_r='255';
           $cor_t_g='255';
           $cor_t_b='255';
           $imp_txt='S';
           $nome='PQO';
           // $foto='obj_file/empreendimento/'.$em_imagem;
           $foto='';

           $parametros = '';
           $parametros .=$fonte.'?';
           $parametros .='path='.$path;
           $parametros .='&texto='.$texto;
           $parametros .='&texto2='.$texto2;
           $parametros .='&texto_x='.$texto_x;
           $parametros .='&texto_y='.$texto_y;
           $parametros .='&font='.$font;
           $parametros .='&font_tam='.$font_tam;
           $parametros .='&cor_t_r='.$cor_t_r;
           $parametros .='&cor_t_g='.$cor_t_g;
           $parametros .='&cor_t_b='.$cor_t_b;
           $parametros .='&imp_txt='.$imp_txt;
           $parametros .='&nome='.$nome;
           $parametros .='&foto='.$foto;

           $_GET['path'] = $path;
           $_GET['texto'] = $texto;
           $_GET['texto2'] = $texto2;
           $_GET['texto_x'] = $texto_x;
           $_GET['texto_y'] = $texto_y;
           $_GET['font'] = $font;
           $_GET['font_tam'] = $font_tam;
           $_GET['cor_t_r'] = $cor_t_r;
           $_GET['cor_t_g'] = $cor_t_g;
           $_GET['cor_t_b'] = $cor_t_b;
           $_GET['imp_txt'] = $imp_txt;
           $_GET['nome'] = $nome;
           $_GET['foto'] = $foto;
           $_GET['arq_img'] = "capa_pqo_{$em_idt}_{$idt_versao_pqo}.jpg";

           require 'getimagem.php';

           $html .= "<div id='capa'  >";
           $html .= "      <img src='tmp_img/".$_GET['arq_img']."' border='0'>";
           //$html .= "      <img src='{$parametros}' border='0'>";


           $html .= "</div>";
           break;
        }

        // Revisões
        $kwherew = ' where iovpqo.idt_empreendimento = '.null($em_idt);
        $sqlx     = 'select ';
        $sqlx    .= ' iovpqo.* , nome_completo  ';
        $sqlx    .= ' from  ';
        $sqlx    .= ' qu_indice_obra_versao_pqo iovpqo ';
        $sqlx    .= ' inner join usuario as us on us.id_usuario = idt_responsavel ';
        $sqlx    .= $kwherew;
        $sqlx    .= ' order by data ';
        $rsx = execsql($sqlx);

        $html .= "<div id='revisoes'  >";
        ForEach($rsx->data as $rowx)
        {
            $html .= "<div id='revisoes1'  >";
            $html .= "<table id='datatable' class='tabela_lista' width='100%' border='0' cellspacing='0' cellpadding='0' vspace='0' hspace='0'> ";
            $html .= "<tr class='cabecalho_lista' style='font-size:13px;'>  ";
            $html .= "   <td class='cabecalho_campo' style=' font-family: Arial; font-size:13px; font-style:italic; font-weight:bold; padding-left:20px; border:0; text-align:left; sborder-left:1px solid #FFFFFF; sborder-top:1px solid #FFFFFF; border-bottom:1px solid #FFFFFF; border-right:1px solid #666666; width:200px; background:#999999; color:#FFFFFF;' >Empreendimento:</td> ";
            $html .= "   <td class='cabecalho_campo' style=' font-family: Arial; font-size:13px; font-style:italic; font-weight:normal; padding-left:20px; border:0; text-align:left; border-left:1px solid #666666; border-top:1px solid #666666; border-bottom:1px solid #666666; sborder-right:1px solid #666666;' >{$em_descricao}</td> ";
            $html .= " </tr> ";
            $html .= "<tr class='cabecalho_lista' style='font-size:13px;'>  ";
            $html .= "   <td class='cabecalho_campo' style=' font-family: Arial; font-size:13px; font-style:italic; font-weight:bold; padding-left:20px; border:0; text-align:left; sborder-left:1px solid #666666; border-bottom:1px solid #FFFFFF; border-right:1px solid #666666; width:200px; background:#999999; color:#FFFFFF;' >Elaboração:</td> ";
            $html .= "   <td class='cabecalho_campo' style=' font-family: Arial; font-size:13px; font-style:italic; font-weight:normal; padding-left:20px; border:0; text-align:left; border-left:1px solid #666666; border-bottom:1px solid #666666; sborder-right:1px solid #666666;' >{$responsavel}</td> ";
            $html .= " </tr> ";
            $html .= "<tr class='cabecalho_lista' style='font-size:13px;'>  ";
            $html .= "   <td class='cabecalho_campo' style=' font-family: Arial; font-size:13px; font-style:italic; font-weight:bold; padding-left:20px; border:0; text-align:left; sborder-left:1px solid #666666; sborder-bottom:1px solid #666666; border-right:1px solid #666666; width:200px; background:#999999; color:#FFFFFF;' >Aprovação:</td> ";
            $html .= "   <td class='cabecalho_campo' style=' font-family: Arial; font-size:13px; font-style:italic; font-weight:normal; padding-left:20px; border:0; text-align:left; border-left:1px solid #666666; border-bottom:1px solid #666666; sborder-right:1px solid #666666;' >{$aprovacao}</td> ";
            $html .= " </tr> ";
            $html .= "</table>";
            $html .= "</div>";
            break;

        }


        $html .= "<div id='revisoes2'  >";
        $html .= "<table id='datatable' class='tabela_lista' width='100%' border='0' cellspacing='0' cellpadding='0' vspace='0' hspace='0'> ";
        $html .= "<tr class='cabecalho_lista' style='font-style:italic; font-weight:normal; font-size:22px; color:#FFFFFF;'>  ";
        $html .= "   <td class='cabecalho_campo' style=' font-family: Arial; font-style:italic; font-size:22px; color:#FFFFFF; background:#999999;  padding-left:20px; border:0; text-align:center; ' >Histórico das Revisões</td> ";
        $html .= " </tr> ";
        $html .= "</table>";

        $html .= "<table id='datatable' class='tabela_lista' width='100%' border='0' cellspacing='0' cellpadding='0' vspace='0' hspace='0'> ";
        $html .= "<tr class='cabecalho_lista' style='background:#900000; font-style:italic; font-size:13px; font-weight:normal; '>  ";
        $html .= "   <td class='cabecalho_campo' style=' font-family: Arial; font-style:italic; color:#FFFFFF; padding-left:20px; sborder-left:1px solid #666666; border-bottom:1px solid #666666; border-right:1px solid #666666; text-align:center; width:200px;' >Revisão</td> ";
        $html .= "   <td class='cabecalho_campo' style=' font-family: Arial; font-style:italic; color:#FFFFFF; padding-left:20px; border-bottom:1px solid #666666; border-right:1px solid #666666; text-align:center;' >Comentários</td> ";
        $html .= "   <td class='cabecalho_campo' style=' font-family: Arial; font-style:italic; color:#FFFFFF; padding-left:20px; border-bottom:1px solid #666666; sborder-right:1px solid #666666; text-align:center;' >Data</td> ";
        $html .= " </tr> ";
        ForEach($rsx->data as $rowx)
        {
           if ($rowx['data'] > $data_atual)
           {
               break;
           }
           $data         = trata_data($rowx['data']);
           $revisao      = $rowx['revisao'];
           $responsavel  = $rowx['responsavel'];
           $observacao   = $rowx['observacao'];

           $html .= "<tr class='linha_lista' style='font-size:13px;'>  ";
           $html .= "   <td class='linha_campo' style=' font-family: Arial; font-style:italic; font-size:13px; font-weight:normal; padding-left:20px; sborder-left:1px solid #666666; border-bottom:1px solid #666666; border-right:1px solid #666666; text-align:center; width:200px;' >{$revisao}</td> ";
           $html .= "   <td class='linha_campo' style=' font-family: Arial; font-style:italic; font-size:13px; font-weight:normal; padding-left:20px; border-bottom:1px solid #666666; border-right:1px solid #666666; text-align:left;' >{$observacao}</td> ";
           $html .= "   <td class='linha_campo' style=' font-family: Arial; font-style:italic; font-size:13px; font-weight:normal; padding-left:20px; border-bottom:1px solid #666666; sborder-right:1px solid #666666; text-align:center;' >{$data}</td> ";
           $html .= " </tr> ";
        }
        $html .= "</table>";
        $html .= "</div>";

        $html .= "</div>";



        //$html .= "<div id='indice1' style='text-align:justify; background:#FFFFFF;' >";
        $indice   = "<div style='text-decoration: underline;  font-family: Arial;  font-size:15px;  font-weight:bold; padding-top:40px; padding-bottom:40px;  text-align:center; background:FFFFFF; display:block; width:100%;'>";
        // $indice  .= utf8_encode("ÍNDICE");
        $indice  .= "ÍNDICE";
        $indice  .= "</div>";
        $html    .= $indice;


        $html .= "<div id='indice' style='padding-left:40px; text-align:justify; background:#FFFFFF;' >";

        ForEach($rs->data as $row)
        {
           $numero       = $row['numero'];
           $flag_numero  = $row['flag_numero'];
           $titulo       = $row['titulo'];
           $revisao      = $row['revisao'];
           $em_descricao = $row['em_descricao'];
           if (substr($numero,0,1)=='0')
           {
              $numero=str_replace('0','',$numero);
           }

           $nivel        = 0;
           $vetni        = Array();
           $vetni        = explode('.',$numero);
           $nivel        = count($vetni);

           if ($vetni[1]=='')
           {
               $numerow  = "<div style='float:left; font-family: Arial; font-weight:bold; font-size:13px; display:block; width:40px;'>";
               $numerow .= $numero;
               $numerow .= "</div>";
           }
           else
           {
               $numerow  = "<div style='float:left; font-family: Arial; font-weight:bold; font-size:13px; padding-left:15px; display:block; width:35px;'>";
               $numerow .= $numero;
               $numerow .= "</div>";
           }

           $xx           = "<div style='float:left; font-family: Arial; font-size:13px; font-weight:bold; margin-left:5px; display:block;'>";
           // $xx1          = utf8_encode($titulo);
           $xx1          = $titulo;
           $xx          .= mb_strtoupper($xx1);
           $xx          .= "</div>";


           $linha        = "<div style='display:block; width:100%; margin-bottom:10px;'>";
           if ($flag_numero!='N')
           {
               $html        .= $linha;
               $html        .= $numerow.' '.$xx;
               $html        .= "</div>";
           }
        }
        $html .= "</div>";

        // agora o detalhe de cada item


        $html .= "<div id='corpo_geral'  >";

        ForEach($rs->data as $row)
        {
           $numero       = $row['numero'];
           $flag_numero  = $row['flag_numero'];
           $titulo       = $row['titulo'];
           $revisao      = $row['revisao'];
           $em_descricao = $row['em_descricao'];
           $texto_padrao = $row['texto_padrao'];
           $imagem       = $row['imagem'];
           $pagina       = $row['pagina'];
           $origem       = $row['origem'];

           $texto_complementar = $row['texto_complementar'];
           $arquivo            = $row['arquivo'];
           if (substr($numero,0,1)=='0')
           {
              $numero=str_replace('0','',$numero);
           }
           $nivel        = 0;
           $vetni        = Array();
           $vetni        = explode('.',$numero);
           $nivel        = count($vetni);

           if ($pagina=='S')
           {   // quebra pagina
               $html .= "</div>";
               $html .= "<div id='anexos'  >";
               $html .= "<br />";
               $html .= "</div>";
               $html .= "<div id='anexos'  >";
               //$html .= "GGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGG";
           }

           if ($vetni[1]=='')
           {
               $numerow  = "<div style='float:left; font-family: Arial; font-weight:bold; padding-left:20px; display:block; width:30px;'>";
               $numerow .= $numero;
               $numerow .= "</div>";
           }
           else
           {
               $numerow  = "<div style='float:left;  font-family: Arial; font-weight:bold; display:block; width:30px;'>";
               $numerow .= $numero;
               $numerow .= "</div>";
           }

           $xx           = "<div style='font-size:14px; float:left; font-family: Arial; font-weight:bold; margin-left:5px; display:block;'>";
           // $xx1          = utf8_encode($titulo);
           $xx1          = $titulo;
           $xx          .= mb_strtoupper($xx1);
           $xx          .= "</div>";

           if ($flag_numero!='N')
           {
               $linha        = "<div style='display:block; width:100%; padding-top:20px;'>";
               $html        .= $linha;
               $html        .= $numerow.' '.$xx;
               $html        .= "</div>";
           }

           $html        .= "<div style='font-size:13px; font-family: Arial; font-weight:normal; display:block; width:100%; '>";
           $texto_padrao = str_replace('small','13px;',$texto_padrao);
           $texto_padrao = str_replace('medium','15px;',$texto_padrao);
           $html        .= $texto_padrao;
           $html        .= "</div>";



           if ($imagem!='')
           {  // mostrar imagem
              $arw='obj_file/qu_indice_pqo/'.$imagem;
              if ($origem=='OBRA')
              {
                  $arw='obj_file/qu_indice_obra_pqo/'.$imagem;
              }
              
              
              $html .= "<br />";
              $html     .= "<div style='font-size:12px; font-weight:normal; display:block; width:100%; '>";
              $html     .= "      <img src='{$arw}' border='0'>";
              $html     .= "</div>";
           }

           if ($texto_complementar!='')
           {
               $html        .= "<div style='font-size:13px; font-family: Arial; font-weight:normal; display:block; width:100%; '>";
               $texto_complementar = str_replace('small','13px;',$texto_complementar);
               $texto_complementar = str_replace('medium','15px;',$texto_complementar);

               $html        .= $texto_complementar;
               $html        .= "</div>";
           }
        }
        $html .= "</div>";
    }
    //  $html .='<a> guy</a>';
    //$html .= "</div>";
    $html .= "</body>";
    $html .= "</html>";
    //$html ='<a> guy</a>';


    $html = utf8_encode($html);

    include(lib_mpdf."mpdf.php");

   // $mpdf=new mPDF();

   $data_emissao=date('d/m/Y H:i:s');


//   if ($sc_codigo != '04' and $sc_codigo != '05' )
//   {
//       $txt_rodape = utf8_encode('Documento Provisório Emitido em '.$data_emissao.' Número: '.$numero);
//   }
//   else
//   {
       $txt_rodape = utf8_encode('Emitido em '.$data_emissao.'  Revisão: '.$revisao);
//   }

  $txt_rodape_left   = utf8_encode('PQO - Plano de Qualidade da Obra '.$em_descricao);
  $txt_rodape_center = utf8_encode('Revisão: '.$revisao);
  $txt_rodape_right  = utf8_encode('Emitido em '.$data_emissao.'     Pg.:'.'{PAGENO}'.' de '.'[pagetotal]');

  $cabec = $txt_rodape_left.'     '.$txt_rodape_center;

  $footer = array (
  'odd' => array (
    'L' => array (
      'content' => '',
      'font-size' => 10,
      'font-style' => 'N',
      'font-family' => 'arial',
      'color'=>'#000000'
    ),
    'C' => array (
      'content' => '',
      'font-size' => 10,
      'font-style' => 'N',
      'font-family' => 'arial',
      'color'=>'#000000'
    ),
    'R' => array (
      'content' => $txt_rodape_right,
      'font-size' => 10,
      'font-style' => 'N',
      'font-family' => 'arial',
      'color'=>'#000000'
    ),
    'line' => 1,
  ),
  'even' => array ()
);

  //echo $html; exit();

   // $mpdf=new mPDF('s');

    $mpdf = new mPDF('',    // mode - default ''
	 '',    // format - A4, for example, default ''
	 0,     // font size - default 0
	 '',    // default font family
	 15,    // margin_left
	 15,    // margin right
	 16,     // margin top
	 16,    // margin bottom
	 9,     // margin header
	 9,     // margin footer
	 'P');  // L - landscape, P - portrait


   // $mpdf->progbar_heading = 'Gerando PDF... Aguarde';
   // $mpdf->StartProgressBarOutput(2);


    $mpdf->SetDisplayMode('fullpage');
    $mpdf->AliasNbPages('[pagetotal]');
 //   $mpdf->SetHeader(utf8_encode('PQO    Pg.:'.'{PAGENO}'.' de '.'[pagetotal]'));

    $mpdf->SetHeader($cabec);
    //$mpdf->SetHTMLHeader();

   // $mpdf->AddPage();
    $mpdf->AddPage('P');
    $mpdf->SetFooter($footer);

    //$footer = '<table class="rodape"><tr><td>33.005 v020 micro</td><td align="right">{PAGENO}</td></tr></table>';
    //$mpdf->SetHTMLFooter($footer);
    //$mpdf->SetHTMLFooter($footer, 'E');

    $mpdf->WriteHTML($html);
    //
    $arquivo='obj_file/qu_indice_pqo/'.$em_idt.'_'.$idt_versao_pqo.'.pdf';
    $mpdf->Output( $arquivo ); // grava em disco
    $mpdf->Output();  // exibe em tela
    exit();



  /*

    //$html = 'alo Guy';
    $dompdf = new DOMPDF();
    $dompdf->load_html($html);
  // $dompdf->set_paper('letter', 'portrait');
    $dompdf->set_paper('a4', 'portrait');
    $dompdf->render();
    $pdf = $dompdf->output();

    $nomearquivo='contrato_'.$numero.'.pdf';
    $arquivo=$nomearquivo;
    $dompdf->stream($arquivo);

//  file_put_contents($arquivo, $pdf);
    */


   // return $retw;
/*
    O objeto load_html é responsável por receber o conteúdo HTML e fazer a conversão.
    O objeto set_paper é responsável pela configuração do papel (formato) do arquivo pdf. No primeiro argumento, você escolhe o tamanho de cada folha; no segundo argumento, você escolhe se quer cada folha em paisagem ou fotografia.

    No Parâmetro 1 você pode preencher com:4a0, 2a0, a0...a10, b0...b10, c0...c10, ra0...ra4, sra0...sra4, letter, legal, ledger, tabloid, executive, folio, commerical #10 envelope, catalog #10 1/2 envelope, 8.5x11, 8.5x14 e11x17.
    No Parâmetro 2 você pode preencher com: portrait ou landscape.

    O objeto render é responsável por imprimir, no documento, o código correspondente ao PDF e exibi-lo no browser.
    O objeto stream é opcional. Se ele for setado, vai forçar o download do documento com o nome que você passar, caso contrário o documento será exibido na tela.
*/




?>


<script type="text/javascript">

    var L = (screen.width) ;
    var T = (screen.height);

    var url = 'conteudo_pdf?html=' + '<?php echo $html ?>';
    alert(' estou nela ');
    teste();
   // alert(' vvvvv '+url);

    OpenWin(url, 'PDF', 0, 0, T, L);
</script>



