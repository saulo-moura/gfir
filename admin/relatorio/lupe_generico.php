<?php
///////////////////////////////    trilha

function lupe_realizacao_inscricao($idt_periodo,$municipio,$idt_programa,$cod_programa)
{

   //   p($idt_eve_periodo);

   if  ($idt_periodo=='')
   {
        // erro de parâmetro
        // exit()
   }
   //
   //  montar select
   //
   $kselectw = 'select count(*) as qtd_inscritos
               from   inscrito
               left join programa pr on idt_programa_inscrito=pr.idt';

   $kwherew=' where   idt_periodo='.$idt_periodo.' and pr.codigo='.aspa($cod_programa);

   if  ($municipio!='')
   {
       $kwherew=$kwherew.' and municipio_matricula='.aspa($municipio);
   }
   if  ($idt_programa!=-1)
   {
       $kwherew=$kwherew.' and idt_programa_inscrito='.$idt_programa;
   }
//   $korderbyw=' order by cod_ordem        ';
   $korderbyw=' ';


   $a=$kselectw.$kwherew.$korderbyw;

// p($a);
//  exit();

  $qtd_realizado=0;

  $ktabelaw = execsql($a);
  ForEach($ktabelaw->data as $row)
  {
       $qtd_realizado=$qtd_realizado+$row['qtd_inscritos'];
  }

//   p($qtd_realizado);
//   exit();


   return $qtd_realizado;
}


function lupe_quantidade_municipios_inscricao($idt_periodo,$idt_programa)
{
  //   p($idt_eve_periodo);

   if  ($idt_periodo=='')
   {
        // erro de parâmetro
        // exit()
   }
   //
   //  montar select
   //

   $kselectw = 'select   count(distinct num_municipio) as qtd_municipios_inscricao from   periodo_municipio';


//   $kselectw = 'select distinct num_municipio, count(*) as qtd_municipios_inscricao
//               from   periodo_municipio  ';

   $kwherew=' where   idt_periodo='.$idt_periodo;


   if  ($idt_programa!=-1)
   {
       $kselw= 'select codigo from programa where idt= '.$idt_programa;
       $ktabelaw  = execsql($kselw);
       $cod_programa='';
       ForEach($ktabelaw->data as $row)
       {
             $cod_programa=$row['codigo'];
       }

       $kwherew=$kwherew.' and cod_programa='.aspa($cod_programa);



   }

  //p($kselw);
//p($idt_programa);
  //exit();


   $korderbyw=' ';

   $a=$kselectw.$kwherew.$korderbyw;

//p($a);
 // exit();

  $qtd_municipios=0;

  $ktabelaw = execsql($a);
  ForEach($ktabelaw->data as $row)
  {
       $qtd_municipios=$qtd_realizado+$row['qtd_municipios_inscricao'];
  }

//   p($qtd_realizado);
//   exit();



   return $qtd_municipios;
}

//
// quantidade de vagas por municipio / programa
//
function lupe_vagas($idt_periodo,$municipio,$idt_programa,$cod_programa)

//p($municipio);
//        exit();


{

   //   p($idt_eve_periodo);
   if  ($idt_periodo=='')
   {
      // erro de parâmetro
      // exit()
   }
   //
   //  Montar select
   //
   $kselectw = 'select sum(qtd_vagas_turma) as qtd_vagas
               from   periodo_let_prgr_muni_cur_turma as turma
               inner join periodo_letivo pelet on turma.idt_periodo=pelet.idt
               inner join periodo peins on pelet.idt_periodo=peins.idt
               left join programa pr on turma.programa=pr.codigo';
   $kwherew=' where   peins.idt='.$idt_periodo.' and pr.codigo='.aspa($cod_programa);

   if  ($municipio!='')
   {
       $kwherew=$kwherew.' and cod_municipio='.aspa($municipio);
   }
   if  ($idt_programa!=-1)
   {
 // tom      $kwherew=$kwherew.' and idt_periodo_let_programa='.$idt_programa;
             $kwherew=$kwherew.' and turma.programa='.aspa($cod_programa);
   }
   $korderbyw=' ';


   $a=$kselectw.$kwherew.$korderbyw;

//p($kwherew);


// p($a);
// exit();

  $qtd_vagas=0;

  $ktabelaw = execsql($a);
  ForEach($ktabelaw->data as $row)
  {
       $qtd_vagas=$qtd_vagas+$row['qtd_vagas'];

  }

 //  p($qtd_vagas);
//   exit();


   return $qtd_vagas;
}



















/////////////////////////////////////////////// do carnaval
/////// NOVAS FUNÇÕES
//mssql_select_db('badaue_rel', $con);

function LUPE_inicializa_combo_evento()
{
    $varw='CARNAVAL';
    return $varw;
}
function LUPE_inicializa_combo_periodo()
{
    $varw='2008';
    return $varw;
}
//
//  Críticas e Consistências para geração do XML para outros Sistemas
//
function lupe_consiste_parametros_xml_ocorrencias($usuariow,$senhaw,$eventow,$periodow,$opcaow,$dataw,$kpathw,$knomew)
{
    $kretow=1;
    $kbufferw='';
    $kbuffer_eerrosw='';
    // criticas
    $evento_trabw =$eventow -1000;         // evento
    $periodo_trabw=$periodow-1000;        // periodo
    //
    $sql = 'select evento.nom_evento from evento
     		where evento.idt_evento='.$evento_trabw;
    $rs = mssql_fetch_array(execsql($sql));
    if  ($rs==false)
    {
        $kbuffer_eerrosw=$kbuffer_eerrosw."Parâmetro Evento. Inválido".$eventow." eroos<br><br>";
        $kretow=0;
    }
    $sql = 'select evento_periodo.cod_periodo from evento_periodo
     		where evento_periodo.idt_eve_periodo='.$periodo_trabw;
    $rs = mssql_fetch_array(execsql($sql));
//  if  (mssql_num_rows($rs)==0)
    if  ($rs==false)
    {
        $kbuffer_eerrosw=$kbuffer_eerrosw."Parâmetro Período. Inválido".$periodo_trabw." erros<br><br>";
        $kretow=0;
    }
    if  ($opcaow!='T' && $opcaow!='D')
    {
          $kretow=0;
    }

    IF  ($kretow==0)
    {
//        $htm_filename='db_prodasal_siae.htm';
        $htm_filename=$kpathw.$knomew.".htm";
        echo "arquivo de erros ".$htm_filename;
        $htm_filehandle=fopen($htm_filename,'w') or die(" Não pode abrir o arquivo ");
        $kbufferw=$kbufferw."<HTML>";
        $kbufferw=$kbufferw."<TITLE>";
        $kbufferw=$kbufferw."SIAE - Transacional: Documentação<br>";
        $kbufferw=$kbufferw."Controle da geração de arquivo XML";
        $kbufferw=$kbufferw."</TITLE>";
        $kbufferw=$kbufferw."<BODY>";
        $kbufferw=$kbufferw."<br><br><br><br>";
        $kbufferw=$kbufferw."<br><br><br><br>";
        $kbufferw=$kbufferw."<p>";
        $kbufferw=$kbufferw."Opções para Geração <br><br>";
        $kbufferw=$kbufferw."Usuário: ".$usuariow."<br><br>";
        $kbufferw=$kbufferw."Evento : ".$eventow."<br><br>";
        $kbufferw=$kbufferw."Periodo: ".$periodow."<br><br>";
        $kbufferw=$kbufferw."Opção: ".$opcaow."<br><br>";
        $kbufferw=$kbufferw."Data: ".$dataw."<br><br>";
        $kbufferw=$kbufferw."Path: ".$kpathw."<br><br>";
        $kbufferw=$kbufferw."arquivo: ".$knomew."<br><br>";
        $kbufferw=$kbufferw."Função não pode ser executada. Exostem ".$quantidade_erros." eroos<br><br>";
        $kbufferw=$kbufferw."</p>";
        $kbufferw=$kbufferw."</BODY>";
        $kbufferw=$kbufferw."</HTML>";
        fwrite($htm_filehandle,$kbufferw);
        fclose($htm_filehandle);

        $htm_filename=$kpathw.$knomew."_retorno.xml";
        $htm_filehandle=fopen($htm_filename,'w') or die(" Não pode abrir o arquivo ");
        $kbufferw='';
        $kbufferw=$kbufferw."<?phpxml version='1.0' encoding='ISO-8859-1'?>";
        $kbufferw=$kbufferw."<BD_PRODASAL_SIAE xmlns:xsi='http://www.w3.org/2001/XMLSchema-instance' xsi:noNamespaceSchemaLocation='./BD_PRODASAL_SIAE_retorno.xsd'>";
        $kbufferw=$kbufferw."<xml_ocorrencias_retorno>";
        $kbufferw=$kbufferw."<xml_usuario>".$usuariow."</xml_usuario>";
        $kbufferw=$kbufferw."<xml_evento>".$eventow."</xml_evento>";
        $kbufferw=$kbufferw."<xml_periodo>".$periodow."</xml_periodo>";
        $kbufferw=$kbufferw."<xml_opcao>".$opcaow."</xml_opcao>";
        $kbufferw=$kbufferw."<xml_data>".$dataw."</xml_data>";
        $kbufferw=$kbufferw."<xml_path>".$kpathw."</xml_path>";
        $kbufferw=$kbufferw."<xml_arquivo>".$knomew."</xml_arquivo>";
        $kbufferw=$kbufferw."<xml_status>NÃO GERADO. COM PROBLEMAS</xml_status>";
        $kbufferw=$kbufferw."<xml_quantidade>0</xml_quantidade>";
        $kbufferw=$kbufferw."</xml_ocorrencias_retorno>";
        $kbufferw=$kbufferw."</BD_PRODASAL_SIAE >";
        fwrite($htm_filehandle,$kbufferw);
        fclose($htm_filehandle);
    }

    // consistências
    return $kretow;
}
//
//  gerar xml ocorrencias
//
function lupe_gera_xml_ocorrencias($usuariow,$senhaw,$eventow,$periodow,$opcaow,$dataw,$kpathw,$knomew)
{
   $varw=1;
   $evento_trabw =$eventow -1000;         // evento
   $periodo_trabw=$periodow-1000;        // periodo
//   p($evento_trabw);
//   p($periodo_trabw);
   // select
   $kselectw = 'select
                      ocorrencia.idt_ocorrencia,
                      ocorrencia.idt_pessoa,
                      ocorrencia.idt_orgao,
                      ocorrencia.idt_amb_eve_dia,
                      ocorrencia.idt_amb_local,
                      ocorrencia.idt_espetaculo,
                      ocorrencia.idt_entidade,
                      ocorrencia.idt_atracao,
                      ocorrencia.idt_local_trecho,
                      ocorrencia.dtc_registro,
                      ocorrencia.dtc_ocorrencia,
                      ocorrencia.hor_ocorrencia,
                      ocorrencia.idt_contexto,
                      ocorrencia.idt_foco,
                      ocorrencia.idt_tipo_ocorr,
                      ocorrencia.idt_ocorr_precad,
                      ocorrencia.idt_qualificador_primario,
                      ocorrencia.des_qualificador_primario,
                      ocorrencia.idt_qualificador_secundario,
                      ocorrencia.des_qualificador_secundario,
                      convert(text, ocorrencia.des_ocorrencia) as des_ocorrencia,
                      evento.idt_evento,
                      evento.nom_evento,
                      evento_periodo.idt_eve_periodo,
                      evento_periodo.cod_periodo,
                      evento_dia.idt_eve_dia,
                      evento_dia.des_dia,
                      local.idt_local,
                      local.nom_local,
                      ambiente.idt_ambiente,
                      ambiente.nom_ambiente,
                      pessoa.nom_pessoa,
                      orgao.nom_orgao,
                      atracao.nom_atracao,
                      entidade.nom_entidade,
                      trecho.idt_trecho,
                      trecho.nom_trecho,
                      trecho.cod_ssp,
                      contexto.nom_contexto,
                      foco.nom_foco,
                      tipo_ocorrencia.nom_tipo_ocorrencia,
                      ocorrencia_pre_cadastrada.nom_ocorrencia,
                      qualificador_primario.des_qualificador as des_qualificador1
--                      qualificador_secundario.des_qualificador as des_qualificador2
                from ocorrencia as ocorrencia
                LEFT JOIN   pessoa ON ocorrencia.idt_pessoa = pessoa.idt_pessoa
                LEFT JOIN   orgao ON ocorrencia.idt_orgao = orgao.idt_orgao
                LEFT JOIN   ambiente_evento_dia ON ocorrencia.idt_amb_eve_dia = ambiente_evento_dia.idt_amb_eve_dia

                LEFT JOIN   evento_dia ON  ocorrencia.dtc_ocorrencia = evento_dia.dtc_dia

                LEFT JOIN   evento_periodo ON evento_periodo.idt_eve_periodo = '.$periodo_trabw.'
                LEFT JOIN   evento         ON evento.idt_evento = '.$evento_trabw.'
                LEFT JOIN   ambiente_local ON ocorrencia.idt_amb_local = ambiente_local.idt_amb_local

                LEFT JOIN   local    ON local.idt_local       = ambiente_local.idt_local
                LEFT JOIN   ambiente ON ambiente.idt_ambiente = ambiente_local.idt_ambiente
                LEFT JOIN   espetaculo ON ocorrencia.idt_espetaculo = espetaculo.idt_espetaculo AND pessoa.idt_pessoa = espetaculo.idt_pessoa AND
                            ambiente_evento_dia.idt_amb_eve_dia = espetaculo.idt_amb_eve_dia AND ambiente_local.idt_amb_local = espetaculo.idt_amb_local
                LEFT JOIN   entidade ON ocorrencia.idt_entidade = entidade.idt_entidade AND espetaculo.idt_entidade = entidade.idt_entidade
                LEFT JOIN   atracao ON ocorrencia.idt_atracao = atracao.idt_atracao
                LEFT JOIN   local_trecho ON ocorrencia.idt_local_trecho = local_trecho.idt_local_trecho
                LEFT JOIN   trecho   ON local_trecho.idt_trecho = trecho.idt_trecho
                LEFT JOIN   contexto ON ocorrencia.idt_contexto = contexto.idt_contexto
                LEFT JOIN   foco ON ocorrencia.idt_foco = foco.idt_foco AND contexto.idt_contexto = foco.idt_contexto
                LEFT JOIN   tipo_ocorrencia ON ocorrencia.idt_tipo_ocorr = tipo_ocorrencia.idt_tipo_ocorr AND foco.idt_foco = tipo_ocorrencia.idt_foco
                LEFT JOIN   ocorrencia_pre_cadastrada ON ocorrencia.idt_ocorr_precad = ocorrencia_pre_cadastrada.idt_ocorr_precad AND
                            tipo_ocorrencia.idt_tipo_ocorr = ocorrencia_pre_cadastrada.idt_tipo_ocorr
                LEFT JOIN   qualificador_primario ON ocorrencia.idt_qualificador_primario = qualificador_primario.idt_qualificador_primario AND
                            ocorrencia_pre_cadastrada.idt_ocorr_precad = qualificador_primario.idt_ocorr_precad';

//                LEFT JOIN   qualificador_secundario ON ocorrencia.idt_qualificador_secundario = qualificador_secundario.idt_qualificador_secundario AND
//-                            qualificador_primario.idt_qualificador_primario = qualificador_secundario.idt_qualificador_primario';
    // where
    //                LEFT JOIN   ambiente_local ON ocorrencia.idt_amb_local = ambiente_local.idt_amb_local AND
    //                            ambiente_evento_dia.idt_amb_local = ambiente_local.idt_amb_local

    if  ($opcaow=='T')
    {
  //    $kwherew='';
        $kwherew=' where evento.idt_evento='.$evento_trabw.' and evento_periodo.idt_eve_periodo='.$periodo_trabw;
//                 ' and  tipo_ocorrencia.sts_xml='.aspa('S').' and   orgao.sts_xml='.aspa('S');

    }
    if  ($opcaow=='D')
    {
        $kwherew=' where evento.idt_evento='.$evento_trabw.' and evento_periodo.idt_eve_periodo='.$periodo_trabw.' and ocorrencia.dtc_registro>='.$dataw;
//                 ' and  tipo_ocorrencia.sts_xml='.aspa('S').' and   orgao.sts_xml='.aspa('S');
    }
//    p($kwherew);
    // ordenação
    $korderbyw=' order by ocorrencia.dtc_registro ';
    $a=$kselectw.$kwherew.$korderbyw;
    $ktabelaw = execsql($a);
    //
    // criar arquivo a ser gravado
    //
    //    $xml_filename=$kpathw.$knomew;
    //    $xml_filename='db_prodasal_siae.xml';
    $xml_filename=$kpathw.$knomew.".xml";

//    echo "arquivo ".$xml_filename;

    $xml_filehandle=fopen($xml_filename,'w') or die(" Não pode abrir o arquivo ");
    $tambufferw=10;
    //
    // estrutura do xml
    //
    $quantidade_ocorrencias=0;
    $quantidade_buffer=0;
    $kbufferw='';
    $xml_ocorrencias = Array();
    $kiw=0;
    $xml_ocorrencias[$kiw]="<?phpxml version='1.0' encoding='ISO-8859-1'?>";
    $kiw=$kiw+1;
    //$xml_ocorrencias[$kiw]="<?phpxml version='1.0'? >";
    //$kiw=$kiw+1;
//    $xml_ocorrencias[$kiw]="<BD_PRODASAL_SIAE xmlns:xsi='http://www.w3.org/2001/XMLSchema-instance' xsi:noNamespaceSchemaLocation='./BD_PRODASAL_SIAE.xsd'>";
//    $xml_ocorrencias[$kiw]="<BD_PRODASAL_SIAE xmlns:xsi='http://www.w3.org/2001/XMLSchema-instance' xsi:noNamespaceSchemaLocation='./BD_PRODASAL_SIAE.xsd'>";
    $xml_ocorrencias[$kiw]="<BD_PRODASAL_SIAE xmlns:xsi='http://www.w3.org/2001/XMLSchema-instance'>";
    While ($row = mssql_fetch_array($ktabelaw))
    {
        // para cada registro

        $kiw=$kiw+1;
        $xml_ocorrencias[$kiw]="<xml_ocorrencias>";

        // campos do registro
        $kiw=$kiw+1;
        $xml_ocorrencias[$kiw]="<xml_idt_ocorrencia>".$row['idt_ocorrencia']."</xml_idt_ocorrencia>";


        $kiw=$kiw+1;
        $xml_ocorrencias[$kiw]="<xml_idt_evento>".$row['idt_evento']."</xml_idt_evento>";
        $kiw=$kiw+1;
        $xml_ocorrencias[$kiw]="<xml_txt_evento>".lupe_trata_texto_xml($row['nom_evento'])."</xml_txt_evento>";

        $kiw=$kiw+1;
        $xml_ocorrencias[$kiw]="<xml_idt_evento>".$row['idt_evento_periodo']."</xml_idt_evento>";
        $kiw=$kiw+1;
        $xml_ocorrencias[$kiw]="<xml_txt_periodo>".lupe_trata_texto_xml($row['cod_periodo'])."</xml_txt_periodo>";

        $kiw=$kiw+1;
        $xml_ocorrencias[$kiw]="<xml_idt_dia>".$row['idt_eve_dia']."</xml_idt_dia>";
        $kiw=$kiw+1;
        $xml_ocorrencias[$kiw]="<xml_txt_dia>".lupe_trata_texto_xml($row['des_dia'])."</xml_txt_dia>";

        $kiw=$kiw+1;
        $xml_ocorrencias[$kiw]="<xml_idt_ambiente>".$row['idt_ambiente']."</xml_idt_ambiente>";
        $kiw=$kiw+1;
        $xml_ocorrencias[$kiw]="<xml_txt_ambiente>".lupe_trata_texto_xml($row['nom_ambiente'])."</xml_txt_ambiente>";

        $kiw=$kiw+1;
        $xml_ocorrencias[$kiw]="<xml_idt_local>".$row['idt_local']."</xml_idt_local>";
        $kiw=$kiw+1;
        $xml_ocorrencias[$kiw]="<xml_txt_local>".lupe_trata_texto_xml($row['nom_local'])."</xml_txt_local>";

        $kiw=$kiw+1;
        $xml_ocorrencias[$kiw]="<xml_idt_pessoa>".$row['idt_pessoa']."</xml_idt_pessoa>";
        $kiw=$kiw+1;
        $xml_ocorrencias[$kiw]="<xml_txt_pessoa>".lupe_trata_texto_xml($row['nom_pessoa'])."</xml_txt_pessoa>";
        $kiw=$kiw+1;
        $xml_ocorrencias[$kiw]="<xml_idt_orgao>".$row['idt_orgao']."</xml_idt_orgao>";
        $kiw=$kiw+1;
        $xml_ocorrencias[$kiw]="<xml_txt_orgao>".lupe_trata_texto_xml($row['nom_orgao'])."</xml_txt_orgao>";
        $kiw=$kiw+1;
        $xml_ocorrencias[$kiw]="<xml_idt_amb_eve_dia>".$row['idt_amb_eve_dia']."</xml_idt_amb_eve_dia>";
        $kiw=$kiw+1;
        $xml_ocorrencias[$kiw]="<xml_idt_amb_local>".$row['idt_amb_local']."</xml_idt_amb_local>";
        $kiw=$kiw+1;
        $xml_ocorrencias[$kiw]="<xml_idt_espetaculo>".$row['idt_espetaculo']."</xml_idt_espetaculo>";
        $kiw=$kiw+1;
        $xml_ocorrencias[$kiw]="<xml_idt_entidade>".$row['idt_entidade']."</xml_idt_entidade>";
        $kiw=$kiw+1;
        $xml_ocorrencias[$kiw]="<xml_txt_entidade>".lupe_trata_texto_xml($row['nom_entidade'])."</xml_txt_entidade>";
        $kiw=$kiw+1;
        $xml_ocorrencias[$kiw]="<xml_idt_atracao>".$row['idt_atracao']."</xml_idt_atracao>";
        $kiw=$kiw+1;
        $xml_ocorrencias[$kiw]="<xml_txt_atracao>".lupe_trata_texto_xml($row['nom_atracao'])."</xml_txt_atracao>";
        $kiw=$kiw+1;
        $xml_ocorrencias[$kiw]="<xml_idt_local_trecho>".$row['idt_atracao']."</xml_idt_local_trecho>";
        $kiw=$kiw+1;
        $xml_ocorrencias[$kiw]="<xml_idt_trecho>".$row['idt_trecho']."</xml_idt_trecho>";
        $kiw=$kiw+1;
        $xml_ocorrencias[$kiw]="<xml_txt_trecho>".lupe_trata_texto_xml($row['cod_ssp'])."</xml_txt_trecho>";
        $kiw=$kiw+1;
        $xml_ocorrencias[$kiw]="<xml_dtc_registro>".$row['dtc_registro']."</xml_dtc_registro>";
        $kiw=$kiw+1;
        $xml_ocorrencias[$kiw]="<xml_dtc_ocorrencia>".$row['dtc_ocorrencia']."</xml_dtc_ocorrencia>";
        $kiw=$kiw+1;
        $xml_ocorrencias[$kiw]="<xml_hor_ocorrencia>".$row['hor_ocorrencia']."</xml_hor_ocorrencia>";
        $kiw=$kiw+1;
        $xml_ocorrencias[$kiw]="<xml_idt_contexto>".$row['idt_contexto']."</xml_idt_contexto>";
        $kiw=$kiw+1;
        $xml_ocorrencias[$kiw]="<xml_idt_foco>".$row['idt_foco']."</xml_idt_foco>";
        $kiw=$kiw+1;
        $xml_ocorrencias[$kiw]="<xml_txt_foco>".lupe_trata_texto_xml($row['nom_foco'])."</xml_txt_foco>";
        $kiw=$kiw+1;
        $xml_ocorrencias[$kiw]="<xml_idt_natureza>".$row['idt_tipo_ocorr']."</xml_idt_natureza>";
        $kiw=$kiw+1;
        $xml_ocorrencias[$kiw]="<xml_txt_natureza>".lupe_trata_texto_xml($row['nom_tipo_ocorrencia'])."</xml_txt_natureza>";
        $kiw=$kiw+1;
        $xml_ocorrencias[$kiw]="<xml_idt_predefinida>".$row['idt_ocorr_precad']."</xml_idt_predefinida>";
        $kiw=$kiw+1;
        $xml_ocorrencias[$kiw]="<xml_txt_predefinida>".lupe_trata_texto_xml($row['nom_ocorrencia'])."</xml_txt_predefinida>";
        $kiw=$kiw+1;
        $xml_ocorrencias[$kiw]="<xml_idt_atributo1>".$row['idt_qualificador_primario']."</xml_idt_atributo1>";
        $kiw=$kiw+1;
        $xml_ocorrencias[$kiw]="<xml_txt_atributo1>".lupe_trata_texto_xml($row['des_qualificador_primario'])."</xml_txt_atributo1>";
        $kiw=$kiw+1;
        $xml_ocorrencias[$kiw]="<xml_conteudo_atributo1>".lupe_trata_texto_xml($row['des_qualificador1'])."</xml_conteudo_atributo1>";
        $kiw=$kiw+1;
        $xml_ocorrencias[$kiw]="<xml_idt_atributo2>".$row['idt_qualificador_secundario']."</xml_idt_atributo2>";
        $kiw=$kiw+1;
        $xml_ocorrencias[$kiw]="<xml_txt_atributo2>".lupe_trata_texto_xml($row['des_qualificador_secundario'])."</xml_txt_atributo2>";
        $kiw=$kiw+1;
        $xml_ocorrencias[$kiw]="<xml_conteudo_atributo2>".lupe_trata_texto_xml($row['des_qualificador2'])."</xml_conteudo_atributo2>";
        $kiw=$kiw+1;
        $xml_ocorrencias[$kiw]="<xml_des_ocorrencia>".lupe_trata_texto_xml($row['des_ocorrencia'])."</xml_des_ocorrencia>";
        // fecha registro - linha
        $kiw=$kiw+1;
        $xml_ocorrencias[$kiw]="</xml_ocorrencias>";
        $quantidade_ocorrencias=$quantidade_ocorrencias+1;
        // controlar gravação do buffer
        $quantidade_buffer=$quantidade_buffer+1;
        if  ($quantidade_buffer==$tambufferw)
        {
            $kbufferw='';

//                for ($x = 0; $x < mssql_num_fields($rs); $x++)
//                {
//                     $vet[mssql_field_name($rs, $x)] = mssql_field_type($rs, $x);
//                }
            for  ($kjw=0; $kjw<=$kiw; $kjw+=1 )
            {
//                $kbufferw=$kbufferw.$xml_ocorrencias[$kjw]."\n";
                $kbufferw=$kbufferw.$xml_ocorrencias[$kjw];
            }

//            $kbufferw="registro ".$quantidade_ocorrencias;
            fwrite($xml_filehandle,$kbufferw);
            echo $kbufferw;
            $quantidade_buffer=0;
            $kiw=-1;
        }
    }
    //
    // fecha o banco
    //
    $kiw=$kiw+1;
    $xml_ocorrencias[$kiw]="</BD_PRODASAL_SIAE >";
  //  p(' o arquivo '.$xml_ocorrencias);
    $kbufferw='';
//  $kbufferw="registro ".$quantidade_ocorrencias;
    for  ($kjw=0; $kjw<=$kiw; $kjw+=1 )
    {
//      $kbufferw=$kbufferw.$xml_ocorrencias[$kjw]."\n";
        $kbufferw=$kbufferw.$xml_ocorrencias[$kjw];
    }
    echo $kbufferw;
    fwrite($xml_filehandle,$kbufferw);
    $quantidade_buffer=0;
    $kiw=-1;
    //
    fclose($xml_filehandle);
    //
    //p('klklkllklkllguy guy  '.$kbufferw);    //
    //
    $retorno_xml=$kbufferw;

    //
    // gravar controles de gravação
    //
//  $htm_filename='db_prodasal_siae.htm';
    //
    $htm_filename=$kpathw.$knomew.".htm";
    //
    $htm_filehandle=fopen($htm_filename,'w') or die(" Não pode abrir o arquivo ");
    $kbufferw='';
    $kbufferw=$kbufferw."<HTML>";
    $kbufferw=$kbufferw."<TITLE>";
    $kbufferw=$kbufferw."SIAE - Transacional: Documentação<br>";
    $kbufferw=$kbufferw."Controle da geração de arquivo XML";
    $kbufferw=$kbufferw."</TITLE>";
    $kbufferw=$kbufferw."<BODY>";
    $kbufferw=$kbufferw."<br><br><br><br>";
    $kbufferw=$kbufferw."<br><br><br><br>";
    $kbufferw=$kbufferw."<p>";
    $kbufferw=$kbufferw."Opções para Geração <br><br>";
    $kbufferw=$kbufferw."Usuário: ".$usuariow."<br><br>";
    $kbufferw=$kbufferw."Evento : ".$eventow."<br><br>";
    $kbufferw=$kbufferw."Periodo: ".$periodow."<br><br>";
    $kbufferw=$kbufferw."Opção: ".$opcaow."<br><br>";
    $kbufferw=$kbufferw."Data: ".$dataw."<br><br>";
    $kbufferw=$kbufferw."Path: ".$kpathw."<br><br>";
    $kbufferw=$kbufferw."arquivo: ".$knomew."<br><br>";
    $kbufferw=$kbufferw."Quantidade de Ocorrências geradas : ".$quantidade_ocorrencias."<br><br>";
    $kbufferw=$kbufferw."</p>";
    $kbufferw=$kbufferw."</BODY>";
    $kbufferw=$kbufferw."</HTML>";
    fwrite($htm_filehandle,$kbufferw);
    fclose($htm_filehandle);
    //
    // gera xml de retorno
    //
    $htm_filename=$kpathw.$knomew."_retorno.xml";
    $htm_filehandle=fopen($htm_filename,'w') or die(" Não pode abrir o arquivo ");
    $kbufferw='';
    $kbufferw=$kbufferw."<?phpxml version='1.0' encoding='ISO-8859-1' ?>";
    $kbufferw=$kbufferw."<?phpxml version='1.0'?>";
    $kbufferw=$kbufferw."<BD_PRODASAL_SIAE xmlns:xsi='http://www.w3.org/2001/XMLSchema-instance' xsi:noNamespaceSchemaLocation='./BD_PRODASAL_SIAE_retorno.xsd'>";
    $kbufferw=$kbufferw."<xml_ocorrencias_retorno>";
    $kbufferw=$kbufferw."<xml_usuario>".$usuariow."</xml_usuario>";
    $kbufferw=$kbufferw."<xml_evento>".$eventow."</xml_evento>";
    $kbufferw=$kbufferw."<xml_periodo>".$periodow."</xml_periodo>";
    $kbufferw=$kbufferw."<xml_opcao>".$opcaow."</xml_opcao>";
    $kbufferw=$kbufferw."<xml_data>".$dataw."</xml_data>";
    $kbufferw=$kbufferw."<xml_path>".$kpathw."</xml_path>";
    $kbufferw=$kbufferw."<xml_arquivo>".$knomew."</xml_arquivo>";
    $kbufferw=$kbufferw."<xml_status>GERADO SEM PROBLEMAS</xml_status>";
    $kbufferw=$kbufferw."<xml_quantidade>".$quantidade_ocorrencias."</xml_quantidade>";
    $kbufferw=$kbufferw."</xml_ocorrencias_retorno>";
    $kbufferw=$kbufferw."</BD_PRODASAL_SIAE >";
    fwrite($htm_filehandle,$kbufferw);
    fclose($htm_filehandle);
    //
    //  gravar arquivo em disco
    //
 //   echo  "Quantidade de Ocorrências ".$quantidade_ocorrencias;


    return $retorno_xml;
}


function lupe_trata_texto_xml($stringw)
{
     // ultimo é o existente o penultimo é o novo


     $string_trabw=str_replace('&','e',$stringw);


/*   $string_trabw=str_replace('ã','a',$stringw);
     $string_trabw=str_replace('Ã','A',$string_trabw);
     $string_trabw=str_replace('á','a',$string_trabw);
     $string_trabw=str_replace('Á','A',$string_trabw);
     $string_trabw=str_replace('à','a',$string_trabw);
     $string_trabw=str_replace('À','A',$string_trabw);
     $string_trabw=str_replace('â','a',$string_trabw);
     $string_trabw=str_replace('Â','A',$string_trabw);
     //
     $string_trabw=str_replace('é','e',$string_trabw);
     $string_trabw=str_replace('É','E',$string_trabw);
     $string_trabw=str_replace('è','e',$string_trabw);
     $string_trabw=str_replace('È','E',$string_trabw);
     //
     $string_trabw=str_replace('ê','e',$string_trabw);
     $string_trabw=str_replace('Ê','E',$string_trabw);
     //
     $string_trabw=str_replace('í','i',$string_trabw);
     $string_trabw=str_replace('Í','I',$string_trabw);
     $string_trabw=str_replace('ì','i',$string_trabw);
     $string_trabw=str_replace('Ì','I',$string_trabw);
     //
     $string_trabw=str_replace('ú','u',$string_trabw);
     $string_trabw=str_replace('Ú','U',$string_trabw);
     //
     $string_trabw=str_replace('ç','c',$string_trabw);
     $string_trabw=str_replace('Ç','C',$string_trabw);
     //
     $string_trabw=str_replace('õ','o',$string_trabw);
     $string_trabw=str_replace('Õ','O',$string_trabw);
     $string_trabw=str_replace('ó','o',$string_trabw);
     $string_trabw=str_replace('Ó','O',$string_trabw);
     $string_trabw=str_replace('ò','o',$string_trabw);
     $string_trabw=str_replace('Ò','O',$string_trabw);
     $string_trabw=str_replace('ô','o',$string_trabw);
     $string_trabw=str_replace('Ô','O',$string_trabw);
     //
     //  para quebras de linhas
     //
     $string_trabw=str_replace('Ô','O',$string_trabw);    */
     //
     return $string_trabw;
}

//
//
//
function lupe_tira_acentuacao($stringw)
{
     // ultimo é o existente o penultimo é o novo

     $string_trabw=str_replace('ã','a',$stringw);
     $string_trabw=str_replace('Ã','A',$string_trabw);
     $string_trabw=str_replace('á','a',$string_trabw);
     $string_trabw=str_replace('Á','A',$string_trabw);
     $string_trabw=str_replace('à','a',$string_trabw);
     $string_trabw=str_replace('À','A',$string_trabw);
     $string_trabw=str_replace('â','a',$string_trabw);
     $string_trabw=str_replace('Â','A',$string_trabw);
     //
     $string_trabw=str_replace('é','e',$string_trabw);
     $string_trabw=str_replace('É','E',$string_trabw);
     $string_trabw=str_replace('è','e',$string_trabw);
     $string_trabw=str_replace('È','E',$string_trabw);
     //
     $string_trabw=str_replace('ê','e',$string_trabw);
     $string_trabw=str_replace('Ê','E',$string_trabw);
     //
     $string_trabw=str_replace('í','i',$string_trabw);
     $string_trabw=str_replace('Í','I',$string_trabw);
     $string_trabw=str_replace('ì','i',$string_trabw);
     $string_trabw=str_replace('Ì','I',$string_trabw);
     //
     $string_trabw=str_replace('ú','u',$string_trabw);
     $string_trabw=str_replace('Ú','U',$string_trabw);
     //
     $string_trabw=str_replace('ç','c',$string_trabw);
     $string_trabw=str_replace('Ç','C',$string_trabw);
     //
     $string_trabw=str_replace('õ','o',$string_trabw);
     $string_trabw=str_replace('Õ','O',$string_trabw);
     $string_trabw=str_replace('ó','o',$string_trabw);
     $string_trabw=str_replace('Ó','O',$string_trabw);
     $string_trabw=str_replace('ò','o',$string_trabw);
     $string_trabw=str_replace('Ò','O',$string_trabw);
     $string_trabw=str_replace('ô','o',$string_trabw);
     $string_trabw=str_replace('Ô','O',$string_trabw);
     //
     //  para quebras de linhas
     //
     $string_trabw=str_replace('Ô','O',$string_trabw);
     //
     return $string_trabw;
}
//
//  Espetáculos
//
function lupe_gera_espetaculos($idt_evento,
                               $idt_eve_periodow,
                               $idt_eve_dia,
                               $idt_local,
                               $idt_amb_local,
                               $idt_amb_eve_dia,
                               $idt_orgao,
                               $idt_entidade_par,
                               $opcao
                               )
{


   if ($idt_eve_dia=='' || $idt_orgao=='')
   {
      return "nada";
   }
   else
   {

	   $varw=1;

	   $a = "select     espetaculo.idt_espetaculo, espetaculo.idt_pessoa, espetaculo.idt_amb_eve_dia, espetaculo.idt_amb_local,
                      espetaculo.idt_entidade, espetaculo.dtc_ini_registro, espetaculo.dtc_fim_registro, espetaculo.hor_inicio, espetaculo.hor_final,
                      espetaculo.sts_sentido, entidade.idt_categoria, entidade.nom_entidade, categoria.nom_categoria, pessoa.nom_pessoa,
                      evento_dia.des_dia, l.cod_local, l.cod_sublocal, l.nom_local, l.sig_local, l.idt_local
from         categoria inner join
                      entidade on categoria.idt_categoria = entidade.idt_categoria inner join
                      espetaculo inner join
                      ambiente_evento_dia on espetaculo.idt_amb_eve_dia = ambiente_evento_dia.idt_amb_eve_dia inner join
                      evento_dia on ambiente_evento_dia.idt_eve_dia = evento_dia.idt_eve_dia inner join
                      pessoa on espetaculo.idt_pessoa = pessoa.idt_pessoa on entidade.idt_entidade = espetaculo.idt_entidade inner join
                      ambiente_local on espetaculo.idt_amb_local = ambiente_local.idt_amb_local inner join
                      [local] l on ambiente_local.idt_local = l.idt_local
where     (espetaculo.idt_amb_eve_dia = $idt_amb_eve_dia)
order by espetaculo.idt_entidade, l.cod_sublocal, espetaculo.hor_inicio";

	   $ktabelaw = execsql($a);
	   $espetaculos=Array();
	   $entidades  =Array();
	   $kiw=-1;
	   $kew=-1;
	   While ($row = mssql_fetch_array($ktabelaw))
	   {
		   $kiw=0;

		   if  ($row['idt_espetaculo']=='')
		   {
				$entidades[$kiw] =9999999999;
		   }
		   else
		   {
				$entidades[$kiw] =$row['idt_espetaculo'];
		   }
		   $kiw=$kiw+1;
		   $entidades[$kiw] =$row['idt_entidade'];
		   $kiw=$kiw+1;
		   $entidades[$kiw] =$row['nom_entidade'];
		   $kiw=$kiw+1;
		   $entidades[$kiw] =$row['sts_sentido'];
		   $kiw=$kiw+1;
		   $entidades[$kiw] =$row['nom_categoria'];
		   $kiw=$kiw+1;

           //$entidades[$kiw] =lupe_espetaculos_atracoes($row['idt_espetaculo']);
		   $entidades[$kiw] =lupe_entidades_atracoes_real($row['idt_entidade'], $idt_amb_eve_dia);

           $kiw=$kiw+1;
		   $entidades[$kiw] =$row['cod_local'];
		   $kiw=$kiw+1;
		   $entidades[$kiw] =$row['cod_sublocal'];
		   $kiw=$kiw+1;
		   if  ($row['idt_espetaculo']!='')
		   {
				 $entidades[$kiw] =$row['sig_local'];   // 8
		   }
		   else
		   {
				 $entidades[$kiw] ='ARMAÇÃO';
		   }
		   $kiw=$kiw+1;
		   $entidades[$kiw] =$row['hor_inicio'];
		   $kiw=$kiw+1;
		   $entidades[$kiw] =$row['hor_final'];
		   $kiw=$kiw+1;
		   $entidades[$kiw] =$row['sts_sentido'];
		   $kiw=$kiw+1;
		   $entidades[$kiw] =$row['des_dia'];
		   $kiw=$kiw+1;
		   $entidades[$kiw] =$row['nom_local'];  // 13
		   $kiw=$kiw+1;
		   $entidades[$kiw] =$row['idt_amb_local'];  // 14


		   $kiw=$kiw+1;
		   $entidades[$kiw]=$row['cod_ordem'];  // 15
		   $kiw=$kiw+1;
		   $entidades[$kiw]=$row['hor_fim_armacao'];  // 16
		   $kiw=$kiw+1;
		   $entidades[$kiw]=$row['hor_tempo_desfile'];  // 17
		  // uma entidade
		   $kew=$kew+1;
		   $espetaculos[$kew]=$entidades;
	  }
	   return $espetaculos;
   }
}



//////////////////////
//
//  Espetáculos
//
function lupe_gera_espetaculos_entidades($idt_evento,
                               $idt_eve_periodow,
                               $idt_eve_dia,
                               $idt_local,
                               $idt_amb_local,
                               $idt_amb_eve_dia,
                               $idt_orgao,
                               $idt_entidade_par,
                               $opcao
                               )
{
//   if ($idt_eve_dia=='' || $idt_orgao=='')
   if ($idt_orgao=='')
   {
    // echo "nada.... nada.....";
      return "nada";
   }
   else
   {

   $varw=1;


   // select
   $kselectw = 'select
                       espetaculo.idt_espetaculo,
                       espetaculo.idt_pessoa,
                       espetaculo.idt_amb_eve_dia,
                       espetaculo.idt_amb_local,
                       espetaculo.idt_entidade,
                       espetaculo.dtc_ini_registro,
                       espetaculo.dtc_fim_registro,
                       espetaculo.hor_inicio,
                       espetaculo.hor_final,
                       espetaculo.sts_sentido,
                       entidade.idt_entidade,
                       entidade.idt_categoria,
                       entidade.nom_entidade,
                       categoria.nom_categoria,
                       pessoa.nom_pessoa,
                       evento_dia.des_dia,
                       [local].idt_local,
                       [local].cod_local,
                       [local].cod_sublocal,
                       [local].sig_local,
                       [local].nom_local,
                       ambiente.nom_ambiente
               from   espetaculo
               left join pessoa ON espetaculo.idt_pessoa = pessoa.idt_pessoa
               left join ambiente_evento_dia ON espetaculo.idt_amb_eve_dia = ambiente_evento_dia.idt_amb_eve_dia
               left join entidade ON espetaculo.idt_entidade = entidade.idt_entidade
               left join categoria ON entidade.idt_categoria = categoria.idt_categoria
               left join evento_dia ON ambiente_evento_dia.idt_eve_dia = evento_dia.idt_eve_dia
               left join evento_periodo ON evento_dia.idt_eve_periodo = evento_periodo.idt_eve_periodo
               left join ambiente_local ON espetaculo.idt_amb_local = ambiente_local.idt_amb_local
               left join ambiente ON ambiente_local.idt_ambiente = ambiente.idt_ambiente
               left join [local] ON ambiente_local.idt_local = [local].idt_local
               inner join local l_pai on local.cod_local = l_pai.cod_local and l_pai.cod_sublocal=0';

    $kwherew=' where evento_periodo.idt_evento='.$idt_evento.' and evento_periodo.idt_eve_periodo='.$idt_eve_periodow.
             '   and espetaculo.idt_entidade='.$idt_entidade_par;

   $korderbyw=' order by espetaculo.idt_entidade,[local].cod_local,evento_dia.cod_ordem,espetaculo.hor_inicio                ';
   $a=$kselectw.$kwherew.$korderbyw;
   $ktabelaw = execsql($a);
   $espetaculos=Array();
   $entidades  =Array();
   $kiw=-1;
   $kew=-1;
   //
   While ($row = mssql_fetch_array($ktabelaw))
   {
       //
       //   para cada registro gerar um elemento espetáculo
       //
       $kiw=0;

       if  ($row['idt_espetaculo']=='')
       {
            $entidades[$kiw] =9999999999;
       }
       else
       {
            $entidades[$kiw] =$row['idt_espetaculo'];
       }
       $kiw=$kiw+1;
       $entidades[$kiw] =$row['idt_entidade'];
//       $entidades[$kiw] =$row['entidade_idt_entidade'];
       $kiw=$kiw+1;
       $entidades[$kiw] =$row['nom_entidade'];
       $kiw=$kiw+1;
       $entidades[$kiw] =$row['sts_sentido'];
       $kiw=$kiw+1;
       $entidades[$kiw] =$row['nom_categoria'];
       $kiw=$kiw+1;
       $entidades[$kiw] =lupe_espetaculos_atracoes($row['idt_espetaculo']);
       $kiw=$kiw+1;
       $entidades[$kiw] =$row['cod_local'];
       $kiw=$kiw+1;
       $entidades[$kiw] =$row['cod_sublocal'];
       $kiw=$kiw+1;
       $entidades[$kiw] =$row['sig_local'];   // 8
       $kiw=$kiw+1;
       $entidades[$kiw] =$row['hor_inicio'];
       $kiw=$kiw+1;
       $entidades[$kiw] =$row['hor_final'];
       $kiw=$kiw+1;
       $entidades[$kiw] =$row['sts_sentido'];
       $kiw=$kiw+1;
       $entidades[$kiw] =$row['des_dia'];
       $kiw=$kiw+1;
       $entidades[$kiw] =$row['nom_local'];  // 13
       $kiw=$kiw+1;
       $entidades[$kiw] =$row['idt_amb_local'];  // 14
       $kiw=$kiw+1;
       $entidades[$kiw]=$row['cod_ordem'];  // 15
       $kiw=$kiw+1;
       $entidades[$kiw]=$row['hor_fim_armacao'];  // 16
       $kiw=$kiw+1;
       $entidades[$kiw]=$row['hor_tempo_desfile'];  // 17
      // uma entidade
       $kew=$kew+1;
       $espetaculos[$kew]=$entidades;
  }

//  p($espetaculos);


   return $espetaculos;

   }
}









/////////////////////////










//
//  Espetáculos - atrações
//
function lupe_espetaculos_atracoes($idt_espetaculo)
{
   $varw=1;
   // select
   $kselectw = 'select
                      atracao.nom_atracao
               from   espetaculo
               left   join espetaculo_atracao ON espetaculo.idt_espetaculo = espetaculo_atracao.idt_espetaculo
               left   join atracao ON espetaculo_atracao.idt_atracao = atracao.idt_atracao';
   $kwherew=' where   espetaculo.idt_espetaculo='.TrataNumero($idt_espetaculo);
   $korderbyw=' order by espetaculo.hor_inicio                ';
   $a=$kselectw.$kwherew.$korderbyw;
   $ktabelaw = execsql($a);
   //
   $katracoes='';
   $separaw='';
   While ($row = mssql_fetch_array($ktabelaw))
   {
       //
       //   para cada concatenar ataração
       //
       $string_trabw=str_replace('/','<br>',$row['nom_atracao']);
//     $katracoes=$katracoes.$separaw.$row['nom_atracao'];
       $katracoes=$katracoes.$separaw.$string_trabw;
       $separaw='<br>';
   }
   return $katracoes;
}


function lupe_entidades_atracoes_real($idt_entidade, $idt_amb_eve_dia)
{
   $varw=1;
   // select
   $kselectw = 'select DISTINCT
                     atracao.nom_atracao
               from  espetaculo
               inner join espetaculo_atracao ON espetaculo.idt_espetaculo = espetaculo_atracao.idt_espetaculo
               inner join atracao ON espetaculo_atracao.idt_atracao = atracao.idt_atracao';
   $kwherew=' where   espetaculo.idt_entidade='.TrataNumero($idt_entidade).' and espetaculo.idt_amb_eve_dia = '.$idt_amb_eve_dia;
   $korderbyw=' order by  atracao.nom_atracao';
   $a=$kselectw.$kwherew.$korderbyw;
   $ktabelaw = execsql($a);
   //
   $katracoes='';
   $separaw='';
   While ($row = mssql_fetch_array($ktabelaw))
   {
       $katracoes .= $separaw.$row['nom_atracao'];
       $separaw='<br>';
   }
   return $katracoes;
}

function lupe_entidades_atracoes($idt_entidade,$par_separa)
{
   $varw=1;
   // select
   $kselectw = 'select
                      atracao.nom_atracao
               from   entidade_atracao
               left   join atracao ON entidade_atracao.idt_atracao = atracao.idt_atracao';
   $kwherew=' where   entidade_atracao.idt_entidade='.$idt_entidade;
   $korderbyw=' order by atracao.nom_atracao         ';
   $a=$kselectw.$kwherew.$korderbyw;

   //   p($a);

   $ktabelaw = execsql($a);
   //
   $katracoes='';
   $separaw='';
   While ($row = mssql_fetch_array($ktabelaw))
   {
       //
       //   para cada concatenar ataração
       //
//     $string_trabw=str_replace('/','<br>',$row['nom_atracao']);
//     $katracoes=$katracoes.$separaw.$row['nom_atracao'];
       $string_trabw=$row['nom_atracao'];
       $katracoes=$katracoes.$separaw.$string_trabw;

       if  ($par_separa=='')
       {
           $separaw=' / ';
       }
       else
       {
           $separaw='<br>';
       }
   }
   return $katracoes;
}





function lupe_entidades_pretensao($idt_entidade)
{
   $varw=1;
   //
   // locais e dias
   //
   // select
   //
   $kselectw = 'select
                 ent.idt_entidade,
                 ent.nom_entidade,
                 cat.nom_categoria,
                 loc.nom_local,
                 edi.des_dia,
                 aml.idt_amb_local
              from entidade as ent
              left join  tipo_entidade tpe on ent.idt_tip_entidade=tpe.idt_tip_entidade
              left join  categoria     cat on ent.idt_categoria=cat.idt_categoria
              left join entidade_dia_evento ede on ede.idt_entidade=ent.idt_entidade
              left join ambiente_evento_dia aed on aed.idt_amb_eve_dia=ede.idt_amb_eve_dia
              left join ambiente_local aml on aml.idt_amb_local=aed.idt_amb_local    -- para pretensão
              left join ambiente amb on amb.idt_ambiente=aml.idt_ambiente
              left join local    loc on loc.idt_local=aml.idt_local
              left join evento_dia edi on edi.idt_eve_dia=aed.idt_eve_dia';

   $kwherew=' where   ent.idt_entidade='.$idt_entidade;

   $korderbyw=' order by aml.idt_amb_local,edi.cod_ordem';

   $a=$kselectw.$kwherew.$korderbyw;

//   p($a);

//   exit();



   $ktabelaw = execsql($a);
   //
   $kvetlocaisdias=Array();
   $vetdias=Array();
   $separaw='';
   While ($row = mssql_fetch_array($ktabelaw))
   {

       if  ($idt_amb_localw=='')
       {   // para o primeiro não quebra
           $nom_localw=$row['nom_local'];
           $idt_amb_localw=$row['idt_amb_local'];
       }
       if  ($idt_amb_localw!=$row['idt_amb_local'])
       {
           $kvetlocaisdias[$nom_localw]=$vetdias;
           $vetdias=Array();
           $nom_localw=$row['nom_local'];
           $idt_amb_localw=$row['idt_amb_local'];
      }
      else
      {
           $vetdias[$row['des_dia']]=$row['des_dia'];
      }
   }
   if  ($idt_amb_localw!='')
   {
       $kvetlocaisdias[$nom_localw]=$vetdias;
   }
   return $kvetlocaisdias;
}


function lupe_orgaos_da_acao($idt_pre_definida)
{
   $varw=1;
   // select
   $kselectw = 'select  orgao.idt_orgao, orgao.nom_orgao,nom_acao, acao.des_acao, acao.idt_acao
               from   acao_orgao
               INNER JOIN acao ON acao_orgao.idt_acao = acao.idt_acao
               INNER JOIN orgao ON acao_orgao.idt_orgao = orgao.idt_orgao';
   $kwherew=' where   acao.idt_ocorr_precad='.$idt_pre_definida;
   $korderbyw=' order by nom_orgao        ';
   $a=$kselectw.$kwherew.$korderbyw;
//   p($a);
   $ktabelaw = execsql($a);
   $vetacoes=Array();
   $vetorgaos==Array();
   $separaw='';
   $idt_acaow=0;
   $kfezw=0;
   While ($row = mssql_fetch_array($ktabelaw))
   {
       $kfezw=$kfezw+1;
       if  ($idt_acaow!=$row['idt_acao'])
       {
           if  ($kfezw!=1)
           {
               $vetacoes[$nom_acao_ant]=$vetorgaos;
           }
           $vetacoes[$row['nom_acao']]=$row['des_acao'];
           $idt_acaow!=$row['idt_acao'];
           $nom_acao_ant=$row['nom_acao'];
           $vetorgaos=Array();
       }
       $vetorgaos[$row['idt_orgao']]=$row['nom_orgao'];
   }
   if  ($kfezw>0)
   {
       $vetacoes[$nom_acao_ant]=$vetorgaos;
   }
   return $vetacoes;
}


function lupe_ambientes_local($idt_local)
{
   // select
   $kselectw = 'select
                      amb.nom_ambiente
               from   ambiente_local as aml
               left   join ambiente amb ON aml.idt_ambiente = amb.idt_ambiente';
   $kwherew=' where   aml.idt_local='.$idt_local;
   $korderbyw=' order by amb.nom_ambiente         ';

   $a=$kselectw.$kwherew.$korderbyw;
   $ktabelaw = execsql($a);
   //
   $ambientes_local='';
   $separaw='';
   While ($row = mssql_fetch_array($ktabelaw))
   {
       //
       //   para cada ambiente
       //
       $string_trabw=$row['nom_ambiente'];
       $ambientes_local=$ambientes_local.$separaw.$string_trabw;
       $separaw='<br>';
   }

   return $ambientes_local;
}

function lupe_dia_do_carnaval($idt_eve_periodo,$Data,$Hora)
{
   $idt_eve_periodow=$idt_eve_periodo;
//   p($idt_eve_periodo);
   if  ($idt_eve_periodow=='')
   {
       $idt_eve_periodow=$_SESSION['idt_eve_periodo'];
   }
   $varw=$Data.' '.$Hora;
   $kselectw = 'select
                      des_dia
               from   evento_dia';
   $kwherew=' where   idt_eve_periodo='.$idt_eve_periodow;
   $kwherew=$kwherew.' and dtc_ini_dia<='.aspa($varw).' and dtc_fim_dia>='.aspa($varw);
   $korderbyw=' order by cod_ordem        ';
   $a=$kselectw.$kwherew.$korderbyw;
  // p($a);
  // exit();
   $ktabelaw = execsql($a);
   $des_dia='';
   While ($row = mssql_fetch_array($ktabelaw))
   {
       $des_dia=$row['des_dia'];
   }
   return $des_dia;
}

function lupe_ordem_dia_do_carnaval($idt_eve_periodo,$Data,$Hora)
{
   $idt_eve_periodow=$idt_eve_periodo;
//   p($idt_eve_periodo);
   if  ($idt_eve_periodow=='')
   {
       $idt_eve_periodow=$_SESSION['idt_eve_periodo'];
   }
   $varw=$Data.' '.$Hora;
   $kselectw = 'select
                      cod_ordem
               from   evento_dia';
   $kwherew=' where   idt_eve_periodo='.$idt_eve_periodow;
   $kwherew=$kwherew.' and dtc_ini_dia<='.aspa($varw).' and dtc_fim_dia>='.aspa($varw);
   $korderbyw=' order by cod_ordem        ';
   $a=$kselectw.$kwherew.$korderbyw;
  // p($a);
  // exit();
   $ktabelaw = execsql($a);
   $ord_dia='';
   While ($row = mssql_fetch_array($ktabelaw))
   {
       $ord_dia=$row['cod_ordem'];
   }
   return $ord_dia;
}

//
// vetor com dias de realização do evento
//
function lupe_dias_realizacao_evento($idt_eve_periodo)
{
   $idt_eve_periodow=$idt_eve_periodo;
   if  ($idt_eve_periodow=='')
   {
       $idt_eve_periodow=$_SESSION['idt_eve_periodo'];
   }
   $kselectw = 'select *
               from   evento_dia';
   $kwherew=' where   idt_eve_periodo='.$idt_eve_periodow;
   $korderbyw=' order by cod_ordem        ';
   $a=$kselectw.$kwherew.$korderbyw;
 //  p($a);
   $ktabelaw = execsql($a);

   $vetor_dias_realizacao=Array();
   $vetor_elementos=Array();
   While ($row = mssql_fetch_array($ktabelaw))
   {
       $vetor_elementos[0]=$row['des_dia'];
       $vetor_elementos[1]=$row['dtc_ini_dia'];
       $vetor_elementos[2]=$row['dtc_fim_dia'];
       $vetor_elementos[3]=0;
       $vetor_elementos[4]=0;
       $vetor_elementos[5]=0;
       $vetor_dias_realizacao[$row['cod_ordem']]=$vetor_elementos;
   }
   return $vetor_dias_realizacao;
}
//
//  função para montar um determinado circuito
//
function lupe_vetor_circuito($idt_evento,$idt_eve_periodow,$idt_eve_dia,$idt_local,$cod_local_pass,$idt_amb_local,$idt_amb_eve_dia,$idt_orgao,$opcao_ocorrw,$vetor_dias_realizacao)
{
   global $qtd_colunas_desfile;
   global $vet_nome_postos;
//   if ($idt_local=='' || $idt_amb_local=='' || $idt_orgao=='')
   if ($idt_orgao=='')
   {
      return "nada";
   }
   else
   {
       $varw=1;
//       $kselectw = "select al.idt_amb_local,
       $kselectw = "select
                            l.idt_local,
                            l.cod_local,
                            l.sig_local,
                           l.nom_local
                    from local l
                    inner join tipo_local tl on l.idt_tip_local = tl.idt_tip_local";

       if  ($idt_local!=0)
       {

//               $kwherew=" where   l.idt_orgao  = ".$idt_orgao.


         $kwherew=" where   l.idt_orgao  = ".$idt_orgao." and l.cod_local = ".aspa($cod_local_pass)." and cod_sublocal<>0";



       }
       else
       {




               $kwherew=" where   l.idt_orgao  = ".$idt_orgao.

//                 " and  (l.cod_local=".aspa('DODO')." OR l.cod_local=".aspa('OSMAR')." OR l.cod_local=".aspa('BATATINHA').
      //                     " and (tl.tip_local = 'P' or tl.tip_local = 'A') ";
//                         ") and (tl.tip_local = 'P') ";

" and (tl.tip_local = 'P') ";



               // tem que ser assim

               $kwherew=" where   l.idt_orgao  = ".$idt_orgao;





       }

	   if  ($opcao_ocorrw=='desfileTOD' || $opcao_ocorrw=='circuito')
	   {
          if  ($idt_local!=0)
          {
               $kwherew=" where   l.idt_orgao  = ".$idt_orgao."
                       and l.cod_local = ".aspa($cod_local_pass).
			               		  " and (tl.tip_local  = 'P')
            	                    and (l.sts_oficial = 'S')";
		  }
		  else
		  {
             $kwherew=" where   l.idt_orgao  = ".$idt_orgao.
            		  " and (tl.tip_local  = 'P')
	                    and (l.sts_oficial = 'S')";
    	   }

	   }



	   if  ($opcao_ocorrw=='orgao_local')
	   {

	         $kwherew=" where   l.idt_eve_periodo  = ".$idt_eve_periodow;


	   }


//       p($kwherew.' /  '.$opcao_ocorrw);


       $korderbyw=" order by l.cod_local,l.cod_sublocal, l.nom_local";

       $a=$kselectw.$kwherew.$korderbyw;
       //
//	   p($a);
       $ktabelaw = execsql($a);
       //
       $matriz_circuito=Array();
       $matriz_postos=Array();
       $vet_nome_postos=Array();
       $qtd_locais=0;
       $qtd_postos=0;
       //
       $cod_local_ant='';
       While ($row = mssql_fetch_array($ktabelaw))
       {
           //
           //   para cada concatenar ataração
           //
           if  ($row['cod_local'] != $cod_local_ant)
           {
               if  ($cod_local_ant!='')
               {
                  $matriz_circuito[$cod_local_ant]=$matriz_postos;
               //   $matriz_circuito[$cod_local_ant.'_TOTAL'] =$matriz_postos;
                  $matriz_postos=Array();
               }
               $cod_local_ant=$row['cod_local'];
               $qtd_locais=$qtd_locais+1;
             //  $matriz_circuito[$row['cod_local']."_".$qtd_locais] =$vetor_dias_realizacao;
           }
           if  ($row['sig_local']=='')
           {
           }
           else
           {
               $qtd_postos=$qtd_postos+1;
               $matriz_postos[$row['sig_local'].$row['idt_local']] =$vetor_dias_realizacao;
               $vet_nome_postos[$row['sig_local'].$row['idt_local']]=$row['nom_local'];
           }
       }
       //
       //  totais
       //
       if  ($cod_local_ant!='')
       {
           $matriz_circuito[$cod_local_ant]=$matriz_postos;
       //    $matriz_circuito[$cod_local_ant.'_TOTAL'] =$matriz_postos;
       }
       return $matriz_circuito;
    }
}

/*
function lupe_vetor_circuito_old_30012008($idt_evento,$idt_eve_periodow,$idt_eve_dia,$idt_local,$idt_amb_local,$idt_amb_eve_dia,$idt_orgao,$vetor_dias_realizacao)
{
   global $qtd_colunas_desfile;
   global $vet_nome_postos;
//   if ($idt_local=='' || $idt_amb_local=='' || $idt_orgao=='')
   if ($idt_orgao=='')
   {
      return "nada";
   }
   else
   {
       $varw=1;
//       $kselectw = "select al.idt_amb_local,
       $kselectw = "select
                            l.cod_local,
                            l.sig_local,
                           l.nom_local
                    from local l
                    inner join tipo_local tl on l.idt_tip_local = tl.idt_tip_local";
        $kwherew=" where   l.idt_orgao  = ".$idt_orgao.
                 " and  (l.cod_local=".aspa('DODO')." OR l.cod_local=".aspa('OSMAR')." OR l.cod_local=".aspa('BATATINHA').
      //                     " and (tl.tip_local = 'P' or tl.tip_local = 'A') ";
                         ") and (tl.tip_local = 'P') ";
       $korderbyw=" order by l.cod_local,l.cod_sublocal, l.nom_local";

       $a=$kselectw.$kwherew.$korderbyw;
       //
       $ktabelaw = execsql($a);
       //
       $matriz_circuito=Array();
       $matriz_postos=Array();
       $vet_nome_postos=Array();
       $qtd_locais=0;
       $qtd_postos=0;
       //
       $cod_local_ant='';
       While ($row = mssql_fetch_array($ktabelaw))
       {
           //
           //   para cada concatenar ataração
           //
           if  ($row['cod_local'] != $cod_local_ant)
           {
               if  ($cod_local_ant!='')
               {
                  $matriz_circuito[$cod_local_ant]=$matriz_postos;
               //   $matriz_circuito[$cod_local_ant.'_TOTAL'] =$matriz_postos;
                  $matriz_postos=Array();
               }
               $cod_local_ant=$row['cod_local'];
               $qtd_locais=$qtd_locais+1;
             //  $matriz_circuito[$row['cod_local']."_".$qtd_locais] =$vetor_dias_realizacao;
           }
           if  ($row['sig_local']=='')
           {
           }
           else
           {
               $qtd_postos=$qtd_postos+1;
               $matriz_postos[$row['sig_local']] =$vetor_dias_realizacao;
               $vet_nome_postos[$row['sig_local']]=$row['nom_local'];
           }
       }
       //
       //  totais
       //
       if  ($cod_local_ant!='')
       {
           $matriz_circuito[$cod_local_ant]=$matriz_postos;
       //    $matriz_circuito[$cod_local_ant.'_TOTAL'] =$matriz_postos;
       }
       return $matriz_circuito;
    }
}
*/
/////////////////////////////////////////////////////
//
//  função para montar contextos
//
function lupe_vetor_contexto($idt_evento,$idt_eve_periodow,$idt_eve_dia,$idt_local,$cod_local_pass,$idt_amb_local,$idt_amb_eve_dia,$idt_orgao,$opcao_ocorrw,$vetor_dias_realizacao)
{
   global $qtd_colunas_contexto;
   global $vet_nome_focos;
//   if ($idt_local=='' || $idt_amb_local=='' || $idt_orgao=='')
   if ($idt_orgao=='')
   {
      return "nada";
   }
   else
   {
       $kselectw = "select
                           con.nom_contexto,
                           foc.nom_foco
                    from Contexto con
                    inner join foco foc on foc.idt_contexto = con.idt_contexto";
       $kwherew=" where   con.idt_orgao  = ".$idt_orgao.' and con.idt_eve_periodo='.$idt_eve_periodow;
       $korderbyw=" order by con.nom_contexto,foc.nom_foco";
       $a=$kselectw.$kwherew.$korderbyw;
       $ktabelaw = execsql($a);
       $matriz_contexto=Array();
       $matriz_foco=Array();
       $vet_nome_foco=Array();
       $qtd_contextos=0;
       $qtd_focos=0;
       //
       $cod_contexto_ant='';
       While ($row = mssql_fetch_array($ktabelaw))
       {
           //
           //   para cada concatenar ataração
           //
           if  ($row['nom_contexto'] != $cod_contexto_ant)
           {
               if  ($cod_contexto_ant!='')
               {
                  $matriz_contexto[$cod_contexto_ant]=$matriz_focos;
                  $matriz_focos=Array();
               }
               $cod_contexto_ant=$row['nom_contexto'];
               $qtd_contextos=$qtd_contextos+1;
           }
           if  ($row['nom_foco']=='')
           {
           }
           else
           {
               $qtd_focos=$qtd_focos+1;
               $matriz_focos[$row['nom_foco']] =$vetor_dias_realizacao;
               $vet_nome_focos[$row['nom_foco']]=$row['nom_foco'];
           }
       }
       //
       //  totais
       //
       if  ($cod_contexto_ant!='')
       {
           $matriz_contexto[$cod_contexto_ant]=$matriz_focos;
       //    $matriz_circuito[$cod_local_ant.'_TOTAL'] =$matriz_postos;
       }

//	   p($matriz_contexto);

       return $matriz_contexto;
    }
}
//
//  função para montar orgaos
//
function lupe_vetor_evento($idt_evento,$idt_eve_periodow,$idt_eve_dia,$idt_local,$cod_local_pass,$idt_amb_local,$idt_amb_eve_dia,$idt_orgao,$opcao_ocorrw,$vetor_dias_realizacao)
{
   global $qtd_colunas_orgao;
   global $vet_nome_orgaos;
//   if ($idt_local=='' || $idt_amb_local=='' || $idt_orgao=='')
//   if ($idt_orgao=='')
//   {
//      return "nada";
//   }
//   else
//   {
       $kselectw = "select  org.nom_orgao from orgao org";
       $kwherew=" where   idt_eve_periodo=".$idt_eve_periodow;
       $korderbyw=" order by org.nom_orgao";
       $a=$kselectw.$kwherew.$korderbyw;
       $ktabelaw = execsql($a);

       $matriz_eventos=Array();
       $matriz_orgaos=Array();
       $vet_nome_orgaos=Array();
       $qtd_eventos=0;
       $qtd_orgaos=0;

//	   p($a);

       //
       $cod_evento_ant='CARNAVAL 2008';
       While ($row = mssql_fetch_array($ktabelaw))
       {
           //
           //   para cada concatenar ataração
           //
           if  ($row['nom_orgao']=='')
           {
           }
           else
           {

           $qtd_orgaos=$qtd_orgaos+1;
           $matriz_orgaos[$row['nom_orgao']] =$vetor_dias_realizacao;

           $vet_nome_orgaos[$row['nom_orgao']]=$row['nom_orgao'];
		   }
       }
       //
       //  totais
       //
       $matriz_eventos[$cod_evento_ant]=$matriz_orgaos;

       return $matriz_eventos;
// }
}




////////////////////////////////////////////////////





function lupe_qualificador_primario($idt_ocorr_precad)
{
   $varw=1;
   // select
   $kselectw = 'select
                      des_qualificador
               from   qualificador_primario';
   $kwherew=' where   idt_ocorr_precad='.$idt_ocorr_precad;
   $korderbyw=' order by des_qualificador        ';
   $a=$kselectw.$kwherew.$korderbyw;
   $ktabelaw = execsql($a);
   //
   $kqualificadores='';
   $separaw='';
   While ($row = mssql_fetch_array($ktabelaw))
   {
       //
       //   para cada concatenar ataração
       //
//     $string_trabw=str_replace('/','<br>',$row['nom_atracao']);
//     $katracoes=$katracoes.$separaw.$row['nom_atracao'];
       $string_trabw=$row['des_qualificador'];
       $kqualificadores=$kqualificadores.$separaw.$string_trabw;
       $separaw='<br>';
   }
   return $kqualificadores;
}



function lupe_qualificador_secundario($idt_ocorr_precad)
{
   $varw=1;
   // select
   $kselectw = 'select
                      des_qualificador
               from   qualificador_secundario';
   $kwherew=' where   idt_ocorr_precad='.$idt_ocorr_precad;
   $korderbyw=' order by des_qualificador        ';
   $a=$kselectw.$kwherew.$korderbyw;
   $ktabelaw = execsql($a);
   //
   $kqualificadores='';
   $separaw='';
   While ($row = mssql_fetch_array($ktabelaw))
   {
       //
       //   para cada concatenar ataração
       //
//     $string_trabw=str_replace('/','<br>',$row['nom_atracao']);
//     $katracoes=$katracoes.$separaw.$row['nom_atracao'];
       $string_trabw=$row['des_qualificador'];
       $kqualificadores=$kqualificadores.$separaw.$string_trabw;
       $separaw='<br>';
   }
   return $kqualificadores;
}
//
//  função para montar um determinado circuito
//
function lupe_montar_circuito($idt_evento,$idt_eve_periodow,$idt_eve_dia,$idt_local,$idt_amb_local,$idt_amb_eve_dia,$idt_orgao, $origem)
{
   global $qtd_colunas_desfile;
   global $colunas_cabecalho_nome;

   //global $colunas_cabecalho;
//   echo "entrou....".$idt_local;
//   echo "entrou....".$idt_amb_local;

   if ($idt_local=='' || $idt_amb_local=='' || $idt_orgao=='')
   {
      return "nada";
   }
   else
   {
   $varw=1;
   $kselectw = "select al.idt_amb_local,
                        l.sig_local,
                        l.nom_local
                from local l
                inner join local l_pai on l.cod_local = l_pai.cod_local
                inner join ambiente_local al on l.idt_local = al.idt_local
                inner join ambiente_local al_pai on l_pai.idt_local = al_pai.idt_local
                      and al.idt_ambiente = al_pai.idt_ambiente
                inner join tipo_local tl on l.idt_tip_local = tl.idt_tip_local";

   if ($origem == 'palco') {
	   $kwherew=" where  l_pai.idt_local = ".$idt_local." and al_pai.idt_amb_local = ".$idt_amb_local.
						 " and l.idt_orgao  = ".$idt_orgao.
						 " and (tl.tip_local = 'P') ";
   } else {
	   $kwherew=" where  l_pai.idt_local = ".$idt_local." and al_pai.idt_amb_local = ".$idt_amb_local.
						 " and l.idt_orgao  = ".$idt_orgao.
						 " and l.sts_oficial='S' and (tl.tip_local = 'P') ";
   }

   $korderbyw=" order by l.cod_sublocal, l.nom_local";

   $a=$kselectw.$kwherew.$korderbyw;
   //
   $ktabelaw = execsql($a);
   //
   $colunas_cabecalho=Array();
   $colunas_cabecalho_nome=Array();
   $kiw=0;
   $colunas_cabecalho['DIA'] ='DIA';
   $colunas_cabecalho_nome['DIA'] ='DIA';
   $kiw=$kiw+1;
   $colunas_cabecalho['ENTIDADE'] ='ENTIDADE';
   $colunas_cabecalho_nome['ENTIDADE'] ='ENTIDADE';
   $kiw=$kiw+1;
   $colunas_cabecalho['ATRAÇÃO'] ='ATRAÇÃO';
   $colunas_cabecalho_nome['ATRAÇÃO'] ='ATRAÇÃO';
   $kiw=$kiw+1;
   $colunas_cabecalho['CATEGORIA'] ='CATEGORIA';
   $colunas_cabecalho_nome['CATEGORIA'] ='CATEGORIA';
// echo "entrou.... para carregar cabecalho";
   While ($row = mssql_fetch_array($ktabelaw))
   {
       //
       //   para cada concatenar ataração
       //
       $kiw=$kiw+1;
  //     echo "carregando cabecalho".$row['sig_local'];
       if  ($row['sig_local']=='')
       {
  //          echo "carregando cabecalho com local nullo erro ";
       }
       else
       {
       $qtd_colunas_desfile=$qtd_colunas_desfile+1;

       $colunas_cabecalho[$row['sig_local']] =$row['sig_local'];
       //
       $colunas_cabecalho_nome[$row['sig_local']] =$row['nom_local'];
       //
       }
   }

   // totais
   $qtd_colunas_desfile=$qtd_colunas_desfile+1;
   $colunas_cabecalho['TOTAL'] ="TOTAL";
   $colunas_cabecalho_nome['TOTAL'] ="TOTAL";


//   p($colunas_cabecalho);

//   echo "saindo do carregando cabecalho";
   return $colunas_cabecalho;
   }
}

function lupe_montar_entidade_no_circuito($idt_evento,$idt_eve_periodow,$idt_eve_dia,$idt_local,$idt_amb_local,$idt_amb_eve_dia,$idt_orgao, $origem = '')
{

// guy2222


//
    global $colunas_cabecalho;
    global $colunas_cabecalho_nome;
    //
//    echo " entrou para gerar espetaculos.....";
    $idt_orgao=$_SESSION['idt_orgao'];
    $espetaculos=Array();
    $espetaculos=lupe_gera_espetaculos($idt_evento,$idt_eve_periodow,$idt_eve_dia,$idt_local,$idt_amb_local,$idt_amb_eve_dia,$idt_orgao,'','');
//    p($espetaculos);
//    exit();
//    echo " entrou para montar circuito.....";
    $colunas_cabecalho=Array();
    $colunas_cabecalho=lupe_montar_circuito($idt_evento,$idt_eve_periodow,$idt_eve_dia,$idt_local,$idt_amb_local,$idt_amb_eve_dia,$idt_orgao, $origem);

//    echo " gerar cabecalho.....";

    $sql = "select sig_local from local where idt_local = $idt_local";
    $row_cir = mssql_fetch_array(execsql($sql));
    $sig_circuito = $row_cir['sig_local'];

//   p($colunas_cabecalho_nome);

    $entidades_no_circuito=Array();
    $resultado_final=Array();
    $vetotordemcabw=Array();
    $kiw=-1;
    ForEach($colunas_cabecalho as $index_vetor => $Valor )
    {
         $kiw=$kiw+1;
         $vetotordemcabw[$kiw]=$Valor;
    }
    //  p($vetotordemcabw);
    $idt_entidade_ant=0;
    $idt_ordem_ant=0;
    //
    $kqtq_linw=count($espetaculos)-1;
    $kqtqw=count($vetotordemcabw)-1;
    $kiniciaremw=4;
    $kentw=-1;
    $kindcelulaw=-1;
    $entidades_no_circuito=Array();

    $entidades_celulas_circuito=Array();

    $entidades_celulas_conteudo=Array();
    $entidades_celulas_conteudo_passagem=Array();
    // inicializa vetor
//    for  ($klw=$kiniciaremw; $klw<=20; $klw+=1 )
//    {
//         $entidades_celulas_circuito[$klw]='###';
//    }

    $entidades_celulas_circuito=lupe_LimpaArray ($entidades_celulas_circuito);
//    print_r ($entidades_celulas_circuito);

    $entidades_celulas_conteudo=lupe_LimpaArray ($entidades_celulas_conteudo);

//  echo " gerar tabela com entidades.....";

    for  ($kjw=0; $kjw<=$kqtq_linw; $kjw+=1 )
    {

         $entidades=$espetaculos[$kjw];
         //
         $idt_espetaculo =$entidades[0];
         $idt_entidade =$entidades[1];
         $nom_entidade =$entidades[2];
         $categoria    =$entidades[4];
         $atracoes     =$entidades[5];
         $sig_local    =$entidades[8];
         $Hora_inicio  =$entidades[9];
         $Hora_final   =$entidades[10];
         $dia          =$entidades[12];
         $idt_amb_local=$entidades[14];


         $idt_ordem =  $entidades[17];


         if  ($Hora_final=='')
         {
             $Hora_final='&nbsp;&nbsp;?';
         }
         if  (($idt_ordem.$idt_entidade == $idt_ordem_ant.$idt_entidade_ant) || $idt_entidade_ant==0)
         {
              if ($idt_entidade_ant==0)
              {
                  $idt_entidade_ant=$idt_entidade;
                  $idt_ordem_ant=$idt_ordem;

                  //  dia
                  $kindcelulaw=$kindcelulaw+1;
                  $entidades_celulas_circuito[$kindcelulaw]=$dia;
                  $kindcelulaw=$kindcelulaw+1;
                  $entidades_celulas_circuito[$kindcelulaw]=$nom_entidade;
                  //  atração
                  $kindcelulaw=$kindcelulaw+1;
                  $entidades_celulas_circuito[$kindcelulaw]=$atracoes;
                  //  categoria
                  $kindcelulaw=$kindcelulaw+1;
                  $entidades_celulas_circuito[$kindcelulaw]=$categoria;
//                  $vet_local_passagem=Array();
//                  $vet_local_passagem=Array(-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1-1,-1,-1,-1,-1,-1,-1,-1,-1,-1);
                    $vet_local_passagem=Array();
              }
         }
         else
         {  // nova linha
             // salva entidade anterior
             $kentw=$kentw+1;
             $entidades_no_circuito[$kentw]=$entidades_celulas_circuito;


             $entidades_celulas_conteudo='';

             $entidades_celulas_circuito=lupe_LimpaArray ($entidades_celulas_circuito);
             //
             // nova entidade
             //
             $idt_entidade_ant=$idt_entidade;
             $idt_ordem_ant=$idt_ordem;


//           $vet_local_passagem=Array(-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1-1,-1,-1,-1,-1,-1,-1,-1,-1,-1);
             $vet_local_passagem=Array();

             $kiniciaremw=4;
             $kindcelulaw=-1;
             $nom_entidade =$entidades[2];
             //  dia
             $kindcelulaw=$kindcelulaw+1;
             $entidades_celulas_circuito[$kindcelulaw]=$dia;
             $kindcelulaw  =$kindcelulaw+1;
             $entidades_celulas_circuito[$kindcelulaw]=$nom_entidade;
             //  atração
             $kindcelulaw=$kindcelulaw+1;
             $entidades_celulas_circuito[$kindcelulaw]=$atracoes;
             //  categoria
             $kindcelulaw=$kindcelulaw+1;
             $entidades_celulas_circuito[$kindcelulaw]=$categoria;
//           $entidades_celulas_circuito=Array();
         }

         // para cada coluna guy

         for  ($klw=$kiniciaremw; $klw<=$kqtqw; $klw+=1 )
         {
            if ($sig_local==$vetotordemcabw[$klw])
            {   // preenche dados da celula cruzamento entidade X posto
                $entidades_celulas_conteudo_passagem = Array();

                $entidades_celulas_conteudo_passagem[0]=$sig_local;
                $entidades_celulas_conteudo_passagem[1]=$Hora_inicio."&nbsp;&nbsp;&nbsp;".$Hora_final;
                $entidades_celulas_conteudo_passagem[2]=$Hora_inicio;
                $entidades_celulas_conteudo_passagem[3]=$Hora_final;
                $entidades_celulas_conteudo_passagem[4]=$dia;
                $entidades_celulas_conteudo_passagem[5]=$idt_espetaculo;
                $entidades_celulas_conteudo_passagem[6]=$idt_amb_local;

                $entidades_celulas_circuito[$klw][]=$entidades_celulas_conteudo_passagem;
            }
         }
    }


    if  ($kindcelulaw>1)
    {
        // salva última entidade
        $kentw=$kentw+1;
        $entidades_no_circuito[$kentw]=$entidades_celulas_circuito;
    }

//    p('ent circuito');

//    p($entidades_no_circuito);
    //
    // calcular tempo do desfile
    //
    $kqtq_linhasw=count($entidades_no_circuito)-1;
    //p($entidades_no_circuito);
    for  ($kjw=0; $kjw<=$kqtq_linhasw; $kjw+=1 )
    {  // para cada entidade, calcular o tempo total de desfile

          $entidades_celulas_circuito=$entidades_no_circuito[$kjw];

          $qtd_colunas_desfile_trabw=(count($colunas_cabecalho)-1)+4-1;

          $primeirahora='';
          $primeirahora_ordena = '';
          $ultimahora='';
          for  ($kdw=4; $kdw<=$qtd_colunas_desfile_trabw; $kdw++ )
          {
                $entidades_celulas_conteudo_circuito=$entidades_celulas_circuito[$kdw];
                $entidades_celulas_conteudo_datas1_circuito=Array();

                if  (is_array($entidades_celulas_conteudo_circuito[0]) == true)
                {
                    ForEach($entidades_celulas_conteudo_circuito as $pos => $entidades_celulas_conteudo_datas1_circuito) {
                        $string1 = $entidades_celulas_conteudo_datas1_circuito[2]; // inicial
                        $primeirahora = lupe_verifica_primeira_hora($string1, $primeirahora);
                        $string2 = $entidades_celulas_conteudo_datas1_circuito[3]; // final
                        $ultimahora = lupe_verifica_ultima_hora($string2, $ultimahora, $string1);

                        if (mb_strtolower($sig_circuito) == mb_strtolower('osmar')) {
                            if (mb_strtolower(trim($entidades_celulas_conteudo_datas1_circuito[0])) == mb_strtolower(trim("PINHO"))) {
    							$primeirahora_ordena = lupe_verifica_primeira_hora($string1, $primeirahora_ordena);;
    						}
                        } else {
                            if (mb_strtolower(trim($entidades_celulas_conteudo_datas1_circuito[0])) != mb_strtolower(trim("VIT"))) {
    							$primeirahora_ordena = lupe_verifica_primeira_hora($string1, $primeirahora_ordena);;
    						}
                        }
                    }
                }
          }

          $tempo=lupe_tempo($primeirahora,$ultimahora);
          $kindcelulaw=(count($colunas_cabecalho)-1);

          $entidades_no_circuito[$kjw][$kindcelulaw]=$tempo;

          if ($primeirahora_ordena == '')
              $ordem = '300:00';
          else if  ($primeirahora_ordena >= "00:00" & $primeirahora_ordena <= "07:59")
              $ordem = '2'.$primeirahora_ordena;
          else
              $ordem = '1'.$primeirahora_ordena;

          $resultado_final[$ordem.str_repeat("0", strlen(count($entidades_no_circuito)) - strlen($kjw)) . $kjw] = $entidades_no_circuito[$kjw];
    }

    ksort($resultado_final);
    reset($resultado_final);

    //p($resultado_final);

    //Ordenado por hora de armação
    //return $entidades_no_circuito;

    //Ordenado por data de inicio de espetaculo
    return $resultado_final;
}
//
//  para ocorrencias de um espetáculo
//
function lupe_ocorrencias_Espetaculo($eventow,$periodow,$idt_espetaculo)
{
   $evento_trabw =$eventow;         // evento
   $periodo_trabw=$periodow;        // periodo
   // select
   $kselectw = 'select
                      ocorrencia.idt_ocorrencia,
                      ocorrencia.idt_pessoa,
                      ocorrencia.idt_orgao,
                      ocorrencia.idt_amb_eve_dia,
                      ocorrencia.idt_amb_local,
                      ocorrencia.idt_espetaculo,
                      ocorrencia.idt_entidade,
                      ocorrencia.idt_atracao,
                      ocorrencia.idt_local_trecho,
                      ocorrencia.dtc_registro,
                      ocorrencia.dtc_ocorrencia,
                      ocorrencia.hor_ocorrencia,
                      ocorrencia.idt_contexto,
                      ocorrencia.idt_foco,
                      ocorrencia.idt_tipo_ocorr,
                      ocorrencia.idt_ocorr_precad,
                      ocorrencia.idt_qualificador_primario,
                      ocorrencia.des_qualificador_primario,
                      ocorrencia.idt_qualificador_secundario,
                      ocorrencia.des_qualificador_secundario,
                      convert(text, ocorrencia.des_ocorrencia) as des_ocorrencia,
                      evento.idt_evento,
                      evento.nom_evento,
                      evento_periodo.idt_eve_periodo,
                      evento_periodo.cod_periodo,
                      evento_dia.idt_eve_dia,
                      evento_dia.des_dia,
                      local.idt_local,
                      local.nom_local,
                      ambiente.idt_ambiente,
                      ambiente.nom_ambiente,
                      pessoa.nom_pessoa,
                      orgao.nom_orgao,
                      atracao.nom_atracao,
                      entidade.nom_entidade,
                      trecho.idt_trecho,
                      trecho.nom_trecho,
                      contexto.nom_contexto,
                      foco.nom_foco,
                      tipo_ocorrencia.nom_tipo_ocorrencia,
                      ocorrencia_pre_cadastrada.nom_ocorrencia,
                      qualificador_primario.des_qualificador as des_qualificador1
                from ocorrencia as ocorrencia
                LEFT JOIN   pessoa ON ocorrencia.idt_pessoa = pessoa.idt_pessoa
                LEFT JOIN   orgao ON ocorrencia.idt_orgao = orgao.idt_orgao
                LEFT JOIN   ambiente_evento_dia ON ocorrencia.idt_amb_eve_dia = ambiente_evento_dia.idt_amb_eve_dia

                LEFT JOIN   evento_dia ON  ocorrencia.dtc_ocorrencia = evento_dia.dtc_dia

                LEFT JOIN   evento_periodo ON evento_periodo.idt_eve_periodo = '.$periodo_trabw.'
                LEFT JOIN   evento         ON evento.idt_evento = '.$evento_trabw.'
                LEFT JOIN   ambiente_local ON ocorrencia.idt_amb_local = ambiente_local.idt_amb_local

                LEFT JOIN   local    ON local.idt_local       = ambiente_local.idt_local
                LEFT JOIN   ambiente ON ambiente.idt_ambiente = ambiente_local.idt_ambiente
                LEFT JOIN   espetaculo ON ocorrencia.idt_espetaculo = espetaculo.idt_espetaculo AND pessoa.idt_pessoa = espetaculo.idt_pessoa AND
                            ambiente_evento_dia.idt_amb_eve_dia = espetaculo.idt_amb_eve_dia AND ambiente_local.idt_amb_local = espetaculo.idt_amb_local
                LEFT JOIN   entidade ON ocorrencia.idt_entidade = entidade.idt_entidade AND espetaculo.idt_entidade = entidade.idt_entidade
                LEFT JOIN   atracao ON ocorrencia.idt_atracao = atracao.idt_atracao
                LEFT JOIN   local_trecho ON ocorrencia.idt_local_trecho = local_trecho.idt_local_trecho
                LEFT JOIN   trecho   ON local_trecho.idt_trecho = trecho.idt_trecho
                LEFT JOIN   contexto ON ocorrencia.idt_contexto = contexto.idt_contexto
                LEFT JOIN   foco ON ocorrencia.idt_foco = foco.idt_foco AND contexto.idt_contexto = foco.idt_contexto
                LEFT JOIN   tipo_ocorrencia ON ocorrencia.idt_tipo_ocorr = tipo_ocorrencia.idt_tipo_ocorr AND foco.idt_foco = tipo_ocorrencia.idt_foco
                LEFT JOIN   ocorrencia_pre_cadastrada ON ocorrencia.idt_ocorr_precad = ocorrencia_pre_cadastrada.idt_ocorr_precad AND
                            tipo_ocorrencia.idt_tipo_ocorr = ocorrencia_pre_cadastrada.idt_tipo_ocorr
                LEFT JOIN   qualificador_primario ON ocorrencia.idt_qualificador_primario = qualificador_primario.idt_qualificador_primario AND
                            ocorrencia_pre_cadastrada.idt_ocorr_precad = qualificador_primario.idt_ocorr_precad';


//
//                LEFT JOIN   qualificador_secundario ON ocorrencia.idt_qualificador_secundario = qualificador_secundario.idt_qualificador_secundario AND
//                            qualificador_primario.idt_qualificador_primario = qualificador_secundario.idt_qualificador_primario';
    // where
    //                LEFT JOIN   ambiente_local ON ocorrencia.idt_amb_local = ambiente_local.idt_amb_local AND
    //                            ambiente_evento_dia.idt_amb_local = ambiente_local.idt_amb_local

    $kwherew=' where evento.idt_evento='.$evento_trabw.' and evento_periodo.idt_eve_periodo='.$periodo_trabw.
             '        and ocorrencia.idt_espetaculo='.$idt_espetaculo;
    // ordenação
    $korderbyw=' order by ocorrencia.dtc_ocorrencia, hor_ocorrencia';

    $a=$kselectw.$kwherew.$korderbyw;

//    p($a);
//    exit();


    $ktabelaw = execsql($a);
    $vet_ocorrencias = Array();
    //
    While ($row = mssql_fetch_array($ktabelaw)) {
           $ocorrencia = Array();
           $ocorrencia[0]=$row['idt_ocorrencia'];
           $ocorrencia[1]=$row['dtc_ocorrencia'];
           $ocorrencia[2]=$row['hor_ocorrencia'];
           $ocorrencia[3]=$row['nom_contexto'];
           $ocorrencia[4]=$row['nom_foco'];
           $ocorrencia[5]=$row['nom_tipo_ocorrencia'];
           $ocorrencia[6]=$row['des_ocorrencia'];
           $ocorrencia[7]=$row['des_qualificador1'];            // descritivo
           $ocorrencia[8]=$row['des_qualificador_primario'];    // conteúdo
           $des_qualificador2=lupe_qualificador_secundario($ocorrencia[0]);
           $ocorrencia[9]=$des_qualificador2;
           $ocorrencia[10]=$row['des_qualificador_secundario'];
           $vet_ocorrencias[$row['idt_ocorrencia']]=$ocorrencia;
    }
    return  $vet_ocorrencias;
}

//
//  para acões de uma ocorrencia
//
function lupe_ocorrencias_acao($idt_ocorrencia)
{
   $evento_trabw =$eventow;         // evento
   $periodo_trabw=$periodow;        // periodo
   // select
   $kselectw = 'select
                      oac.idt_oco_acao,
                      oac.idt_acao,
                      oac.des_obs,
                      aca.nom_acao,
                      aca.des_acao
                from ocorrencia_acao as oac
                left join acao       aca  on oac.idt_acao = aca.idt_acao

                left join ocorrencia oco  on oac.idt_ocorrencia = oco.idt_ocorrencia';

                //                left join acao_orgao aco  on aca.idt_acao = aco.idt_acao

    $kwherew=' where oco.idt_ocorrencia='.$idt_ocorrencia;
    // ordenação
    $korderbyw=' order by oco.dtc_ocorrencia, oco.hor_ocorrencia';
    $a=$kselectw.$kwherew.$korderbyw;
    $ktabelaw = execsql($a);
    $vet_acoes = Array();
    While ($row = mssql_fetch_array($ktabelaw)) {
           $acao = Array();
           $acao[0]=$row['idt_oco_acao'];
           $acao[1]=$row['idt_acao'];
           $acao[2]=$row['nom_acao'];
           $acao[3]=$row['des_acao'];
           $acao[4]=$row['des_obs'];
           //
           // órgãos avisados
           //

           $selw = 'select    org.idt_orgao,
                              org.nom_orgao
                    from  acao as aca
                       left  join acao_orgao aco on aca.idt_acao = aco.idt_acao
                       left  join orgao org on aco.idt_orgao = org.idt_orgao
                    where aco.idt_acao='.$row['idt_acao'];

  //                  p('nnnnnnnnnn'.$row['idt_acao']);

           $ktabela2w = execsql($selw);
           $vet_orgaos=Array();
           $vet_orgaos_acao=Array();
           While ($row2 = mssql_fetch_array($ktabela2w)) {
                 $vet_orgaos_acao=Array();
                 $vet_orgaos_acao[0]=$row2['idt_orgao'];
                 $vet_orgaos_acao[1]=$row2['nom_orgao'];
                 $vet_orgaos[$row2['idt_orgao']]=$vet_orgaos_acao;
           }
           $acao[5]=$vet_orgaos;

           $vet_acoes[$acao[0]] = $acao;
    }
//    p($vet_acoes);
    return  $vet_acoes;
}






function lupe_LimpaArray ($x)
{
  for ($a = 0; $a < count ($x); $a++){
    $x[$a] = "";
    array_shift ($x);
    array_pop ($x);
  }
  return $x;
}

function lupe_tempo($Hora_inicio,$Hora_final)
{
    // fazer diferença
    $tempo='tempo';
    // verificar primeira hora
    $date1="01/02/2008";
    $date2="02/02/2008";

    $date3='';
    $date4='';


//
//$databd=''; // coloque a data vinda do banco de dados
//$databd= explode("-",$databd);
//$data = mktime(0,0,0,$databd[1],$databd[2],$databd[0]);
//$data_atual = mktime(0,0,0,date("m"),date("d"),date("Y"));
//$dias = ($data - $data_atual)/86400;
//$dias = ceil($dias);
//
//    int mktime ( [int hora [, int minuto [, int second [, int mes [, int dia [, int ano [, int is_dst]]]]]]] )

    $hh_ma=explode(":",$Hora_final);
    $hh_me=explode(":",$Hora_inicio);


  //  p($hh_ma);
//    p($hh_me);


//    $nummaior=mktime( int hora , int minuto , 0 , 2 , 1 , 2008 )

   //
   // tratar entidade que ainda não entrou no desfile --- tempo = 0
   //

   $tempo=0;
   if  ($Hora_inicio=='' || $Hora_final=='')
   {
          // entidade sem desfilar
        $hhmm=gmdate("H:i", $tempo);
        return $hhmm;
   }
   if  ($Hora_final=='&nbsp;&nbsp;?' || $Hora_final=='' )
   {   // assumir a hora atual do sistema??????

   echo"nada????".$Hora_final;

   }

    if  ($Hora_inicio>="00:00" & $Hora_inicio<="07:59")
    {
        $nenor=mktime( $hh_me[0] , $hh_me[1] , 0 , 2 , 2 , 2008 );
    }
    else
    {
        $nenor=mktime( $hh_me[0] , $hh_me[1] , 0 , 2 , 1 , 2008 );
    }
    if  ($Hora_final>="00:00" & $Hora_final<="07:59")
    {
//        $date4=date('d/m/Y H:i:s',$date2." ".$Hora_final);
        $maior=mktime( $hh_ma[0] , $hh_ma[1] , 0 , 2 , 2 , 2008 );
    }
    else
    {
        $maior=mktime( $hh_ma[0] , $hh_ma[1] , 0 , 2 , 1 , 2008 );
    }
    $tempo=$maior-$nenor;

//    p($Hora_inicio);
//    p($Hora_final);

//    p($maior);
//    p($menor);
//    p($tempo);

//    $hhmm=$tempo/3600;
    $hhmm=gmdate("H:i", $tempo);



    return $hhmm;
}


function lupe_verifica_primeira_hora($Hora_inicio,$primeirahora)
{
    // verificar primeira hora
    $date1="1";
    $date2="2";
    $date3='';
    $date4='';
    if  ($primeirahora=='')
    {
        return $Hora_inicio;
    }
    //
//    $hora=str_replace(':','',$primeirahora)
    if  ($Hora_inicio>="00:00" & $Hora_inicio<="07:59")
    {
        $date3=$date2." ".$Hora_inicio;
    }
    else
    {
        $date3=$date1." ".$Hora_inicio;
    }
    if  ($primeirahora>="00:00" & $primeirahora<="07:59")
    {
        $date4=$date2." ".$primeirahora;
    }
    else
    {
        $date4=$date1." ".$primeirahora;
    }
    if  ($date3<$date4)
    {
        $hora=$Hora_inicio;
    }
    else
    {
       $hora=$primeirahora;
    }
    //
    return $hora;
}

function lupe_verifica_ultima_hora($Hora_final,$ultimahora,$Hora_inicial)
{
    // verificar ultima hora
    $date1="1";
    $date2="2";

    $date3='';
    $date4='';


    $Hora_finalw=$Hora_final;

    if  (($Hora_final == '&nbsp;&nbsp;?') || ($Hora_finalw==''))
    {
        if ($ultimahora == '')
            return $Hora_inicial;
        else
            return $ultimahora;
    }

    if  ($ultimahora == '')
    {
       return $Hora_finalw;
    }

    if  ($Hora_finalw>="00:00" & $Hora_finalw<="07:59")
    {
        $date3=$date2." ".$Hora_finalw;
    }
    else
    {
        $date3=$date1." ".$Hora_finalw;
    }

    if  ($ultimahora>="00:00" & $ultimahora<="07:59")
    {
        $date4=$date2." ".$ultimahora;
    }
    else
    {
        $date4=$date1." ".$ultimahora;
    }
    if  ($date3>$date4)
    {
        $hora=$Hora_finalw;
    }
    else
    {
       $hora=$ultimahora;
    }

    return $hora;
}

function lupe_acessa_usuario_sca($idt_usuario_sca)
{
   $usuario_sca='';
   $kselectw = 'SELECT
                idt_usuario,
                idt_orgao,
                cod_usuario,
                nom_usuario,
                des_usuario
       from
            bd_prodasal_seg.dbo.usuario';

   $kwherew=' where idt_usuario = '.$idt_usuario_sca;
   $korderbyw='';
   $a=$kselectw.$kwherew.$korderbyw;
   $ktabelaw = execsql($a);
//
// $usuario_sca=$row['nom_usuario'];
//
   $row = mssql_fetch_array($ktabelaw);

   return  	$row['nom_usuario'];

}







/////
////    FUNÇÕES EXISTENTES
////
function LUPE_criar_tabela($rs, $vetCampo, $idCampo, $novo = true, $edit = true, $prefixo = 'cadastro', $novomenu = '', $vetFiltro = '', $pagina = 'conteudo.php', $chamada_js = 'self.parent') {
    global $menu, $reg_pagina, $num_pagina, $goCad, $upCad, $target_frm, $local_menu, $local_acao, $btn_js;

    if ($novomenu == '')
      $menulocal = $menu;
    else
      $menulocal = $novomenu;

    if (is_array($vetFiltro)) {
        ForEach($vetFiltro as $Filtro) {
            $extra_url .= '&'.$Filtro['id'].'='.$Filtro['valor'];
        }
    }

    if ($_REQUEST['p'] != '') {
        $extra_url .= '&p='.$_REQUEST['p'];
    }

    if (is_array($upCad) || $novo)
        $tab_novo = true;
    else
        $tab_novo = false;

    $tab_edit = true;

    echo "<script type='text/javascript'>var goCad = new Array();</script>\n";
    echo '<iframe src="goCad.php" class="MenuGeral" name="MenuGeral" id="MenuGeral" frameborder="0" scrolling="no" onmouseout="MenuAbre(-1)"></iframe>';
    echo "<table width='100%' border='1' cellspacing='0' cellpadding='0' vspace='0' hspace='0' class='Generica'>\n";
    echo "<tr class='Generica'>\n";

    if ($tab_novo) {
        echo "<td class='Acao' width='1%' nowrap>";

        if ($novo) {
            if (acesso($menulocal, 'INC') || acesso($local_menu, $local_acao))
                echo "<a target='$target_frm' href='$pagina?acao=INC&id=0$extra_url&prefixo=$prefixo&menu=$menulocal' class='Titulo'><img src='imagens/Incluir.gif' border='0' alt='Incluir'></a>";
            else if (TemDireito($menulocal, 'INC') || TemDireito($local_menu, $local_acao))
                echo "<img src='imagens/Incluir.gif' border='0' alt='Incluir'>";
        }

        if (is_array($upCad)) {
            if ($upCad['cond_campo'] == '')
                $mostra = true;
            else if ($row[$upCad['cond_campo']] == $upCad['cond_valor'])
                $mostra = true;
            else
                $mostra = false;

            if ($mostra) {
                $url = '';

                if ($upCad['campo'] != '') {
                    ForEach(explode(',', $upCad['campo']) as $dbCampo)
                        if ($row[$dbCampo] != '')
                            $url .= "&$dbCampo=".$row[$dbCampo];
                        else
                            $url .= "&$dbCampo=".$_REQUEST[$dbCampo];
                }

                echo '&nbsp;';

                if (acesso($upCad['menu']))
                    echo "<a class='Registro' target='$target_frm' href='$pagina?prefixo=".$upCad['prefixo']."&menu=".$upCad['menu']."$url'><img src='imagens/Sobe_Borda.gif' alt='".$upCad['nome']."' border='0'></a>";
                else if (TemDireito($upCad['menu']))
                    echo "<img src='imagens/Sobe_Borda.gif' alt='".$upCad['nome']."' border='0'>";
            }
        }

        echo "</td>\n";
    } elseif ($tab_edit)
        echo "<td class='Acao' width='1%' nowrap>&nbsp;</td>\n";

    ForEach($vetCampo as $Campo => $Valor ) {
        echo "<td class='Titulo'><b>\n";
        echo $Valor['nome'];
        echo "</b></td>\n";
    }

    echo "</tr>\n";

    if (mssql_num_rows($rs) == 0) {
        echo "<tr align=center>\n";
        echo "<td class='Registro' colspan='".(count($vetCampo) + 1)."'>Não tem informação cadastrada!</td>\n";
        echo "</tr>\n";
    } else {
        //Paginação
        $p = $_REQUEST['p'];
        $pag_tot = mssql_num_rows($rs);

        if ($pag_tot <= $reg_pagina)
            $pag_tot = 1;
        elseif (($pag_tot % $reg_pagina) == 0)
            $pag_tot = ($pag_tot / $reg_pagina);
        else
            $pag_tot = (int)($pag_tot / $reg_pagina) + 1;

        $pag_tot--;

        if (!is_numeric($p) || $p <= 0)
            $p = 0;
        elseif ($p > $pag_tot)
            $p = $pag_tot;
        else
            $p--;

        $fim = (($p + 1) * $reg_pagina);
        if ($fim > mssql_num_rows($rs))
            $fim = mssql_num_rows($rs);

        mssql_data_seek($rs, $p * $reg_pagina);

        $indMenu = -1;
        for ($i = ($p * $reg_pagina); $i < $fim; $i++) {
            $row = mssql_fetch_array($rs);
            $indMenu++;

            echo "<tr align=left>\n";

            $Colspan = "";
            if ($tab_edit) {
                echo "<td class='Acao' nowrap>";

                if ($local_acao == '') {
                    if (acesso($menulocal, 'CON'))
                        echo "<a class='Registro' target='$target_frm' href='$pagina?acao=CON&id=".$row[$idCampo]."$extra_url&prefixo=$prefixo&menu=$menulocal'><img src='imagens/Consultar.gif' border='0' alt='Consultar'></a>";
                    else if (TemDireito($menulocal, 'CON'))
                        echo "<img src='imagens/Consultar.gif' border='0' alt='Consultar'>";

                    echo '&nbsp;';

                    if ($edit) {
                        if (acesso($menulocal, 'ALT'))
                            echo "<a class='Registro' target='$target_frm' href='$pagina?acao=ALT&id=".$row[$idCampo]."$extra_url&prefixo=$prefixo&menu=$menulocal'><img src='imagens/Alterar.gif' border='0' alt='Alterar'></a>";
                        else if (TemDireito($menulocal, 'ALT'))
                            echo "<img src='imagens/Alterar.gif' border='0' alt='Alterar'>";

                        echo '&nbsp;';

                        if (acesso($menulocal, 'EXC'))
                            echo "<a class='Registro' target='$target_frm' href='$pagina?acao=EXC&id=".$row[$idCampo]."$extra_url&prefixo=$prefixo&menu=$menulocal'><img src='imagens/Excluir.gif' border='0' alt='Excluir'></a>";
                        else if (TemDireito($menulocal, 'EXC'))
                            echo "<img src='imagens/Excluir.gif' border='0' alt='Excluir'>";
                    }
                } else {
                    echo "<a class='Registro' target='$target_frm' href='#' onClick=\"return $chamada_js.$btn_js(".$row[$idCampo].")\"><img src='imagens/Consultar.gif' border='0' alt='Consultar'></a>";
                }

                if (count($goCad) == 1) {
                    $Cad = $goCad[0];

                    if ($Cad['cond_campo'] == '')
                        $mostra = true;
                    else if ($row[$Cad['cond_campo']] == $Cad['cond_valor'])
                        $mostra = true;
                    else
                        $mostra = false;

                    if ($mostra) {
                        $url = '';
                        ForEach(explode(',', $Cad['campo']) as $dbCampo)
                            if ($row[$dbCampo] != '')
                                $url .= "&$dbCampo=".$row[$dbCampo];
                            else
                                $url .= "&$dbCampo=".$_REQUEST[$dbCampo];

                        echo '&nbsp;';

                        if (acesso($Cad['menu']))
                            echo "<a class='Registro' target='$target_frm' href='$pagina?prefixo=".$Cad['prefixo']."&menu=".$Cad['menu']."$url'><img src='imagens/Desce_Borda.gif' alt='".$Cad['nome']."' border='0'></a>";
                        else if (TemDireito($Cad['menu']))
                            echo "<img src='imagens/Desce_Borda.gif' alt='".$Cad['nome']."' border='0'>";
                    } else {
                        echo '&nbsp;<img src="imagens/trans.gif" alt="" width="16" height="16" border="0">';
                    }
                } else if (count($goCad) != 0) {
                    echo "
                        <script type='text/javascript'>
                            var goTemp = new Array();
                        </script>
                    ";

                    $i_link = 0;
                    ForEach($goCad as $Cad) {
                        if ($Cad['cond_campo'] == '')
                            $mostra = true;
                        else if ($row[$Cad['cond_campo']] == $Cad['cond_valor'])
                            $mostra = true;
                        else
                            $mostra = false;

                        if ($mostra) {
                            $url = '';
                            ForEach(explode(',', $Cad['campo']) as $dbCampo)
                                if ($row[$dbCampo] != '')
                                    $url .= "&$dbCampo=".$row[$dbCampo];
                                else
                                    $url .= "&$dbCampo=".$_REQUEST[$dbCampo];

                            if (acesso($Cad['menu']))
                                echo "
                                    <script type='text/javascript'>
                                        goTemp[goTemp.length] = \"<a class='MenuLink' id='link".($i_link++)."' target='_parent' href='$pagina?prefixo=".$Cad['prefixo']."&menu=".$Cad['menu']."$url'>&nbsp;".$Cad['nome']."</a>\";
                                    </script>
                                ";
                        }
                    }

                    echo "
                        <script type='text/javascript'>
                            goCad[$indMenu] = goTemp;
                        </script>
                    ";

                    echo "<a class='Registro' href='#' onmousemove=\"MenuAbre($indMenu)\"><img src='imagens/Desce_Borda.gif' border='0'></a>";
                }

                echo "</td>\n";
            } elseif ($tab_novo)
                $Colspan = "colspan='2'";

            ForEach($vetCampo as $Campo => $Valor ) {
                echo "<td $Colspan class='Registro'>\n";

                switch ($Valor['tipo']) {
                	case 'descDominio':
                        if ($Valor['vetDominio'][$row[$Campo]] == '')
                            echo $row[$Campo];
                        else
                            echo $Valor['vetDominio'][$row[$Campo]];
                		break;

                    default:
                        echo $row[$Campo];
                		break;
                }

                echo "&nbsp;</td>\n";
            }

            echo"</tr>\n";
        }

        //Linha de Paginação
        $p++;
        $pag_tot++;

        $ini = $p - $num_pagina;
        $fim = $p + $num_pagina;

        if ($ini < 1) {
            $fim = $fim - $ini + 1;
            $ini = 1;
        }

        if ($fim >= $pag_tot) {
            $ini = $ini - ($fim - $pag_tot);
            if ($ini < 1)
                $ini = 1;

            $fim = $pag_tot;
        }

        if ($ini != $fim) {
            echo "<tr class='Generica' align='center'>
                  <td class='Titulo' colspan='".(count($vetCampo) + 1)."'>
                  <a href='$pagina?p=1".getParametro('p')."' class='Titulo'>&lt;&lt;</a>&nbsp;
                  <a href='$pagina?p=".($p - 1).getParametro('p')."' class='Titulo'>&lt;</a>&nbsp;";

            for ($i = $ini; $i <= $fim; $i++) {
                if ($i == $p)
                    echo "<span class='titulo_marca'>$i</span>&nbsp;";
                else
                    echo "<a href='$pagina?p=$i".getParametro('p')."' class='Titulo'>$i</a>&nbsp;";
            }

            echo "<a href='$pagina?p=".($p + 1).getParametro('p')."' class='Titulo'>&gt;</a>&nbsp;
                  <a href='$pagina?p=$pag_tot".getParametro('p')."' class='Titulo'>&gt;&gt;</a>
                  </td></tr>\n";
        }
    }

    echo "</table>\n";

   return 0;
}

function LUPE_criar_tabela_tab($prefixo, $rs, $vetCampo, $vetHidTab, $exc_tabela = '', $exc_campo = '') {
    /*
    informar os campos abaixos se quiser que na hora de excluir seja verificado se o registro
    esta cadastrado em outra tabela
    $exc_tabela = informar o nome da tabela
    $exc_campo = nome do campo
    */

    echo "<table id='tab{$prefixo}_Tabela' width='100%' border='1' cellspacing='0' cellpadding='0' vspace='0' hspace='0' class='Generica'>\n";
    echo "<tr class='Generica'>\n";

    if (Ativo()) {
        echo "<td class='Acao' width='1%' nowrap>";
        echo '<a href="" onclick="return tab'.$prefixo.'_Incluir();" class="Titulo"><img src="imagens/Incluir.gif" border="0" alt="Incluir"></a>';
        echo "</td>\n";
    }

    ForEach($vetCampo as $Campo => $Valor ) {
        echo "<td class='Titulo'><b>\n";
        echo $Valor['nome'];
        echo "</b></td>\n";
    }

    echo "</tr>\n";

    if (mssql_num_rows($rs) != 0) {
        for ($i = 0; $i < mssql_num_rows($rs); $i++) {
            $row = mssql_fetch_array($rs);

            echo "<tr id='tab{$prefixo}_linha{$i}' align=left>\n";

            if (Ativo()) {
                echo "<td class='Acao' nowrap>";

                echo '<a class="Registro" href="" onclick="return tab'.$prefixo.'_Alterar('.$i.');"><img src="imagens/Alterar.gif" border="0" alt="Alterar"></a>';

                echo '&nbsp;';

                echo '<a class="Registro" href="" onclick="return tab'.$prefixo.'_Excluir('.$i.');"><img src="imagens/Excluir.gif" border="0" alt="Excluir"></a>';

                if ($exc_campo == '' || $exc_tabela == '') {
                    $exclui = 'N';
                } else {
                    $sql = "select $exc_campo from $exc_tabela where $exc_campo = ".$row[$exc_campo];
                    if (mssql_num_rows(execsql($sql)) == 0)
                        $exclui = 'N';
                    else
                        $exclui = 'E';
                }

                echo "<input id='{$prefixo}_excluir$i' type='hidden' name='{$prefixo}_excluir[]' value='$exclui'>\n";

                ForEach($vetHidTab as $Valor)
            	    echo "<input id='{$prefixo}_$Valor$i' type='hidden' name='{$prefixo}_{$Valor}[]' value='".$row[$Valor]."'>\n";

                echo "</td>\n";
            }

            ForEach($vetCampo as $Campo => $Valor ) {
                echo "<td id='{$prefixo}_cel_{$Campo}_{$i}' class='Registro'>\n";

                switch ($Valor['tipo']) {
                	case 'descDominio':
                        if ($Valor['vetDominio'][$row[$Campo]] == '')
                            echo $row[$Campo];
                        else
                            echo $Valor['vetDominio'][$row[$Campo]];
                		break;

                    default:
                        echo $row[$Campo];
                		break;
                }

                echo "</td>\n";
            }

            echo"</tr>\n";
        }
    }

    echo "</table>\n";
    echo "<script type='text/javascript'>
            tab{$prefixo}_TotLin = ".mssql_num_rows($rs).";
            tab{$prefixo}_AtuLin = -1;
          </script>";

    return 0;
}

function LUPE_CriaVetTabela($nome, $tipo = '', $menu = '', $prefixo = '', $campoCond = '', $vlCond = '', $vetDominio = '') {
    $vet = Array();

    $vet['nome'] = $nome;
    $vet['tipo'] = $tipo;
    $vet['menu'] = $menu;
    $vet['prefixo'] = $prefixo;
    $vet['campoCond'] = $campoCond;
    $vet['vlCond'] = $vlCond;
    $vet['vetDominio'] = $vetDominio;

    return $vet;
}

function LUPE_vetCad($campo, $nome, $menu, $prefixo = 'listar', $cond_campo = '', $cond_valor = '') {
    $vet = Array();

    $vet['campo'] = $campo;
    $vet['nome'] = $nome;
    $vet['menu'] = $menu;
    $vet['prefixo'] = $prefixo;
    $vet['cond_campo'] = $cond_campo;
    $vet['cond_valor'] = $cond_valor;

    return $vet;
}

function LUPE_execsql($sql, $banco = '') {
    global $con, $debug;
    $sql_error = '';

    ob_start();
    if ($banco == '')
        $rs = mssql_query($sql, $con);
    else
        $rs = mssql_query($sql, $banco);

    if ($rs == false) {
        $sql_error = ob_get_contents();

        if (!$debug) {
            $sql_error = explode("<b>Warning</b>:  mssql_query() [<a href='function.mssql-query'>function.mssql-query</a>]: message:",$sql_error);
            $sql_error = explode("(severity",$sql_error[1]);
            $sql_error = $sql_error[0];
        }
    }
    ob_end_clean();

    if ($sql_error != '') {
		if ($debug)
            echo "'".$sql."'<br>";

        Require_Once('erro_personalizado.php');

		if ($debug) {
            echo $sql_error;
            Fim_de_Pagina();
        } else {
            $sql_error = addslashes($sql_error);
            $sql_error = str_replace('<b>', '', $sql_error);
            $sql_error = str_replace('</b>', '', $sql_error);
            $sql_error = str_replace(" [<a href=\'function.mssql-query\'>function.mssql-query</a>]", '', $sql_error);
            $sql_error = str_replace(chr(10), '', $sql_error);
            $sql_error = str_replace("<br />", '\n', $sql_error);

            echo "
                <script type='text/javascript'>
                    alert('$sql_error')
                    history.go(-1);
                </script>";
        }
        exit();
    }

	return $rs;
}

function LUPE_p($valor) {
    echo '<pre>';
    print_r($valor);
    echo '</pre>';
}

function LUPE_onLoadPag($campo = '', $frm = 'frm') {
	echo "<script language=\"JavaScript\">\n";
	echo "function LUPE_onLoadPag() {\n";

	if ($campo != '') {
		if ($frm == false) {
			echo "fieldobj = document.getElementById('".$campo."___Frame');
				  setTimeout('fieldobj.contentWindow.focus()',200);";
		} else {
			echo "if (document.forms.length > 0)\n";
			echo "	document.$frm.$campo.focus();\n";
		}
	}

	echo "}\n";
	echo "</script>\n";
}

function LUPE_getParametro($NaoPegar = '') {
	$NaoPegar = explode(",", $NaoPegar);

	$cgi = $_POST;
	reset($cgi);

	while (list($key, $value) = each($cgi)) {
		if (!in_array($key, $NaoPegar)) {
			$query_string .= "&" . $key . "=" . $value;
            $NaoPegar[] = $key;
        }
	}

	$cgi = $_GET;
	reset($cgi);

	while (list($key, $value) = each($cgi)) {
		if (!in_array($key, $NaoPegar))
			$query_string .= "&" . $key . "=" . $value;
            $NaoPegar[] = $key;
	}

    return $query_string;
}

function LUPE_acesso($cod_funcao, $cod_direito = '', $Msg = false) {
    global $SCA, $target_js;

    $SCA->COD_Funcao = $cod_funcao;
    $SCA->COD_Direito = $cod_direito;
    $acesso = $SCA->TemAcesso();

    if ($Msg && !$acesso) {
        echo "<script type='text/javascript'>alert('O usuário não tem acesso a este cadastro!');</script>";
        echo "<script type='text/javascript'>$target_js.location = 'conteudo.php';</script>";
        exit();
    }

	return $acesso;
}

function LUPE_TemDireito($cod_funcao, $cod_direito = '') {
    global $SCA;

    $SCA->COD_Funcao = $cod_funcao;
    $SCA->COD_Direito = $cod_direito;
	return $SCA->TemDireito();
}

function LUPE_camposObrigatoriosVet($vet, $frm = 'frm') {
	echo "<script language=\"JavaScript\">\n";
	echo "function LUPE_".$frm."Fcn() {\n";
    echo "if (valida == 'S') {\n";
    ForEach($vet as $obj) {
		echo "  if (document.$frm.".$obj['campo'].".value=='') {\n";
        echo "          mudatab(".$obj['tab'].");\n";
		echo "          alert('Favor preencher o campo: ".$obj['nome']."');\n";
		echo "          if (document.$frm.".$obj['campo'].".type != 'hidden')\n";
        echo "              document.$frm.".$obj['campo'].".focus();\n";
		echo "          return false;\n";
		echo "          }\n";
	} // next do for
    echo "}\n";

	echo "      if (confirm('Deseja realmente confirmar essa operação?')) {\n";
	echo "          return true;\n";
	echo "      } else {\n";
	echo "          return false;\n";
	echo "      }\n";
	echo "  }\n";
	echo "</script>\n";
}

function LUPE_camposObrigatorios($variaveis) {
	echo "<script language=\"JavaScript\">\n";
	echo "function LUPE_$variaveis[0]Fcn() {\n";
    echo "if (valida == 'S') {\n";
	for ($contador=1;$contador<count($variaveis);$contador=$contador+2) {
		$contadorMaisUm=$contador+1;
		echo "  if (document.$variaveis[0].$variaveis[$contador].value=='') {\n";
		echo "          alert('Favor preencher o campo: $variaveis[$contadorMaisUm]');\n";
		echo "          if (document.$variaveis[0].$variaveis[$contador].type != 'hidden')\n";
        echo "              document.$variaveis[0].$variaveis[$contador].focus();\n";
		echo "          return false;\n";
		echo "          }\n";
	} // next do for
    echo "}\n";

	echo "      if (confirm('Deseja realmente confirmar essa operação?')) {\n";
	echo "          return true;\n";
	echo "      } else {\n";
	echo "          return false;\n";
	echo "      }\n";
	echo "  }\n";
	echo "</script>\n";
}

function LUPE_aspa($Valor, $extra = '') {
	if ($Valor == '') {
		if ($extra == '')
            return "NULL";
        else
            return "'$extra$extra'";
	} else {
        $r = stripslashes($Valor);
		$r = trim(str_replace("'", "''", $r));
        $r = mb_strtoupper($r);
        return "'$extra$r$extra'";
    }
}

function LUPE_null($Valor) {
	if ($Valor == '')
		return "NULL";
	else {
        return trim($Valor);
    }
}

function LUPE_criar_combo_rs($rs, $NomeCombo, $PreSelect, $LinhaFixa, $JS, $Style = '')
{
    /*
    RS = Recordset
    NomeCombo = Nome do Objeto
    PreSelect = Value Selecionado
    LinhaFixa = Linha fixa no combo (id = "")
    JS = Texto em JS para o Combo
    */

    echo "<select id='$NomeCombo' name='$NomeCombo' $JS style='$Style'>\n";

    if ($LinhaFixa != '')
        echo "<option value=''>$LinhaFixa</option>\n";

    if (mssql_num_rows($rs) == 0) {
        echo "<option value=''>Não há informação no sistema</option>\n";
    } else {
        mssql_data_seek($rs, 0);

        While ($row = mssql_fetch_array($rs)) {
            echo "<option value='".$row[0]."'";

            if ($PreSelect == $row[0])
                echo 'selected >';
            else
                echo '>';

            for ($x = 1; $x < mssql_num_fields($rs); $x++) {
                echo $row[$x];
                if ($x < mssql_num_fields($rs) - 1)
                    echo ' - ';
            }
            echo"</option>\n";
        }
    }

    echo '</select>';

    return 0;
}

function LUPE_option_combo_rs($rs, $NomeCombo, $PreSelect, $LinhaFixa, $JS, $Style = '')
{
    /*
    RS = Recordset
    NomeCombo = Nome do Objeto
    PreSelect = Value Selecionado
    LinhaFixa = Linha fixa no combo (id = "")
    JS = Texto em JS para o Combo
    */

    $option = '<select id="'.$NomeCombo.'" name="'.$NomeCombo.'" '.$JS.' style="'.$Style.'">';

    if ($LinhaFixa != '')
        $option .= '<option value="">'.$LinhaFixa.'</option>';

    if (mssql_num_rows($rs) == 0) {
        $option .= '<option value="">Não há informação no sistema</option> ';
    } else {
        mssql_data_seek($rs, 0);

        While ($row = mssql_fetch_array($rs)) {
            $option .= '<option value="'.$row[0].'"';

            if ($PreSelect == $row[0])
                $option .= "selected >";
            else
                $option .= ">";

            for ($x = 1; $x < mssql_num_fields($rs); $x++) {
                $option .= $row[$x];
                if ($x < mssql_num_fields($rs) - 1)
                    $option .= " - ";
            }
            $option .= "</option> ";
        }
    }

    $option .= "</select>";

    return $option;
}

function LUPE_criar_combo_vet($Vet, $NomeCombo, $PreSelect, $LinhaFixa = ' ', $JS = '', $Style = '')
{
	/*
	Vet = Vetor
	NomeCombo = Nome do Objeto
	PreSelect = Value Selecionado
	LinhaFixa = Linha fixa no combo (id = "")
	JS = Texto em JS para o Combo
	*/

   $numrows = count($Vet);

   echo "<select id='$NomeCombo' name='$NomeCombo' $JS style='$Style'>\n";

	if ($LinhaFixa != '')
		echo "<option value=''>$LinhaFixa</option>\n";

   if ($numrows == 0) {
		echo "<option value=''>Não há informação no sistema</option>\n";
   } else {
	  ForEach($Vet as $Chave => $Valor ){
 		  echo "<option value='$Chave'";

		  if ($PreSelect == $Chave)
			echo 'selected >';
  		  else
			echo '>';

	  	  echo "$Valor</option>\n";
      }
   }

   echo '</select>';

   return 0;
}

function LUPE_option_combo_vet($Vet, $NomeCombo, $PreSelect, $LinhaFixa = ' ', $JS = '', $Style = '')
{
	/*
	Vet = Vetor
	NomeCombo = Nome do Objeto
	PreSelect = Value Selecionado
	LinhaFixa = Linha fixa no combo (id = "")
	JS = Texto em JS para o Combo
	*/

   $numrows = count($Vet);

   $html = "<select id='$NomeCombo' name='$NomeCombo' $JS style='$Style'>\n";

	if ($LinhaFixa != '')
		$html .= "<option value=''>$LinhaFixa</option>\n";

   if ($numrows == 0) {
		$html .= "<option value=''>Não há informação no sistema</option>\n";
   } else {
	  ForEach($Vet as $Chave => $Valor ){
 		  $html .= "<option value='$Chave'";

		  if ($PreSelect == $Chave)
			$html .= 'selected >';
  		  else
			$html .= '>';

	  	  $html .= "$Valor</option>\n";
      }
   }

   $html .= '</select>';

   return $html;
}

function LUPE_criar_lista_rs($rs, $NomeCombo, $size = '', $JS = '', $Style = '', $multiple = true)
{
    /*
    RS = Recordset
    NomeCombo = Nome do Objeto
    size = tamanho da lista
    JS = Texto em JS para o Combo
    Style = Style da lista
    multiple = Selecionar mais de uma linha
    */

    $multiple = $multiple ? 'multiple' : '';
    $tam_lst = $size == '' ? mssql_num_rows($rs) : $size;

    if ($size == '') {
        $tam_lst = $tam_lst < 6 ? 6 : $tam_lst;
        $tam_lst = $tam_lst > 15 ? 15 : $tam_lst;
    }

    echo "<select id='$NomeCombo' name='$NomeCombo' size='$tam_lst' $multiple $JS style='$Style'>\n";

    if (mssql_num_rows($rs) > 0) {
        mssql_data_seek($rs, 0);

        While ($row = mssql_fetch_array($rs)) {
            echo "<option value='".$row[0]."'>";

            for ($x = 1; $x < mssql_num_fields($rs); $x++) {
                echo $row[$x];
                if ($x < mssql_num_fields($rs) - 1)
                    echo ' - ';
            }
            echo"</option>\n";
        }
    }

    echo '</select>';

    return 0;
}

function LUPE_option_lista_rs($rs, $NomeCombo, $size = '', $JS = '', $Style = '', $multiple = true)
{
    /*
    RS = Recordset
    NomeCombo = Nome do Objeto
    size = tamanho da lista
    JS = Texto em JS para o Combo
    Style = Style da lista
    multiple = Selecionar mais de uma linha
    */

    $multiple = $multiple ? 'multiple' : '';
    $tam_lst = $size == '' ? mssql_num_rows($rs) : $size;

    if ($size == '') {
        $tam_lst = $tam_lst < 6 ? 6 : $tam_lst;
        $tam_lst = $tam_lst > 15 ? 15 : $tam_lst;
    }

    $option = '<select id="'.$NomeCombo.'" name="'.$NomeCombo.'" size="'.$tam_lst.'" '.$multiple.' '.$JS.' style="'.$Style.'">';

    if (mssql_num_rows($rs) > 0) {
        mssql_data_seek($rs, 0);

        While ($row = mssql_fetch_array($rs)) {
            $option .= '<option value="'.$row[0].'">';

            for ($x = 1; $x < mssql_num_fields($rs); $x++) {
                $option .= htmlentities($row[$x]);
                if ($x < mssql_num_fields($rs) - 1)
                    $option .= " - ";
            }
            $option .= "</option>";
        }
    }

    $option .= "</select>";

    return $option;
}

function LUPE_Troca($Valor, $Padrao, $Novo) {
	if ($Valor == $Padrao)
		return $Novo;
	else
		return $Valor;
}

function LUPE_troca_caracter($campo) {
    $estranha = "áéíóúàèìòùâêîôûäëïöüãõ@#$%^&*()_+=-~` ç";
    $correta  = "aeiouaeiouaeiouaeiouao________________c";

    $campo = mb_strtolower($campo);

	for($i = 0; $i < strlen($estranha); $i++) {
	    for($j = 0; $j < strlen($campo); $j++) {
	        $campo = str_replace($estranha[$i], $correta[$i], $campo);
	        $campo = str_replace("_", "", $campo);
	    }
	}

    return $campo;
}

function LUPE_monta_vet_tipo($rs) {
    $vet = Array();
    for ($x = 0; $x < mssql_num_fields($rs); $x++) {
        $vet[mssql_field_name($rs, $x)] = mssql_field_type($rs, $x);
    }
    return $vet;
}

function LUPE_TrataNumero($Valor) {
    if (is_numeric($Valor))
        return $Valor;
    else
        return 0;
}

function LUPE_Fim_de_Pagina() {
    onLoadPag();

    echo '
        </div>
        <div align="center">
            <div class="Rodape"></div>
        </div>
        </body>
        </html>
    ';

    exit();
}

function LUPE_Ativo() {
    global $acao, $menu;

    switch ($acao) {
        case "INC":
            return true;
            break;

        case "ALT":
            return true;
            break;

        case "CON":
            return false;
            break;

        case "EXC":
            return false;
            break;

        default:
            if ($menu = 'fix_ocorre')
                return true;
            else
                return false;
            break;
    }
}

function LUPE_vEventoPeriodo() {
    global $prefixo, $menu, $target_js;

    if ($_SESSION['idt_eve_periodo'] == '') {
        echo "
            <script type='text/javascript'>
                alert('Favor selecionar o Evento / Período que deseja trabalhar!');
                $target_js.location = 'conteudo.php?prefixo=inc&menu=escolhe_evento&orgprefixo=$prefixo&orgmenu=$menu';
            </script>
        ";

        exit();
    }
}

function LUPE_trata_id($Filtro) {
    global $Campo;

    if ($Filtro['rs'] == '') {
        if (is_numeric($Filtro['vlPadrao']))
            $valor = $Filtro['vlPadrao'];
        else if (is_numeric($_SESSION[$Filtro['id']]))
            $valor = $_SESSION[$Filtro['id']];
        else
            $valor = $_REQUEST[$Filtro['id']];

        if ($valor == '')
            $valor = 0;

    } else if ($Filtro['rs'] == 'Texto') {
        $valor = $_REQUEST[$Filtro['id']];

    } else if (is_array($Filtro['rs'])) {
        $id = $_REQUEST[$Filtro['id']];
        $achei = false;

	    ForEach($Filtro['rs'] as $Chave => $Valor ){
            if ($Chave == $id) {
                $achei = true;
                break;
            }
        }

        if (!$achei) {
            if (is_numeric($Filtro['vlPadrao']))
                $id = $Filtro['vlPadrao'];
            else if (is_numeric($_SESSION[$Filtro['id']]))
                $id = $_SESSION[$Filtro['id']];
            else if ($Filtro['LinhaUm'] != '') {
                $id = 0;
            } else {
                reset($Filtro['rs']);
                $vet = each($Filtro['rs']);
                $id = $vet['key'];
            }
        }

        $valor = $id;

        if ($valor == '')
            $Campo .= $Filtro['nome'].', ';
    } else {
        switch (mssql_num_rows($Filtro['rs'])) {
        	case 0:
                $valor = 0;
                break;
        	case 1:
                if ($Filtro['LinhaUm'] != '')
                    $valor = -1;
                else
                    $valor = mssql_result($Filtro['rs'], 0, $Filtro['id']);
                break;
            default:
                $id = $_REQUEST[$Filtro['id']];
                $achei = false;

                While ($Linha = mssql_fetch_array($Filtro['rs'])) {
                    if ($Linha[$Filtro['id']] == $id) {
                        $achei = true;
                        break;
                    }
                }

                if (!$achei) {
                    if (is_numeric($Filtro['vlPadrao']))
                        $id = $Filtro['vlPadrao'];
                    else if (is_numeric($_SESSION[$Filtro['id']]))
                        $id = $_SESSION[$Filtro['id']];
                    else if ($Filtro['LinhaUm'] != '')
                        $id = -1;
                    else
                        $id = mssql_result($Filtro['rs'], 0, $Filtro['id']);
                }

                $valor = $id;
                break;
        }

        if ($valor == 0)
            $Campo .= $Filtro['nome'].', ';
    }

    return $valor;
}

function LUPE_codigo_filtro($esconde = true, $StyleCmb = '') {
    global $vetFiltro, $Focus;

    $Focus = '';
    $html = '';
    $tabela = false;

    if (count($vetFiltro) <= 0)
        return;

    echo "
        <script type='text/javascript'>
        function LUPE_trata_filtro(obj) {
            if (obj.value.length > 0 && obj.value.length <= 3)
                alert('Favor informar o texto com mais de três caracteres!');
            else
                frm.submit();

            return false;
        }
        </script>
    ";

    ForEach($vetFiltro as $Filtro) {
        if ($Filtro['rs'] == '') {
            //Não faz nada...
        } else if (is_array($Filtro['rs']) || $Filtro['rs'] == 'Texto') {
            if ($Focus == '')
                $Focus = $Filtro['id'];
        } else {
            if (mssql_num_rows($Filtro['rs']) != 1 && $Focus == '')
                $Focus = $Filtro['id'];
        }
    }

    ForEach($vetFiltro as $Filtro) {
        if ($Filtro['rs'] == '') {
            if ($Focus == $Filtro['id'])
                $Focus = '';

            echo '<input type="hidden" name="'.$Filtro['id'].'" value="'.$Filtro['valor'].'">';

            if ($Filtro['tabela'] != '' && $Filtro['campo'] != '') {
                $tabela = true;
                $html .= '<tr><td class="Tit_Campo_Obr" align="right">'.$Filtro['nome'].':&nbsp;</td><td class="Texto">';
                $sql = 'select '.$Filtro['campo'].' from '.$Filtro['tabela'].' where '.$Filtro['id'].' = '.$Filtro['valor'];
                $html .= mssql_result(execsql($sql), 0, $Filtro['campo']);
                $html .= '</td></tr>';
            }
        } else if ($Filtro['rs'] == 'Texto') {
            $tabela = true;
            $html .= '<tr><td class="Tit_Campo_Obr" align="right">'.$Filtro['nome'].':&nbsp;</td><td>';

            if ($Filtro['js'] == '')
                //return !(event.keyCode == 13) --> sem enter
                $js = "onkeydown = 'return (event.keyCode == 13 ? trata_filtro(this) : true);' onChange = 'trata_filtro(this)'";
            else if ($Filtro['js'] != false)
                $js = $Filtro['js'];
            else
                $js = '';

            $html .= '<input id="'.$Filtro['id'].'" name="'.$Filtro['id'].'" type="text" class="Texto" value="'.$Filtro['valor'].'" size="30" '.$js.' />';

            $html .= '</td></tr>';
        } else if (is_array($Filtro['rs'])) {
            $tabela = true;
            $html .= '<tr><td class="Tit_Campo_Obr" align="right">'.$Filtro['nome'].':&nbsp;</td><td>';

            if ($Filtro['js'] == '')
                $js = 'onChange = "frm.submit();"';
            else if ($Filtro['js'] != false)
                $js = $Filtro['js'];
            else
                $js = '';

            $html .= option_combo_vet($Filtro['rs'], $Filtro['id'], $Filtro['valor'], $Filtro['LinhaUm'], $js, $StyleCmb);
            $html .= '</td></tr>';
        } else {
            if (mssql_num_rows($Filtro['rs']) == 1 && $esconde) {
                echo '<input type="hidden" name="'.$Filtro['id'].'" value="'.$Filtro['valor'].'">';
            } else {
                $tabela = true;
                $html .= '<tr><td class="Tit_Campo_Obr" align="right">'.$Filtro['nome'].':&nbsp;</td><td>';

                if ($Filtro['js'] == '')
                    $js = 'onChange = "frm.submit();"';
                else if ($Filtro['js'] == 'vazio')
                    $js = '';
                else
                    $js = $Filtro['js'];

                $html .= option_combo_rs($Filtro['rs'], $Filtro['id'], $Filtro['valor'], $Filtro['LinhaUm'], $js, $StyleCmb);
                $html .= '</td></tr>';
            }
        }
    }

    if ($tabela) {
    	echo '<table id="Tabela_Filtro" border="0" cellspacing="0" cellpadding="0" align="center">';
        echo $html;
        echo '</table>';
    }
}

function LUPE_url_ajuda($tipo) {
    global $menu;

    $url = "help/";

    if ($tipo != 'G')
        $url .= "{$menu}_{$tipo}.htm";
    else
        $url .= "index.htm";

    return mb_strtolower($url);
}

function LUPE_idtOrgaoSistema() {
    global $SCA;

    $sql = 'select idt_orgao from orgao where idt_eve_periodo = '.$_SESSION['idt_eve_periodo'].'
            and idt_org_sca = '.$SCA->IDT_Orgao;
    $row = mssql_fetch_array(execsql($sql));
    return $row['idt_orgao'];
}
?>