<?php
include 'conexao.php';
if ($_POST['id'] != 0) {
    $action = $_POST['action'];
    
    $query = "SELECT * from cadastro where id=" . $_POST['id'] . "";
    $statement = $con->prepare($query);

    $statement->execute();
    $statement->bind_result($id, $razao_social, $cnpj, $insc_m, $cep, $logradouro, $numero, $complemento, $bairro, $cidade, $uf, $email, $telefone);
    $statement->fetch();
}
?>

<div class="container" >
    <div class="row main">
        <div class="main-login main-center">
            <h2>Cadastro</h2><br><br>

            <form method="POST" id="form1" >
                <input type='hidden'  name='action' value='<?php print (isset($action) ? $action : '') ?>'/>
                <input type='hidden'  name='id'value='<?php print (isset($id) ? $id : '') ?>'/>
                <div class="form-group">
                    <label style='color: red;'>*&nbsp;</label><label for="razaosocial" class="cols-sm-6 control-label">Razão Social</label>
                    <div class="cols-sm-9">
                        <div class="input-group col-lg-6">
                            <input type="text" class="form-control"  name="razao_social" id="razao_social"  placeholder="" required='true' value="<?php print (isset($razao_social)) ? $razao_social : ""  ?>"/>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label style='color: red;'>*&nbsp;</label><label for="cnpj" class="cols-sm-2 control-label">CNPJ</label>
                    <div class="cols-sm-3">
                        <div class="input-group">
                            <input type="text" class="form-control" name="cnpj" id="cnpj"  placeholder="" required="true" value="<?php print (isset($cnpj)) ? $cnpj : ""  ?>"/>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label style='color: red;'>*&nbsp;</label><label for="im" class="cols-sm-2 control-label">Inscrição Municipal</label>
                    <div class="cols-sm-10">
                        <div class="input-group">
                            <input type="text" class="form-control" name="insc_m" id="insc_m"  placeholder="" required="true" value="<?php print (isset($insc_m)) ? $insc_m : ""  ?>"/>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label style='color: red;'>*&nbsp;</label><label for="cep" class="cols-sm-2 control-label">CEP</label>
                    <div class="cols-sm-10">
                        <div class="input-group">
                            <input type="text"  class="form-control" name="cep" id="cep" placeholder="" required="true" value="<?php print (isset($cep)) ? $cep : ""  ?>"/>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label style='color: red;'>*&nbsp;</label><label for="logradouro" class="cols-sm-2 control-label">Endereço</label>
                    <div class="cols-sm-10">
                        <div class="input-group col-lg-6">
                            <input type="text" class="form-control" name="logradouro" id="logradouro"  placeholder="" required="true" value="<?php print (isset($logradouro)) ? $logradouro : ""  ?>"/>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label style='color: red;'>*&nbsp;</label><label for="num" class="cols-sm-2 control-label">Número</label>
                    <div class="cols-sm-10">
                        <div class="input-group">
                            <input type="text" class="form-control" name="numero" id="numero"  placeholder="" required="true" value="<?php print (isset($numero)) ? $numero : ""  ?>"/>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="complemento" class="cols-sm-2 control-label">Complemento</label>
                    <div class="cols-sm-10">
                        <div class="input-group">
                            <input type="text" class="form-control" name="complemento" id="complemento"  placeholder="" value="<?php print (isset($complemento)) ? $complemento : ""  ?>"/>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label style='color: red;'>*&nbsp;</label><label for="bairro" class="cols-sm-2 control-label">Bairro</label>
                    <div class="cols-sm-10">
                        <div class="input-group">
                            <input type="text" class="form-control" name="bairro" id="bairro"  placeholder="" required="true" value="<?php print (isset($bairro)) ? $bairro : ""  ?>"/>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label style='color: red;'>*&nbsp;</label><label for="cidade" class="cols-sm-2 control-label">Cidade</label>
                    <div class="cols-sm-10">
                        <div class="input-group">
                            <input type="text" class="form-control" name="cidade" id="cidade"  placeholder="" required="true" value="<?php print (isset($cidade)) ? $cidade : ""  ?>"/>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label style='color: red;'>*&nbsp;</label><label for="estado" class="cols-sm-2 control-label">UF</label>
                    <div class="cols-sm-10">
                        <div class="input-group">
                            <!--<input type="text" class="form-control" name="uf" id="uf"  placeholder=""/>-->
                            <select class='form-control' name="uf" id="uf" required="true" value="<?php print (isset($uf)) ? $uf : ""  ?>">
                                <?php
                                if (isset($uf)) {
                                    print "<option value='" . $uf . "' selected>" . $uf . "</option>";
                                }
                                ?>
                                <option value="">Selecione</option>
                                <option value="AC">AC</option>
                                <option value="AL">AL</option>
                                <option value="AM">AM</option>
                                <option value="AP">AP</option>
                                <option value="BA">BA</option>
                                <option value="CE">CE</option>
                                <option value="DF">DF</option>
                                <option value="ES">ES</option>
                                <option value="GO">GO</option>
                                <option value="MA">MA</option>
                                <option value="MG">MG</option>
                                <option value="MS">MS</option>
                                <option value="MT">MT</option>
                                <option value="PA">PA</option>
                                <option value="PB">PB</option>
                                <option value="PE">PE</option>
                                <option value="PI">PI</option>
                                <option value="PR">PR</option>
                                <option value="RJ">RJ</option>
                                <option value="RN">RN</option>
                                <option value="RS">RS</option>
                                <option value="RO">RO</option>
                                <option value="RR">RR</option>
                                <option value="SC">SC</option>
                                <option value="SE">SE</option>
                                <option value="SP">SP</option>
                                <option value="TO">TO</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label style='color: red;'>*&nbsp;</label><label for="email" class="cols-sm-2 control-label">Email</label>
                    <div class="cols-sm-10">
                        <div class="input-group">
                            <input type="email" class="form-control" name="email" id="email"  placeholder="" required="true" value="<?php print (isset($email)) ? $email : ""  ?>"/>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label style='color: red;'>*&nbsp;</label><label for="telefone" class="cols-sm-2 control-label">Telefone</label>
                    <div class="cols-sm-10">
                        <div class="input-group">
                            <input type="text" class="form-control" name="telefone" id="telefone"  placeholder="" required="true" value="<?php print (isset($telefone)) ? $telefone : ""  ?>"/>
                        </div>
                    </div>
                </div>
                <div class="form-group ">
                    <?php if (isset($action) && $action == 'editar') { ?>
                              <input  type="submit" id="enviar" class="btn btn-primary btn-lg" value='Enviar'/>
                    <?php } elseif (isset($action) && $action == 'excluir') { ?>
                              <input  type="submit" id="excluir" class="btn btn-danger btn-lg" value='Excluir'/>
                    <?php }else{ ?>
                              <input  type="submit" id="enviar" class="btn btn-primary btn-lg" value='Enviar'/>
                    <?php } ?>
                    <?php if (!isset($id)) { ?>
                        <input  type="reset" id="limpar" class="btn btn-primary btn-lg" value='Limpar'/>
<?php } ?>
                </div>
            </form>
        </div>
    </div>
</div>