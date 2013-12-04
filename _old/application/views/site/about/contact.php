<section class="about-contact">
  <?php echo  heading('Atendimento', 2); ?>
  <aside>
    <i class="imp">&nbsp;</i>
    = Campos obrigatórios
  </aside>

  <p>D&uacute;vidas, sugest&otilde;es, cr&iacute;ticas, elogios? Fale conosco, adorar&iacute;amos ouvir de voc&ecirc;.</p>
  <br />
  <p>Atendimento por telefone</p>
  <p>Ligue pra gente: (019) 3112-0316. Nosso atendimento telef&#244;nico funciona de segunda a sexta das 9h &#224;s 17h.</p>
  <br />
  <p>D&#250;vidas frequentes</p>
  <p>Se preferir, voc&#234; pode acessar o nosso <?php echo  anchor('institucional/duvidas-frequentes', 'FAQ') ?>. L&#225; voc&#234; encontra respostas para as perguntas que recebemos com maior frequ&#234;ncia.</p>
  <br />
  <p>Atendimento online</p>
  <p>Preencha os campos abaixo ou escreva pra gente: <?php echo  safe_mailto(EMAIL_GALATEA, EMAIL_GALATEA); ?></p>

  <?php echo  form_open( current_url() ) ?>
    <fieldset>
      <i class="imp name">&nbsp;</i>
      <?php echo  form_input('name', set_value('name'), 'placeholder="nome" required') ?>
      <i class="imp email">&nbsp;</i>
      <?php echo  form_input('email', set_value('email'), 'placeholder="email" required') ?>
      <?php echo  form_input('ddd', set_value('ddd'), 'placeholder="ddd" class="ddd"') ?>
      <?php echo  form_input('phone', set_value('phone'), 'placeholder="telefone" class="phone"') ?>
      <?php echo  form_input('subject', set_value('subject'), 'placeholder="assunto"') ?>
      <?php echo  form_input('order', set_value('order'), 'placeholder="número do pedido (se houver)"') ?>
      <?php echo  form_textarea('message', set_value('message'), 'placeholder="escreva o assunto com o qual podemos ajudar você"'); ?>
    </fieldset>

    <hr>
    <?php echo  form_submit('send', 'enviar', 'class="button float-r"'); ?>

  <?php echo  form_close() ?>
</section>
