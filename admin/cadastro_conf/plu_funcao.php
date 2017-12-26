<style>
    fieldset.class_frame {
        background:#ECF0F1;
        border:1px solid #14ADCC;
    }

    div.class_titulo {
        background: #ABBBBF;
        border    : 1px solid #14ADCC;
        color     : #FFFFFF;
        text-align: left;
    }
    div.class_titulo span {
        padding-left:10px;
    }
</style>
<?php
$tabela = 'plu_funcao';
$id = 'id_funcao';

$onSubmitDep = 'plu_funcao_dep()';

$vetCampo['nm_funcao'] = objTexto('nm_funcao', 'Nome', True, 92, 120);
$vetCampo['cod_funcao'] = objTexto('cod_funcao', 'Transação', True, 50, 200);
$vetCampo['des_prefixo'] = objHidden('des_prefixo', '');
$vetCampo['prefixo_menu'] = objTexto('prefixo_menu', 'Prefixo Menu', True, 40, 40);
$vetCampo['parametros'] = objTexto('parametros', 'Parametros do GET (&campo=valor...)', False, 92, 200);
$vetCampo['url'] = objURL('url', 'URL', false, 92, 255, false);
$vetCampo['cod_classificacao'] = objTexto('cod_classificacao', 'Classificação', True, 92, 200);
$vetCampo['sts_menu'] = objCmbVetor('sts_menu', 'Mostra no Menu', True, $vetSimNao);
$vetCampo['sts_linha'] = objCmbVetor('sts_linha', 'Colocar linha separadora', True, $vetSimNao);
$vetCampo['abrir_sistema'] = objCmbVetor('abrir_sistema', 'Usar arquivos do sistema', True, $vetSistemaUtilizaCmb, '');

$sql_lst_1 = 'select id_direito, nm_direito from plu_direito order by nm_direito';

$sql_lst_2 = 'select d.id_direito, df.id_difu, d.nm_direito from plu_direito d inner join
               plu_direito_funcao df on d.id_direito = df.id_direito
               where df.id_funcao = '.$_GET['id'].' order by d.nm_direito';

$vetCampo['id_direito'] = objLista('id_direito', True, 'Direitos do Sistema', 'sistema', $sql_lst_1, 'plu_direito_funcao', 200, 'Direitos da Função', 'funcao', $sql_lst_2, '', '', 'plu_direito_perfil', 'id_difu');

$vetCampo['plu_funcao_desc'] = objInclude('plu_funcao_desc', 'cadastro_conf/plu_funcao_desc.php');

$par = 'parametros';
$vetDesativa['prefixo_menu'][0] = vetDesativa($par, 'link,abc');

$par = 'url';
$vetDesativa['prefixo_menu'][1] = vetDesativa($par, 'link', false);
$vetAtivadoObr['prefixo_menu'][1] = vetAtivadoObr($par, 'link');

MesclarCol($vetCampo['nm_funcao'], 5);
MesclarCol($vetCampo['cod_funcao'], 3);
MesclarCol($vetCampo['cod_classificacao'], 5);
MesclarCol($vetCampo['parametros'], 5);
MesclarCol($vetCampo['url'], 5);
MesclarCol($vetCampo['des_prefixo'], 5);
MesclarCol($vetCampo['id_direito'], 5);
MesclarCol($vetCampo['plu_funcao_desc'], 5);

$class_frame = "class_frame";
$class_titulo = "class_titulo";
$titulo_na_linha = false;

$vetFrm = Array();
$vetFrm[] = Frame('<span>Identificação</span>', Array(
    Array($vetCampo['nm_funcao']),
    Array($vetCampo['cod_funcao'], '', $vetCampo['prefixo_menu']),
    Array($vetCampo['parametros']),
    Array($vetCampo['url']),
    Array($vetCampo['des_prefixo']),
    Array($vetCampo['cod_classificacao']),
    Array($vetCampo['sts_menu'], '', $vetCampo['sts_linha'], '', $vetCampo['abrir_sistema']),
    Array($vetCampo['id_direito']),
    Array($vetCampo['plu_funcao_desc']),
        ), $class_frame, $class_titulo, $titulo_na_linha);

$vetCad[] = $vetFrm;
