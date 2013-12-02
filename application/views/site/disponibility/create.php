<section class="container_12">

  <?php echo  $breadcrumbs ?>

  <section class="grid_12">

    <header>

      <!-- title -->
      <h2>Interesse em produzir "<?php echo  $product->name ?>"</h2>
      <?php echo  br(1) ?>
      <!-- description -->
      <p>
        <?php echo  ucfirst($user->name) ?>, agradecemos desde já o interesse por ser nosso parceiro! <?php echo  br(1) ?>
        Por favor, confira seus dados e preencha o formulário abaixo. <?php echo  br(1) ?>
        Assim que recebermos sua solicitação, entraremos em contato para esclarecermos detalhes.
      </p>
      <?php echo  br(1) ?>
    </header>

    <?php echo  form_open( current_url() ) ?>

      <!-- user data -->
      <fieldset class="product-create">

        <h3>Seus dados</h3>

        <!-- company name -->
        <div class="inline-block">
          <?php echo  form_label('Razão social:', '', 'class="grey-text"') ?>
          <?php echo  form_input('', $user->company_name, 'readonly') ?>
        </div>

        <!-- email -->
        <div class="inline-block">
          <?php echo  form_label('Email:', '', 'class="grey-text"') ?>
          <?php echo  form_input('', $user->email, 'readonly') ?>
        </div>

        <!-- phone -->
        <div class="inline-block">
          <?php echo  form_label('Telefone:', '', 'class="grey-text"') ?>
          <?php echo  form_input('', $user->phone, 'readonly') ?>
        </div>

        <!-- update data -->
        <div>
          <?php echo  anchor( site_url('minha-conta'), 'Alterar meus dados', 'class="link-btn"') ?>
        </div>

      </fieldset>

      <?php echo  br(3) ?>

      <!-- product data -->
      <fieldset class="product-create">

        <h3>Formulário de contato</h3>

        <!-- name -->
        <div class="inline-block">
          <?php echo  form_label('Nome:', '', 'class="grey-text"') ?>
          <?php echo  form_input('', $user->name, 'readonly') ?>
        </div>

        <!-- email -->
        <div class="inline-block">
          <?php echo  form_label('Email:', '', 'class="grey-text"') ?>
          <?php echo  form_input('', $user->email, 'readonly') ?>
        </div>

        <!-- subject -->
        <div class="inline-block">
          <?php echo  form_label('Assunto*:', 'subject', 'class="grey-text"') ?>
          <?php echo  form_input('subject', set_value('subject', 'Quero produzir : '.$product->name)) ?>
        </div>

        <!-- message -->
        <div>
          <?php echo  form_label('Mensagem*:', 'message', 'class="grey-text"') ?>
          <?php echo  form_textarea('message', set_value('message', 'Gostaria de formalizar meu interesse em produzir o projeto '.$product->name) ) ?>
        </div>

        <div>
          <small>* implica obrigatoriedade.</small>
          <?php echo  br(2) ?>
        </div>

      </fieldset>

      <!-- submit button -->
      <button class="link-btn blue float-r" type="submit">Solicitar contato</button>
    <?php echo  form_close() ?>

  </section>

</section>
