<?php
//ini_set('display_errors', 1);
//ini_set('log_errors', 1);
////ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
//error_reporting(E_ALL);
include "./source/conexao.php";
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8"/>
        <!-- Bootstrap links CDN-->
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <!-- Dependência jQuery-->
        <script   src="https://code.jquery.com/jquery-1.12.4.min.js"   integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ="   crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        <!--mascaras  mas-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.maskedinput/1.4.1/jquery.maskedinput.js" integrity="sha256-fvFKHgcKai7J/0TM9ekjyypGDFhho9uKmuHiFVfScCA=" crossorigin="anonymous"></script>
        <title>Cadastro</title>
        <script>
            function load_cadastro(container, action, id) {
                var m_action = action;
                $.ajax({
                    url: "./source/cadastro.php",
                    method: "POST",
                    dataType: "html",
                    data: {
                        action: m_action,
                        id: id
                    },
                    success: function(response) {
                        $(container).html(response);
                        //MASCARAS
                        $("#cep").mask("99999-999", {placeholder: " "});
                        $("#cnpj").mask("99.999.999/9999-99", {placeholder: " "});
                        $("#telefone").mask("(99)99999-9999", {placeholder: " "});
                        $("#insc_m").mask("999999999", {placeholder: " "});

                        //WS VERIFICAR CNPJ client-side API PUBLICA 
                        $("#cnpj").blur(function() {
                            var cnpj = $(this).val();
                            cnpj = cnpj.replace(/\.|\-|\//g, '');
                            cnpj = cnpj.trim();
                            if (cnpj !== '') {
                                //alert(cnpj);
                                $.getJSON("https://www.receitaws.com.br/v1/cnpj/" + cnpj + "/?callback=?", function(dados) {
                                    if (dados.status === 'ERROR') {
                                        //VALIDA SE CNPJ É VALIDO
                                        $("#cnpj").val('');
                                        cnpj = '';
                                        $("#cnpj").focus();
                                        alert(dados.message);
                                    } else {
                                        //APENAS CONFIRMAR RAZÃO SOCIAL MAS HÁ VARIOS DADOS DE RETORNO PARA SE USAR CASO PRECISE
                                        if (confirm("Razão Social: " + dados.nome + "\n\nSituação : " + dados.situacao)) {
                                            $("#insc_m").focus();
                                        } else {
                                            $("#cnpj").focus();
                                        }
                                    }
                                    ;
                                });
                            }
                        });
                        //WS VERIFICAR CEP client-side
                        $("#cep").blur(function() {
                            var cep = $(this).val();
                            cep = cep.replace(/\.|\-/g, '');
                            //Consulta o webservice viacep.com.br/
                            $.getJSON("//viacep.com.br/ws/" + cep + "/json/?callback=?", function(dados) {

                                if (!("erro" in dados)) {
                                    //Atualiza os campos com os valores da consulta.
                                    $("#logradouro").val(dados.logradouro);
                                    $("#bairro").val(dados.bairro);
                                    $("#cidade").val(dados.localidade);
                                    $("#uf").val(dados.uf);
                                    $('#numero').focus();

                                } //end if.
                                else {
                                    //CEP pesquisado não foi encontrado.
                                    $("#cep").val('');
                                    $("#logradouro").val('');
                                    $("#bairro").val('');
                                    $("#cidade").val('');
                                    $("#uf").val('');
                                    $("#cep").focus();
                                    alert("CEP não encontrado.");
                                }
                            });
                        });

                        //SUBMIT SEM REFRESH
                        $("#form1").submit(function(event) {
                            if (confirm("CONFIRMAR " + action)) {
                                var dados = $(this).serialize();
                                $.ajax({
                                    type: "POST",
                                    url: "./source/processa_cadastro.php",
                                    data: dados,
                                    dataType: "json",
                                    success: function(data) {
                                        var resp = '';
                                        if (data.erro !== undefined) {
                                            var id_campo = data.erro;
                                            if (data.erro === 'razao_social') {
                                                data.erro = "razão social";
                                            }
                                            if (data.erro === "insc_m") {
                                                data.erro = "inscrição social";
                                            }
                                            data.erro = data.erro.toUpperCase();
                                            resp = "Campo " + data.erro + " não foi informado ";
                                            alert(resp);
                                            $("#" + id_campo).focus();
                                            return false;
                                        }
                                        if (data.msg_cnpj !== undefined) {
                                            resp = data.msg_cnpj;
                                        }
                                        if (data.ok !== undefined) {
                                            resp = data.ok;
                                        }
                                        if (resp !== '') {
                                            alert(resp);
                                        }
                                        if(resp === 'Ocorreu um erro e os dados não foram salvos'){
                                            return false;
                                        }
                                        if (container === '.modal-body') {
                                            $('#myModal').modal('hide');
                                            $(".modal-backdrop").hide();
                                            consulta_lista();
                                            ;
                                        } else {
                                            consulta_lista();
                                        }
                                    }
                                });
                                event.preventDefault();
                            } else {
                                $('#myModal').modal('hide');
                                $(".modal-backdrop").hide();
                                return false;
                            }
                        });
                    }
                });
            }
            $(document).ready(function() {
                $('#cadastro').click(function() {
                    load_cadastro("#content", "novo", 0);
                });
                $("#consulta").click(function() {
                    consulta_lista();
                });
            });
            function consulta_lista() {
                $.ajax({
                    url: "./source/lista_cadastros.php",
                    method: "GET",
                    dataType: "html",
                    success: function(response) {
                        $('#content').html(response);

                        $(".editar").click(function() {
                            var editar_id = $(this).attr('id');
                            load_cadastro('.modal-body', "editar", editar_id);
                            $('.modal-title').html('Editar');
                        });

                        $(".excluir").click(function() {
                            var excluir_id = $(this).attr('id');
                            load_cadastro('.modal-body', "excluir", excluir_id);
                            $('.modal-title').html('Excluir');
                        });
                    }
                });
            }
        </script>
    </head>
    <body>
        <div class="container" style="width:1357px;">
            <nav class="navbar navbar-inverse">
                <div class="container-fluid">
                </div>
                <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Menu <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="#" id="cadastro">Novo Cadastro</a></li>
                                <li><a href="#" id="consulta">Consulta</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
        </div>
    </nav>
    <div id='content'>
        <!--formulario e lista-->
    </div>
</div>
</body>
</html>