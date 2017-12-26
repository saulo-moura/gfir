<?php

$acesso_outro_banco=true;
if ($acesso_outro_banco==true)
{
   $con_trab = $con;
   $con      = $con1;
}
$origem_carga = "SCA";



$idCampo = 'idt';
$Tela = "o Entidade";
//$goCad[] = vetCad('idt', 'Cidades', 'cidade');
/*
$goCad[] = vetCad('p_cod_classificacao,p_nm_funcao,p_cod_funcao,p_classifica,id_funcao', 'Objetos', 'plu_objetos_funcao');
$goCad[] = vetCad('p_cod_classificacao,p_nm_funcao,p_cod_funcao,p_classifica,id_funcao', 'GO 01', 'plu_direito', 'listar', true);
$goCad[] = vetCad('p_cod_classificacao,p_nm_funcao,p_cod_funcao,p_classifica,id_funcao', 'GO 02', 'plu_direito', 'listar', false);
$goCad[] = vetCadGrupo(Array(
    vetCad('p_cod_classificacao,p_nm_funcao,p_cod_funcao,p_classifica,id_funcao', 'GO 03', 'plu_direito', 'listar'),
    vetCad('p_cod_classificacao,p_nm_funcao,p_cod_funcao,p_classifica,id_funcao', 'GO 04', 'plu_direito', 'listar'),
    vetCad('p_cod_classificacao,p_nm_funcao,p_cod_funcao,p_classifica,id_funcao', 'GO 05', 'plu_direito', 'listar'),
        ));
$goCad[] = vetCad('p_cod_classificacao,p_nm_funcao,p_cod_funcao,p_classifica,id_funcao', 'GO 06', 'plu_direito', 'listar', false);
$goCad[] = vetCad('p_cod_classificacao,p_nm_funcao,p_cod_funcao,p_classifica,id_funcao', 'GO 07', 'plu_direito', 'listar', true);
$goCad[] = vetCadGrupo(Array(
    vetCad('p_cod_classificacao,p_nm_funcao,p_cod_funcao,p_classifica,id_funcao', 'GO 08', 'plu_direito', 'listar'),
    vetCad('p_cod_classificacao,p_nm_funcao,p_cod_funcao,p_classifica,id_funcao', 'GO 09', 'plu_direito', 'listar'),
        ), false);
$goCad[] = vetCad('p_cod_classificacao,p_nm_funcao,p_cod_funcao,p_classifica,id_funcao', 'GO 10', 'plu_direito', 'listar', true);
*/

 $tipoidentificacao='N';
 $tipofiltro='N';
 

$mostrar    = false;
$cond_campo = '';
$cond_valor = '';

if ($veio=='O')
{
    $imagem     = 'imagens/empresa_16.png';
    
    $prefixow    = 'cadastro';
    //$prefixow    = 'listar';
    $goCad[] = vetCad('idt', 'Dados complementares da Organização', 'gec_entidade_organizacao', $prefixow, $mostrar, $imagem, $cond_campo, $cond_valor);

//    $imagem     = 'imagens/cnae_16.gif';
//    $goCad[] = vetCad('idt', 'CNAEs da Organização', 'gec_entidade_cnae', $prefixow, $mostrar, $imagem, $cond_campo, $cond_valor);

    $prefixow    = 'listar';
    $imagem     = 'imagens/endereco_16.png';
    $goCad[] = vetCad('idt', 'Endereços da Organização', 'gec_entidade_endereco', $prefixow, $mostrar, $imagem, $cond_campo, $cond_valor);

    $imagem     = 'imagens/relacionamento_16.png';
    $goCad[] = vetCad('idt', 'Relacionamentos com a Organização', 'gec_entidade_entidade', $prefixow, $mostrar, $imagem, $cond_campo, $cond_valor);


    $imagem     = 'imagens/relacionamento_16.png';
    $goCad[] = vetCad('idt', 'Mercados', 'gec_entidade_mercado', $prefixow, $mostrar, $imagem, $cond_campo, $cond_valor);

    $imagem     = 'imagens/relacionamento_16.png';
    $goCad[] = vetCad('idt', 'Documentos', 'gec_entidade_documento', $prefixow, $mostrar, $imagem, $cond_campo, $cond_valor);
    $imagem     = 'imagens/relacionamento_16.png';
    $goCad[] = vetCad('idt', 'Área Conhecimento', 'gec_entidade_area_conhecimento', $prefixow, $mostrar, $imagem, $cond_campo, $cond_valor);

}
else
{
    $prefixow    = 'listar';
    $imagem     = 'imagens/dados_pessoa_16.gif';
    $goCad[] = vetCad('idt', 'Dados complementares da Pessoa ', 'gec_entidade_pessoa', $prefixow, $mostrar, $imagem, $cond_campo, $cond_valor);
    
    
    $imagem     = 'imagens/endereco_16.png';
    $goCad[] = vetCad('idt', 'Endereços da Pessoa', 'gec_entidade_endereco', $prefixow, $mostrar, $imagem, $cond_campo, $cond_valor);

    $imagem     = 'imagens/relacionamento_16.png';
    $goCad[] = vetCad('idt', 'Relacionamentos com a Pessoa', 'gec_entidade_entidade', $prefixow, $mostrar, $imagem, $cond_campo, $cond_valor);


    $imagem     = 'imagens/relacionamento_16.png';
    $goCad[] = vetCad('idt', 'Documentos', 'gec_entidade_documento', $prefixow, $mostrar, $imagem, $cond_campo, $cond_valor);
    

    $imagem     = 'imagens/relacionamento_16.png';
    $goCad[] = vetCad('idt', 'Área Conhecimento', 'gec_entidade_area_conhecimento', $prefixow, $mostrar, $imagem, $cond_campo, $cond_valor);


    $prefixow    = 'listar';
    $imagem     = 'imagens/relacionamento_16.png';
    $goCad[] = vetCad('idt', 'Cursos', 'gec_entidade_curso', $prefixow, $mostrar, $imagem, $cond_campo, $cond_valor);

    $imagem     = 'imagens/relacionamento_16.png';
    $goCad[] = vetCad('idt', 'Escolaridade', 'gec_entidade_escolaridade', $prefixow, $mostrar, $imagem, $cond_campo, $cond_valor);
    
    

}





$TabelaPrinc      = "gec_entidade";
$AliasPric        = "gec_en";
$Entidade         = "Entidade";
$Entidade_p       = "Entidades";
$barra_inc_h      = 'Incluir um Novo Registro de Entidade';
$contlinfim       = "Existem #qt Entidades.";

$_SESSION[CS][$TabelaPrinc]['veio']=$veio;




$Filtro = Array();
$Filtro['rs'] = 'Texto';
$Filtro['id'] = 'texto';
$Filtro['js_tam'] = '0';
$Filtro['nome'] = 'Texto';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['texto'] = $Filtro;
// Monta o vetor de Campo
if ($veio=="O" or $veio=="P")
{
    if ($veio=="O")
    {

        $vetCampo['codigo']              = CriaVetTabela('CNPJ');
        $vetCampo['descricao']           = CriaVetTabela('RAZÃO SOCIAL');
        $vetCampo['resumo']              = CriaVetTabela('NOME FANTASIA');
        $vetCampo['gec_ec_descricao']    = CriaVetTabela('CLASSE');
        $vetCampo['ativo']               = CriaVetTabela('Ativa?', 'descDominio', $vetSimNao );
    }
    else
    {
        $vetCampo['codigo']           = CriaVetTabela('CPF');
        $vetCampo['descricao']        = CriaVetTabela('NOME');
        $vetCampo['resumo']           = CriaVetTabela('NOME RESUMO (APELIDO)');
        $vetCampo['gec_ec_descricao'] = CriaVetTabela('CLASSE');
        $vetCampo['ativo']            = CriaVetTabela('Ativa?', 'descDominio', $vetSimNao );
    }
}
else
{
    //$vetCampo['tipo_entidade']    = CriaVetTabela('Tipo da Entidade', 'descDominio', $vetTipoEntidade );
    $vetCampo['gec_et_descricao']    = CriaVetTabela('Tipo da Entidade');
    $vetCampo['codigo']           = CriaVetTabela('CNPJ//<br />CPF');
    $vetCampo['descricao']        = CriaVetTabela('RAZÃO SOCIAL//<br />NOME');
    $vetCampo['resumo']           = CriaVetTabela('NOME FANTASIA/<br />NOME RESUMO (APELIDO)');
    $vetCampo['gec_ec_descricao'] = CriaVetTabela('CLASSE');
    $vetCampo['ativo']            = CriaVetTabela('Ativa?', 'descDominio', $vetSimNao );
}
$sql   = 'select gec_en.*, ';
$sql  .= '       gec_ec.descricao as gec_ec_descricao, ';
$sql  .= '       gec_et.descricao as gec_et_descricao ';
$sql  .= ' from gec_entidade gec_en ';
$sql  .= ' inner join gec_entidade_classe gec_ec on gec_ec.idt  = gec_en.idt_entidade_classe ';
$sql  .= ' inner join gec_entidade_tipo gec_et on gec_et.codigo = gec_en.tipo_entidade ';
//
if ($veio=="O" or $veio=="P"  )
{
    $sql .= ' where gec_en.tipo_entidade = '.aspa($veio).' and ' ;
}
else
{
    $sql .= ' where ';
}
$sql .= ' ( ';
$sql .= '  lower(gec_en.codigo)      like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
$sql .= ' or lower(gec_en.descricao) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
$sql .= ' or lower(gec_en.resumo)    like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
$sql .= ' or lower(gec_ec.codigo)    like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
$sql .= ' or lower(gec_ec.descricao) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
$sql .= ' ) ';

$sql .= " and gec_e.reg_situacao = 'A'";

if ($veio=="O" or $veio=="P"  )
{
    $sql .= ' order by gec_en.codigo';
}
else
{
    $sql .= ' order by gec_en.tipo_entidade, gec_en.codigo';
}
?>