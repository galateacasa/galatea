<section class="about">
  <h2>GANHE CRÉDITOS</h2>

  <p>Ganhe 1% de comissão a cada venda que você gerar.</p>

  <p>Na galeria <?php echo  anchor('inspire-me', 'Inspire-me') ?>, você posta imagens de ambientes decorados e sugere móveis da GALATEA que poderiam compor esse ambiente. Se alguém gostar da sua sugestão e ela inspirar uma compra no site, você ganha 1% do valor da venda em descontos na GALATEA. Se você for um decorador ou arquiteto, pode resgatar seus créditos por transferência bancária mediante envio de nota fiscal ou RPA.
  </p>

<?php if (!$this->session->userdata('id')) { ?>
  <p>Gostou da nossa ideia? <?php echo  anchor('login', 'Cadastre-se aqui') ?>.</p>
<?php } ?>
  <p>Você pode acompanhar seus <?php echo  $this->session->userdata('id') ? anchor('meus-creditos', 'créditos pelo site') : 'créditos pelo site' ?>.</p>
</section>
