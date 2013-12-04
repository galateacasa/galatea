<h2 class="extra-btm-space extra-top-space">dados Pessoais</h2>

<form id="frm_edit_user" name="frm_edit_user" class="user-edit" method="post" action="<?php echo  site_url('minha-conta'); ?>" >
  <input type="hidden" value="<?php echo $user->role?>" id="role">

  <!-- required field information -->
  <aside>
    <i class="imp">&nbsp;</i> = Campos obrigatórios para realizar compras
  </aside>

  <!-- user data -->
  <section>
    <!-- name -->
    <div class="name">
      <input type="text" placeholder="nome" name="name" id="name" value="<?php echo  set_value('name', $user->name); ?>" class="name">
      <em class="imp">&nbsp;</em>
    </div>

    <!-- surname -->
    <div class="surname">
      <input type="text" placeholder="sobrenome" name="surname" value="<?php echo  set_value('surname', $user->surname); ?>" class="surname">
      <em class="imp">&nbsp;</em>
    </div>

    <!-- CPF -->
    <div class="cpf">
      <input type="text" placeholder="cpf" name="cpf"  value="<?php echo  set_value('cpf', $user->cpf); ?>" class="cpf">
      <em class="imp">&nbsp;</em>
    </div>

    <!-- imagem + drag and drop area -->
    <div class="up-image-box">
      <figure class="upload-frame">
        <figcaption>foto</figcaption>
        <span id="user-edit-dropbox" class="frame" >
          <?php echo  img( amazon_url("images/users/{$user->image}", 100, 100) ) ?>
        </span>
        <small id="user-edit-dropbox-message">&nbsp;</small>
      </figure>
    </div> <!-- /imagem + drag and drop area -->

    <span>Arraste uma imagem para o quadrado caso queira trocá-la.</span>

    <!-- custom file input -->
    <input type="file" name="file" id="user-edit-custom-file" class="file-upload-styled" />

    <textarea class="msg" id="description" name="description" rows="4"><?php echo  set_value('description', !empty($user->description)?$user->description:'escreva algumas palavras sobre você'); ?></textarea>
  </section> <!-- /user data -->


  <?php if ($user->role == 2): /* Check if the user is a supplier */ ?>

    <!-- company data -->
    <section>
      <hr>
      <h2>Dados da empresa</h2>

      <!-- company name -->
      <div class="company-name">
        <input type="text" placeholder="razão social" id="company_name" name="company_name" value="<?php echo  set_value('company_name', $user->company_name) ?>" class="company_name">
        <em class="imp">&nbsp;</em>
      </div>

      <!-- CNPJ -->
      <div class="cnpj">
        <input type="text" placeholder="cnpj" name="cnpj" value="<?php echo set_value('cnpj', $user->cnpj);?>" class="cnpj">
        <em class="imp">&nbsp;</em>
      </div>

      <!-- expertises options -->
      <div class="expertise">
        <select class="styled" id="expertise">
          <option value="">Selecione sua area de atuação</option>
          <?php foreach ($expertises as $expertise): ?>
            <option value="<?php echo $expertise->id?>"><?php echo $expertise->name?></option>
          <?php endforeach ?>
        </select>
      </div> <!-- /expertises options -->

      <!-- expertises list -->
      <div class="expertise-list"  id="toshow" >

        <span>
          Clique uma vez para selecionar e outra para cancelar a seleção das funções que você desempenha
        </span>

        <ul class="field-links" id="field-links">
          <?php foreach ($user->expertise->get() as $exp): ?>
            <li>
              <a class="link-btn btli" href="javascript:;"><?php echo $exp->name?></a>
              <input type="hidden"  value="<?php echo $exp->id?>" name="expertise[]" />
            </li>
          <?php endforeach ?>
        </ul>

      </div> <!-- /expertises list -->

    </section> <!-- /company data -->

  <?php endif ?>

  <!-- main address -->
  <section>
    <hr>
    <h2>endereço</h2>

    <!-- zip code -->
    <div class="zip">
      <input type="text" placeholder="cep" name="zip" value="<?php echo  set_value('zip', $user->zip); ?>"  class="zip">
      <em class="imp">&nbsp;</em>
    </div>

    <!-- zip code search -->
    <a class="zip-search" href="http://www.buscacep.correios.com.br/servicos/dnec/index.do" target="_blank">não sabe o seu CEP?</a>

    <!-- area code -->
    <div class="area-code">
      <input type="text" placeholder="ddd"  name="areaCode" value="<?php echo  set_value('areaCode', $user->areaCode) ?>" class="areaCode">
      <em class="imp">&nbsp;</em>
    </div>

    <!-- phone -->
    <div class="phone">
      <input type="text" placeholder="telefone"  name="phone" value="<?php echo  set_value('phone', $user->phone) ?>" class=" phone">
      <em class="imp">&nbsp;</em>
    </div>

    <!-- address -->
    <div class="address">
      <input type="text" placeholder="rua/avenida" id="street" name="street" value="<?php echo  set_value('street', $user->street); ?>" class="street">
      <em class="imp">&nbsp;</em>
    </div>

    <div class="number">
      <input type="text" placeholder="número" id="number" name="number" value="<?php echo  set_value('number', $user->number) ?>" class="number">
      <em class="imp">&nbsp;</em>
    </div>

    <div class="complement">
      <input type="text" placeholder="complemento" name="complement" id="complement" value="<?php echo  set_value('complement', $user->complement) ?>" class="complement">
    </div>

    <!-- country -->
    <div class="country-container">
      <?php echo  form_dropdown('country_id', $countries['all'], $countries['user'], 'class="styled country"') ?>
      <em class="imp">&nbsp;</em>
    </div>

    <!-- state -->
    <div class="state-container" style="display: <?php echo  $countries['user'] == 36 ? 'inline-block' : 'none' ?>;">
      <select name="state_id" class="styled state" id="state_id">
      </select>
      <?//php echo $states ?>
      <em class="imp">&nbsp;</em>
    </div>

    <!-- city -->
    <div class="city-container" style="display: <?php echo  $countries['user'] == 36 ? 'inline-block' : 'none' ?>;">
      <select name="city_id" class="styled city" id="city_id">
      </select>
      <?//php echo $cities ?>
      <em class="imp">&nbsp;</em>
    </div>

  </section> <!-- /main address -->

  <!-- aditional address -->
  <section>

    <!-- title -->
    <h2>
      <a style="cursor:pointer;" class="dark-clr" id="user-edit-adds-content">+ endereço de entrega</a>
    </h2>

  </section> <!-- /aditional address -->

  <?php echo  $deliveryAddress ? $deliveryAddress : '' ?>

  <!-- update form -->
  <footer id="user-delivery-address-footer">

    <!-- button -->
    <button type="submit" class="button float-r">Atualizar</button>

    <!-- button -->
    <button id="update-go-cart" type="button" class="button float-r">Atualizar e ir para o carrinho</button>

    <!-- text -->
    <span class="grid_4 terms-con alpha float-r">
      Clicando em ATUALIZAR, você estará concordando <br> com os <?php echo  anchor('institucional/termos-e-condicoes', 'Termos do site', 'target="_blank"') ?> e que você leu nossa <br> <?php echo  anchor('institucional/termos-e-condicoes#privacidade', 'política de uso de informações e Cookies', 'target="_blank"') ?>.
    </span>

  </footer> <!-- /update form -->

</form>

<script type="text/javascript">
  $(document).ready(function() {
    //Address city and state Dropdown
    new Dropdown(
      'state_id',
      'city_id',
      '<?php echo site_url("ajax/states/get")?>',
      '<?php echo $user->state_id ?>',
      '<?php echo $user->city_id ?>'
    );

    //Image upload
    new upload_box("dropbox", "dropbox-message", "images/users", "<?php echo amazon_url('images/users')?>", 1, '', '<?php echo $user->image?>', 160);
  });
</script>
