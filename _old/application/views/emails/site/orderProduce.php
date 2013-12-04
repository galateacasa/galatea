<p style="font-size: 14px; color: #51534c; font-family: Georgia, Serif;">Oi <?php echo  $supplierName ?>,</p>

<p style="font-size: 14px; color: #51534c; font-family: Georgia, Serif;">
  Ótima notícia: temos um novo pedido para você! Por favor, leia atentamente os detalhes abaixo:
</p>

<table border="1" rules="all" cellpadding="5">

  <tbody>

    <tr>
      <td>Número do pedido</td>
      <td><?php echo  $orderNumber ?></td>
    </tr>

    <tr>
      <td>Produto</td>
      <td><?php echo  $productName ?></td>
    </tr>

    <tr>
      <td>Acabamento</td>
      <td><?php echo  $productMaterial ?></td>
    </tr>
    <tr>
      <td>Medidas</td>
      <td><?php echo  $productMeasurament ?></td>
    </tr>
    <tr>
      <td>Data do pedido</td>
      <td><?php echo  $orderDate ?></td>
    </tr>
    <tr>
      <td>Prazo para entrega no galpão da Galatea</td>
      <td><?php echo  $scheaduleDate ?></td>
    </tr>

  </tbody>

</table>

<p style="font-size: 14px; color: #51534c; font-family: Georgia, Serif;">
  O prazo de entrega deste item no galpão da Galatea é de <?php echo  $scheaduleAmount ?> dias corridos.
  <br>
  <?php if($scheaduleAmount > 15): /* The scheadule amount is bigger than 15 days? */ ?>
    Em <?php echo  $scheaduleAmount - 15 ?> dias você receberá um novo email com um lembrete deste pedido.
  <?php endif ?>
</p>

<p style="font-size: 14px; color: #51534c; font-family: Georgia, Serif;">
  Você pode conferir toda a relação de pedidos aqui.
</p>

<!--
<p style="font-size: 14px; color: #51534c; font-family: Georgia, Serif;">
  Obrigado por escolher fazer parte deste time!
</p>
-->

<p style="font-size: 14px; color: #51534c; font-family: Georgia, Serif;">
  Time Galatea Casa<br>
  <?php echo  anchor('/', base_url()) ?>
</p>
