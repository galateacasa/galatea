<div class="row-fluid">
  <div class="box span12">
    <div class="box-header well" data-original-tile >
      <h2><i class="icon-edit"></i> Criar usuário</h2>
    </div>
    <div class="box-content">
      <form action="" class="form-horizontal" method="post">
        <fieldset>
          <legend>Criar usuário</legend>
          <div class="control-group">
            <label class="control-label" for="name"> Nome </label>
            <div class="controls">
              <input type="text" name="name" id="name" value="">
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="email"> Email </label>
            <div class="controls">
              <input type="text" name="email" id="email" value="">
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="password">Senha</label>
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
            <label class="control-label" for="role"> Expertises </label>
            <div class="controls">
              <select name="expertises[]" id="expertise" multiple="multiple"></select>
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="zip">CEP</label>
            <div class="controls">
              <input type="text" id="zip" name="zip" maxlength="45" value="" />&nbsp;<a id="zip_search" class="btn btn-primary">Buscar CEP</a>
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
              <input type="text" id="street" name="street" maxlength="100" value="" />
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="number">Número</label>
            <div class="controls">
              <input type="text" id="number" name="number" maxlength="10" value="" />
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="complement">Complemento</label>
            <div class="controls">
              <input type="text" id="complement" name="complement" maxlength="10" value="" />
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="district">Bairro</label>
            <div class="controls">
              <input type="text" id="district" name="district" maxlength="100" value="" />
            </div>
          </div>

          <div class="control-group">
            <label class="control-label" for="areaCode"> DDD </label>
            <div class="controls">
              <input type="text" name="areaCode" maxlength="2" class="input-mini" id="areaCode" value="">
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="phone"> Telefone </label>
            <div class="controls">
              <input type="text" name="phone" id="phone" value="">
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
              <input type="text" id="cpf" maxlength="45" name="cpf" value="" />
            </div>
            <label class="control-label"  for="rg">RG</label>
            <div class="controls">
              <input type="text" id="rg" maxlength="45" name="rg" value="" />
            </div>
          </div>
          <div class="control-group" id="person_pj">
            <label class="control-label" for="cpf">CNPJ</label>
            <div class="controls">
              <input type="text" id="cnpj" maxlength="45" name="cnpj" value="" />
            </div>
            <label class="control-label" for="ie">IE</label>
            <div class="controls">
              <input type="text" id="ie" maxlength="45" name="ie" value="" />
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
