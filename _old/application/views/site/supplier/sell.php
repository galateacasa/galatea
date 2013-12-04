<div class="row-fluid">
  <h3>Pedido: <?php echo  $order->id ?></h3>

  <div class="row-fluid">
    <div class="span12">
      <div class="wellDark borBox">
        <div class="row-fluid">
          <h3 class="span12">Status</h3>
        </div>
      </div>
    </div>
  </div>

  <div class="row-fluid">
    <div class="span12">
      <?php if (count($order_status) > 0) { ?>
        <table class="table table-bordered table-striped ">
          <thead>
            <tr >
              <th>Data</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($order_status as $st) { ?>
              <tr>
                <td><?php echo  $st->create_date ?></td>
                <td><?php echo  status_to_literal_pagseguro($st->status) ?></td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      <?php } ?>
    </div>
  </div>

  <div class="row-fluid">
    <div class="span12">
      <div class="wellDark borBox">
        <div class="row-fluid">
          <h3 class="span12">Detalhes</h3>
        </div>
      </div>
    </div>
  </div>

  <div class="row-fluid">
    <div class="span12">
      <strong>Método de pagamento</strong><br>
      <?php echo  payment_to_literal_pagseguro($order->payment_method) ?>
      </address>
    </div>
  </div>

  <div class="row-fluid">
    <div class="span12">
      <address>
        <strong>Endereço de entrega</strong><br>
        <?php echo  $delivery_address->street ?>, <?php echo  $delivery_address->number ?>, <?php echo  $delivery_address->complement ?>, <?php echo  $delivery_address->district ?><br>
        <?php echo  $delivery_address->city ?> - <?php echo  $delivery_address->state ?>, <?php echo  $delivery_address->zip ?><br>
        Tel: <?php echo  $delivery_address->phone ?>
      </address>
    </div>
  </div>

  <div class="row-fluid">
    <div class="span12">
      <div class="wellDark borBox">
        <div class="row-fluid">
          <h3 class="span12">Produtos</h3>
        </div>
      </div>
    </div>
  </div>

  <div class="row-fluid">
    <div class="span12">
      <?php if (count($order_items) > 0) { ?>
        <table class="table table-bordered table-striped ">
          <thead>
            <tr >
              <th>Id</th>
              <th>Produto</th>
              <th>Preço</th>
              <th>Quantidade</th>
              <th>Variações</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($order_items as $order_item) { ?>
              <tr>
                <td><?php echo  $order_item['id'] ?></td>
                <td><?php echo  $order_item['name'] ?></td>
                <td><?php echo  $order_item['price'] ?></td>
                <td><?php echo  $order_item['qty'] ?></td>
                <td><?php echo  $order_item['variations'] ?></td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      <?php } ?>
    </div>
  </div>

</div>
