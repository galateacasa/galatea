<h2 class="extra-btm-space extra-top-space">meus pedidos</h2>

<?php foreach ($orders as $order): ?>
  <div class="block extra-btm-space border-top over-flow-clear">

    <h3 class="float-l clear-no no-margin">Pedido <?php echo $order->id?></h3>

    <?php if ($order->status == 10) { ?>
      <h3 class="float-r clear-no small-caps no-margin blue-text">Entregue em <?php echo $order->delivery_date?></h3>
    <?php }else{ ?>
      <h3 class="small-caps"><?php echo  "Entrega prevista em {$order->estimated_delivery_date}"?></h3>
    <?php } ?>

    <ul class="order-links">
      <li class="active">
        pedido realizado
        <?php if($order->status <= 4){ ?>
          <a onclick="return window.confirm('Tem certeza que deseja cancelar o pedido?');" href="<?php echo site_url('meus-pedidos/cancel_order/'.$order->id)?>" class="cancel-order">
            cancelar pedido
          </a>
        <?php } if ($order->status == 7) { ?>
          <a  class="cancel-order">
            cancelado
          </a>
        <?php } ?>
      </li>
      <li class="<?php echo  ($order->status >=3 && $order->status <= 4) ? '' : '' ?>" >confirmação do pagamento</li>
      <li class="<?php echo  ($order->status ==8) ? '' : '' ?>" >produção</li>
      <li class="<?php echo  ($order->status ==9) ? '' : '' ?>">logística</li>
    </ul>
    <div class="block border-btm">
      <table class="chart">
        <tbody>
          <tr class="chart-title">
            <td>Ítem</td>
            <td>Acabamento</td>
            <td>Quant</td>
            <td>Valor Unitário</td>
            <td>Valor Total</td>
          </tr>
          <?php $total_order = 0; ?>
          <?php foreach ($order->order_item->get() as $order_item): ?>
            <?
              $measures = array(
                $order_item->item_variation_measurement->width,
                $order_item->item_variation_measurement->height,
                $order_item->item_variation_measurement->depth
              );

              $measures = implode('cm X ', $measures) . 'cm';

              $total = $order_item->price * $order_item->qty;
              $total_order += $total;
            ?>
            <tr>
              <td><div class="block over-pro">(<?php echo  $order_item->item->id ?>)<?php echo  $order_item->item->name ?></div></td>
              <td>
                Material: <?php echo  $order_item->item_variation_material->material ?></br>
                Medidas: <?php echo  $measures ?>
              </td>
              <td><?php echo  $order_item->qty ?></td>
              <td>R$ <?php echo  number_format($order_item->price, 2, '.', ',') ?></td>
              <td>R$ <?php echo  number_format($total, 2, '.', ',') ?></td>
            </tr>
          <?php endforeach ?>
            <tr class="last">
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td class="dark-clr">R$ <?php echo  number_format($total_order, 2, '.', ',') ?></td>
            </tr>
        </tbody>
      </table>
    </div>
  </div>
<?php endforeach ?>
