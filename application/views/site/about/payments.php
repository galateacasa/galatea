<?
  $cards['credit_card'] = array(
    'visa.jpeg',
    'master-card.jpeg',
    'diners.jpeg',
    'elo.jpeg',
    'american-express.jpeg',
    'hipercard.jpeg',
    'aura.jpeg',
    'pleno.jpeg',
    'personal-card.jpeg',
    'vale-card.jpeg',
    'brasil-card.jpeg',
  );

  $cards['debit'] = array(
    'mais.jpg',
    'cabal.jpeg',
    'card-ban.jpeg',
    'avista.jpeg',
    'fortbrasil.png',
    'itau.jpeg',
    'hsbc.jpeg',
    'banrisul.jpeg',
    'bradesco.jpeg',
    'banco-do-brasil.jpeg',
  );

  $cards['billet'] = array('boleto.jpeg');

  $card_pattern = "<div><span><img src=\"%s\"></span></div>";
?>
<section class="about">
  <h2>Formas de pagamento</h2>

  <p>A GALATEA aceita as seguintes formas de pagamento:</p>

  <br>
  <p>
    Cartões de crédito: parcelamento em até 10 vezes;
    <div class="about-cards">
      <?php foreach($cards['credit_card'] as $credit_card) printf($card_pattern, assets_url("images/cards/$credit_card") ); ?>
    </div>

  </p>
    Débito bancário: faça o pagamento diretamente em sua conta corrente;
    <div class="about-cards">
      <?php foreach($cards['debit'] as $debit) printf($card_pattern, assets_url("images/cards/$debit") ); ?>
    </div>
  </ul>

  <p>
    Boleto bancário: imprima e pague no banco mais próximo ou digite o código de barras em seu internet banking;
    <div class="about-cards">
      <?php foreach($cards['billet'] as $billet) printf($card_pattern, assets_url("images/cards/$billet") ); ?>
    </div>
  </p>

</section>
