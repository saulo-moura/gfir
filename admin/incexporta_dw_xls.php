<?php
$ano_base = '2017';

set_time_limit(0);

$sql = "SELECT idt FROM grc_dw_{$ano_base}_indicadores_qualidade";
$rsl = execsql($sql, true, null, array(), PDO::FETCH_ASSOC);

echo "<table>";

// Titulos dos Grupos: Atendimento
echo "  <tr>";
echo "      <th colspan=\"3\" text-align:right; style=\"background: black; color: white\" >Atendimento</th>";
echo "      <th colspan=\"17\" text-align:right; style=\"background: Gray; color: white\" >Pessoa Jurídica</th>";
echo "      <th colspan=\"18\" text-align:right; style=\"background: black; color: white\" >Pessoa Fisica</th>";
echo "      <th colspan=\"3\" text-align:right; style=\"background: Gray; color: white\" >INDICADOR 1</th>";
echo "      <th colspan=\"6\" text-align:right; style=\"background: black; color: white\" >INDICADOR 2</th>";
echo "      <th colspan=\"11\" text-align:right; style=\"background: Gray; color: white\" >INDICADOR 3</th>";
echo "      <th colspan=\"10\" text-align:right; style=\"background: black; color: white\" >INDICADOR 5</th>";
echo "  </tr>";

// Grupo: Atendimento
echo "  <tr>";
echo "   <th>Ponto Atendimento</th>";
echo "   <th>Atendente/Consultor</th>";
echo "   <th>Data Atendimento</th>";

// Grupo: Pessoa Jurídica
echo "  <th> CNPJ	            </th>";
echo "  <th> Razão Social	    </th>";
echo "  <th> Simples Nacional       </th>";
echo "  <th> CEP Logradouro         </th>";
echo "  <th> Número	            </th>";
echo "  <th> Complemento	    </th>";
echo "  <th> Bairro	            </th>";
echo "  <th> Cidade	            </th>";
echo "  <th> Estado	            </th>";
echo "  <th> País	            </th>";
echo "  <th> Telefone Comercial     </th>";
echo "  <th> Telefone Celular       </th>";
echo "  <th> Data Abertura	    </th>";
echo "  <th> Endereço de e-mail     </th>";
echo "  <th> CNAE Secundário        </th>";
echo "  <th> CNAE CRM               </th>";
echo "  <th> Porte CRM              </th>";

// Grupo: Pessoa Fisica
echo "  <th> CPF	            </th>";
echo "  <th> Nome	            </th>";
echo "  <th> CEP	            </th>";
echo "  <th> Logradouro             </th>";
echo "  <th> Número	            </th>";
echo "  <th> Complemento	    </th>";
echo "  <th> Bairro	            </th>";
echo "  <th> Cidade	            </th>";
echo "  <th> Estado	            </th>";
echo "  <th> País	            </th>";
echo "  <th> Telefone Residencial   </th>";
echo "  <th> Telefone Celular	    </th>";
echo "  <th> Telefone de Reacado    </th>";
echo "  <th> Data Nascimento	    </th>";
echo "  <th> Endereço de e-mail	    </th>";
echo "  <th> Escolaridade	    </th>";
echo "  <th> Potencial Personagem   </th>";
echo "  <th> Necessidade Especial   </th>";

// Grupo: Indicador 1
echo "  <th>Inconsistencia</th>";
echo "  <th>Indicador 1 PF</th>";
echo "  <th>Indicador 1 PJ</th>";

// Grupo: Indicador 2
echo "  <th>Inconsistencia</th>";
echo "  <th>CNPJ RF </th>";
echo "  <th>Razâo Social RF </th>";
echo "  <th>Porte RF </th>";
echo "  <th>Data Abertura Empresa RF </th>";
echo "  <th>CNAE RF </th>";

// Grupo: Indicador 3
echo "  <th>Inconsistencia</th>";
echo "  <th>Data Nascimento</th>";
echo "  <th>Telefone Residencial</th>";
echo "  <th>Telefone Celular</th>";
echo "  <th>Telefone de Reacado</th>";
echo "  <th>Endereço de e-mail</th>";
echo "  <th>Data Abertura Empresa</th>";
echo "  <th>Telefone Comercial</th>";
echo "  <th>Telefone Celular</th>";
echo "  <th>E-mail</th>";
echo "  <th>Endereço PF</th>";
echo "  <th>Endereço PJ</th>";

// Grupo: Indicador 5
echo "  <th>Inconsistencia</th>";
echo "  <th>Registro em Tempo Real</th>";
echo "  <th>Duração do Atendimento (minutos)</th>";
echo "  <th>Observação do Atendimento</th>";
echo "  <th>Data Atendimento</th>";
echo "  <th>Data Registro</th>";
echo "  <th>Inconsistente na Duração</th>";
echo "  <th>Inconsistente na Observação</th>";
echo "  <th>Hora Inicio Atendimento</th>";
echo "  <th>Hora Termino Atendimento</th>";

echo "  </tr>";

ForEach ($rsl->data as $rowl) {
    set_time_limit(60);

    unset($rs_campo);
    unset($vetC);
    unset($row);
    unset($rowc);
    
    $sql = "SELECT * FROM grc_dw_{$ano_base}_indicadores_qualidade where idt = " . null($rowl['idt']);
    $rs_campo = execsql($sql, true, null, array(), PDO::FETCH_ASSOC);
    $row = $rs_campo->data[0];

    // Grupo Valores Atendimento
    echo "  <tr>";
    echo "      <td> {$row['ponto_atendimento']} </td>";
    echo "      <td> {$row['nome_consultor']} </td>";
    echo "      <td> {$row['data_atendimento']} </td>";

    // Grupo Valores Pessoa Jurídica
    echo "      <td> {$row['cnpj']} </td>";
    echo "      <td> {$row['razao_social']} </td>";
    echo "      <td> {$vetSimNao[$row['simples_nacional']]} </td>";
    echo "      <td> {$row['logradouro_cep_e']} </td>";
    echo "      <td> {$row['logradouro_numero_e']} </td>";
    echo "      <td> {$row['logradouro_complemento_e']} </td>";
    echo "      <td> {$row['logradouro_bairro_e']} </td>";
    echo "      <td> {$row['logradouro_cidade_e']} </td>";
    echo "      <td> {$row['logradouro_estado_e']} </td>";
    echo "      <td> {$row['logradouro_pais_e']} </td>";
    echo "      <td> {$row['telefone_comercial_e']} </td>";
    echo "      <td> {$row['telefone_celular_e']} </td>";
    echo "      <td> {$row['data_abertura']} </td>";
    echo "      <td> {$row['email_e']} </td>";
    echo "      <td> {$row['atividade_economica_secundaria']} </td>";
    echo "      <td> {$vetSimNao[$row['cnae_crm']]} </td>";
    echo "      <td> {$row['porte_crm']} </td>";

    // Grupo Valores Pessoa Física
    echo "      <td> {$row['cpf']} </td>";
    echo "      <td> {$row['nome']} </td>";
    echo "      <td> {$row['logradouro_cep']} </td>";
    echo "      <td> {$row['logradouro_complemento']} </td>";
    echo "      <td> {$row['logradouro_numero']} </td>";
    echo "      <td> {$row['logradouro_complemento']} </td>";
    echo "      <td> {$row['logradouro_bairro']} </td>";
    echo "      <td> {$row['logradouro_cidade']} </td>";
    echo "      <td> {$row['logradouro_estado']} </td>";
    echo "      <td> {$row['logradouro_pais']} </td>";
    echo "      <td> {$row['telefone_residencial']} </td>";
    echo "      <td> {$row['telefone_celular']} </td>";
    echo "      <td> {$row['telefone_recado']} </td>";
    echo "      <td> {$row['data_nascimento']} </td>";
    echo "      <td> {$row['email']} </td>";
    echo "      <td> {$row['idt_escolaridade']} </td>";
    echo "      <td> {$vetSimNao[$row['potencial_personagem']]} </td>";
    echo "      <td> {$vetSimNao[$row['necessidade_especial']]} </td>";

    // Valores Grupo Indicador 1
    echo "      <td> {$row['indicador_1']} </td>";
    echo "      <td> {$row['indicadorpf']} </td>";
    echo "      <td> {$row['indicadorpj']} </td>";

    // Valores Grupo: Indicador 2
    echo "      <td> {$row['indicador_2']} </td>";
    echo "      <td> {$row['cnpj_rf']} </td>";
    echo "      <td> {$row['razao_social_rf']} </td>";
    echo "      <td> {$row['porte_rf']} </td>";
    echo "      <td> {$row['data_abertura_rf']} </td>";
    echo "      <td> {$row['cnae_rf']} </td>";

    $sql = '';
    $sql .= ' select c.*';
    $sql .= " from grc_dw_{$ano_base}_matriz_campos_iq_3 iq";
    $sql .= " inner join grc_dw_{$ano_base}_matriz_campos c on c.idt = iq.idt_dw_matriz_campos";
    $sql .= ' where iq.idt_dw_indicadores_qualidade = ' . null($row['idt']);
    $sql .= " and c.inconsistente = 'S'";
    $rs_campo = execsql($sql, true, null, array(), PDO::FETCH_ASSOC);

    $vetC = Array();

    foreach ($rs_campo->data as $rowc) {
        $vetC[$rowc['campo']] = $rowc['quantidade'];
    }

    // Valores Grupo Indicador 3
    echo "      <td> {$vetSimNao[$row['indicador_3_inconsistente']]} </td>";
    echo "      <td> {$vetC['data_nascimento']} </td>";
    echo "      <td> {$vetC['telefone_residencial']} </td>";
    echo "      <td> {$vetC['telefone_celular']} </td>";
    echo "      <td> {$vetC['telefone_recado']} </td>";
    echo "      <td> {$vetC['email']} </td>";
    echo "      <td> {$vetC['data_abertura']} </td>";
    echo "      <td> {$vetC['telefone_comercial_e']} </td>";
    echo "      <td> {$vetC['telefone_celular_e']} </td>";
    echo "      <td> {$vetC['email_e']} </td>";
    echo "      <td> {$vetC['endereco_pf']} </td>";
    echo "      <td> {$vetC['endereco_pj']} </td>";

    // Valores Grupo Indicador 5
    $horas_atendimento = number_format($row['horas_atendimento'], 0);
    echo "      <td> {$vetSimNao[$row['indicador_5_inconsistente']]} </td>";
    echo "      <td> {$vetSimNao[$row['data_atendimento_aberta']]} </td>";
    echo "      <td> {$horas_atendimento} </td>";
    echo "      <td> {$row['demanda']} </td>";
    echo "      <td> {$row['data_atendimento']} </td>";
    echo "      <td> {$row['data_inicio_atendimento']} </td>";
    echo "      <td> {$vetSimNao[$row['indicador_5_hora']]} </td>";
    echo "      <td> {$vetSimNao[$row['indicador_5_demanda']]} </td>";
    echo "      <td> {$row['hora_inicio_atendimento']} </td>";
    echo "      <td> {$row['hora_termino_atendimento']} </td>";

    echo "  </tr>";
}

echo "</table>";
