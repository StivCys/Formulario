<?php

include 'conexao.php';
header("Content-Type: text/html; charset=UTF-8", true);

//print_r($_POST);

foreach ($_POST as $campo => $valor) {
    $$campo = $valor;
    $$campo = trim($$campo);
    $$campo = str_replace('"', '', $$campo);
    $$campo = str_replace("'", '', $$campo);
    if (($campo != 'complemento' && $campo != 'action' && $campo != 'id') && $valor == '') {
        $var['erro'] = "$campo";
        print json_encode($var);
        exit;
    }
//    $$campo = mysql_real_escape_string($$campo);
}

if ($id > 0) {
    if ($action == 'excluir') {
        //DELETE
        if (!($stmt = $con->prepare("DELETE from cadastro WHERE id= ? "
                ))) {
            // echo "Prepare failed: (" . $con->errno . ") " . $con->error;
        }

        if (!$stmt->bind_param("i", $id)) {
            // echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
        }

        if (!$stmt->execute()) {
            // echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        $var['ok'] = "Dados Excluidos";
        print json_encode($var);
        exit;
    }
}
//VALIDAÇÕES

validar_cnpj($cnpj);
validar_cep($cep);



if ($id < 0 || !isset($id) || $id == '') {
    //VERIFICAR CNPJ JA CADASTRADO
    if (!($stmt = $con->query("SELECT id from cadastro WHERE cnpj='$cnpj'"
            ))) {
//        echo "Query failed: (" . $con->errno . ") " . $con->error;
        $var['ok'] = "Ocorreu um erro e os dados não foram salvos";
        print json_encode($var);
        exit;
    }
    if ($stmt->num_rows > 0) {
        $var['ok'] = "Já consta uma empresa com esse CNPJ na base de dados";
        print json_encode($var);
        exit;
    }

    //INSERT
    if (!($stmt = $con->prepare("INSERT INTO cadastro
                                        (   razao_social,
                                            cnpj,
                                            insc_m,
                                            cep,
                                            logradouro,
                                            numero,
                                            complemento,
                                            bairro,
                                            cidade,
                                            uf,
                                            email,
                                            telefone
                                        )
                                        VALUES (?,?,?,?,?,?,?,?,?,?,?,?)"))) {
        // echo "Prepare failed: (" . $con->errno . ") " . $con->error;
    }

    if (!$stmt->bind_param("sssssissssss", $razao_social, $cnpj, $insc_m, $cep, $logradouro, $numero, $complemento, $bairro, $cidade, $uf, $email, $telefone
            )) {
        // echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
    }

    if (!$stmt->execute()) {
        // echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
    }
    $var['ok'] = "Dados Salvos";
    print json_encode($var);
} else {
    //UPDATE
    if (!($stmt = $con->prepare("UPDATE cadastro
                                       SET
                                            razao_social =?,
                                            cnpj =?,
                                            insc_m  =?,
                                            cep  =?,
                                            logradouro  =?,
                                            numero  =?,
                                            complemento =?,
                                            bairro =?,
                                            cidade =?,
                                            uf =?,
                                            email =?,
                                            telefone =?
                                        
                                        WHERE id= ? "
            ))) {
        // echo "Prepare failed: (" . $con->errno . ") " . $con->error;
    }

    if (!$stmt->bind_param("sssssissssssi", $razao_social, $cnpj, $insc_m, $cep, $logradouro, $numero, $complemento, $bairro, $cidade, $uf, $email, $telefone, $id
            )) {
        // echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
    }

    if (!$stmt->execute()) {
        // echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
    }
    $var['ok'] = "Dados Salvos";
    print json_encode($var);
}

function validar_cep($m_cep) {
    $m_cep = preg_replace('/[^0-9]/', '', (string) $m_cep);
    if (strlen($m_cep) != 8) {
        $var['msg_cep'] = "CEP Inválido \n";
        print json_encode($var);
        return false;
    }
}

function validar_cnpj($m_cnpj) {
    $m_cnpj = preg_replace('/[^0-9]/', '', (string) $m_cnpj);
    // Valida tamanho
    $msg = '';
    if (strlen($m_cnpj) != 14) {
        $var['msg_cnpj'] = "CNPJ Inválido";
        print json_encode($var);
        return false;
        ;
    }
    // Valida primeiro dígito verificador
    for ($i = 0, $j = 5, $soma = 0; $i < 12; $i++) {
        $soma += $m_cnpj{$i} * $j;
        $j = ($j == 2) ? 9 : $j - 1;
    }
    $resto = $soma % 11;
    $primeiro_invalido = false;
    if ($m_cnpj{12} != ($resto < 2 ? 0 : 11 - $resto)) {
        $msg.="CNPJ Inválido, o primeiro digito verificador não confere\n";
        $primeiro_invalido = true;
    }
    // Valida segundo dígito verificador
    for ($i = 0, $j = 6, $soma = 0; $i < 13; $i++) {
        $soma += $m_cnpj{$i} * $j;
        $j = ($j == 2) ? 9 : $j - 1;
    }
    $resto = $soma % 11;
    $segundo_invalido = false;
    if ($m_cnpj{13} != ($resto < 2 ? 0 : 11 - $resto)) {
        $msg.="CNPJ Inválido, o segundo digito verificador não confere\n";
        $segundo_invalido = true;
    }
    if ($primeiro_invalido || $segundo_invalido) {
        $var['msg_cnpj'] = $msg;
    }

    if ($msg !== '') {
        print json_encode($var);
        exit;
    }
}
