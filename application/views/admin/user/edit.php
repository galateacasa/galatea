<script>
$(function(){
  $('#expertise').multiSelect({
    selectAll : false
  });

  //STATE AND CITY
  set_combo_state('<?php echo  $user->state_id ?>');
  <?
  if (!empty($user->city_id)) {
    ?>
    set_combo_city('<?php echo  $user->city_id ?>', '<?php echo  $user->state_id ?>');
    <?
  }
  ?>

  <?
  if(!empty($user->role)){
    ?>
    $('#role').val('<?php echo $user->role?>');
    <?
  }
  ?>

  //PERSON TYPE
  $("#radio_pf").attr("checked",true);
  $("#person_pf").show();
  $("#person_pj").hide();
  <?
  if(!empty($user->cpf) || !empty($user->rg)){
    ?>
    $("#person_pf").show();
    $("#person_pj").hide();
    $("#radio_pf").attr("checked",true);
    <?
  }elseif(!empty($user->cnpj) || !empty($user->ie)){
    ?>
    $("#person_pf").hide();
    $("#person_pj").show();
    $("#radio_pj").attr("checked",true);
    <?
  }
  ?>
});
</script>
<div class="row-fluid">
  <div class="box span12">
    <div class="box-header well" data-original-tile >
      <h2><i class="icon-edit"></i> Editar usuário</h2>
    </div>
    <div class="box-content">
      <form action="" class="form-horizontal" method="post">
        <fieldset>
          <legend><?php echo  $user->name ?> - <?php echo  $user->email ?></legend>
          <div class="control-group">
            <label class="control-label" for="name"> Nome </label>
            <div class="controls">
              <input type="text" name="name" id="name" value="<?php echo  set_value('name', $user->name); ?>">
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="password">Nova Senha</label>
            <div class="controls">
              <input type="password" id="password" maxlength="15" name="password">
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="password_conf">Confirmação de Senha</label>
            <div class="controls">
              <input type="password" id="password_conf" maxlength="15" name="password_conf">
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="role"> Tipo </label>
            <div class="controls">
              <select name="role" id="role">
                <option value="1" >Admin</option>
                <option value="2" >Fornecedor</option>
                <option value="3" >Designer</option>
                <option value="4" >Decorador</option>
                <option value="5" >Cliente</option>
              </select>
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="expertise"> Expertises </label>
            <div class="controls">
              <select name="expertises[]" id="expertise" multiple="multiple"></select>
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="zip">CEP</label>
            <div class="controls">
              <input type="text" id="zip" name="zip" maxlength="45" value="<?php echo  set_value('zip', $user->zip); ?>" />&nbsp;<a id="zip_search" class="btn btn-primary">Buscar CEP</a>
              <label id="zip_warning"></label>
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="role"> Estado </label>
            <div class="controls">
              <select name="state" id="state"></select>
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="role"> Cidade </label>
            <div class="controls">
              <select name="city" id="city"></select>
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="street">Endereço</label>
            <div class="controls">
              <input readonly="true" type="text" id="street" name="street" maxlength="100" value="<?php echo  set_value('street', $user->street); ?>" />
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="number">Número</label>
            <div class="controls">
              <input type="text" id="number" name="number" maxlength="10" value="<?php echo  set_value('number', $user->number); ?>" />
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="complement">Complemento</label>
            <div class="controls">
              <input type="text" id="complement" name="complement" maxlength="10" value="<?php echo  set_value('complement', $user->complement); ?>" />
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="district">Bairro</label>
            <div class="controls">
              <input readonly="true" type="text" id="district" name="district" maxlength="100" value="<?php echo  set_value('district', $user->district); ?>" />
            </div>
          </div>

          <div class="control-group">
            <label class="control-label" for="areaCode"> DDD </label>
            <div class="controls">
              <input type="text" name="areaCode" maxlength="2" class="input-mini" id="areaCode" value="<?php echo  set_value('areaCode', $user->areaCode); ?>">
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="phone"> Telefone </label>
            <div class="controls">
              <input type="text" name="phone" id="phone" value="<?php echo  set_value('phone', $user->phone); ?>">
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="person_type">Tipo Pessoa</label>
            <div class="controls">
              <label class="radio inline">
                <input type="radio" name="person_type" class="person_type" value="pf" id="radio_pf">
                Física
              </label>
              <label class="radio inline">
                <input type="radio" name="person_type" class="person_type" value="pj" id="radio_pj">
                Jurídica
              </label>
            </div>
          </div>
          <div class="control-group" id="person_pf">
            <label class="control-label" for="cpf">CPF</label>
            <div class="controls">
              <input type="text" id="cpf" maxlength="45" name="cpf" value="<?php echo  set_value('cpf', $user->cpf); ?>" />
            </div>
            <label class="control-label"  for="rg">RG</label>
            <div class="controls">
              <input type="text" id="rg" maxlength="45" name="rg" value="<?php echo  set_value('rg', $user->rg); ?>" />
            </div>
          </div>
          <div class="control-group" id="person_pj">
            <label class="control-label" for="cpf">CNPJ</label>
            <div class="controls">
              <input type="text" id="cnpj" maxlength="45" name="cnpj" value="<?php echo  set_value('cnpj', $user->cnpj); ?>" />
            </div>
            <label class="control-label" for="ie">IE</label>
            <div class="controls">
              <input type="text" id="ie" maxlength="45" name="ie" value="<?php echo  set_value('ie', $user->ie); ?>" />
            </div>
          </div>
          <div class="form-actions">
            <button class="btn btn-primary" type="submit">Salvar</button>
          </div>
        </fieldset>
      </form>
    </div>
  </div>
</div>
