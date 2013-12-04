<p style="font-size: 14px; color: #51534c; font-family: Georgia, Serif;">Oi <?php echo  $userName ?>,</p>

<p style="font-size: 14px; color: #51534c; font-family: Georgia, Serif;">
  Sua compra na GALATEA foi autorizada no dia <?php echo  date('d/m/Y') ?>. O prazo de entrega de <?php echo  $scheadule ?> dias começa a valer a partir desta data.
</p>

<p style="font-size: 14px; color: #51534c; font-family: Georgia, Serif;">
  O n&uacute;mero do seu pedido &eacute; o <?php echo  $orderNumber ?>. Você pode acompanhá-lo pelo link <?php echo  anchor('meus-pedidos', base_url('meus-pedidos')) ?>.
</p>

<p>Este pedido inclui:</p>

<table border="1" rules="all" cellpadding="5">

  <thead>
    <tr>
      <th>Quantidade</th>
      <th>Item</th>
      <th>Designer</th>
      <th>Valor</th>
      <th>Total</th>
    </tr>
  </thead>

  <tbody>
    <?php foreach ($products as $product): ?>
      <tr>
        <td><?php echo  $product['productQuantity'] ?></td>
        <td><?php echo  $product['productName'] ?></td>
        <td><?php echo  $product['designerName'] ?></td>
        <td><?php echo  $product['productPrice'] ?></td>
        <td><?php echo  $product['productPriceTotal'] ?></td>
      </tr>
    <?php endforeach ?>
  </tbody>

</table>

<p style="font-size: 14px; color: #51534c; font-family: Georgia, Serif;">Valor Total do pedido: <?php echo  $total ?></p>

Dados para entrega:
<br><br>

Destinat&aacute;rio: <?php echo  $userAddress['userFullName'] ?><br>
<?php echo  $userAddress['street'] ?>, <?php echo  $userAddress['number'] ?> - <?php echo  $userAddress['complement'] ?><br>
Bairro <?php echo  $userAddress['district'] ?> - <?php echo  $userAddress['city'] ?><br>
<?php echo  $userAddress['state'] ?> - CEP: <?php echo  $userAddress['zipCode'] ?><br>
<br>

Voc&ecirc; pode acompanhar e cancelar seu pedido pelo <?php echo  anchor('meus-pedidos', 'site') ?>. Verifique tamb&eacute;m nossa <?php echo  anchor('institucional/trocas-e-devolucoes', 'Pol&iacute;tica de Troca e Devolu&ccedil;&atilde;o') ?> e, sempre que precisar, fale conosco pelo email <?php echo  mailto(EMAIL_GALATEA, EMAIL_GALATEA) ?>.<br>
<br>

Obrigado por fazer parte da Galatea,
<br><br>

Time Galatea Casa<br>
<?php echo  anchor('/', base_url()) ?><br>
