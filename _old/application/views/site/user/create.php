<div class="span5">

  <h3>Cadastro</h3>

  <form class="form-horizontal" id="form_create_user" method="POST">
    <div class="control-group">
      <label class="control-label" for="name">Nome Completo*</label>
      <div class="controls">
        <input type="text" id="name" name="name" maxlength="100" value="<?php echo  set_value('name'); ?>" />
      </div>
    </div>
    <div class="control-group">
      <label class="control-label" for="role"> Quem é você? </label>
      <div class="controls">
        <select name="role" id="role">
          <option value="5" >Cliente</option>
          <option value="2" >Fornecedor</option>
          <option value="3" >Designer</option>
          <option value="4" >Decorador</option>
        </select>
      </div>
    </div>
    <div class="control-group">
      <label class="control-label" for="description">Descrição</label>
      <div class="controls">
        <textarea id="description" name="description" ><?php echo  set_value('description'); ?> </textarea>
      </div>
    </div>
    <div class="control-group">
      <label class="control-label" for="email">Email*</label>
      <div class="controls">
        <input type="email" id="email" name="email" maxlength="100" value="<?php echo  set_value('email'); ?>" />
      </div>
    </div>
    <div class="control-group">
      <label class="control-label" for="password">Senha*</label>
      <div class="controls">
        <input type="password" id="password" maxlength="15" name="password">
      </div>
    </div>
    <div class="control-group">
      <label class="control-label" for="password_conf">Confirmação de Senha*</label>
      <div class="controls">
        <input type="password" id="password_conf" maxlength="15" name="password_conf">
      </div>
    </div>
    <div class="control-group">
      <label class="control-label" for="zip">CEP</label>
      <div class="controls">
        <input type="text" id="zip" name="zip" maxlength="45" value="<?php echo  set_value('zip'); ?>" />&nbsp;<a id="zip_search" class="btn btn-primary">Buscar CEP</a>
        <label id="zip_warning"></label>
      </div>
    </div>
    <div class="control-group">
      <label class="control-label" for="street">Endereço</label>
      <div class="controls">
        <input type="text" id="street" name="street" maxlength="100" value="<?php echo  set_value('street'); ?>" />
      </div>
    </div>
    <div class="control-group">
      <label class="control-label" for="number">Número</label>
      <div class="controls">
        <input type="text" id="number" name="number" maxlength="10" value="<?php echo  set_value('number'); ?>" />
      </div>
    </div>
    <div class="control-group">
      <label class="control-label" for="complement">Complemento</label>
      <div class="controls">
        <input type="text" id="complement" name="complement" maxlength="10" value="<?php echo  set_value('complement'); ?>" />
      </div>
    </div>
    <div class="control-group">
      <label class="control-label" for="district">Bairro</label>
      <div class="controls">
        <input type="text" id="district" name="district" maxlength="100" value="<?php echo  set_value('district'); ?>" />
      </div>
    </div>

    <div class="control-group">
      <label class="control-label" for="state">Estado</label>
      <div class="controls">
        <select name="state" id="state"></select>
      </div>
    </div>
    <div class="control-group">
      <label class="control-label" for="city">Cidade</label>
      <div class="controls">
        <select name="city" id="city"></select>
      </div>
    </div>
    <div class="control-group">
      <label class="control-label" for="areaCode">DDD</label>
      <div class="controls">
        <input type="text" id="areaCode" name="areaCode" maxlength="3" value="<?php echo  set_value('areaCode'); ?>" />
      </div>
    </div>
    <div class="control-group">
      <label class="control-label" for="phone">Telefone</label>
      <div class="controls">
        <input type="text" id="phone" name="phone"  value="<?php echo  set_value('phone'); ?>" />
      </div>
    </div>
    <div class="control-group">
      <label class="control-label" for="person_type">Tipo Pessoa</label>
      <div class="controls">
        <label class="radio inline">
          <input type="radio" name="person_type" class="person_type" value="pf" checked>
          Física
        </label>
        <label class="radio inline">
          <input type="radio" name="person_type" class="person_type" value="pj">
          Jurídica
        </label>
      </div>
    </div>
    <div class="control-group" id="person_pf">
      <label class="control-label" for="cpf">CPF</label>
      <div class="controls">
        <input type="text" id="cpf" maxlength="45" name="cpf" value="<?php echo  set_value('cpf'); ?>" />
      </div>
      <label class="control-label"  for="rg">RG</label>
      <div class="controls">
        <input type="text" id="rg" maxlength="45" name="rg" value="<?php echo  set_value('rg'); ?>" />
      </div>
    </div>
    <div class="control-group" id="person_pj">
      <label class="control-label" for="cpf">CNPJ</label>
      <div class="controls">
        <input type="text" id="cnpj" maxlength="45" name="cnpj" value="<?php echo  set_value('cnpj'); ?>" />
      </div>
      <label class="control-label" for="ie">IE</label>
      <div class="controls">
        <input type="text" id="ie" maxlength="45" name="ie" value="<?php echo  set_value('ie'); ?>" />
      </div>
    </div>
    <div class="control-group">
      <label class="checkbox">
        <input type="checkbox" name="agreement" id="agreement"> Li e concordo com os termos e Condições Gerais de Uso do Site
      </label>
    </div>
    <div class="form-actions">
      <button type="submit" class="btn btn-primary">Salvar</button>
    </div>
  </form>
</div>
