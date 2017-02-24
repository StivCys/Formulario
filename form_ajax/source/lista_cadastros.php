<?php
include 'conexao.php';
header("Content-Type: text/html; charset=UTF-8", true);

$query = "SELECT * from cadastro";
$statement = $con->prepare($query);

$statement->execute();
$statement->bind_result($id, $razao_social, $cnpj, $insc_m, $cep, $logradouro, $numero, $complemento, $bairro, $cidade, $uf, $email, $telefone);
?>
<div class="container" >
    <div class="row main">
        <div class="main-login main-center">
            <h2>Cadastro</h2><br><br>
            <table class="table-hover table-bordered table-condensed" >
                <thead>
                    <tr>
                        <th align="center" class="col-sm-2">CNPJ</th>
                        <th align="center" class="col-sm-3">Razão Social</th>
                        <th align="center" class="col-sm-1">E-mail</th>
                        <th align="center" class="col-sm-2">Telefone</th>
                        <th align="center" class="col-sm-3">Ações</th>
                    </tr>
                </thead>
                <?php
                while ($statement->fetch()) {
                    ?>    
                    <tr>
                        <td align="center" ><?php print $cnpj ?></td>
                        <td align="center" ><?php print $razao_social ?></td>
                        <td align="center" ><?php print $email ?></td>
                        <td align="center" ><?php print $telefone ?></td>
                        <td align="center" ><div class="dropdown">
                                <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Menu
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    &nbsp;&nbsp;&nbsp;<a class="dropdown-item editar" id="<?php print $id ?>" href="" data-toggle="modal" data-target="#myModal">Editar</a><br>
                                    &nbsp;&nbsp;&nbsp;<a class="dropdown-item excluir" id="<?php print $id ?>" href="" data-toggle="modal" data-target="#myModal">Excluir</a><br>
                                </div>
                            </div>
                    </tr>
                <?php
                }
                ?>
            </table>
        </div>
    </div>
</div>

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content" style="width:908px;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">
                <p>Some text in the modal.</p>
            </div>
            <div class="modal-footer">
                <button type="button" id='close'class="btn btn-default" data-dismiss="modal">Fechar</button>
            </div>
        </div>

    </div>
</div>

<?php
//close connection
$statement->close();


